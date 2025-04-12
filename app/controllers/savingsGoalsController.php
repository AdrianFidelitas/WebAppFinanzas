<?php
namespace app\controllers;

use app\models\mainModel;

class savingsGoalsController extends mainModel {

    // Obtener todas las metas activas
    public function getAllGoals() {
        return $this->execStoredProcedure("GetFinancialGoals", [])->fetchAll();
    }

    // Obtener una meta por ID
    public function getGoalById($goalId) {
        $params = [
            ["parameter_marker" => ":p_FinancialGoalId", "parameter_value" => $goalId]
        ];
        return $this->execStoredProcedure("GetFinancialGoalById", $params)->fetch();
    }

    // Crear una nueva meta
    public function createGoal($data) {
        $params = [
            ["parameter_marker" => ":p_UserId",         "parameter_value" => $data["UserId"]],
            ["parameter_marker" => ":p_Name",           "parameter_value" => $data["Name"]],
            ["parameter_marker" => ":p_TargetAmount",   "parameter_value" => $data["TargetAmount"]],
            ["parameter_marker" => ":p_PlannedAmount",  "parameter_value" => $data["PlannedAmount"]],
            ["parameter_marker" => ":p_SavedAmount",    "parameter_value" => $data["SavedAmount"]],
            ["parameter_marker" => ":p_AuditUser",      "parameter_value" => $data["AuditUser"]],
        ];
        return $this->execStoredProcedure("CreateFinancialGoal", $params);
    }

    // Actualizar meta financiera existente
    public function updateGoal($goalId, $data) {
        $params = [
            ["parameter_marker" => ":p_FinancialGoalId", "parameter_value" => $goalId],
            ["parameter_marker" => ":p_UserId",          "parameter_value" => $data["UserId"]],
            ["parameter_marker" => ":p_Name",            "parameter_value" => $data["Name"]],
            ["parameter_marker" => ":p_TargetAmount",    "parameter_value" => $data["TargetAmount"]],
            ["parameter_marker" => ":p_PlannedAmount",   "parameter_value" => $data["PlannedAmount"]],
            ["parameter_marker" => ":p_SavedAmount",     "parameter_value" => $data["SavedAmount"]],
            ["parameter_marker" => ":p_AuditUser",       "parameter_value" => $data["AuditUser"]],
        ];
        return $this->execStoredProcedure("UpdateFinancialGoal", $params);
    }

    // Eliminar (soft delete) una meta financiera
    public function deleteGoal($goalId, $auditUser) {
        $params = [
            ["parameter_marker" => ":p_FinancialGoalId", "parameter_value" => $goalId],
            ["parameter_marker" => ":p_AuditUser",       "parameter_value" => $auditUser]
        ];
        return $this->execStoredProcedure("DeleteFinancialGoal", $params);
    }
}
