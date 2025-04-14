<?php

namespace app\controllers;

use app\models\mainModel;

class budgetsController extends mainModel {

    public function getBudgetsByUser($userId = null) {
        if ($userId === null) {
            $userId = $_SESSION['id'];
        }

        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];

        return $this->execStoredProcedure("GetBudgetsByUser", $params)->fetchAll();
    }

    public function createBudget($userId, $category, $percentage, $balance, $currency = 'CRC') {
        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId],
            ["parameter_marker" => ":p_Category", "parameter_value" => $category],
            ["parameter_marker" => ":p_Percentage", "parameter_value" => $percentage],
            ["parameter_marker" => ":p_Balance", "parameter_value" => $balance],
            ["parameter_marker" => ":p_Currency", "parameter_value" => $currency]
        ];

        return $this->execStoredProcedure("CreateBudget", $params);
    }

    public function updateBudget($budgetId, $category, $percentage, $balance, $currency) {
        $params = [
            ["parameter_marker" => ":p_BudgetId", "parameter_value" => $budgetId],
            ["parameter_marker" => ":p_Category", "parameter_value" => $category],
            ["parameter_marker" => ":p_Percentage", "parameter_value" => $percentage],
            ["parameter_marker" => ":p_Balance", "parameter_value" => $balance],
            ["parameter_marker" => ":p_Currency", "parameter_value" => $currency]
        ];

        return $this->execStoredProcedure("UpdateBudget", $params);
    }

    public function deleteBudget($budgetId) {
        $params = [
            ["parameter_marker" => ":p_BudgetId", "parameter_value" => $budgetId]
        ];

        return $this->execStoredProcedure("DeleteBudget", $params);
    }

    public function getTipoCambioCompra() {
        $json = @file_get_contents("https://api.hacienda.go.cr/indicadores/tc/dolar");
        if (!$json) return 0;
        $data = json_decode($json, true);
        return $data["compra"]["valor"] ?? 0;
    }

    public function getTipoCambioVenta() {
        $json = @file_get_contents("https://api.hacienda.go.cr/indicadores/tc/dolar");
        if (!$json) return 0;
        $data = json_decode($json, true);
        return $data["venta"]["valor"] ?? 0;
    }

    public function getMonthlyIncomeDetails($userId = null) {
        if ($userId === null) {
            $userId = $_SESSION['id'];
        }

        $params = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];

        $rows = $this->execStoredProcedure("GetTransactionsByUser", $params)->fetchAll();

        $inicio = date("Y-m-01", strtotime("first day of last month"));
        $fin    = date("Y-m-t", strtotime("last day of last month"));

        $ingresos = [];

        foreach ($rows as $row) {
            $fecha = date("Y-m-d", strtotime($row['DateTransaction']));
            if ($row['TypeTransaction'] == 1 && $fecha >= $inicio && $fecha <= $fin) {
                $ingresos[] = [
                    'Amount' => (float)$row['Amount'],
                    'Currency' => $row['Currency'] ?? 'CRC'
                ];
            }
        }

        return $ingresos;
    }

    public function distribuirPresupuesto($userId = null) {
        if ($userId === null) {
            $userId = $_SESSION['id'];
        }

        $ingresosDetalle = $this->getMonthlyIncomeDetails($userId);
        $tasaCompra = $this->getTipoCambioCompra();

        $ingresosCRC = 0;

        foreach ($ingresosDetalle as $ingreso) {
            $monto = $ingreso['Amount'];
            $moneda = $ingreso['Currency'];
            if ($moneda === 'USD' && $tasaCompra > 0) {
                $monto *= $tasaCompra;
            }
            $ingresosCRC += $monto;
        }

        $gastosFijos = round($ingresosCRC * 0.50, 2);
        $lujos       = round($ingresosCRC * 0.30, 2);
        $ahorro      = round($ingresosCRC * 0.20, 2);

        $presupuestos = $this->getBudgetsByUser($userId);
        foreach ($presupuestos as $presupuesto) {
            $this->deleteBudget($presupuesto['BudgetId']);
        }

        $this->createBudget($userId, 'Gastos Fijos', 50.00, $gastosFijos, 'CRC');
        $this->createBudget($userId, 'Lujos', 30.00, $lujos, 'CRC');
        $this->createBudget($userId, 'Ahorro', 20.00, $ahorro, 'CRC');

        return [
            'ingreso_total' => $ingresosCRC
        ];
    }
}
