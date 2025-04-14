<?php
use app\controllers\transactionsController;

$controller = new transactionsController();
$userId = $_SESSION['id'];

// Crear transacción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'usuario'     => $userId,
        'descripcion' => $_POST['descripcion'],
        'moneda'      => $_POST['moneda'],
        'monto'       => $_POST['monto'],
        'categoria'   => $_POST['categoria'],
        'tipo'        => $_POST['tipo'],
        'fecha'       => $_POST['fecha']
    ];

    $controller->createTransaction($data);

    if ($data['tipo'] == 2 && $data['categoria'] === 'Ahorro' && !empty($_POST['metaId'])) {
        $goalId = (int)$_POST['metaId'];
        $amount = (float)$data['monto'];
        $meta = $controller->getSavingsGoalById($goalId);
        if ($meta) {
            $nuevoBalance = $meta['Balance'] + $amount;
            $controller->updateSavingsGoalBalance($goalId, $nuevoBalance);
        }
    }

    header("Location: transactions/?action=created");
    exit;
}

// Datos
$transacciones = $controller->getTransactionsByUser();
$savingsGoals = $controller->getSavingsGoalsByUser($userId);

// Tipo de cambio
function getTipoCambio() {
    $json = @file_get_contents("https://api.hacienda.go.cr/indicadores/tc/dolar");
    if (!$json) return ["compra" => 0, "venta" => 0];
    $data = json_decode($json, true);
    return [
        "compra" => $data["compra"]["valor"] ?? 0,
        "venta"  => $data["venta"]["valor"] ?? 0
    ];
}

$tc = getTipoCambio();
$venta = $tc["venta"];
$compra = $tc["compra"];

// Labels
$labels = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

// Inicializar arrays por mes
$gastosMensuales = array_fill(1, 12, ['CRC' => 0, 'USD' => 0]);
$ingresosMensuales = array_fill(1, 12, ['CRC' => 0, 'USD' => 0]);

foreach ($transacciones as $t) {
    $mes = (int)date('n', strtotime($t['DateTransaction']));
    $monto = (float)$t['Amount'];
    $tipo  = (int)$t['TypeTransaction'];
    $moneda = $t['Currency'];

    if ($tipo === 1) {
        $ingresosMensuales[$mes][$moneda] += $monto;
    } else {
        $gastosMensuales[$mes][$moneda] += abs($monto);
    }
}

$ingresosCRC = array_map(fn($m) => $m['CRC'], $ingresosMensuales);
$ingresosUSD = array_map(fn($m) => $m['USD'], $ingresosMensuales);
$gastosCRC   = array_map(fn($m) => $m['CRC'], $gastosMensuales);
$gastosUSD   = array_map(fn($m) => $m['USD'], $gastosMensuales);

$dataIngresosCRCJs = json_encode(array_values($ingresosCRC));
$dataIngresosUSDJs = json_encode(array_values($ingresosUSD));
$dataGastosCRCJs   = json_encode(array_values($gastosCRC));
$dataGastosUSDJs   = json_encode(array_values($gastosUSD));
$labelsJs          = json_encode($labels);
?>

<div class="dashboard-content"> 
    <h2 class="title has-text-white">Gestión de Transacciones</h2>
    <button class="button is-primary" onclick="showTransactionModal()">Añadir Transacción</button>

    <div class="field mt-4">
        <label class="label has-text-white">Ver montos en:</label>
        <div class="control">
            <div class="select">
                <select id="currencySelect">
                    <option value="CRC">Colones (₡)</option>
                    <option value="USD">Dólares ($)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="chart-container mt-5" style="height: 400px;">
        <canvas id="transactionsChart" height="300"></canvas>
    </div>

    <h3 class="title is-4 has-text-white mt-5">Transacciones</h3>
    <table class="table is-fullwidth is-striped is-hoverable mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Categoría</th>
                <th>Moneda</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacciones as $transaccion): ?>
                <?php $tipoTexto = $transaccion['TypeTransaction'] == 1 ? 'Ingreso' : 'Gasto'; ?>
                <tr>
                    <td><?= htmlspecialchars($transaccion['TransactionId']) ?></td>
                    <td><?= htmlspecialchars($transaccion['Description']) ?></td>
                    <td><?= number_format($transaccion['Amount'], 2) ?></td>
                    <td><?= htmlspecialchars($transaccion['Category']) ?></td>
                    <td><?= htmlspecialchars($transaccion['Currency']) ?></td>
                    <td><?= $tipoTexto ?></td>
                    <td><?= date('Y-m-d', strtotime($transaccion['DateTransaction'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="transactionModal" class="modal">
    <div class="modal-background" onclick="closeTransactionModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Añadir Transacción</p>
            <button class="delete" aria-label="close" onclick="closeTransactionModal()"></button>
        </header>

        <form method="POST">
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Descripción</label>
                    <div class="control">
                        <input class="input" type="text" name="descripcion" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Moneda</label>
                    <div class="select is-fullwidth">
                        <select name="moneda" required>
                            <option value="USD">USD</option>
                            <option value="CRC">CRC</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Tipo de Transacción</label>
                    <div class="select is-fullwidth">
                        <select name="tipo" id="tipoSelect" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="1">Ingreso</option>
                            <option value="2">Gasto</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Categoría</label>
                    <div class="select is-fullwidth">
                        <select name="categoria" id="categoriaSelect" required onchange="handleCategoriaChange()">
                            <option value="">Seleccionar categoría</option>
                        </select>
                    </div>
                </div>

                <div class="field" id="savingsGoalField" style="display: none;">
                    <label class="label">Meta Financiera</label>
                    <div class="select is-fullwidth">
                        <select id="metaSelect" onchange="updateMontoFromMeta()">
                            <option value="">Seleccionar meta</option>
                            <?php foreach ($savingsGoals as $goal): ?>
                                <option value="<?= htmlspecialchars($goal['PlannedAmount']) ?>" data-id="<?= $goal['SavingsGoalsId'] ?>">
                                    <?= htmlspecialchars($goal['NameGoal']) ?> - <?= number_format($goal['PlannedAmount'], 2) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="metaId" id="metaIdInput">

                <div class="field">
                    <label class="label">Monto</label>
                    <div class="control">
                        <input class="input" type="number" name="monto" id="montoInput" step="0.01" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Fecha</label>
                    <div class="control">
                        <input class="input" type="date" name="fecha" required>
                    </div>
                </div>
            </section>

            <footer class="modal-card-foot">
                <button type="submit" class="button is-success">Guardar</button>
                <button type="button" class="button" onclick="closeTransactionModal()">Cancelar</button>
            </footer>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const labels = <?= $labelsJs ?>;
const data = {
    ingresos_crc: <?= $dataIngresosCRCJs ?>,
    ingresos_usd: <?= $dataIngresosUSDJs ?>,
    gastos_crc: <?= $dataGastosCRCJs ?>,
    gastos_usd: <?= $dataGastosUSDJs ?>
};

const tipoCambio = {
    compra: <?= $compra ?: 0 ?>,
    venta: <?= $venta ?: 0 ?>
};

const currencySelect = document.getElementById('currencySelect');
let chart = null;

function getCombinedData(tipo, moneda) {
    const crc = data[`${tipo}_crc`] || [];
    const usd = data[`${tipo}_usd`] || [];

    return crc.map((valorCRC, i) => {
        const valorUSD = usd[i] || 0;
        if (moneda === 'CRC') {
            return valorCRC + (tipoCambio.compra ? valorUSD * tipoCambio.compra : 0);
        } else {
            return valorUSD + (tipoCambio.venta ? valorCRC / tipoCambio.venta : 0);
        }
    });
}

function renderChart(moneda = 'CRC') {
    const ingresos = getCombinedData('ingresos', moneda);
    const gastos = getCombinedData('gastos', moneda);

    if (chart) chart.destroy();

    const ctx = document.getElementById('transactionsChart').getContext('2d');
    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: `Ingresos (${moneda})`,
                    data: ingresos,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: `Gastos (${moneda})`,
                    data: gastos,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

currencySelect.addEventListener('change', () => {
    renderChart(currencySelect.value);
});

function showTransactionModal() {
    document.getElementById("transactionModal").classList.add("is-active");
}

function closeTransactionModal() {
    document.getElementById("transactionModal").classList.remove("is-active");
    document.getElementById("metaSelect").value = "";
}

const categoriasIngreso = [
    { value: 'Salario', label: 'Salario' },
    { value: 'Intereses', label: 'Intereses' },
    { value: 'Regalos', label: 'Regalos' }
];

const categoriasGasto = [
    { value: 'Ahorro', label: 'Ahorro' },
    { value: 'Gastos Fijos', label: 'Gastos Fijos' },
    { value: 'Lujos', label: 'Lujos' },
];

function handleTipoChange() {
    const tipo = document.getElementById("tipoSelect").value;
    const select = document.getElementById("categoriaSelect");
    const categorias = tipo === "1" ? categoriasIngreso : categoriasGasto;

    select.innerHTML = '<option value="">Seleccionar categoría</option>';
    categorias.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.value;
        option.textContent = cat.label;
        select.appendChild(option);
    });

    handleCategoriaChange();
}

function handleCategoriaChange() {
    const categoria = document.getElementById("categoriaSelect").value;
    document.getElementById("savingsGoalField").style.display = categoria === "Ahorro" ? "block" : "none";
}

function updateMontoFromMeta() {
    const option = document.getElementById("metaSelect").selectedOptions[0];
    if (option) {
        document.getElementById("montoInput").value = option.value;
        document.getElementById("metaIdInput").value = option.getAttribute("data-id");
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById("tipoSelect").addEventListener("change", handleTipoChange);
    renderChart(currencySelect.value);
});
</script>

<?php if ($_GET['action'] ?? '' === 'created'): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Transacción registrada con éxito',
    toast: true,
    timer: 2000,
    position: 'top-end',
    showConfirmButton: false
});
</script>
<?php endif; ?>
