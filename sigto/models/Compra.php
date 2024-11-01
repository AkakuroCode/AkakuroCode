<?php
require_once __DIR__ . '/../config/Database.php';

class Compra {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    // Método para crear una compra
    public function crearCompra($idpago, $tipo_entrega, $estado) {
        $sql = "INSERT INTO compra (idpago, tipo_entrega, estado) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $idpago, $tipo_entrega, $estado);
        $stmt->execute();
        return $this->conn->insert_id; // Retorna el ID de la compra creada
    }

    // Método para crear un detalle de envío
    public function crearDetalleEnvio($idcompra, $direccion) {
        $sql = "INSERT INTO detalle_envio (idcompra, direccion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $idcompra, $direccion);
        $stmt->execute();
        return $this->conn->insert_id; // Retorna el ID del detalle de envío
    }

    // Método para crear un detalle de recibo
    public function crearDetalleRecibo($idcompra, $idrecibo) {
        $sql = "INSERT INTO detalle_recibo (idcompra, idrecibo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idrecibo);
        $stmt->execute();
        return $this->conn->insert_id; // Retorna el ID del detalle de recibo
    }

    // Método para relacionar en la tabla especifica
    public function relacionarEspecifica($idrecibo, $iddetalle) {
        $sql = "INSERT INTO especifica (idrecibo, iddetalle) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idrecibo, $iddetalle);
        $stmt->execute();
    }

    // Método para relacionar en la tabla maneja
    public function relacionarManeja($idenvio, $iddetalle) {
        $sql = "INSERT INTO maneja (idenvio, iddetalle) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idenvio, $iddetalle);
        $stmt->execute();
    }

    // Método para asignar un vehículo a un envío
    public function asignarVehiculo($idenvio, $idv) {
        $sql = "INSERT INTO transporta (idenvio, idv) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idenvio, $idv);
        $stmt->execute();
    }
}
