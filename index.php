<?php
require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/inc/session_start.php";

use app\controllers\viewsController;

$url = isset($_GET['views']) ? explode("/", $_GET['views']) : ["login"];

$viewsController = new viewsController();
$view = $viewsController->getViewsController($url[0]);

// Rutas públicas
$rutasPublicas = ['login', 'register', '404'];

// Bloquear acceso si no está logueado
if (!in_array($url[0], $rutasPublicas) && !isset($_SESSION['id'])) {
    header("Location: " . APP_URL . "login/");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body>
    <?php 
    if (in_array($url[0], $rutasPublicas)) {
        require_once $view;
    } else {
        echo '<div class="container">';
        require_once "./app/views/inc/sidebar.php";
        require_once $view;
        echo '</div>';
    }

    require_once "./app/views/inc/script.php";
    ?>
</body>
</html>
