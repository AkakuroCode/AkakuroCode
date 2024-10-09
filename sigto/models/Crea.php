<?php
require_once __DIR__ . '/../config/Database.php';

class Crea {
    private $conn;
    private $table_name = "crea";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Agregar un producto a un carrito en la tabla 'crea'
    public function add($sku, $idcarrito) {
        $query = "INSERT INTO " . $this->table_name . " (sku, idcarrito) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $sku, $idcarrito);

        return $stmt->execute();
    }

    // Verificar si un producto ya está asociado a un carrito
    public function isProductInCart($sku, $idcarrito) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE sku = ? AND idcarrito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $sku, $idcarrito);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Eliminar la relación entre un producto y un carrito en 'crea'
    public function remove($sku, $idcarrito) {
        $query = "DELETE FROM " . $this->table_name . " WHERE sku = ? AND idcarrito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $sku, $idcarrito);

        return $stmt->execute();
    }
}
?>
