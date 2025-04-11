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
    <link rel="stylesheet" href="metasAhorro.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="dashboard-content">
        <h2 class="title has-text-white">Gestión de Ahorro</h2>
        <button class="button is-primary" onclick="showSavingModal()">Crear Meta de Ahorro</button>
        
        <h3 class="title is-4 has-text-white mt-5">Metas de Ahorro</h3>
        <table class="table is-fullwidth is-striped is-hoverable mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Monto Meta</th>
                    <th>Progreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="savingTable"></tbody>
        </table>
    </div>

    <!-- Modal para agregar meta de ahorro -->
    <div id="savingModal" class="modal">
        <div class="modal-background" onclick="closeSavingModal()"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Crear Meta de Ahorro</p>
                <button class="delete" aria-label="close" onclick="closeSavingModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nombre de la Meta</label>
                    <div class="control">
                        <input class="input" type="text" id="savingName" placeholder="Ej: Viaje a Europa">
                    </div>
                </div>
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
                    <label class="label">Monto Meta</label>
                    <div class="control">
                        <input class="input" type="number" id="savingGoal" placeholder="Monto Meta">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Monto Actual</label>
                    <div class="control">
                        <input class="input" type="number" id="savingCurrent" placeholder="Monto Ahorrado">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" onclick="saveSaving()">Guardar</button>
                <button class="button" onclick="closeSavingModal()">Cancelar</button>
            </footer>
        </div>
    </div>

    <script src="metasAhorro.js"></script>
</body>
</html>