<?php

namespace app\controllers;

use app\models\mainModel;

class accountsController extends mainModel {

    // Obtiene todas las cuentas activas de un usuario
    public function getAccounts() {
        $userId = 1; // Reemplazá por $_SESSION['id'] cuando tengas login

        $params = [
            ["parameter_marker" => ":UserId", "parameter_value" => $userId]
        ];

        // Asumo que existe este procedimiento que filtra por usuario
        $cuentas = $this->execStoredProcedure("GetAccountsByUser", $params)->fetchAll();

        return $cuentas;
    }

    // Crear una nueva cuenta
    public function createAccount($data) {
        $params = [
            ["parameter_marker" => ":p_Name", "parameter_value" => $data["Name"]],
            ["parameter_marker" => ":p_UserId", "parameter_value" => $data["UserId"]],
            ["parameter_marker" => ":p_CurrencyId", "parameter_value" => $data["CurrencyId"]],
            ["parameter_marker" => ":p_AccountType", "parameter_value" => $data["AccountType"]],
            ["parameter_marker" => ":p_Balance", "parameter_value" => $data["Balance"]],
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $data["AuditUser"]],
        ];

        return $this->execStoredProcedure("CreateAccount", $params);
    }

    // Editar cuenta existente
    public function updateAccount($data) {
        $params = [
            ["parameter_marker" => ":p_AccountId", "parameter_value" => $data["AccountId"]],
            ["parameter_marker" => ":p_Name", "parameter_value" => $data["Name"]],
            ["parameter_marker" => ":p_UserId", "parameter_value" => $data["UserId"]],
            ["parameter_marker" => ":p_CurrencyId", "parameter_value" => $data["CurrencyId"]],
            ["parameter_marker" => ":p_AccountType", "parameter_value" => $data["AccountType"]],
            ["parameter_marker" => ":p_Balance", "parameter_value" => $data["Balance"]],
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $data["AuditUser"]],
        ];

        return $this->execStoredProcedure("UpdateAccount", $params);
    }

    // Eliminar cuenta (soft delete)
    public function deleteAccount($accountId, $auditUser) {
        $params = [
            ["parameter_marker" => ":p_AccountId", "parameter_value" => $accountId],
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $auditUser],
        ];

        return $this->execStoredProcedure("DeleteAccount", $params);
    }

    // Obtener una sola cuenta
    public function getAccountById($accountId) {
        $params = [
            ["parameter_marker" => ":p_AccountId", "parameter_value" => $accountId]
        ];

        return $this->execStoredProcedure("GetAccountById", $params)->fetch();
    }
}
