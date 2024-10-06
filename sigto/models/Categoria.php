<?php
require_once __DIR__ . '/../config/Database.php';

class Categoria {
    private $conn;
    private $table_name = "categoria";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para obtener todas las categorías
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para asignar una categoría a un producto
    public function asignarCategoria($sku, $idcat) {
        $query = "INSERT INTO pertenece (sku, idcat) VALUES (?, ?)
                  ON DUPLICATE KEY UPDATE idcat = VALUES(idcat)"; // Esto actualiza si ya existe
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ii", $sku, $idcat);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al asignar la categoría: " . $stmt->error;
            return false;
        }
    }
}
?>
