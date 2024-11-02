<?php
require_once __DIR__ . '/../config/Database.php';

class Compra {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    // Iniciar transacción
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    // Confirmar transacción
    public function commit() {
        $this->conn->commit();
    }

    // Revertir transacción
    public function rollback() {
        $this->conn->rollback();
    }

    // Crear compra
    public function crearCompra($idpago, $tipo_entrega, $estado) {
        $sql = "INSERT INTO compra (idpago, tipo_entrega, estado) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $idpago, $tipo_entrega, $estado);
        $stmt->execute();
        return $stmt->insert_id ? $stmt->insert_id : false;
    }

    // Crear detalle de envío
    public function crearDetalleEnvio($idcompra, $direccion) {
        $sql = "INSERT INTO detalle_envio (idcompra, direccion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $idcompra, $direccion);
        $stmt->execute();
        return $stmt->insert_id ? $stmt->insert_id : false;
    }

    // Crear detalle de recibo
    public function crearDetalleRecibo($idcompra, $idrecibo) {
        $sql = "INSERT INTO detalle_recibo (idcompra, idrecibo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idrecibo);
        $stmt->execute();
        return $stmt->insert_id ? $stmt->insert_id : false;
    }

    // Asignar vehículo
    public function asignarVehiculo($idenvio, $idv) {
        $sql = "INSERT INTO transporta (idenvio, idv) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idenvio, $idv);
        return $stmt->execute();
    }
}
