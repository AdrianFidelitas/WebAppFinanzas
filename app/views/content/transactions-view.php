<div class="container mt-5">
    <!-- Resumen Financiero -->
    <div class="columns is-multiline mb-4">
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="has-text-weight-semibold">Ingresos:</p>
                <p class="has-text-success">$<?= number_format($totals['ingresos'] ?? 0, 2) ?></p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="has-text-weight-semibold">Egresos:</p>
                <p class="has-text-danger">$<?= number_format($totals['egresos'] ?? 0, 2) ?></p>
            </div>
        </div>
        <div class="column is-one-third">
            <div class="box has-text-centered">
                <p class="has-text-weight-semibold">Balance:</p>
                <p class="has-text-weight-bold">
                    $<?= number_format(($totals['ingresos'] ?? 0) - ($totals['egresos'] ?? 0), 2) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Barra de Acciones -->
    <div class="level mb-4">
        <div class="level-left">
            <form action="/transactions/search" method="get" class="field has-addons">
                <div class="control">
                    <input class="input" type="text" name="q" placeholder="Buscar..." value="<?= htmlspecialchars($search_term ?? '') ?>">
                </div>
                <div class="control">
                    <button class="button is-info" type="submit">🔍</button>
                </div>
            </form>
        </div>
        <div class="level-right">
            <a href="/transactions/create" class="button is-primary">➕ Nueva Transacción</a>
        </div>
    </div>

    <!-- Tabla de Transacciones -->
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($t['fecha'])) ?></td>
                    <td>
                        <span class="tag <?= $t['tipo'] == 1 ? 'is-success' : 'is-danger' ?>">
                            <?= $t['tipo'] == 1 ? 'Ingreso' : 'Egreso' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($t['nombre']) ?></td>
                    <td class="<?= $t['tipo'] == 1 ? 'has-text-success' : 'has-text-danger' ?>">
                        $<?= number_format($t['monto'], 2) ?>
                    </td>
                    <td class="is-flex is-align-items-center">
                        <a href="/transactions/edit/<?= $t['id'] ?>" class="button is-small is-warning mr-2">✏️</a>
                        <a href="/transactions/delete/<?= $t['id'] ?>" class="button is-small is-danger" onclick="return confirm('¿Eliminar transacción?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
