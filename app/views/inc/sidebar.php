<aside class="sidebar">
    <h2>Sistema Finanzas</h2>
    <ul>
        <li><a href="<?php echo APP_URL; ?>dashboard/"><i class="fas fa-home"></i> Panel de control</a></li>
        <li><a href="<?php echo APP_URL; ?>budgets/"><i class="fas fa-coins"></i> Presupuestos</a></li>
        <li><a href="<?php echo APP_URL; ?>savingsGoals/"><i class="fas fa-piggy-bank"></i> Metas de Ahorro</a></li>
        <li><a href="<?php echo APP_URL; ?>transactions/"><i class="fas fa-arrows-rotate"></i> Transacciones</a></li>
        <li><a href="<?php echo APP_URL; ?>progress/"><i class="fas fa-chart-line"></i> Informes</a></li>
    </ul>

    <hr style="margin: 20px 0; border-color: #333;">

    <form action="<?= APP_URL ?>logout" method="POST">
        <button type="submit" class="button is-danger is-fullwidth">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </form>
</aside>
