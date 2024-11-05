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

    public function registrarEnHistorialCompra($idus, $fecha) {
        // Primero, insertamos o actualizamos el registro en historial_compra sin el stock.
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
            // Si existe, actualizamos la fecha (y luego el stock).
            $queryUpdate = "UPDATE historial_compra SET fecha = ? WHERE idus = ?";
            $stmtUpdate = $this->conn->prepare($queryUpdate);
    
            if (!$stmtUpdate) {
                echo "Error en la preparación de la consulta para actualizar el historial: " . $this->conn->error;
                return false;
            }
    
            $stmtUpdate->bind_param("si", $fecha, $idus);
            $stmtUpdate->execute();
        } else {
            // Si no existe, creamos un nuevo registro.
            $queryInsert = "INSERT INTO historial_compra (idus, fecha) VALUES (?, ?)";
            $stmtInsert = $this->conn->prepare($queryInsert);
    
            if (!$stmtInsert) {
                echo "Error en la preparación de la consulta para insertar en historial_compra: " . $this->conn->error;
                return false;
            }
    
            $stmtInsert->bind_param("is", $idus, $fecha);
            $stmtInsert->execute();
        }
    
        // Obtener el idhistorial recién insertado o actualizado.
        $idhistorial = $this->obtenerIdHistorialReciente($idus);
    
        // Calcular el stock basado en la cantidad de productos en detalle_historial vinculados al idhistorial.
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
    
        // Actualizar el stock en historial_compra.
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
    
    public function registrarDetalleHistorial($idhistorial, $sku, $estado, $codigoUnidades) {
        // Obtener el precio actual del producto, considerando si tiene oferta activa
        $queryPrecio = "SELECT IF(o.preciooferta IS NOT NULL AND NOW() BETWEEN o.fecha_inicio AND o.fecha_fin, o.preciooferta, p.precio) AS precio_actual
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
        $precioActual = $resultPrecio->fetch_assoc()['precio_actual'];
    
        // Verificar que $codigoUnidades sea un array antes de iterar
        if (is_array($codigoUnidades)) {
            foreach ($codigoUnidades as $codigoUnidad) {
                $query = "INSERT INTO detalle_historial (idhistorial, sku, estado, codigo_unidad, precio_actual)
                          VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);
    
                if (!$stmt) {
                    echo "Error en la preparación de la consulta: " . $this->conn->error;
                    return false;
                }
    
                $stmt->bind_param("iissd", $idhistorial, $sku, $estado, $codigoUnidad, $precioActual);
                $resultado = $stmt->execute();
    
                // Actualizar el estado del producto_unitario a "Vendido" si se registra correctamente
                if ($resultado) {
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
            // Si $codigoUnidades no es un array, registrar con un código de unidad null
            $query = "INSERT INTO detalle_historial (idhistorial, sku, estado, codigo_unidad, precio_actual)
                      VALUES (?, ?, ?, NULL, ?)";
            $stmt = $this->conn->prepare($query);
    
            if (!$stmt) {
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                return false;
            }
    
            $stmt->bind_param("iisd", $idhistorial, $sku, $estado, $precioActual);
            $resultado = $stmt->execute();
        }
    
        return true;
    }
    
    public function obtenerCodigosUnidadDisponibles($sku, $cantidad) {
        // Consultar códigos de unidad disponibles para el SKU específico, limitados por la cantidad
        $query = "SELECT codigo_unidad FROM producto_unitario WHERE sku = ? AND estado = 'Disponible' LIMIT ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return [];
        }
    
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("ii", $sku, $cantidad);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $codigos = [];
        while ($row = $result->fetch_assoc()) {
            $codigos[] = $row['codigo_unidad'];
        }
    
        // Si la cantidad de códigos obtenidos es menor que la requerida, devolver solo los disponibles
        if (count($codigos) < $cantidad) {
            echo "Advertencia: No hay suficientes códigos de unidad disponibles para el SKU $sku. Se obtuvieron " . count($codigos) . " de $cantidad solicitados.";
        }
    
        return $codigos;
    }
    
    
}
