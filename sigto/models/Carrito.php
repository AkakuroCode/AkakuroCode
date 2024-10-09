<?php
require_once __DIR__ . '/../config/Database.php';

class Carrito {
    private $conn;
    private $table_name = "carrito";

    private $idcarrito;
    private $idus;
    private $sku;
    private $fechacrea;
    private $fechamod;
    private $total;
    private $cantidad;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setIdus($idus) {
        $this->idus = $idus;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    // Método para agregar un producto al carrito
    public function addItem() {
        $query = "INSERT INTO " . $this->table_name . " (idus, sku, cantidad, fechacrea)
                  VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $this->idus, $this->sku, $this->cantidad);
        return $stmt->execute();
    }

    // Método para obtener un producto del carrito por usuario y SKU
    public function getItemByUserAndSku() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->idus, $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para obtener todos los productos del carrito de un usuario
    public function getItemsByUser($idus) {
        $query = "SELECT c.*, p.nombre, p.descripcion, p.precio, p.imagen, 
                         (c.cantidad * p.precio) AS subtotal 
                  FROM " . $this->table_name . " c
                  INNER JOIN producto p ON c.sku = p.sku
                  WHERE c.idus = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Método para actualizar la cantidad de un producto en el carrito
    public function updateQuantity($idcarrito, $sku, $cantidad) {
        $query = "UPDATE " . $this->table_name . " 
                  SET cantidad = ?, fechamod = NOW() 
                  WHERE idcarrito = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $cantidad, $idcarrito, $sku);
        return $stmt->execute();
    }

    // Método para eliminar un producto del carrito
    public function removeItem($idcarrito, $sku) {
        $query = "DELETE FROM " . $this->table_name . " WHERE idcarrito = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idcarrito, $sku);
        return $stmt->execute();
    }

    // Método para obtener el ID del carrito de un usuario
    public function getIdCarritoByUser($idus) {
        $query = "SELECT idcarrito FROM " . $this->table_name . " WHERE idus = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['idcarrito'] : null;
    }

    // Método para crear un nuevo carrito si no existe uno para el usuario
    public function createCart($idus) {
        $query = "INSERT INTO " . $this->table_name . " (idus, fechacrea) VALUES (?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        return $stmt->insert_id;
    }
}
?>
