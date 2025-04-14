<?php
use app\controllers\budgetsController;

$controller = new budgetsController();
$controller->distribuirPresupuesto(); // Recalcula presupuestos según ingresos del mes pasado

$presupuestos = $controller->getBudgetsByUser();

$compra = $controller->getTipoCambioCompra();
$venta  = $controller->getTipoCambioVenta();

$labels = [];
$balancesCRC = [];
$balancesUSD = [];

foreach ($presupuestos as $p) {
    $label = $p['Category'];
    $balance = (float)$p['Balance'];
    $currency = $p['Currency'] ?? 'CRC';

    $labels[] = $label;

    if ($currency === 'USD') {
        $balancesUSD[] = $balance;
        $balancesCRC[] = $compra > 0 ? $balance * $compra : $balance;
    } else {
        $balancesCRC[] = $balance;
        $balancesUSD[] = $venta > 0 ? $balance / $venta : $balance;
    }
}

$labelsJs = json_encode($labels);
$balancesCRCJs = json_encode($balancesCRC);
$balancesUSDJs = json_encode($balancesUSD);
?>

<div class="dashboard-content">
    <h2 class="title has-text-white">Presupuesto Mensual</h2>

    <div class="field mt-4" style="max-width: 250px; margin: auto;">
        <label class="label has-text-white">Ver en:</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select id="currencySelect">
                    <option value="CRC">Colones (₡)</option>
                    <option value="USD">Dólares ($)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="chart-container mt-5" style="max-width: 500px; margin: auto;">
        <canvas id="budgetChart" height="300"></canvas>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = <?= $labelsJs ?>;
const balances = {
    CRC: <?= $balancesCRCJs ?>,
    USD: <?= $balancesUSDJs ?>
};

const colores = [
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)',
    'rgba(255, 159, 64, 0.6)',
    'rgba(255, 99, 132, 0.6)'
];
const bordes = colores.map(c => c.replace('0.6', '1'));

function renderChart(moneda = 'CRC') {
    const canvas = document.getElementById('budgetChart');
    const ctx = canvas.getContext('2d');

    // ✅ Destruir instancia previa si existe (sin usar variables globales)
    const existingChart = Chart.getChart(canvas);
    if (existingChart) {
        existingChart.destroy();
    }

    const data = balances[moneda] || [];
    const simbolo = moneda === 'USD' ? '$' : '₡';
    const total = data.reduce((a, b) => a + b, 0);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: `Presupuesto (${moneda})`,
                data: data,
                backgroundColor: colores,
                borderColor: bordes,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const value = context.parsed;
                            const porcentaje = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                            return `${context.label}: ${simbolo}${value.toLocaleString(undefined, { minimumFractionDigits: 2 })} (${porcentaje}%)`;
                        }
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const currencySelect = document.getElementById('currencySelect');

    currencySelect.addEventListener('change', () => {
        renderChart(currencySelect.value);
    });

    renderChart(currencySelect.value); // inicial
});
</script>
