<?php
namespace app\controllers;

use app\models\mainModel;

class transactionsController extends mainModel {

    public function getTransactionsByUser() {
        $userId = $_SESSION['id'];

        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
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
            ["parameter_marker" => ":p_UserId", "parameter_value" => $data["usuario"]],
            ["parameter_marker" => ":p_Description", "parameter_value" => $data["descripcion"]],
            ["parameter_marker" => ":p_Currency", "parameter_value" => $data["moneda"]],
            ["parameter_marker" => ":p_Amount", "parameter_value" => $data["monto"]],
            ["parameter_marker" => ":p_Category", "parameter_value" => $data["categoria"]],
            ["parameter_marker" => ":p_TypeTransaction", "parameter_value" => $data["tipo"]],
            ["parameter_marker" => ":p_DateTransaction", "parameter_value" => $data["fecha"]]
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

    public function getSavingsGoalsByUser($userId) {
        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];
        return $this->execStoredProcedure("GetSavingsGoalsByUser", $params)->fetchAll();
    }

    public function getSavingsGoalById($id) {
        $params = [
            ["parameter_marker" => ":p_SavingsGoalsId", "parameter_value" => $id]
        ];
        return $this->execStoredProcedure("GetSavingsGoalById", $params)->fetch();
    }

    public function updateSavingsGoalBalance($id, $balance) {
        $params = [
            ["parameter_marker" => ":p_SavingsGoalsId", "parameter_value" => $id],
            ["parameter_marker" => ":p_Balance", "parameter_value" => $balance]
        ];
        return $this->execStoredProcedure("UpdateSavingsGoalBalance", $params);
    }
}
