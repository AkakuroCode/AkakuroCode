<?php
require_once __DIR__ . '/../config/Database.php';

class Compra {
    private $conn;

    public function __construct() {
        $database = new Database('user');
        $this->conn = $database->getConnection();
    }

    // Iniciar transacción
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    // Confirmar transacción
    public function commit() {
        $this->conn->commit();
    }

    // Revertir transacción
    public function rollback() {
        $this->conn->rollback();
    }

    // Crear compra
    public function crearCompra($idpago, $tipo_entrega, $estado) {
        $sql = "INSERT INTO compra (idpago, estado, tipo_entrega) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $idpago, $estado, $tipo_entrega);
        $stmt->execute();
        return $stmt->insert_id ? $stmt->insert_id : false;
    }

    // Crear registro en la tabla inicia
    public function registrarInicioCompra($idcompra, $idpago) {
        $sql = "INSERT INTO inicia (idcompra, idpago) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idpago);
        return $stmt->execute();
    }

    // Crear detalle de recibo
    public function crearDetalleRecibo($idcompra, $total_compra, $estado = 'Completado') {
        $sql = "INSERT INTO detalle_recibo (idcompra, total_compra, estado) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ids", $idcompra, $total_compra, $estado);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Relacionar en la tabla especifica
    public function relacionarEspecifica($idcompra, $idrecibo) {
        $sql = "INSERT INTO especifica (idcompra, idrecibo) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idrecibo);
        return $stmt->execute();
    }

    // Crear detalle de envío
    public function crearDetalleEnvio($idcompra, $direccion, $total_compra, $estado = 'Completado') {
        $sql = "INSERT INTO detalle_envio (idcompra, direccion, total_compra, estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isds", $idcompra, $direccion, $total_compra, $estado);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    // Crear envio
    public function crearEnvio() {
    $sql = "INSERT INTO envio (fecsa, fecen) VALUES (NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    // Verificar si la inserción fue exitosa
    return $stmt->affected_rows > 0;
    }

    // Relacionar en la tabla maneja
    public function relacionarManeja($idcompra, $idenvio) {
        $sql = "INSERT INTO maneja (idcompra, idenvio) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idenvio);
        return $stmt->execute();
    }

   // Función para registrar en la tabla "cierra"
    public function registrarCierre($idpago, $idcarrito) {
    $query = "INSERT INTO cierra (idpago, idcarrito) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $idpago, $idcarrito);
    return $stmt->execute();
    }

    // Función para eliminar los productos del carrito
    public function eliminarProductosDelCarrito($idcarrito) {
    $query = "DELETE FROM detalle_carrito WHERE idcarrito = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $idcarrito);
    return $stmt->execute();
    }

    public function registrarOActualizarHistorialCompra($idus, $fecha) {
        // Verificar si el historial ya existe
        $queryCheck = "SELECT idhistorial FROM historial_compra WHERE idus = ?";
        $stmtCheck = $this->conn->prepare($queryCheck);
    
        if (!$stmtCheck) {
            echo "Error en la preparación de la consulta para verificar el historial: " . $this->conn->error;
            return false;
        }
    
        $stmtCheck->bind_param("i", $idus);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
    
        if ($resultCheck->num_rows > 0) {
            // Si existe, actualizar la fecha
            $queryUpdate = "UPDATE historial_compra SET fecha = ? WHERE idus = ?";
            $stmtUpdate = $this->conn->prepare($queryUpdate);
    
            if (!$stmtUpdate) {
                echo "Error en la preparación de la consulta para actualizar el historial: " . $this->conn->error;
                return false;
            }
    
            $stmtUpdate->bind_param("si", $fecha, $idus);
            $stmtUpdate->execute();
        } else {
            // Si no existe, crear un nuevo registro
            $queryInsert = "INSERT INTO historial_compra (idus, fecha) VALUES (?, ?)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            if (!$stmtInsert) {
                echo "Error en la preparación de la consulta para insertar en historial_compra: " . $this->conn->error;
                return false;
            }
    
            $stmtInsert->bind_param("is", $idus, $fecha);
            $stmtInsert->execute();
        }
    
        return $this->obtenerIdHistorialReciente($idus);
    }
    
    public function actualizarStockEnHistorialCompra($idhistorial) {
        // Calcular el stock basado en la cantidad de productos en `detalle_historial`
        $queryStock = "SELECT COUNT(*) AS cantidad_total FROM detalle_historial WHERE idhistorial = ?";
        $stmtStock = $this->conn->prepare($queryStock);
    
        if (!$stmtStock) {
            echo "Error en la preparación de la consulta para contar el stock: " . $this->conn->error;
            return false;
        }
    
        $stmtStock->bind_param("i", $idhistorial);
        $stmtStock->execute();
        $resultStock = $stmtStock->get_result();
        $stock = $resultStock->fetch_assoc()['cantidad_total'];
    
        // Actualizar el stock en historial_compra
        $queryUpdateStock = "UPDATE historial_compra SET stock = ? WHERE idhistorial = ?";
        $stmtUpdateStock = $this->conn->prepare($queryUpdateStock);
    
        if (!$stmtUpdateStock) {
            echo "Error en la preparación de la consulta para actualizar el stock en historial_compra: " . $this->conn->error;
            return false;
        }
    
        $stmtUpdateStock->bind_param("ii", $stock, $idhistorial);
        return $stmtUpdateStock->execute();
    }
    
    



    public function obtenerIdHistorialReciente($idUsuario) {
        $query = "SELECT idhistorial FROM historial_compra WHERE idus = ? ORDER BY idhistorial DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row ? $row['idhistorial'] : null;
    }
    
    public function registrarDetalleDesdeCarrito($idhistorial, $idCarrito, $sku, $estado) {
        // Obtener la cantidad del producto en detalle_carrito
        $queryCantidad = "SELECT cantidad FROM detalle_carrito WHERE idcarrito = ? AND sku = ?";
        $stmtCantidad = $this->conn->prepare($queryCantidad);
    
        if (!$stmtCantidad) {
            echo "Error en la preparación de la consulta para obtener la cantidad: " . $this->conn->error;
            return false;
        }
    
        $stmtCantidad->bind_param("ii", $idCarrito, $sku);
        $stmtCantidad->execute();
        $resultCantidad = $stmtCantidad->get_result();
        $cantidad = $resultCantidad->fetch_assoc()['cantidad'] ?? 0;
    
        if ($cantidad <= 0) {
            echo "Cantidad no válida o no encontrada para el SKU $sku en el carrito $idCarrito.";
            return false;
        }
    
        // Obtener el precio actual del producto
        $queryPrecio = "SELECT IF(o.preciooferta IS NOT NULL AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, o.preciooferta, p.precio) AS precio_actual, p.tipo_stock
                        FROM producto p
                        LEFT JOIN ofertas o ON p.sku = o.sku
                        WHERE p.sku = ?";
        $stmtPrecio = $this->conn->prepare($queryPrecio);
    
        if (!$stmtPrecio) {
            echo "Error en la preparación de la consulta para obtener el precio: " . $this->conn->error;
            return false;
        }
    
        $stmtPrecio->bind_param("i", $sku);
        $stmtPrecio->execute();
        $resultPrecio = $stmtPrecio->get_result();
        $row = $resultPrecio->fetch_assoc();
        $precioActual = $row['precio_actual'];
        $tipoStock = $row['tipo_stock'];
    
        // Si es un producto de tipo "unidad", obtener cada código de unidad disponible e insertarlo en `detalle_historial`
        if ($tipoStock === 'unidad') {
            $queryUnidad = "SELECT codigo_unidad FROM producto_unitario WHERE sku = ? AND estado = 'Disponible' LIMIT 1";
            $stmtUnidad = $this->conn->prepare($queryUnidad);
    
            if (!$stmtUnidad) {
                echo "Error en la preparación de la consulta para obtener códigos de unidad: " . $this->conn->error;
                return false;
            }
    
            for ($i = 0; $i < $cantidad; $i++) {
                $stmtUnidad->bind_param("i", $sku);
                $stmtUnidad->execute();
                $resultUnidad = $stmtUnidad->get_result();
                $codigoUnidad = $resultUnidad->fetch_assoc()['codigo_unidad'] ?? null;
    
                // Insertar en `detalle_historial`
                $queryInsert = "INSERT INTO detalle_historial (idhistorial, sku, estado, codigo_unidad, precio_actual)
                                VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = $this->conn->prepare($queryInsert);
    
                if (!$stmtInsert) {
                    echo "Error en la preparación de la consulta de inserción en detalle_historial: " . $this->conn->error;
                    return false;
                }
    
                $stmtInsert->bind_param("iissd", $idhistorial, $sku, $estado, $codigoUnidad, $precioActual);
                $resultadoInsert = $stmtInsert->execute();
    
                // Actualizar el estado del producto_unitario a "Vendido"
                if ($resultadoInsert && $codigoUnidad) {
                    $queryUpdateUnidad = "UPDATE producto_unitario SET estado = 'Vendido' WHERE codigo_unidad = ?";
                    $stmtUpdate = $this->conn->prepare($queryUpdateUnidad);
    
                    if (!$stmtUpdate) {
                        echo "Error en la preparación de la consulta para actualizar el estado: " . $this->conn->error;
                        return false;
                    }
    
                    $stmtUpdate->bind_param("s", $codigoUnidad);
                    $stmtUpdate->execute();
                }
            }
        } else {
            // Para productos de tipo "cantidad", registrar sin `codigo_unidad` y reducir el stock
            $queryInsert = "INSERT INTO detalle_historial (idhistorial, sku, estado, codigo_unidad, precio_actual)
                            VALUES (?, ?, ?, NULL, ?)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            if (!$stmtInsert) {
                echo "Error en la preparación de la consulta de inserción en detalle_historial: " . $this->conn->error;
                return false;
            }
    
            for ($i = 0; $i < $cantidad; $i++) {
                $stmtInsert->bind_param("iisd", $idhistorial, $sku, $estado, $precioActual);
                $stmtInsert->execute();
            }
    
            // Reducir el stock en la tabla `producto`
            $queryUpdateStock = "UPDATE producto SET stock = stock - ? WHERE sku = ?";
            $stmtUpdateStock = $this->conn->prepare($queryUpdateStock);
    
            if (!$stmtUpdateStock) {
                echo "Error en la preparación de la consulta para reducir el stock en producto: " . $this->conn->error;
                return false;
            }
    
            $stmtUpdateStock->bind_param("ii", $cantidad, $sku);
            $stmtUpdateStock->execute();
        }
    
        return true;
    }
    
    
     
    
}
