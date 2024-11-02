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
        $sql = "INSERT INTO compra (idpago, estado, tipo_entrega) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $idpago, $estado, $tipo_entrega);
        $stmt->execute();
        return $stmt->insert_id ? $stmt->insert_id : false;
    }

    // Crear registro en la tabla inicia
    public function registrarInicioCompra($idcompra, $idpago) {
        $sql = "INSERT INTO inicia (idcompra, idpago) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idpago);
        return $stmt->execute();
    }

    // Crear detalle de recibo
    public function crearDetalleRecibo($idcompra, $total_compra, $estado = 'Completado') {
        $sql = "INSERT INTO detalle_recibo (idcompra, total_compra, estado) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ids", $idcompra, $total_compra, $estado);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Relacionar en la tabla especifica
    public function relacionarEspecifica($idcompra, $idrecibo) {
        $sql = "INSERT INTO especifica (idcompra, idrecibo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idrecibo);
        return $stmt->execute();
    }

    // Crear detalle de envío
    public function crearDetalleEnvio($idcompra, $direccion, $total_compra, $estado = 'Completado') {
        $sql = "INSERT INTO detalle_envio (idcompra, direccion, total_compra, estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isds", $idcompra, $direccion, $total_compra, $estado);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Crear envio
    public function crearEnvio() {
    $sql = "INSERT INTO envio (fecsa, fecen) VALUES (NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    // Verificar si la inserción fue exitosa
    return $stmt->affected_rows > 0;
    }

    // Relacionar en la tabla maneja
    public function relacionarManeja($idcompra, $idenvio) {
        $sql = "INSERT INTO maneja (idcompra, idenvio) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idenvio);
        return $stmt->execute();
    }

    //Relacional en la tabla cierra
    public function registrarCierre($idPago, $idCarrito) {
        $sql = "INSERT INTO cierra (idpago, idcarrito) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idPago, $idCarrito);
        return $stmt->execute();
    }
    
    public function actualizarEstadoCarrito($idCarrito) {
        $sql = "UPDATE carrito SET estado = 'Inactivo' WHERE idcarrito = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idCarrito);
        return $stmt->execute();
    }
    
}
