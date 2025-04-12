<?php
use app\controllers\budgetsController;

$controller = new budgetsController();
$cuentas = $controller->getAccounts(); // Asegúrate que esta función devuelva un array de cuentas
?>

<div class="dashboard-content">
            <h2 class="title has-text-white">Gestión de Presupuestos</h2>
            <button class="button is-primary" onclick="showBudgetModal()">Crear Presupuesto</button>
            <button class="button is-warning" onclick="showAdminBudgetModal()">Presupuesto del Administrador</button>
            
            <div class="chart-container mt-5">
                <canvas id="budgetChart"></canvas>
            </div>

            <h3 class="title is-4 has-text-white mt-5">Mis Presupuestos</h3>
            <table class="table is-fullwidth is-striped is-hoverable mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Monto Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="budgetTable"></tbody>
            </table>
        </div>

<!-- Modal para crear presupuesto -->
    <div id="budgetModal" class="modal">
        <div class="modal-background" onclick="closeBudgetModal()"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Crear Presupuesto</p>
                <button class="delete" aria-label="close" onclick="closeBudgetModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nombre del Presupuesto</label>
                    <div class="control">
                        <input class="input" type="text" id="budgetName" placeholder="Ej: Presupuesto de Ahorro">
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
                    <label class="label">Monto Total</label>
                    <div class="control">
                        <input class="input" type="number" id="budgetAmount" placeholder="Monto">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" onclick="saveBudget()">Guardar</button>
                <button class="button" onclick="closeBudgetModal()">Cancelar</button>
            </footer>
        </div>
    </div>

    <!-- Modal para presupuestos del administrador -->
    <div id="adminBudgetModal" class="modal">
        <div class="modal-background" onclick="closeAdminBudgetModal()"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Presupuesto Sugerido por el Administrador</p>
                <button class="delete" aria-label="close" onclick="closeAdminBudgetModal()"></button>
            </header>
            <section class="modal-card-body">
                <p>El administrador sugiere el siguiente presupuesto basado en su actividad financiera:</p>
                <ul>
                    <li>🏠 Vivienda: $500</li>
                    <li>🍽 Alimentación: $300</li>
                    <li>🚗 Transporte: $200</li>
                    <li>💰 Ahorro: $150</li>
                </ul>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" onclick="acceptAdminBudget()">Aceptar</button>
                <button class="button" onclick="closeAdminBudgetModal()">Cancelar</button>
            </footer>
        </div>
    </div>