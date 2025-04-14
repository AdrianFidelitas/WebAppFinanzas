<?php
use app\controllers\userController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logout = new userController();
$logout->cerrarSesionControlador();
