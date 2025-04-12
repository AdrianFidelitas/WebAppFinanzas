<?php
use app\controllers\transactionsController;

$controller = new transactionsController();
$cuentas = $controller->getAccounts(); // Debería venir de SP en producción
$transacciones = $controller->getTransactionsByUser(); // Obtener transacciones reales
?>

<div class="dashboard-content">
    <h2 class="title has-text-white">Gestión de Transacciones</h2>
    <button class="button is-primary mb-3" onclick="showTransactionModal()">Añadir Transacción</button>

    <div class="chart-container mt-5">
        <canvas id="transactionsChart"></canvas>
    </div>

    <h3 class="title is-4 has-text-white mt-5">Transacciones Recientes</h3>
    <table class="table is-fullwidth is-striped is-hoverable mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Monto</th>
                <th>Cuenta Origen</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transacciones)): ?>
                <?php foreach ($transacciones as $trx): ?>
                    <tr>
                        <td><?php echo $trx['TransactionId']; ?></td>
                        <td><?php echo $trx['Name']; ?></td>
                        <td><?php echo number_format($trx['Amount'], 2); ?> ₡</td>
                        <td><?php echo $trx['SourceAccountId']; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($trx['TransactionDate'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay transacciones registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar transacción -->
<div id="transactionModal" class="modal">
    <div class="modal-background" onclick="closeTransactionModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Añadir Transacción</p>
            <button class="delete" aria-label="close" onclick="closeTransactionModal()"></button>
        </header>
        <section class="modal-card-body">
            <form action="<?php echo APP_URL; ?>transaction/store" method="POST">
                <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control">
                        <input class="input" name="nombre" type="text" placeholder="Ej. Renta, Compra">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Descripción</label>
                    <div class="control">
                        <textarea class="textarea" name="descripcion" placeholder="Detalle de la transacción"></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="select is-fullwidth">
                        <select name="tipo">
                            <option value="0">Ingreso</option>
                            <option value="1">Egreso</option>
                            <option value="2">Transferencia</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Cuenta origen</label>
                    <div class="select is-fullwidth">
                        <select name="cuenta_origen">
                            <?php foreach ($cuentas as $cuenta): ?>
                                <option value="<?php echo $cuenta['Id']; ?>"><?php echo $cuenta['Name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Cuenta destino (opcional)</label>
                    <div class="select is-fullwidth">
                        <select name="cuenta_destino">
                            <option value="">-- Ninguna --</option>
                            <?php foreach ($cuentas as $cuenta): ?>
                                <option value="<?php echo $cuenta['Id']; ?>"><?php echo $cuenta['Name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Monto</label>
                    <div class="control">
                        <input class="input" name="monto" type="number" min="0" step="0.01" placeholder="₡">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Fecha</label>
                    <div class="control">
                        <input class="input" name="fecha" type="date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
        </section>
        <footer class="modal-card-foot">
            <button type="submit" class="button is-success">Guardar</button>
            <button type="button" class="button" onclick="closeTransactionModal()">Cancelar</button>
            </form>
        </footer>
    </div>
</div>
