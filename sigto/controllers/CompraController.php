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
        // Establecer cabecera de respuesta JSON
        header('Content-Type: application/json');

        // Decodificar la solicitud JSON
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Error en el formato de los datos JSON."]);
            exit;
        }

        // Validar datos requeridos
        if (!isset($data['orderId'], $data['payerName'], $data['paymentStatus'], $data['idpago'], $data['tipo_entrega'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Datos incompletos."]);
            exit;
        }

        // Iniciar la sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener datos del usuario y otros detalles de la compra
        $idUsuario = $_SESSION['idus'] ?? null;
        $idPago = $data['idpago'];
        $tipoEntrega = $data['tipo_entrega'];
        $direccion = isset($data['direccion']) ? implode(', ', $data['direccion']) : null;
        $idCentroRecibo = $data['centroRecibo'] ?? null;
        $idVehiculo = $data['vehiculo'] ?? null;

        if (!$idUsuario) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
            exit;
        }

        $this->compraModel->conn->begin_transaction(); // Iniciar transacción

        try {
            // Crear registro en la tabla `compra`
            $idCompra = $this->compraModel->crearCompra($idPago, $tipoEntrega, 'confirmada');
            if (!$idCompra) {
                throw new Exception("Error al crear la compra.");
            }

            // Insertar detalles de envío o recibo según el tipo de entrega
            if ($tipoEntrega === 'domicilio') {
                $idDetalleEnvio = $this->compraModel->crearDetalleEnvio($idCompra, $direccion);
                if (!$idDetalleEnvio) {
                    throw new Exception("Error al crear el detalle de envío.");
                }
                $this->compraModel->relacionarManeja($idCompra, $idDetalleEnvio);

                // Asignar vehículo si aplica
                if ($idVehiculo) {
                    $this->compraModel->asignarVehiculo($idCompra, $idVehiculo);
                }
            } elseif ($tipoEntrega === 'recibo') {
                $idDetalleRecibo = $this->compraModel->crearDetalleRecibo($idCompra, $idCentroRecibo);
                if (!$idDetalleRecibo) {
                    throw new Exception("Error al crear el detalle de recibo.");
                }
                $this->compraModel->relacionarEspecifica($idCentroRecibo, $idDetalleRecibo);
            }

            // Actualizar stock de productos y limpiar el carrito
            $productos = $this->carritoController->getItemsByUser($idUsuario);
            foreach ($productos as $producto) {
                $actualizado = $this->compraModel->actualizarStockProducto($producto['sku'], $producto['cantidad']);
                if (!$actualizado) {
                    throw new Exception("Error al actualizar el stock del producto con SKU: {$producto['sku']}.");
                }
            }
            $this->carritoController->vaciarCarrito($idUsuario);

            $this->compraModel->conn->commit(); // Confirmar transacción
            echo json_encode(["success" => true, "message" => "Orden registrada exitosamente."]);

        } catch (Exception $e) {
            $this->compraModel->conn->rollback(); // Revertir transacción
            error_log("Error en la compra: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar la orden."]);
        }
    }
}

// Llamada al controlador solo si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CompraController();
    $controller->procesarCompra();
}
