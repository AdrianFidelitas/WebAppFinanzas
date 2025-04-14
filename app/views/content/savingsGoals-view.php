<?php
use app\controllers\savingsGoalsController;

$controller = new savingsGoalsController();
$userId = $_SESSION['id'];
$actionResult = null;

// Eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['formAction'] === 'delete') {
    if (!empty($_POST['deleteGoalId'])) {
        $controller->deleteGoal($_POST['deleteGoalId']);
        header("Location: savingsGoals/?action=deleted");
        exit;
    }
}

// Crear o actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['formAction'] === 'save') {
    $tc = $controller->getTipoCambio();

    $data = [
        'UserId'        => $userId,
        'NameGoal'      => $_POST['NameGoal'],
        'TargetAmount'  => $_POST['TargetAmount'],
        'PlannedAmount' => $_POST['PlannedAmount'],
        'Balance'       => $_POST['Balance'] ?? 0,
        'Currency'      => $_POST['Currency'],
        'PrecioCompra'  => $tc['compra'] ?? 0,
        'PrecioVenta'   => $tc['venta'] ?? 0
    ];

    if (!empty($_POST['goalId'])) {
        $controller->updateGoal($_POST['goalId'], $data);
        $actionResult = 'updated';
    } else {
        $controller->createGoal($data);
        $actionResult = 'created';
    }

    header("Location: savingsGoals/?action={$actionResult}");
    exit;
}

$goals = $controller->getGoalsByUser($userId);
$actionMessage = $_GET['action'] ?? null;
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
                <th>Planificado</th>
                <th>Acumulado</th>
                <th>Progreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($goals)): ?>
                <?php foreach ($goals as $goal): ?>
                    <tr>
                        <td><?= $goal['SavingsGoalsId']; ?></td>
                        <td><?= $goal['NameGoal']; ?></td>
                        <td><?= number_format($goal['TargetAmount'], 2); ?> <?= $goal['Currency'] ?></td>
                        <td><?= number_format($goal['PlannedAmount'], 2); ?> <?= $goal['Currency'] ?></td>
                        <td><?= number_format($goal['Balance'], 2); ?> <?= $goal['Currency'] ?></td>
                        <td>
                            <?php
                                $progress = $goal['TargetAmount'] > 0
                                    ? min(100, ($goal['Balance'] / $goal['TargetAmount']) * 100)
                                    : 0;
                            ?>
                            <progress class="progress is-success" value="<?= $progress; ?>" max="100">
                                <?= round($progress); ?>%
                            </progress>
                        </td>
                        <td>
                            <button
                                class="button is-small is-warning"
                                onclick="editSaving(this)"
                                data-id="<?= $goal['SavingsGoalsId']; ?>"
                                data-name="<?= htmlspecialchars($goal['NameGoal'], ENT_QUOTES); ?>"
                                data-target="<?= $goal['TargetAmount']; ?>"
                                data-planned="<?= $goal['PlannedAmount']; ?>"
                                data-balance="<?= $goal['Balance']; ?>"
                                data-currency="<?= $goal['Currency']; ?>"
                            >Editar</button>
                            <button class="button is-small is-danger" onclick="confirmDelete(<?= $goal['SavingsGoalsId']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No hay metas de ahorro registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="savingModal" class="modal">
    <div class="modal-background" onclick="closeSavingModal()"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p id="modalTitle" class="modal-card-title">Crear Meta de Ahorro</p>
            <button class="delete" aria-label="close" onclick="closeSavingModal()"></button>
        </header>
        <form id="savingForm" method="POST">
            <input type="hidden" name="formAction" value="save">
            <section class="modal-card-body">
                <input type="hidden" name="goalId" id="goalId">
                <input type="hidden" name="Balance" id="savingBalance" value="0">

                <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control">
                        <input class="input" type="text" name="NameGoal" id="savingName" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Monto Meta</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" name="TargetAmount" id="savingGoal" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Aporte Planificado</label>
                    <div class="control">
                        <input class="input" type="number" step="0.01" name="PlannedAmount" id="plannedAmount" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Moneda</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="Currency" id="savingCurrency" required>
                                <option value="CRC">Colones (₡)</option>
                                <option value="USD">Dólares ($)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button type="submit" class="button is-success">Guardar</button>
                <button type="button" class="button" onclick="closeSavingModal()">Cancelar</button>
            </footer>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showSavingModal() {
    clearForm();
    document.getElementById("modalTitle").textContent = "Crear Meta de Ahorro";
    document.getElementById("savingModal").classList.add("is-active");
}

function closeSavingModal() {
    document.getElementById("savingModal").classList.remove("is-active");
}

function clearForm() {
    document.getElementById('goalId').value = '';
    document.getElementById('savingName').value = '';
    document.getElementById('savingGoal').value = '';
    document.getElementById('plannedAmount').value = '';
    document.getElementById('savingBalance').value = '0';
    document.getElementById('savingCurrency').value = 'CRC';
}

function editSaving(button) {
    document.getElementById('goalId').value = button.dataset.id;
    document.getElementById('savingName').value = button.dataset.name;
    document.getElementById('savingGoal').value = button.dataset.target;
    document.getElementById('plannedAmount').value = button.dataset.planned;
    document.getElementById('savingBalance').value = button.dataset.balance;
    document.getElementById('savingCurrency').value = button.dataset.currency;
    document.getElementById("modalTitle").textContent = "Editar Meta de Ahorro";
    document.getElementById("savingModal").classList.add("is-active");
}

function confirmDelete(goalId) {
    Swal.fire({
        title: '¿Eliminar meta?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'savingsGoals/';
            form.innerHTML = `
                <input type="hidden" name="formAction" value="delete">
                <input type="hidden" name="deleteGoalId" value="${goalId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Toast
<?php if ($actionMessage === 'created'): ?>
Swal.fire({ icon: 'success', title: 'Meta creada con éxito', toast: true, timer: 2000, position: 'top-end', showConfirmButton: false });
<?php elseif ($actionMessage === 'updated'): ?>
Swal.fire({ icon: 'success', title: 'Meta actualizada con éxito', toast: true, timer: 2000, position: 'top-end', showConfirmButton: false });
<?php elseif ($actionMessage === 'deleted'): ?>
Swal.fire({ icon: 'success', title: 'Meta eliminada', toast: true, timer: 2000, position: 'top-end', showConfirmButton: false });
<?php endif; ?>
</script>
