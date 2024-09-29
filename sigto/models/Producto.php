<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $conn;
    private $table_name = "producto";

    private $sku; // Este es autoincremental
    private $idemp;
    private $nombre;
    private $descripcion;
    private $oferta;
    private $fecof; // fecha de oferta
    private $estado;
    private $origen;
    private $precio; // Nuevo campo para el precio
    private $stock;
    private $imagen; // Nombre de la imagen del producto

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getIdEmp() {
        return $this->idemp;
    }

    public function setIdEmp($idemp) {
        $this->idemp = $idemp;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getOferta() {
        return $this->oferta;
    }

    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    public function getFecof() {
        return $this->fecof;
    }

    public function setFecof($fecof) {
        $this->fecof = $fecof;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getOrigen() {
        return $this->origen;
    }

    public function setOrigen($origen) {
        $this->origen = $origen;
    }

    public function getPrecio() { // Nuevo método para obtener el precio
        return $this->precio;
    }

    public function setPrecio($precio) { // Nuevo método para establecer el precio
        $this->precio = $precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET idemp=?, nombre=?, descripcion=?, oferta=?, fecof=?, estado=?, origen=?, precio=?, stock=?, imagen=?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ississsiis", $this->idemp, $this->nombre, $this->descripcion, $this->oferta, $this->fecof, $this->estado, $this->origen, $this->precio, $this->stock, $this->imagen);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error en la ejecución: " . $stmt->error;
            return false;
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($query);

        if (!$result) {
            echo "Error en la consulta SQL: " . $this->conn->error;
            return false;
        }

        return $result;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE sku = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET idemp=?, nombre=?, descripcion=?, oferta=?, fecof=?, estado=?, origen=?, precio=?, stock=?, imagen=? 
                  WHERE sku=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ississsiis", $this->idemp, $this->nombre, $this->descripcion, $this->oferta, $this->fecof, $this->estado, $this->origen, $this->precio, $this->stock, $this->imagen, $this->sku);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        return $stmt->execute();
    }
}
?>
