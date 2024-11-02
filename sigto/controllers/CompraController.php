<?php
require_once __DIR__ . '/../models/Compra.php';

class CompraController {
    private $compraModel;

    public function __construct() {
        $this->compraModel = new Compra();
    }

    public function procesarCompra() {
        header('Content-Type: application/json');

        // Decodificar datos JSON
        $data = json_decode(file_get_contents("php://input"), true);

        // Validar datos requeridos
        if (!isset($data['orderId'], $data['payerName'], $data['paymentStatus'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Datos incompletos."]);
            exit;
        }

        // Iniciar sesión si es necesario
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['idus'] ?? null;
        if (!$idUsuario) {
            http_response_code(401);
            echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
            exit;
        }

        $idPago = 1;  // Suponiendo que el ID de PayPal es 1; cámbialo según tu base de datos
        $tipoEntrega = $data['tipo_entrega'] ?? 'domicilio';
        $direccion = isset($data['direccion']) ? implode(', ', $data['direccion']) : null;
        $idCentroRecibo = $data['centroRecibo'] ?? null;
        $idVehiculo = $data['vehiculo'] ?? null;

        // Iniciar transacción
        $this->compraModel->beginTransaction();

        try {
            // Crear la compra
            $idCompra = $this->compraModel->crearCompra($idPago, $tipoEntrega, 'confirmada');
            if (!$idCompra) {
                throw new Exception("Error al crear la compra.");
            }

            // Insertar detalles según el tipo de entrega
            if ($tipoEntrega === 'domicilio' && $direccion) {
                $idDetalleEnvio = $this->compraModel->crearDetalleEnvio($idCompra, $direccion);
                if (!$idDetalleEnvio) {
                    throw new Exception("Error al crear el detalle de envío.");
                }
                if ($idVehiculo) {
                    $this->compraModel->asignarVehiculo($idDetalleEnvio, $idVehiculo);
                }
            } elseif ($tipoEntrega === 'recibo' && $idCentroRecibo) {
                $idDetalleRecibo = $this->compraModel->crearDetalleRecibo($idCompra, $idCentroRecibo);
                if (!$idDetalleRecibo) {
                    throw new Exception("Error al crear el detalle de recibo.");
                }
            }

            // Confirmar transacción
            $this->compraModel->commit();
            echo json_encode(["success" => true, "message" => "Compra registrada exitosamente."]);

        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->compraModel->rollback();
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
