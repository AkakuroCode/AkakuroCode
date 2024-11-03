<?php  
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

class Carrito {
    private $conn;
    private $carrito_table = "carrito";
    private $detalle_table = "detalle_carrito";

    private $idcarrito;
    private $idus;
    private $sku;
    private $cantidad;

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

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    // Método para agregar un producto al carrito
    public function addItem($idcarrito, $sku, $cantidad) {
        $query = "INSERT INTO " . $this->detalle_table . " (idcarrito, sku, cantidad) 
                  VALUES (?, ?, ?) 
                  ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("iii", $idcarrito, $sku, $cantidad);
        return $stmt->execute();
    }

    // Método para obtener los productos del carrito de un usuario
    public function getItemsByUser($idus) {
        $query = "SELECT dc.*, p.nombre, p.descripcion, p.imagen, 
                         IF(o.preciooferta IS NOT NULL AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, o.preciooferta, p.precio) AS precio_actual,
                         (dc.cantidad * IF(o.preciooferta IS NOT NULL AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, o.preciooferta, p.precio)) AS subtotal
                  FROM " . $this->detalle_table . " dc
                  INNER JOIN producto p ON dc.sku = p.sku
                  LEFT JOIN ofertas o ON p.sku = o.sku 
                  WHERE dc.idcarrito = (SELECT idcarrito FROM " . $this->carrito_table . " WHERE idus = ? AND estado = 'Activo')";
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

// Método para actualizar la cantidad de un producto en el carrito y actualizar el total
public function updateQuantity($idcarrito, $sku, $cantidad) {
    $query = "UPDATE " . $this->detalle_table . " 
              SET cantidad = ?
              WHERE idcarrito = ? AND sku = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("iii", $cantidad, $idcarrito, $sku);

    if ($stmt->execute()) {
        // Calcular el nuevo total del carrito
        $totalCarrito = $this->recalcularTotalCarrito($idcarrito);

        // Actualizar el total en la tabla `carrito`
        $queryUpdateTotal = "UPDATE " . $this->carrito_table . " SET total = ? WHERE idcarrito = ?";
        $stmtUpdateTotal = $this->conn->prepare($queryUpdateTotal);

        if (!$stmtUpdateTotal) {
            echo "Error en la preparación de la consulta para actualizar el total: " . $this->conn->error;
            return false;
        }

        $stmtUpdateTotal->bind_param("di", $totalCarrito, $idcarrito);
        return $stmtUpdateTotal->execute();
    } else {
        return false;
    }
}

public function getSubtotalByUserAndSku($sku) {
    $query = "SELECT 
                 (dc.cantidad * IFNULL(
                     IF(
                         o.preciooferta IS NOT NULL 
                         AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, 
                         o.preciooferta, 
                         p.precio
                     ), 0)
                 ) AS subtotal
              FROM detalle_carrito dc
              INNER JOIN producto p ON dc.sku = p.sku
              LEFT JOIN ofertas o ON p.sku = o.sku
              WHERE dc.sku = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $sku);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ? $result['subtotal'] : 0;
}




// Método para recalcular el total del carrito
public function recalcularTotalCarrito($idcarrito) {
    $query = "SELECT SUM(cantidad * IFNULL(o.preciooferta, p.precio)) AS total 
              FROM " . $this->detalle_table . " d
              INNER JOIN producto p ON d.sku = p.sku
              LEFT JOIN ofertas o ON p.sku = o.sku 
                  AND o.fecha_inicio <= NOW() 
                  AND o.fecha_fin >= NOW()
              WHERE d.idcarrito = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return 0;
    }

    $stmt->bind_param("i", $idcarrito);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] ?? 0; // Retornar el total calculado
}


// Método para eliminar un producto del carrito y actualizar el total
public function removeItem($idcarrito, $sku) {
    $query = "DELETE FROM " . $this->detalle_table . " WHERE idcarrito = ? AND sku = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("ii", $idcarrito, $sku);

    if ($stmt->execute()) {
        // Calcular el nuevo total del carrito después de eliminar un producto
        $totalCarrito = $this->recalcularTotalCarrito($idcarrito);

        // Actualizar el total en la tabla `carrito`
        $queryUpdateTotal = "UPDATE " . $this->carrito_table . " SET total = ? WHERE idcarrito = ?";
        $stmtUpdateTotal = $this->conn->prepare($queryUpdateTotal);

        if (!$stmtUpdateTotal) {
            echo "Error en la preparación de la consulta para actualizar el total: " . $this->conn->error;
            return false;
        }

        $stmtUpdateTotal->bind_param("di", $totalCarrito, $idcarrito);
        return $stmtUpdateTotal->execute();
    } else {
        return false;
    }
}

public function getItemByUserAndSku($idus, $sku) {
    $query = "SELECT * FROM " . $this->detalle_table . " 
              WHERE idcarrito = (SELECT idcarrito FROM " . $this->carrito_table . " WHERE idus = ? AND estado = 'Activo') 
              AND sku = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("ii", $idus, $sku);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

    // Método para obtener el idcarrito activo de un usuario
    public function getActiveCartIdByUser($idus) {
        $query = "SELECT idcarrito FROM " . $this->carrito_table . " WHERE idus = ? AND estado = 'Activo'";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row ? $row['idcarrito'] : null;
    }

    public function getPrecioProducto($sku) {
        $query = "SELECT p.precio, 
                         IF(o.preciooferta IS NOT NULL AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, o.preciooferta, p.precio) AS precio_final
                  FROM producto p 
                  LEFT JOIN ofertas o ON p.sku = o.sku
                  WHERE p.sku = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("i", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row ? $row['precio_final'] : 0; // Retorna el precio con la oferta si existe, de lo contrario el precio normal
    }
    public function createCart($idus) {
        $query = "INSERT INTO " . $this->carrito_table . " (idus, fechacrea, estado, total) VALUES (?, NOW(), 'Activo', 0)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("i", $idus);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Devuelve el idcarrito recién creado
        } else {
            return false;
        }
    }

    public function getTotalByUser($idus) {
        $query = "SELECT total FROM " . $this->carrito_table . " WHERE idus = ? AND estado = 'Activo'";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return 0;
        }
    
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row ? $row['total'] : 0; // Retorna el total o 0 si no se encuentra
    }
    
}
