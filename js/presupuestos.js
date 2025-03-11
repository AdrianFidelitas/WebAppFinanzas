var ctx = document.getElementById('budgetChart').getContext('2d');
        var budgetChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Vivienda', 'Alimentación', 'Transporte', 'Ahorro'],
                datasets: [{
                    data: [500, 300, 200, 150],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        function showBudgetModal() {
            document.getElementById("budgetModal").classList.add("is-active");
        }
        function closeBudgetModal() {
            document.getElementById("budgetModal").classList.remove("is-active");
        }
        function showAdminBudgetModal() {
            document.getElementById("adminBudgetModal").classList.add("is-active");
        }
        function closeAdminBudgetModal() {
            document.getElementById("adminBudgetModal").classList.remove("is-active");
        }
        function saveBudget() {
            const name = document.getElementById("budgetName").value;
            const amount = document.getElementById("budgetAmount").value;
            if (!name || !amount) {
                Swal.fire("Error", "Todos los campos son obligatorios", "error");
                return;
            }
            const newRow = `<tr>
                <td>#</td>
                <td>${name}</td>
                <td>${amount}</td>
                <td>
                    <button class='button is-warning is-small'>Editar</button>
                    <button class='button is-danger is-small'>Eliminar</button>
                </td>
            </tr>`;
            document.getElementById("budgetTable").innerHTML += newRow;
            closeBudgetModal();
            Swal.fire("Éxito", "Presupuesto creado correctamente", "success");
        }
        function acceptAdminBudget() {
            Swal.fire("¡Presupuesto Aceptado!", "El presupuesto del administrador ha sido asignado.", "success");
            closeAdminBudgetModal();
        }