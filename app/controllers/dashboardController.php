<?php

namespace app\controllers;

use app\models\mainModel;

class dashboardController extends mainModel {

    public function getDashboardData() {
        $userId = $_SESSION['id'];

        // Transacciones
        $paramsTransacciones = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];
        $transacciones = $this->execStoredProcedure("GetTransactionsByUser", $paramsTransacciones)->fetchAll();

        // Presupuestos
        $paramsPresupuestos = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];
        $presupuestos = $this->execStoredProcedure("GetBudgetsByUser", $paramsPresupuestos)->fetchAll();

        // Ahorros
        $paramsGoals = [
            ["parameter_marker" => ":p_UserId", "parameter_value" => $userId]
        ];
        $savingsGoals = $this->execStoredProcedure("GetSavingsGoalsByUser", $paramsGoals)->fetchAll();

        // Tipo de cambio
        $tipoCambio = $this->getTipoCambio();
        $tasaVenta = $tipoCambio['venta'] ?? 0;
        $tasaCompra = $tipoCambio['compra'] ?? 0;

        // Fechas del mes
        $fechaInicioMes = date("Y-m-01");
        $fechaFinMes = date("Y-m-t");

        // Inicializar totales por moneda
        $ingresosCRC = 0;
        $ingresosUSD = 0;
        $gastosCRC = 0;
        $gastosUSD = 0;
        $presupuestoCRC = 0;
        $presupuestoUSD = 0;

        // Transacciones
        foreach ($transacciones as $trans) {
            $fecha = date("Y-m-d", strtotime($trans['DateTransaction']));
            $tipo = $trans['TypeTransaction'];
            $monto = $trans['Amount'];
            $moneda = $trans['Currency'] ?? 'CRC';

            if ($fecha >= $fechaInicioMes && $fecha <= $fechaFinMes) {
                if ($tipo == 1) {
                    $moneda === 'USD' ? $ingresosUSD += $monto : $ingresosCRC += $monto;
                } elseif ($tipo == 2) {
                    $moneda === 'USD' ? $gastosUSD += $monto : $gastosCRC += $monto;
                }
            }
        }

        // Presupuestos
        foreach ($presupuestos as $p) {
            $monto = $p['Balance'];
            $moneda = $p['Currency'] ?? 'CRC';
            $moneda === 'USD' ? $presupuestoUSD += $monto : $presupuestoCRC += $monto;
        }

        // Ahorros
        $ahorroPendiente = [];
        foreach ($savingsGoals as $goal) {
    $restante = $goal['TargetAmount'] - $goal['Balance'];
    if ($restante > 0) {
        $ahorroPendiente[] = [
            'nombre' => $goal['NameGoal'],
            'restante' => $restante,
            'moneda' => $goal['Currency'] ?? 'CRC' // 👈 Agregar la moneda
        ];
    }
}

        return [
            "transacciones" => array_slice($transacciones, 0, 5),
            "presupuestos" => $presupuestos,
            "ahorros_pendientes" => $ahorroPendiente,
            "totales" => [
                "ingresos_crc" => $ingresosCRC,
                "ingresos_usd" => $ingresosUSD,
                "gastos_crc" => $gastosCRC,
                "gastos_usd" => $gastosUSD,
                "presupuesto_crc" => $presupuestoCRC,
                "presupuesto_usd" => $presupuestoUSD
            ],
            "dolar" => $tipoCambio
        ];
    }

    private function getTipoCambio() {
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
            "venta" => $data["venta"]["valor"] ?? null
        ];
    }

    public function getDashboardJson() {
        return json_encode($this->getDashboardData());
    }
}
