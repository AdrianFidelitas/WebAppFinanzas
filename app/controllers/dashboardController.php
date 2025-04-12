<?php

namespace app\controllers;

use app\models\mainModel;

class dashboardController extends mainModel {

    public function getDashboardData() {
        $userId = 1;#$_SESSION['id'];

        $paramsCuentas = [
            ["parameter_marker" => ":UserId", "parameter_value" => $userId]
        ];
        $cuentas = $this->execStoredProcedure("GetAccountsByUser", $paramsCuentas)->fetchAll();

        $paramsTransacciones = [
            ["parameter_marker" => ":AuditUser", "parameter_value" => $userId]
        ];
        $transacciones = $this->execStoredProcedure("GetTransactionsByUser", $paramsTransacciones)->fetchAll();

        $paramsPresupuestos = [
            ["parameter_marker" => ":UserId", "parameter_value" => $userId]
        ];
        $presupuestos = $this->execStoredProcedure("GetBudgetsByUser", $paramsPresupuestos)->fetchAll();

        $categorias = $this->execStoredProcedure("GetCategories", [])->fetchAll();

        $totalDisponible = 0;
        $valorNeto = 0;
        foreach ($cuentas as $cuenta) {
            $totalDisponible += $cuenta['Balance'];
            $valorNeto += $cuenta['Balance'];
        }

        return [
            "cuentas" => $cuentas,
            "transacciones" => array_slice($transacciones, 0, 5),
            "presupuestos" => $presupuestos,
            "categorias" => $categorias,
            "totales" => [
                "entrada_salida" => 0,
                "subscripciones" => 0, 
                "disponible" => $totalDisponible,
                "valor_neto" => $valorNeto
            ]
        ];
    }

    // Si deseas exponer un método para AJAX
    public function getDashboardJson() {
        return json_encode($this->getDashboardData());
    }
}
