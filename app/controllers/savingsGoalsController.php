<?php

namespace app\controllers;

use app\models\mainModel;

class savingsGoalsController extends mainModel {

    public function getGoalsByUser($userId = null) {
        if ($userId === null) {
            $userId = $_SESSION['id'];
        }

        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];

        return $this->execStoredProcedure("GetSavingsGoalsByUser", $params)->fetchAll();
    }

    public function createGoal($data) {
        $params = [
            ["parameter_marker" => ":p_UserId",        "parameter_value" => $data["UserId"]],
            ["parameter_marker" => ":p_NameGoal",      "parameter_value" => $data["NameGoal"]],
            ["parameter_marker" => ":p_TargetAmount",  "parameter_value" => $data["TargetAmount"]],
            ["parameter_marker" => ":p_PlannedAmount", "parameter_value" => $data["PlannedAmount"]],
            ["parameter_marker" => ":p_Balance",       "parameter_value" => $data["Balance"]],
            ["parameter_marker" => ":p_Currency",      "parameter_value" => $data["Currency"]],
            ["parameter_marker" => ":p_PrecioVenta",   "parameter_value" => $data["PrecioVenta"]],
            ["parameter_marker" => ":p_PrecioCompra",  "parameter_value" => $data["PrecioCompra"]],
        ];

        return $this->execStoredProcedure("CreateSavingsGoal", $params);
    }

    public function updateGoal($goalId, $data) {
        $params = [
            ["parameter_marker" => ":p_SavingsGoalsId", "parameter_value" => $goalId],
            ["parameter_marker" => ":p_NameGoal",       "parameter_value" => $data["NameGoal"]],
            ["parameter_marker" => ":p_TargetAmount",   "parameter_value" => $data["TargetAmount"]],
            ["parameter_marker" => ":p_PlannedAmount",  "parameter_value" => $data["PlannedAmount"]],
            ["parameter_marker" => ":p_Balance",        "parameter_value" => $data["Balance"]],
            ["parameter_marker" => ":p_Currency",       "parameter_value" => $data["Currency"]],
        ];

        return $this->execStoredProcedure("UpdateSavingsGoal", $params);
    }

    public function updateGoalBalance($goalId, $balance) {
        $params = [
            ["parameter_marker" => ":p_SavingsGoalsId", "parameter_value" => $goalId],
            ["parameter_marker" => ":p_Balance",        "parameter_value" => $balance]
        ];

        return $this->execStoredProcedure("UpdateSavingsGoalBalance", $params);
    }

    public function deleteGoal($goalId) {
        $params = [
            ["parameter_marker" => ":p_SavingsGoalsId", "parameter_value" => $goalId]
        ];

        return $this->execStoredProcedure("DeleteSavingsGoal", $params);
    }

    public function getTipoCambio() {
        $json = @file_get_contents("https://api.hacienda.go.cr/indicadores/tc/dolar");

        if (!$json) {
            return [
                "compra" => null,
                "venta" => null
            ];
        }

        $data = json_decode($json, true);

        return [
            "compra" => $data["compra"]["valor"] ?? null,
            "venta"  => $data["venta"]["valor"] ?? null
        ];
    }
}
