<?php
require_once __DIR__ . '/../config/Database.php';


class HistorialCompra {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    public function obtenerRegistrosPorHistorial($idhistorial) {
        $sql = "SELECT * FROM detalle_historial WHERE idhistorial = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idhistorial); // "i" indica que es un entero
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verifica si hay registros y devuélvelos como un array asociativo
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // Retorna un array vacío si no hay resultados
        }
    }

    public function obtenerIdHistorialPorUsuario($idus) {
        $sql = "SELECT idhistorial FROM historial_compra WHERE idus = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['idhistorial'];
        } else {
            return null; // Retorna null si no se encuentra el historial
        }
    }
    
}
