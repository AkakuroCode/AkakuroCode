<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $conn;
    private $table_name = "producto";

    private $idproducto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=?, descripcion=?, precio=?, imagen=?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ssds", $this->nombre, $this->descripcion, $this->precio, $this->imagen);
        
        return $stmt->execute();
    }

    // Setters for the product properties
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
?>
