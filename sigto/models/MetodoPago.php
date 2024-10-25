<?php
require_once __DIR__ . '/../config/Database.php';

class MetodoPago {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    // Método para obtener métodos de pago activos
    public function obtenerMetodosActivos() {
        $sql = "SELECT proveedor FROM metodopago WHERE estado = 'activo'";
        $result = $this->conn->query($sql);

        $metodos_pago = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $metodos_pago[] = $row['proveedor'];
            }
        }
        return $metodos_pago;
    }
}