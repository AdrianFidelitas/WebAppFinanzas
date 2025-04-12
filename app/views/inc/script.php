<script src="<?php echo APP_URL; ?>app/views/js/ajax.js"></script>
<script src="<?php echo APP_URL; ?>app/views/js/main.js"></script>

<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "accounts") : ?>
    <script src="<?php echo APP_URL; ?>app/views/js/cuentas.js"></script>
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "transactions") : ?>
    <script src="<?php echo APP_URL; ?>app/views/js/transacciones.js"></script>
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "budgets") : ?>
    <script src="<?php echo APP_URL; ?>app/views/js/presupuestos.js"></script>
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "savingsGoals") : ?>
    <script src="<?php echo APP_URL; ?>app/views/js/metasAhorro.js"></script>
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "reports") : ?>
    <script src="<?php echo APP_URL; ?>app/views/js/informes.js"></script>
<?php endif; ?>