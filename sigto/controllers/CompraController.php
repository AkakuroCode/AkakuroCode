<?php 
require_once __DIR__ . '/../models/Compra.php';
require_once __DIR__ . '/../controllers/CarritoController.php';

class CompraController {
    private $compraModel;
    private $carritoController;

    public function __construct() {
        $this->compraModel = new Compra();
        $this->carritoController = new CarritoController();
    }

    public function procesarCompra() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Error en el formato de los datos JSON."]);
            exit;
        }

        if (!isset($data['payerName'], $data['paymentStatus'], $data['idpago'], $data['tipo_entrega'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Datos incompletos."]);
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['idus'] ?? null;
        if (!$idUsuario) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
            exit;
        }

        $idPago = $data['idpago'];
        $tipoEntrega = $data['tipo_entrega'];
        $totalCompra = $data['total_compra'];
        $idrecibo = $data['idrecibo'] ?? null;
        $direccion = isset($data['direccion']) ? implode(', ', $data['direccion']) : null;

        // Paso 1: Insertar en la tabla compra
        $idCompra = $this->compraModel->crearCompra($idPago, $tipoEntrega, 'Completado');
        if (!$idCompra) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla compra."]);
            return;
        }
        
        // Paso 2: Registrar en la tabla inicia
        $resultadoInicio = $this->compraModel->registrarInicioCompra($idCompra, $idPago);
        if (!$resultadoInicio) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla inicia."]);
            return;
        }
        
        // Paso 3: Insertar en detalle_recibo o detalle_envio
        if ($tipoEntrega === 'Recibo') {
            $idDetalleRecibo = $this->compraModel->crearDetalleRecibo($idCompra, $totalCompra);
            if (!$idDetalleRecibo) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_recibo."]);
                return;
            }
            
            // Relacionar en especifica
            $resultadoEspecifica = $this->compraModel->relacionarEspecifica($idCompra, $idrecibo);
            if (!$resultadoEspecifica) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla especifica."]);
                return;
            }
        } elseif ($tipoEntrega === 'Envio') {
            $idDetalleEnvio = $this->compraModel->crearDetalleEnvio($idCompra, $direccion, $totalCompra);
            if (!$idDetalleEnvio) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_envio."]);
                return;
            }
            
            // Paso: Insertar en la tabla envio
            $idEnvio = $this->compraModel->crearEnvio($idDetalleEnvio);
            if (!$idEnvio) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla envio."]);
                return;
            }
            
            // Paso: Relacionar en la tabla maneja
            $resultadoManeja = $this->compraModel->relacionarManeja($idCompra, $idEnvio);
            if (!$resultadoManeja) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla maneja."]);
                return;
            }
        }

        // Obtener idCarrito
        $idCarrito = $this->carritoController->obtenerIdCarrito($idUsuario);
        if (!$idCarrito) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "No se pudo obtener el ID del carrito."]);
            return;
        }
        
        // Registrar en la tabla cierra
        $resultadoCierra = $this->compraModel->registrarCierre($idPago, $idCarrito);
        if (!$resultadoCierra) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla cierra."]);
            return;
        }

        // Paso: Crear el registro en historial_compra
        $stock = 0; // Inicialización de la variable $stock
        $resultadoHistorialCompra = $this->compraModel->registrarEnHistorialCompra($idUsuario, date('Y-m-d'), $stock);
        if (!$resultadoHistorialCompra) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla historial_compra."]);
            return;
        }

        // Obtener el ID del historial de compra recién creado
        $idhistorial = $this->compraModel->obtenerIdHistorialReciente($idUsuario);
        if (!$idhistorial) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al obtener el ID del historial de compra."]);
            return;
        }

// Obtener productos del carrito y verificar
$productos = $this->carritoController->obtenerProductosDelCarrito($idCarrito);
if (!$productos || !is_array($productos)) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al obtener los productos del carrito."]);
    return;
}

// Calcular el stock (cantidad total de productos)
$stock = array_sum(array_column($productos, 'cantidad'));

foreach ($productos as $producto) {
    $sku = $producto['sku'];
    $estado = 'Completado';
    $cantidadComprada = $producto['cantidad'];
    $tipoStock = $producto['tipo_stock'];

    if ($tipoStock === 'Unidad') {
        // Obtener códigos de unidad disponibles exactos para el SKU
        $codigoUnidades = $this->compraModel->obtenerCodigosUnidadDisponibles($sku, $cantidadComprada);

        if (!$codigoUnidades || count($codigoUnidades) < $cantidadComprada) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "No hay suficientes códigos de unidad disponibles para el producto $sku."]);
            return;
        }

        // Registrar cada código de unidad para el producto de tipo 'Unidad'
        foreach ($codigoUnidades as $codigoUnidad) {
            $resultadoDetalleHistorial = $this->compraModel->registrarDetalleHistorial($idhistorial, $sku, $estado, $codigoUnidad);
            if (!$resultadoDetalleHistorial) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_historial para el producto $sku."]);
                return;
            }
        }
    } else {
        // Registrar un solo registro para productos de tipo 'Cantidad', con `codigo_unidad` como NULL
        for ($i = 0; $i < $cantidadComprada; $i++) {
            $resultadoDetalleHistorial = $this->compraModel->registrarDetalleHistorial($idhistorial, $sku, $estado, null);
            if (!$resultadoDetalleHistorial) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_historial para el producto $sku."]);
                return;
            }
        }
    }
}

echo json_encode(["success" => true, "message" => "Compra procesada y detalles registrados exitosamente."]);




        // Eliminar los productos del carrito
        $resultadoEliminarProductos = $this->carritoController->removeAllItems($idCarrito);
        if (!$resultadoEliminarProductos) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al eliminar los productos del carrito."]);
            return;
        }



        // Confirmar la transacción al final, después de todas las operaciones exitosas
        if ($resultadoCierra && $resultadoEliminarProductos) {
            $this->compraModel->commit();
            echo json_encode(["success" => true, "message" => "Orden registrada y carrito cerrado exitosamente."]);
        } else {
        // Si algo falla, puedes hacer rollback
            $this->compraModel->rollback();
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error en el cierre de la compra."]);
        return;
        }

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CompraController();
    $controller->procesarCompra();
}
