<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Finanzas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="transacciones.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="dashboard-content"> 
            <h2 class="title has-text-white">Gestión de Transacciones</h2>
            <button class="button is-primary" onclick="showTransactionModal()">Añadir Transacción</button>
            <button class="button is-warning" onclick="showRecurringModal()">Añadir Transacción Recurrente</button>
        
            <div class="chart-container mt-5">
                <canvas id="transactionsChart"></canvas>
            </div>

            <h3 class="title is-4 has-text-white mt-5">Transacciones</h3>
            <table class="table is-fullwidth is-striped is-hoverable mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Monto</th>
                        <th>Categoría</th>
                        <th>Cuenta</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="transactionTable"></tbody>
            </table>

            <h3 class="title is-4 has-text-white mt-5">Transacciones Recurrentes</h3>
            <table class="table is-fullwidth is-striped is-hoverable mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Monto</th>
                        <th>Categoría</th>
                        <th>Cuenta</th>
                        <th>Frecuencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="recurringTable"></tbody>
            </table>
        </div>    
    </div>
    
   
    <!-- Modal para agregar transacción -->
    <div id="transactionModal" class="modal">
        <div class="modal-background" onclick="closeTransactionModal()"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Añadir/Editar Transacción</p>
                <button class="delete" aria-label="close" onclick="closeTransactionModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Moneda</label>
                    <div class="control"> 
                        <div class="select is-fullwidth">
                            <select id="savingCurrency">
                                <option value="">Seleccionar moneda</option>
                                <option value="USD">$ - Dólares (USD)</option>
                                <option value="CRC">₡ - Colones (CRC)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Monto</label>
                    <div class="control">
                        <input class="input" type="number" id="transactionAmount" placeholder="Monto">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Categoría</label>
                    <div class="control">
                        <input class="input" type="text" id="transactionCategory" placeholder="Categoría">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Cuenta</label>
                    <div class="control">
                        <input class="input" type="text" id="transactionAccount" placeholder="Cuenta">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Fecha</label>
                    <div class="control">
                        <input class="input" type="date" id="transactionDate">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" onclick="saveTransaction()">Guardar</button>
                <button class="button" onclick="closeTransactionModal()">Cancelar</button>
            </footer>
        </div>
    </div>

    <!-- Modal para agregar transacción recurrente -->
    <div id="recurringModal" class="modal">
        <div class="modal-background" onclick="closeRecurringModal()"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Añadir Transacción Recurrente</p>
                <button class="delete" aria-label="close" onclick="closeRecurringModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Monto</label>
                    <div class="control">
                        <input class="input" type="number" id="recurringAmount" placeholder="Monto">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Categoría</label>
                    <div class="control">
                        <input class="input" type="text" id="recurringCategory" placeholder="Categoría">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Cuenta</label>
                    <div class="control">
                        <input class="input" type="text" id="recurringAccount" placeholder="Cuenta">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Frecuencia</label>
                    <div class="control">
                        <input class="input" type="text" id="recurringFrequency" placeholder="Ej: Mensual, Semanal">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" onclick="saveRecurringTransaction()">Guardar</button>
                <button class="button" onclick="closeRecurringModal()">Cancelar</button>
            </footer>
        </div>
    </div>

    <script src="transacciones.js"></script>
</body>
</html>
