<?php

namespace app\controllers;
use app\models\mainModel;

class userController extends mainModel {

    /*----------  Register User Controller  ----------*/
    public function registerUserController() {
        // Receiving and cleaning data
        $firstName = $this->cleanString($_POST['user_first_name']);
        $lastName = $this->cleanString($_POST['user_last_name']);
        $username = $this->cleanString($_POST['user_username']);
        $email = $this->cleanString($_POST['user_email']);
        $password1 = $this->cleanString($_POST['user_password_1']);
        $password2 = $this->cleanString($_POST['user_password_2']);
        $userType = 1;  // Set the user type (e.g., 1 for regular user)
        $auditUser = $_SESSION['id'];  // User who is performing the action (auditing)

        // Checking required fields
        if ($firstName == "" || $lastName == "" || $username == "" || $password1 == "" || $password2 == "") {
            return $this->responseError("All required fields must be filled.");
        }

        // Checking if passwords match
        if ($password1 != $password2) {
            return $this->responseError("The passwords do not match.");
        } else {
            $password = password_hash($password1, PASSWORD_BCRYPT, ["cost" => 10]);
        }

        // Checking email
        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checkEmail = $this->execQuery("SELECT user_email FROM users WHERE user_email='$email'");
                if ($checkEmail->rowCount() > 0) {
                    return $this->responseError("The email is already registered.");
                }
            } else {
                return $this->responseError("The email is not valid.");
            }
        }

        // Checking username
        $checkUsername = $this->execQuery("SELECT user_username FROM users WHERE user_username='$username'");
        if ($checkUsername->rowCount() > 0) {
            return $this->responseError("The username is already taken.");
        }

        // Executing stored procedure to create user
        $params = [
            ["parameter_marker" => ":FirstName", "parameter_value" => $firstName],
            ["parameter_marker" => ":LastName", "parameter_value" => $lastName],
            ["parameter_marker" => ":Username", "parameter_value" => $username],
            ["parameter_marker" => ":Email", "parameter_value" => $email],
            ["parameter_marker" => ":Password", "parameter_value" => $password],
            ["parameter_marker" => ":UserType", "parameter_value" => $userType],
            ["parameter_marker" => ":AuditUser", "parameter_value" => $auditUser]
        ];

        $result = $this->execStoredProcedure("CreateUser", $params);
        if ($result->rowCount() == 1) {
            return $this->responseSuccess("The user has been successfully registered.");
        } else {
            return $this->responseError("The user could not be registered.");
        }
    }

    /*----------  List Users Controller  ----------*/
    public function listUserController($url) {
        $url = $this->cleanString($url);
        $url = APP_URL . $url . "/";

        // Ejecutar el procedimiento almacenado para obtener los usuarios
        $params = [
        ];

        // Ejecutar el SP
        $data = $this->execStoredProcedure("GetUsers", $params);
        
        // Obtener el total de usuarios para la paginación
        $total = $this->execQuery("SELECT COUNT(UserId) FROM Users WHERE AuditDeleteDate IS NULL");
        $total = (int) $total->fetchColumn();

        // Construcción de la tabla
        $table = '<div class="table-container">';
        $table .= '<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">';
        $table .= '<thead><tr><th>#</th><th>Nombre</th><th>Usuario</th><th>Email</th><th>Creado</th><th>Opciones</th></tr></thead><tbody>';

        // Recorrer los datos de los usuarios
        foreach ($data as $rows) {
            $table .= '<tr>';
            $table .= '<td>' . $rows['UserId'] . '</td>';
            $table .= '<td>' . $rows['Firstname'] . ' ' . $rows['Lastname'] . '</td>';
            $table .= '<td>' . $rows['Username'] . '</td>';
            $table .= '<td>' . $rows['Email'] . '</td>';
            $table .= '<td>' . date("d-m-Y H:i:s", strtotime($rows['AuditCreateDate'])) . '</td>';
            $table .= '<td><a href="' . APP_URL . 'userUpdate/' . $rows['UserId'] . '/" class="button is-info">Actualizar</a></td>';
            $table .= '</tr>';
        }

        $table .= '</tbody></table></div>';

        return $table;
    }

    /*----------  Delete User Controller  ----------*/
    public function deleteUserController() {
        $id = $this->cleanString($_POST['user_id']);
        $auditUser = $_SESSION['id']; // Auditing the user who is performing the action

        // Executing stored procedure to delete user
        $params = [
            ["parameter_marker" => ":UserId", "parameter_value" => $id],
            ["parameter_marker" => ":AuditUser", "parameter_value" => $auditUser]
        ];

        $result = $this->execStoredProcedure("DeleteUser", $params);
        if ($result->rowCount() == 1) {
            return $this->responseSuccess("The user has been successfully deleted.");
        } else {
            return $this->responseError("The user could not be deleted.");
        }
    }

    /*----------  Update User Controller  ----------*/
    public function updateUserController() {
        $id = $this->cleanString($_POST['user_id']);
        $firstName = $this->cleanString($_POST['user_first_name']);
        $lastName = $this->cleanString($_POST['user_last_name']);
        $username = $this->cleanString($_POST['user_username']);
        $email = $this->cleanString($_POST['user_email']);
        $password1 = $this->cleanString($_POST['user_password_1']);
        $password2 = $this->cleanString($_POST['user_password_2']);
        $auditUser = $_SESSION['id'];  // Auditing the user who is performing the action

        // Checking required fields
        if ($firstName == "" || $lastName == "" || $username == "") {
            return $this->responseError("All required fields must be filled.");
        }

        // Checking if passwords match
        if ($password1 != $password2) {
            return $this->responseError("The passwords do not match.");
        } else {
            $password = password_hash($password1, PASSWORD_BCRYPT, ["cost" => 10]);
        }

        // Checking email
        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checkEmail = $this->execQuery("SELECT user_email FROM users WHERE user_email='$email' AND user_id != '$id'");
                if ($checkEmail->rowCount() > 0) {
                    return $this->responseError("The email is already registered.");
                }
            } else {
                return $this->responseError("The email is not valid.");
            }
        }

        // Executing the stored procedure to update user
        $params = [
            ["parameter_marker" => ":UserId", "parameter_value" => $id],
            ["parameter_marker" => ":FirstName", "parameter_value" => $firstName],
            ["parameter_marker" => ":LastName", "parameter_value" => $lastName],
            ["parameter_marker" => ":Username", "parameter_value" => $username],
            ["parameter_marker" => ":Email", "parameter_value" => $email],
            ["parameter_marker" => ":Password", "parameter_value" => $password],
            ["parameter_marker" => ":AuditUser", "parameter_value" => $auditUser]
        ];

        $result = $this->execStoredProcedure("UpdateUser", $params);
        if ($result->rowCount() == 1) {
            return $this->responseSuccess("The user has been successfully updated.");
        } else {
            return $this->responseError("The user could not be updated.");
        }
    }

    private function responseError($message) {
        return json_encode([
            "type" => "simple",
            "title" => "An unexpected error occurred",
            "text" => $message,
            "icon" => "error"
        ]);
    }

    private function responseSuccess($message) {
        return json_encode([
            "type" => "reload",
            "title" => "Operation Successful",
            "text" => $message,
            "icon" => "success"
        ]);
    }
}
