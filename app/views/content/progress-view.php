<?php
use app\controllers\progressController;

$controller = new progressController();
$raw = $controller->getProgressData($_SESSION['id']);

$goals = $raw['goals'];
$budgets = $raw['budgets'];
$transactions = $raw['transactions'];
$labels = $raw['labels'];
$compra = $raw['tipocambio']['compra'];
$venta = $raw['tipocambio']['venta'];

$labelsJs = json_encode($labels);
$compraJs = json_encode($compra);
$ventaJs = json_encode($venta);

$transactionsJs = [];

foreach ($transactions as $t) {
    $month = (int)date('n', strtotime($t['DateTransaction']));
    $amount = (float)$t['Amount'];
    $currency = $t['Currency'];
    $type = $t['TypeTransaction'];

    $transactionsJs[] = [
        'month' => $month,
        'amount' => $amount,
        'currency' => $currency,
        'type' => $type,
        'Category' => $t['Category'] ?? null
    ];
}

$goalsJs = json_encode($goals);
$budgetsJs = json_encode($budgets);
$transactionsJs = json_encode($transactionsJs);
?>

<!-- Scroll & Layout Fix -->
<style>
    html, body {
        height: auto;
        min-height: 100%;
        overflow-y: auto;
        background-color: #1e1e2f;
        color: #ffffff;
    }

    .dashboard-content {
        padding: 30px;
        width: 100%;
    }

    .chart-container {
        background-color: #26263a;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
        margin-bottom: 40px;
    }

    .progress {
        height: 1.1rem;
    }

    @media (max-width: 768px) {
        .dashboard-content {
            padding: 20px;
        }
    }
</style>

<div class="dashboard-content">
    <h2 class="title has-text-white">Progreso Financiero</h2>

    <div class="field mt-4" style="max-width: 250px;">
        <label class="label has-text-white">Ver en:</label>
        <div class="select is-fullwidth">
            <select id="currencySelect">
                <option value="CRC">Colones (₡)</option>
                <option value="USD">Dólares ($)</option>
            </select>
        </div>
    </div>

    <div id="progressData" class="mt-5 scrollable-section">
    <!-- Contenido generado por JS -->
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const rawGoals = <?= $goalsJs ?>;
const rawBudgets = <?= $budgetsJs ?>;
const rawTransactions = <?= $transactionsJs ?>;
const labels = <?= $labelsJs ?>;
const tipoCambio = { compra: <?= $compraJs ?>, venta: <?= $ventaJs ?> };

let chart = null;

function convertirMonto(monto, origen, destino) {
    if (origen === destino) return monto;
    if (origen === 'USD' && destino === 'CRC') return tipoCambio.compra > 0 ? monto * tipoCambio.compra : monto;
    if (origen === 'CRC' && destino === 'USD') return tipoCambio.venta > 0 ? monto / tipoCambio.venta : monto;
    return monto;
}

function renderProgress(moneda) {
    const simbolo = moneda === 'USD' ? '$' : '₡';

    // Metas
    let metasHtml = '<h3 class="title is-4 has-text-white">Metas de Ahorro</h3>';
    rawGoals.forEach(g => {
        const balance = convertirMonto(parseFloat(g.Balance), g.Currency, moneda);
        const target = convertirMonto(parseFloat(g.TargetAmount), g.Currency, moneda);
        const progress = target > 0 ? ((balance / target) * 100).toFixed(2) : 0;

        metasHtml += `
            <div class="box is-fullwidth">
                <p><strong>${g.NameGoal}</strong> (${simbolo}${balance.toFixed(2)} / ${simbolo}${target.toFixed(2)})</p>
                <progress class="progress is-success" value="${progress}" max="100">${progress}%</progress>
            </div>
        `;
    });

    // Presupuestos
    const gastoPorCategoria = {};
    rawTransactions.forEach(t => {
        if (t.type === 2) {
            const cat = t.Category || '';
            gastoPorCategoria[cat] = (gastoPorCategoria[cat] || 0) + convertirMonto(t.amount, t.currency, moneda);
        }
    });

    let presupuestoHtml = '<h3 class="title is-4 has-text-white">Ejecución de Presupuestos</h3>';
    rawBudgets.forEach(b => {
        const budget = convertirMonto(parseFloat(b.Balance), b.Currency, moneda);
        const spent = gastoPorCategoria[b.Category] || 0;
        const percent = budget > 0 ? ((spent / budget) * 100).toFixed(2) : 0;

        presupuestoHtml += `
            <div class="box is-fullwidth">
                <p><strong>${b.Category}</strong> (${simbolo}${spent.toFixed(2)} / ${simbolo}${budget.toFixed(2)})</p>
                <progress class="progress is-info" value="${percent}" max="100">${percent}%</progress>
            </div>
        `;
    });

    // Ingresos y Gastos Mensuales
    const income = Array(12).fill(0);
    const expense = Array(12).fill(0);
    rawTransactions.forEach(t => {
        const month = t.month - 1;
        const amount = convertirMonto(t.amount, t.currency, moneda);
        if (t.type == 1) income[month] += amount;
        else expense[month] += amount;
    });

    const chartCanvas = `<canvas id="progressChart" height="120" style="width:100%; max-width:100%;"></canvas>`;

    document.getElementById('progressData').innerHTML = `
    <h3 class="title is-4 has-text-white">Ingresos vs Gastos Mensuales</h3>
    <div class="chart-container">
        ${chartCanvas}
    </div>
    ${metasHtml}
    ${presupuestoHtml}
    
`;

    if (chart) chart.destroy();

    const ctx = document.getElementById('progressChart').getContext('2d');
    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: `Ingresos (${simbolo})`,
                    data: income,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: `Gastos (${simbolo})`,
                    data: expense,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
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

document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('currencySelect');
    select.addEventListener('change', () => renderProgress(select.value));
    renderProgress(select.value);
});
</script>
