<?php
require_once __DIR__ . '/../config/Database.php';

class Producto {
    private $conn;
    private $table_name = "producto";

    private $sku; // Autoincremental
    private $idemp;
    private $nombre;
    private $descripcion;
    private $estado;
    private $origen;
    private $precio;
    private $stock;
    private $imagen;

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

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
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

    // Método para crear un producto
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET idemp=?, nombre=?, descripcion=?, estado=?, origen=?, precio=?, stock=?, imagen=?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("issssiis", $this->idemp, $this->nombre, $this->descripcion, $this->estado, $this->origen, $this->precio, $this->stock, $this->imagen);

        if ($stmt->execute()) {
            // Devolver el último ID insertado
            return $this->conn->insert_id;  // Esto devuelve el `sku` generado
        } else {
            echo "Error en la ejecución: " . $stmt->error;
            return false;
        }
    }

    public function asignarCategoria($sku, $idcat) {
        // Usar la conexión actual en lugar de crear una nueva instancia de Producto
        $query = "INSERT INTO pertenece (sku, idcat) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("ii", $sku, $idcat);
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al insertar la relación en la tabla pertenece: " . $stmt->error;
            return false;
        }
    }
    // Método para eliminar la categoría actual antes de asignar una nueva
    public function eliminarCategoria($sku) {
        $query = "DELETE FROM pertenece WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("i", $sku);
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al eliminar la categoría: " . $stmt->error;
            return false;
        }
    }

    public function readAllProducts() {
        $query = "SELECT p.*, o.porcentaje_oferta, o.preciooferta, o.fecha_inicio, o.fecha_fin
                  FROM producto p
                  LEFT JOIN ofertas o ON p.sku = o.sku"; // Unimos la tabla de ofertas para mostrar la oferta si existe
        $result = $this->conn->query($query);
    
        if (!$result) {
            echo "Error en la consulta SQL: " . $this->conn->error;
            return false;
        }
    
        return $result;
    }
    // Método para obtener todos los productos
    public function readByEmpresa($idemp) {
        $query = "SELECT p.*, o.porcentaje_oferta, o.preciooferta, o.fecha_inicio, o.fecha_fin 
                  FROM producto p
                  LEFT JOIN ofertas o ON p.sku = o.sku
                  WHERE p.idemp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idemp);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function getCategoriaBySku($sku) {
        $query = "SELECT idcat FROM pertenece WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para obtener un solo producto por su SKU
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE sku = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para actualizar un producto
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET idemp=?, nombre=?, descripcion=?, estado=?, origen=?, precio=?, stock=?, imagen=? 
                  WHERE sku=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("issssiisi", $this->idemp, $this->nombre, $this->descripcion, $this->estado, $this->origen, $this->precio, $this->stock, $this->imagen, $this->sku);

        return $stmt->execute();
    }

    // Método para eliminar un producto
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        return $stmt->execute();
    }
}
?>
