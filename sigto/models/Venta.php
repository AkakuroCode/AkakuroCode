<?php
require_once __DIR__ . '/../config/Database.php';

class Venta {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }
    
    public function registrarOActualizarVenta($idemp) {
        // Verificar si ya existe una venta para esta empresa
        $queryCheck = "SELECT idventa FROM venta WHERE idemp = ?";
        $stmtCheck = $this->conn->prepare($queryCheck);
        
        if (!$stmtCheck) {
            echo "Error en la preparación de la consulta para verificar la venta: " . $this->conn->error;
            return false;
        }
        
        $stmtCheck->bind_param("i", $idemp);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        if ($resultCheck->num_rows > 0) {
            // Si existe, obtener el idventa y retornarlo
            $venta = $resultCheck->fetch_assoc();
            return $venta['idventa'];
        } else {
            // Si no existe, crear un nuevo registro de venta
            $queryInsert = "INSERT INTO venta (idemp, fecha) VALUES (?, CURDATE())";
            $stmtInsert = $this->conn->prepare($queryInsert);
            
            if (!$stmtInsert) {
                echo "Error en la preparación de la consulta para insertar en venta: " . $this->conn->error;
                return false;
            }
            
            // Usamos la fecha actual para el campo `fecha`
            $stmtInsert->bind_param("i", $idemp);
            $stmtInsert->execute();
            
            // Retornar el idventa recién insertado
            return $this->conn->insert_id;
        }
    }

 public function actualizarStockEnVenta($idventa) {
    // Calcular el stock basado en la cantidad de productos en `detalle_venta`
    $queryStock = "SELECT COUNT(*) AS cantidad_total FROM detalle_venta WHERE idventa = ?";
    $stmtStock = $this->conn->prepare($queryStock);
    
    if (!$stmtStock) {
        echo "Error en la preparación de la consulta para contar el stock: " . $this->conn->error;
        return false;
    }
    
    $stmtStock->bind_param("i", $idventa);
    $stmtStock->execute();
    $resultStock = $stmtStock->get_result();
    $stock = $resultStock->fetch_assoc()['cantidad_total'];
    
    // Actualizar el stock en la tabla `venta`
    $queryUpdateStock = "UPDATE venta SET stock = ? WHERE idventa = ?";
    $stmtUpdateStock = $this->conn->prepare($queryUpdateStock);
    
    if (!$stmtUpdateStock) {
        echo "Error en la preparación de la consulta para actualizar el stock en venta: " . $this->conn->error;
        return false;
    }
    
    $stmtUpdateStock->bind_param("ii", $stock, $idventa);
    return $stmtUpdateStock->execute();
}


public function registrarDetalleVenta($idventa, $sku, $cantidad, $precio_unitario) {
    // Calcular el subtotal para la cantidad actual
    $subtotal = $cantidad * $precio_unitario;

    // Verificar si el registro ya existe
    $queryCheck = "SELECT cantidad, subtotal FROM detalle_venta WHERE idventa = ? AND sku = ?";
    $stmtCheck = $this->conn->prepare($queryCheck);
    $stmtCheck->bind_param("ii", $idventa, $sku);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Si el registro ya existe, actualiza la cantidad y el subtotal
        $existingData = $resultCheck->fetch_assoc();
        $newCantidad = $existingData['cantidad'] + $cantidad;
        $newSubtotal = $newCantidad * $precio_unitario;

        $queryUpdate = "UPDATE detalle_venta SET cantidad = ?, subtotal = ? WHERE idventa = ? AND sku = ?";
        $stmtUpdate = $this->conn->prepare($queryUpdate);

        if (!$stmtUpdate) {
            echo "Error en la preparación de la consulta para actualizar detalle_venta: " . $this->conn->error;
            return false;
        }

        $stmtUpdate->bind_param("idii", $newCantidad, $newSubtotal, $idventa, $sku);
        return $stmtUpdate->execute();
    } else {
        // Si no existe, insertar un nuevo registro
        $queryInsert = "INSERT INTO detalle_venta (idventa, sku, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $this->conn->prepare($queryInsert);

        if (!$stmtInsert) {
            echo "Error en la preparación de la consulta para insertar en detalle_venta: " . $this->conn->error;
            return false;
        }

        // Vincular los parámetros
        $stmtInsert->bind_param("iiidd", $idventa, $sku, $cantidad, $precio_unitario, $subtotal);

        // Ejecutar la consulta
        return $stmtInsert->execute();
    }
}

public function obtenerHistorialVentas($idemp) {
    // Consulta para obtener las ventas realizadas por la empresa
    $queryVentas = "SELECT idventa, fecha, stock FROM venta WHERE idemp = ?";
    $stmtVentas = $this->conn->prepare($queryVentas);

    if (!$stmtVentas) {
        echo "Error en la preparación de la consulta para obtener ventas: " . $this->conn->error;
        return false;
    }

    $stmtVentas->bind_param("i", $idemp);
    $stmtVentas->execute();
    $resultVentas = $stmtVentas->get_result();
    $ventas = [];

    while ($venta = $resultVentas->fetch_assoc()) {
        // Para cada venta, obtenemos sus detalles
        $ventaId = $venta['idventa'];
        $venta['detalles'] = $this->obtenerDetallesVenta($ventaId);
        $ventas[] = $venta;
    }

    return $ventas;
}

private function obtenerDetallesVenta($idventa) {
    // Consulta para obtener los detalles de cada venta
    $queryDetalles = "SELECT dv.sku, dv.cantidad, dv.precio_unitario, dv.subtotal, p.nombre AS nombre_producto
                      FROM detalle_venta dv
                      JOIN producto p ON dv.sku = p.sku
                      WHERE dv.idventa = ?";
    $stmtDetalles = $this->conn->prepare($queryDetalles);

    if (!$stmtDetalles) {
        echo "Error en la preparación de la consulta para obtener detalles de la venta: " . $this->conn->error;
        return [];
    }

    $stmtDetalles->bind_param("i", $idventa);
    $stmtDetalles->execute();
    $resultDetalles = $stmtDetalles->get_result();
    $detalles = $resultDetalles->fetch_all(MYSQLI_ASSOC);

    return $detalles;
}

    
}
