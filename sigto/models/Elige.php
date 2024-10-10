<?php
require_once __DIR__ . '/../config/Database.php';

class Elige {
    private $conn;
    private $table_name = "elige";

    private $sku;
    private $idus;
    private $favorito;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setIdus($idus) {
        $this->idus = $idus;
    }

    public function setFavorito($favorito) {
        $this->favorito = $favorito;
    }

    public function add() {
        $query = "INSERT INTO " . $this->table_name . " (sku, idus, favorito) VALUES (?, ?, 'No')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->sku, $this->idus);
        return $stmt->execute();
    }

    // Otros métodos CRUD para la tabla `elige`...
}
?>
