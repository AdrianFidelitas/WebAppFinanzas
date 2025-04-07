<?php
namespace app\models;
use \PDO;

class transactionModel extends mainModel {

    private $table = "transacciones";

    // Obtener todas las transacciones (usando execQuery de mainModel)
    public function getTransactions() {
        $query = "SELECT * FROM {$this->table} ORDER BY fecha DESC";
        return $this->execQuery($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener transacción por ID (con parámetros seguros)
    public function getTransactionById($id) {
        $id = $this->cleanString($id);
        $sql = $this->connect()->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $sql->bindParam(":id", $id, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // Crear transacción (con validación)
    public function createTransaction($data) {
        $sql = $this->connect()->prepare("INSERT INTO {$this->table} 
            (tipo, nombre, descripcion, fecha, cuenta, monto) 
            VALUES (:tipo, :nombre, :descripcion, :fecha, :cuenta, :monto)");
        
        $params = [
            ':tipo' => $this->cleanString($data['tipo']),
            ':nombre' => $this->cleanString($data['nombre']),
            ':descripcion' => $this->cleanString($data['descripcion']),
            ':fecha' => $data['fecha'],
            ':cuenta' => $this->cleanString($data['cuenta']),
            ':monto' => $this->cleanString($data['monto'])
        ];
        
        foreach ($params as $key => $value) {
            $sql->bindValue($key, $value);
        }
        
        return $sql->execute();
    }

    // Actualizar transacción
    public function updateTransaction($id, $data) {
        $sql = $this->connect()->prepare("UPDATE {$this->table} SET 
            tipo = :tipo, 
            nombre = :nombre, 
            descripcion = :descripcion, 
            fecha = :fecha, 
            cuenta = :cuenta, 
            monto = :monto 
            WHERE id = :id");
        
        $params = [
            ':id' => $this->cleanString($id),
            ':tipo' => $this->cleanString($data['tipo']),
            ':nombre' => $this->cleanString($data['nombre']),
            ':descripcion' => $this->cleanString($data['descripcion']),
            ':fecha' => $data['fecha'],
            ':cuenta' => $this->cleanString($data['cuenta']),
            ':monto' => $this->cleanString($data['monto'])
        ];
        
        foreach ($params as $key => $value) {
            $sql->bindValue($key, $value);
        }
        
        return $sql->execute();
    }

    // Eliminar transacción
    public function deleteTransaction($id) {
        $id = $this->cleanString($id);
        $sql = $this->connect()->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $sql->bindParam(":id", $id, PDO::PARAM_INT);
        return $sql->execute();
    }

    // Buscar transacciones (usando LIKE seguro)
    public function searchTransactions($term) {
        $term = "%" . $this->cleanString($term) . "%";
        $sql = $this->connect()->prepare("SELECT * FROM {$this->table} 
            WHERE nombre LIKE :term OR descripcion LIKE :term
            ORDER BY fecha DESC");
        
        $sql->bindParam(":term", $term);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener totales (usando execQuery)
    public function getTotals() {
        $query = "SELECT 
            SUM(CASE WHEN tipo = 1 THEN monto ELSE 0 END) as ingresos,
            SUM(CASE WHEN tipo = 0 THEN monto ELSE 0 END) as egresos
            FROM {$this->table}";
        
        return $this->execQuery($query)->fetch(PDO::FETCH_ASSOC);
    }
}