var ctx = document.getElementById('transactionsChart').getContext('2d');
var transactionsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
        datasets: [{
            label: 'Gastos Mensuales',
            data: [500, 700, 800, 650, 900],
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function showTransactionModal() {
    document.getElementById("transactionModal").classList.add("is-active");
}

function closeTransactionModal() {
    document.getElementById("transactionModal").classList.remove("is-active");
}

function showRecurringModal() {
    document.getElementById("recurringModal").classList.add("is-active");
}

function closeRecurringModal() {
    document.getElementById("recurringModal").classList.remove("is-active");
}