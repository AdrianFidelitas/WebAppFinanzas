<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME; ?></title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/styles.css">


<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "accounts") : ?>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/cuentas.css">
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "transactions") : ?>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/transacciones.css">
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "budgets") : ?>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/presupuestos.css">
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "savingsGoals") : ?>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/metasAhorro.css">
<?php endif; ?>
<?php if (isset($_GET['views']) && explode("/", $_GET['views'])[0] === "reports") : ?>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/informes.css">
<?php endif; ?>