<?php
namespace app\controllers;

use app\models\mainModel;

class progressController extends mainModel {

    public function getProgressData($userId) {
        // Obtener datos
        $goals = $this->execStoredProcedure("GetSavingsGoalsByUser", [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ])->fetchAll();

        $budgets = $this->execStoredProcedure("GetBudgetsByUser", [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ])->fetchAll();

        $transactions = $this->execStoredProcedure("GetTransactionsByUser", [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ])->fetchAll();

        // Tipo de cambio
        $tc = $this->getTipoCambio();

        return [
            "goals" => $goals,
            "budgets" => $budgets,
            "transactions" => $transactions,
            "tipocambio" => $tc,
            "labels" => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
        ];
    }

    public function getTipoCambio() {
        $json = @file_get_contents("https://api.hacienda.go.cr/indicadores/tc/dolar");

        if (!$json) {
            return ["compra" => 0, "venta" => 0];
        }

        $data = json_decode($json, true);
        return [
            "compra" => $data["compra"]["valor"] ?? 0,
            "venta"  => $data["venta"]["valor"] ?? 0
        ];
    }
}
