<?php
namespace app\controllers;

use app\models\mainModel;

class budgetsController extends mainModel {

    public function getTransactionsByUser() {
        $userId = 1; // Reemplazar por $_SESSION['id'] en producción

        $params = [
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $userId]
        ];

        return $this->execStoredProcedure("GetTransactionsByUser", $params)->fetchAll();
    }

    public function getTransactionById($id) {
        $params = [
            ["parameter_marker" => ":p_TransactionId", "parameter_value" => $id]
        ];

        return $this->execStoredProcedure("GetTransactionById", $params)->fetch();
    }

    public function createTransaction($data) {
        $params = [
            ["parameter_marker" => ":p_TransactionType", "parameter_value" => $data["tipo"]],
            ["parameter_marker" => ":p_Name", "parameter_value" => $data["nombre"]],
            ["parameter_marker" => ":p_Description", "parameter_value" => $data["descripcion"]],
            ["parameter_marker" => ":p_TransactionDate", "parameter_value" => $data["fecha"]],
            ["parameter_marker" => ":p_SourceAccountId", "parameter_value" => $data["cuenta_origen"]],
            ["parameter_marker" => ":p_DestinationAccountId", "parameter_value" => $data["cuenta_destino"]],
            ["parameter_marker" => ":p_Amount", "parameter_value" => $data["monto"]],
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $data["usuario"]]
        ];

        return $this->execStoredProcedure("CreateTransaction", $params);
    }

    public function deleteTransaction($id, $user) {
        $params = [
            ["parameter_marker" => ":p_TransactionId", "parameter_value" => $id],
            ["parameter_marker" => ":p_AuditUser", "parameter_value" => $user]
        ];

        return $this->execStoredProcedure("DeleteTransaction", $params);
    }

    // Dummy temporal
    public function getAccounts() {
        return [
            ['Id' => 1, 'Name' => 'Cuenta Corriente'],
            ['Id' => 2, 'Name' => 'Ahorros USD']
        ];
    }
}
