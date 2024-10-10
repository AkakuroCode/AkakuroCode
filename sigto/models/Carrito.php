<?php  
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

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

    public function setTotal($total) {
        $this->total = $total;
    }

    // Método para agregar un producto al carrito
    public function addItem() {
        $query = "INSERT INTO " . $this->table_name . " (idus, sku, cantidad, fechacrea, fechamod, total) 
                  VALUES (?, ?, ?, NOW(), NOW(), ?)";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("iiii", $this->idus, $this->sku, $this->cantidad, $this->total);
        return $stmt->execute();
    }

    // Método para obtener los productos del carrito de un usuario
    public function getItemsByUser($idus) {
        $query = "SELECT c.*, p.nombre, p.descripcion, p.precio, p.imagen, 
                         IFNULL(o.preciooferta, p.precio) AS precio_actual, 
                         (c.cantidad * IFNULL(o.preciooferta, p.precio)) AS subtotal 
                  FROM " . $this->table_name . " c
                  INNER JOIN producto p ON c.sku = p.sku
                  LEFT JOIN ofertas o ON p.sku = o.sku 
                      AND o.fecha_inicio <= NOW() 
                      AND o.fecha_fin >= NOW()
                  WHERE c.idus = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para actualizar la cantidad de un producto en el carrito
    public function updateQuantity($idus, $sku, $cantidad) {
        $this->setSku($sku); // Asegúrate de que el SKU esté configurado antes de obtener el precio
        $total = $cantidad * $this->getPrecioProducto();
        $query = "UPDATE " . $this->table_name . " 
                  SET cantidad = ?, total = ?, fechamod = NOW() 
                  WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("iiii", $cantidad, $total, $idus, $sku);
        return $stmt->execute();
    }

    // Método para eliminar un producto del carrito
    public function removeItem($idus, $sku) {
        $query = "DELETE FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ii", $idus, $sku);
        return $stmt->execute();
    }

    // Método para obtener el precio de un producto considerando una posible oferta
    private function getPrecioProducto() {
        $query = "SELECT p.precio, o.preciooferta, o.fecha_inicio, o.fecha_fin 
                  FROM producto p 
                  LEFT JOIN ofertas o ON p.sku = o.sku 
                  WHERE p.sku = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return 0;
        }

        $stmt->bind_param("i", $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $fechaActual = date('Y-m-d');
            // Si existe una oferta válida, usar el precio de oferta
            if (!empty($row['preciooferta']) && $row['fecha_inicio'] <= $fechaActual && $row['fecha_fin'] >= $fechaActual) {
                return $row['preciooferta'];
            }
            // Si no hay oferta, devolver el precio normal
            return $row['precio'];
        }
        return 0;
    }

    // Método para verificar si un producto ya está en el carrito del usuario
    public function getItemByUserAndSku() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? AND sku = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ii", $this->idus, $this->sku);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
