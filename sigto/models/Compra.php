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

   // Función para registrar en la tabla "cierra"
    public function registrarCierre($idpago, $idcarrito) {
    $query = "INSERT INTO cierra (idpago, idcarrito) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $idpago, $idcarrito);
    return $stmt->execute();
    }

    // Función para eliminar los productos del carrito
    public function eliminarProductosDelCarrito($idcarrito) {
    $query = "DELETE FROM detalle_carrito WHERE idcarrito = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $idcarrito);
    return $stmt->execute();
    }

    public function registrarEnHistorialCompra($idus, $fecha, $totalCompra, $stock) {
        $query = "INSERT INTO historial_compra (idus, fecha, total_compra, stock) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("isdi", $idus, $fecha, $totalCompra, $stock);
        return $stmt->execute();
    }

    public function obtenerIdHistorialReciente($idUsuario) {
        $query = "SELECT idhistorial FROM historial_compra WHERE idus = ? ORDER BY idhistorial DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row ? $row['idhistorial'] : null;
    }
    
    public function registrarDetalleHistorial($idhistorial, $sku, $estado, $codigoUnidad) {
        $query = "INSERT INTO detalle_historial (idhistorial, sku, estado, codigo_unidad)
                  VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        // Asegúrate de que si $codigoUnidad es NULL, se maneje correctamente
        $stmt->bind_param("iiss", $idhistorial, $sku, $estado, $codigoUnidad);
        return $stmt->execute();
    }
    
}
