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
    private $visible;

    private $tipo_stock; // Aquí agregamos la propiedad tipo_stock

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

    // Métodos getters y setters para 'visible'
    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function getVisible() {
        return $this->visible;
    }

    // Método para establecer el tipo de stock (unidad o cantidad)
    public function setTipoStock($tipo_stock) {
        $this->tipo_stock = $tipo_stock;
    }

    // Método para obtener el tipo de stock
    public function getTipoStock() {
        return $this->tipo_stock;
    }

    // Método para crear un producto (incluyendo el tipo de stock)
    public function create() {
        $query = "INSERT INTO producto (idemp, nombre, descripcion, estado, origen, stock, precio, imagen, visible, tipo_stock) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("issssiiss", $this->idemp, $this->nombre, $this->descripcion, $this->estado, $this->origen, $this->stock, $this->precio, $this->imagen, $this->tipo_stock);

        if ($stmt->execute()) {
            return $this->conn->insert_id; // Devolver el último ID insertado (el SKU)
        } else {
            return false;
        }
    }

    // Método para agregar un código único en la tabla 'producto_unitario'
    public function agregarUnidad($sku, $codigoUnidad) {
        $query = "INSERT INTO producto_unitario (sku, codigo_unidad, estado) VALUES (?, ?, 'Disponible')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $sku, $codigoUnidad);
        return $stmt->execute();
    }

    // Método para verificar si un código ya existe
    public function existeCodigoUnidad($codigoUnidad) {
        $query = "SELECT COUNT(*) as total FROM producto_unitario WHERE codigo_unidad = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $codigoUnidad);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] > 0; // Retorna true si ya existe, false si no
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

    // Método para obtener productos visibles
    public function readVisibleProducts() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE visible = 1";
        $result = $this->conn->query($query);
        
        if (!$result) {
            echo "Error en la consulta SQL: " . $this->conn->error;
            return false;
        }
        
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve los productos visibles
    }

    // Método para obtener todos los productos de una empresa
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
        // Verificar si el tipo de stock es "unidad", en cuyo caso no se actualiza el stock
        if ($this->tipo_stock === 'unidad') {
            $query = "UPDATE " . $this->table_name . " 
                      SET idemp=?, nombre=?, descripcion=?, estado=?, origen=?, precio=?, imagen=? 
                      WHERE sku=?";
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters excluding 'stock'
            $stmt->bind_param("issssisi", $this->idemp, $this->nombre, $this->descripcion, $this->estado, $this->origen, $this->precio, $this->imagen, $this->sku);
        } else {
            // Si es por cantidad, incluimos el campo de stock en la actualización
            $query = "UPDATE " . $this->table_name . " 
                      SET idemp=?, nombre=?, descripcion=?, estado=?, origen=?, precio=?, stock=?, imagen=? 
                      WHERE sku=?";
            $stmt = $this->conn->prepare($query);
    
            // Bind parameters including 'stock'
            $stmt->bind_param("issssiisi", $this->idemp, $this->nombre, $this->descripcion, $this->estado, $this->origen, $this->precio, $this->stock, $this->imagen, $this->sku);
        }
    
        // Ejecutar la consulta y verificar el resultado
        if ($stmt->execute()) {
            return true; // Actualización exitosa
        } else {
            // Mostrar errores si la consulta falla
            echo "Error en la actualización: " . $this->conn->error;
            echo "Query ejecutada: " . $query;
            return false;
        }
    }
    


    // Método para ocultar un producto (borrado lógico)
    public function softDelete() {
        $query = "UPDATE " . $this->table_name . " SET visible = 0 WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        return $stmt->execute();
    }

     // Método para mostrar un producto nuevamente
     public function restore() {
        $query = "UPDATE " . $this->table_name . " SET visible = 1 WHERE sku = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->sku);
        return $stmt->execute();
    }

    // Método en Producto.php para obtener la cantidad de productos disponibles en la tabla producto_unitario
    public function getCantidadDisponiblePorSku($sku) {
    $query = "SELECT COUNT(*) AS cantidad_disponible FROM producto_unitario WHERE sku = ? AND estado = 'Disponible'";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $sku);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['cantidad_disponible']; // Retorna la cantidad de productos disponibles
}

}
?>
