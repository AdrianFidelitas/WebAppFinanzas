<?php
use app\controllers\dashboardController;

$controller = new dashboardController();
$data = $controller->getDashboardData();

$transacciones = $data["transacciones"];
$totales = $data["totales"];
$ahorros = $data["ahorros_pendientes"];
$presupuestos = $data["presupuestos"];
$dolar = $data["dolar"];

$tVenta = $dolar['venta'] ?? 0;
$tCompra = $dolar['compra'] ?? 0;

function convertirTotalUSD($crc, $usd, $tVenta) {
    return $tVenta > 0 ? ($crc / $tVenta) + $usd : $usd;
}

function convertirTotalCRC($usd, $crc, $tCompra) {
    return $tCompra > 0 ? ($usd * $tCompra) + $crc : $crc;
}
?>

<main class="content">
    <h1 class="has-text-white">Dashboard</h1>

    <!-- Tarjetas resumen -->
    <div class="cards">
        <div class="card">
            <i class="fas fa-wallet"></i> Presupuesto total:<br>
            <strong>
                <?= number_format(convertirTotalCRC($totales['presupuesto_usd'], $totales['presupuesto_crc'], $tCompra), 2); ?> ₡
                <?= number_format(convertirTotalUSD($totales['presupuesto_crc'], $totales['presupuesto_usd'], $tVenta), 2); ?> $
            </strong>
        </div>

        <div class="card">
            <i class="fas fa-arrow-up"></i> Ingresos del mes:<br>
            <strong>
                <?= number_format(convertirTotalCRC($totales['ingresos_usd'], $totales['ingresos_crc'], $tCompra), 2); ?> ₡
                <?= number_format(convertirTotalUSD($totales['ingresos_crc'], $totales['ingresos_usd'], $tVenta), 2); ?> $
            </strong>
        </div>

        <div class="card">
            <i class="fas fa-arrow-down"></i> Gastos del mes:<br>
            <strong>
                <?= number_format(convertirTotalCRC($totales['gastos_usd'], $totales['gastos_crc'], $tCompra), 2); ?> ₡
                <?= number_format(convertirTotalUSD($totales['gastos_crc'], $totales['gastos_usd'], $tVenta), 2); ?> $
            </strong>
        </div>

        <div class="card">
            <i class="fas fa-dollar-sign"></i> Tipo de Cambio Dólar:<br>
            <strong>Compra: <?= $tCompra ? number_format($tCompra, 2) : 'N/D'; ?> ₡</strong><br>
            <strong>Venta: <?= $tVenta ? number_format($tVenta, 2) : 'N/D'; ?> ₡</strong>
        </div>
    </div>

    <!-- Transacciones recientes -->
    <div class="transactions mt-5">
        <h2 class="has-text-white">Últimas transacciones</h2>
        <table class="table is-fullwidth is-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th style="text-align:right;">Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transacciones as $trans): ?>
                    <tr>
                        <td><?= htmlspecialchars($trans['DateTransaction']); ?></td>
                        <td><?= htmlspecialchars($trans['Description']); ?></td>
                        <td><?= $trans['TypeTransaction'] == 1 ? 'Ingreso' : 'Egreso'; ?></td>
                        <td style="text-align:right;">
                            <?php
                                $simbolo = $trans['Currency'] === 'USD' ? '$' : '₡';
                                echo $simbolo . number_format($trans['Amount'], 2);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Presupuestos detallados -->
    <div class="budget-section mt-5">
        <h2 class="has-text-white">Presupuestos por Categoría</h2>
        <?php if (!empty($presupuestos)): ?>
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Porcentaje</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($presupuestos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['Category']); ?></td>
                            <td><?= number_format($p['Percentage'], 2); ?>%</td>
                            <td>
                                <?php
                                    $simbolo = ($p['Currency'] ?? 'CRC') === 'USD' ? '$' : '₡';
                                    echo $simbolo . number_format($p['Balance'], 2);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay presupuestos registrados.</p>
        <?php endif; ?>
    </div>

    <!-- Metas de ahorro pendientes -->
    <div class="savings-section mt-5">
        <h2 class="has-text-white">Metas de Ahorro Pendientes</h2>
        <?php if (!empty($ahorros)): ?>
            <ul>
    <?php foreach ($ahorros as $meta): ?>
        <li>💰 <?= htmlspecialchars($meta['nombre']); ?>: faltan
            <?php
                $simbolo = ($meta['moneda'] ?? 'CRC') === 'USD' ? '$' : '₡';
                echo "<strong class='has-text-white'>{$simbolo}" . number_format($meta['restante'], 2) . "</strong>";
            ?>
        </li>
    <?php endforeach; ?>
</ul>

        <?php else: ?>
            <p>No hay metas de ahorro pendientes.</p>
        <?php endif; ?>
    </div>
</main>
