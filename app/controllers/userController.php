<?php

namespace app\controllers;

use app\models\mainModel;

class userController extends mainModel {

    // ========== REGISTRO ==========
    public function registerUserController() {
        $firstName  = $this->cleanString($_POST['user_first_name']);
        $lastName   = $this->cleanString($_POST['user_last_name']);
        $username   = $this->cleanString($_POST['user_username']);
        $password1  = $this->cleanString($_POST['user_password_1']);
        $password2  = $this->cleanString($_POST['user_password_2']);

        if ($firstName == "" || $lastName == "" || $username == "" || $password1 == "" || $password2 == "") {
            return $this->responseError("Todos los campos son obligatorios.");
        }

        if ($password1 !== $password2) {
            return $this->responseError("Las contraseñas no coinciden.");
        }

        $checkUsername = $this->execQuery("SELECT Username FROM Users WHERE Username = '$username'");
        if ($checkUsername->rowCount() > 0) {
            return $this->responseError("El nombre de usuario ya está registrado.");
        }

        $passwordHash = password_hash($password1, PASSWORD_BCRYPT, ["cost" => 10]);

        $params = [
            ["parameter_marker" => ":p_Firstname", "parameter_value" => $firstName],
            ["parameter_marker" => ":p_Lastname", "parameter_value" => $lastName],
            ["parameter_marker" => ":p_Username", "parameter_value" => $username],
            ["parameter_marker" => ":p_Password", "parameter_value" => $passwordHash]
        ];

        $result = $this->execStoredProcedure("CreateUser", $params);

        if ($result->rowCount() == 1) {
            return $this->responseSuccess("Usuario registrado exitosamente.");
        } else {
            return $this->responseError("No se pudo registrar el usuario.");
        }
    }

    // ========== LOGIN ==========
    public function loginUserController() {
        $username = $this->cleanString($_POST['user_username']);
        $password = $this->cleanString($_POST['user_password']);

        if ($username == "" || $password == "") {
            return $this->responseError("Todos los campos son obligatorios.");
        }

        $data = $this->execQuery("SELECT * FROM Users WHERE Username = '$username'");

        if ($data->rowCount() === 1) {
            $user = $data->fetch();

            if (password_verify($password, $user['Password'])) {
                $_SESSION['id'] = $user['UserId'];
                $_SESSION['username'] = $user['Username'];

                return json_encode([
                    "type" => "redirect",
                    "url" => APP_URL . "dashboard/"
                ]);
            } else {
                return $this->responseError("Contraseña incorrecta.");
            }
        } else {
            return $this->responseError("Usuario no encontrado.");
        }
    }

    // ========== RESPUESTAS ==========
    private function responseError($message) {
        return json_encode([
            "type" => "simple",
            "title" => "Error",
            "text" => $message,
            "icon" => "error"
        ]);
    }

    private function responseSuccess($message) {
        return json_encode([
            "type" => "redirect",
            "url" => APP_URL . "login/",
            "text" => $message,
            "icon" => "success"
        ]);
    }

    // ========== LOGOUT VISTA ==========
    public function cerrarSesionControlador() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();

        if (headers_sent()) {
            echo "<script>window.location.href='" . APP_URL . "login/';</script>";
        } else {
            header("Location: " . APP_URL . "login/");
        }
        exit;
    }

    // ========== OPCIONAL: JSON Logout ==========
    public function logoutUserController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        return json_encode([
            "type" => "redirect",
            "url" => APP_URL . "login/"
        ]);
    }
}
