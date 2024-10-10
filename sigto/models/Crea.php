<?php
require_once __DIR__ . '/../config/Database.php';

class Crea {
    private $conn;
    private $table_name = "crea";

    private $sku;
    private $idcarrito;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setIdcarrito($idcarrito) {
        $this->idcarrito = $idcarrito;
    }

    public function add() {
        $query = "INSERT INTO " . $this->table_name . " (sku, idcarrito) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->sku, $this->idcarrito);
        return $stmt->execute();
    }

    public function remove() {
        $query = "DELETE FROM " . $this->table_name . " WHERE sku = ? AND idcarrito = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->sku, $this->idcarrito);
        return $stmt->execute();
    }
}
?>
