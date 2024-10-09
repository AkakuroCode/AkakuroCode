<?php
require_once __DIR__ . '/../config/Database.php';

class Elige {
    private $conn;
    private $table_name = "elige";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Verificar si un producto ya fue elegido por el usuario
    public function isProductChosen($idus, $sku) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idus, $sku);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Agregar un producto como elegido por un usuario
    public function add($idus, $sku) {
        $query = "INSERT INTO " . $this->table_name . " (idus, sku) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idus, $sku);

        return $stmt->execute();
    }

    // Eliminar la relación entre un producto y un usuario en 'elige'
    public function remove($idus, $sku) {
        $query = "DELETE FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idus, $sku);

        return $stmt->execute();
    }
}
?>
