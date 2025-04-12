<?php
use app\controllers\savingsGoalsController;

$controller = new savingsGoalsController();
$goals = $controller->getAllGoals();
?>

<div class="dashboard-content">
    <h2 class="title has-text-white">Gestión de Ahorro</h2>
    <button class="button is-primary mb-4" onclick="showSavingModal()">Crear Meta de Ahorro</button>

    <h3 class="title is-4 has-text-white mt-5">Metas de Ahorro</h3>
    <table class="table is-fullwidth is-striped is-hoverable mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Monto Meta</th>
                <th>Ahorrado</th>
                <th>Fecha Meta</th>
                <th>Progreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($goals)): ?>
                <?php foreach ($goals as $goal): ?>
                    <tr>
                        <td><?php echo $goal['FinancialGoalId']; ?></td>
                        <td><?php echo $goal['Name']; ?></td>
                        <td><?php echo number_format($goal['TargetAmount'], 2); ?> ₡</td>
                        <td><?php echo number_format($goal['SavedAmount'], 2); ?> ₡</td>
                        <td><?php echo date('d-m-Y', strtotime($goal['TargetDate'])); ?></td>
                        <td>
                            <?php 
                                $progress = $goal['TargetAmount'] > 0 
                                    ? min(100, ($goal['SavedAmount'] / $goal['TargetAmount']) * 100) 
                                    : 0;
                            ?>
                            <progress class="progress is-success" value="<?php echo $progress; ?>" max="100">
                                <?php echo round($progress); ?>%
                            </progress>
                        </td>
                        <td>
                            <button class="button is-small is-warning" onclick="editSaving(<?php echo $goal['FinancialGoalId']; ?>)">Editar</button>
                            <button class="button is-small is-danger" onclick="deleteSaving(<?php echo $goal['FinancialGoalId']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No hay metas de ahorro registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar/editar meta de ahorro -->
<div id="savingModal" class="modal">
    <div class="modal-background" onclick="closeSavingModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Crear Meta de Ahorro</p>
            <button class="delete" aria-label="close" onclick="closeSavingModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="savingForm" action="<?php echo APP_URL; ?>savings/store" method="POST">
                <input type="hidden" name="goalId" id="goalId">

                <div class="field">
                    <label class="label">Nombre de la Meta</label>
                    <div class="control">
                        <input class="input" type="text" name="Name" id="savingName" placeholder="Ej: Viaje a Europa" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Monto Meta</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" min="0" name="TargetAmount" id="savingGoal" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Aporte Mensual Planificado</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" min="0" name="PlannedAmount" id="plannedAmount" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Monto Ahorrado</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" min="0" name="SavedAmount" id="savingCurrent" required>
                    </div>
                </div>
        </section>
        <footer class="modal-card-foot">
            <button type="submit" class="button is-success">Guardar</button>
            <button type="button" class="button" onclick="closeSavingModal()">Cancelar</button>
            </form>
        </footer>
    </div>
</div>
