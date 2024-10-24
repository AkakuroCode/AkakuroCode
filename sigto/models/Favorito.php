<?php
require_once __DIR__ . '/../config/Database.php';


class Favorito {
    private $conn;
    private $table_name = "elige"; // Nombre de la tabla de favoritos

    private $idus;
    private $sku;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    public function setIdus($idus) {
        $this->idus = $idus;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function addFavorito() {
        // Verificar si el registro ya existe
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->idus, $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Si el registro ya existe, actualizar el estado de favorito a 'si'
            $query = "UPDATE " . $this->table_name . " SET favorito = 'si' WHERE idus = ? AND sku = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $this->idus, $this->sku);
        } else {
            // Si el registro no existe, agregar uno nuevo
            $query = "INSERT INTO " . $this->table_name . " (idus, sku, favorito) VALUES (?, ?, 'si')";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $this->idus, $this->sku);
        }
    
        return $stmt->execute();
    }
    

    public function removeFavorito() {
        // Verificar si el registro ya existe
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->idus, $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Si el registro existe, actualizar el estado de favorito a 'no'
            $query = "UPDATE " . $this->table_name . " SET favorito = 'no' WHERE idus = ? AND sku = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $this->idus, $this->sku);
            return $stmt->execute();
        } else {
            return false; // Si no existe el registro, retornar false
        }
    }
    

    // Método para obtener todos los productos favoritos de un usuario
    public function getFavoritosByUser($idus) {
        $query = "SELECT p.* FROM producto p 
                  INNER JOIN " . $this->table_name . " e ON p.sku = e.sku 
                  WHERE e.idus = ? AND e.favorito = 'si'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para verificar si un producto está en favoritos
    public function esFavorito($idus, $sku) {
        $query = "SELECT favorito FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idus, $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return ($row && $row['favorito'] === 'si');
    }
}
