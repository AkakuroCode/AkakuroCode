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
        echo json_encode(["success" => true, "message" => "Registro en tabla compra exitoso.", "idCompra" => $idCompra]);
        
        // Paso 2: Registrar en la tabla inicia
        $resultadoInicio = $this->compraModel->registrarInicioCompra($idCompra, $idPago);
        if (!$resultadoInicio) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla inicia."]);
            return;
        }
        echo json_encode(["success" => true, "message" => "Registro en tabla inicia exitoso."]);
        
        // Paso 3: Insertar en detalle_recibo o detalle_envio
        if ($tipoEntrega === 'Recibo') {
            $idDetalleRecibo = $this->compraModel->crearDetalleRecibo($idCompra, $totalCompra);
            if (!$idDetalleRecibo) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_recibo."]);
                return;
            }
            echo json_encode(["success" => true, "message" => "Registro en tabla detalle_recibo exitoso."]);
            
            // Relacionar en especifica
            $resultadoEspecifica = $this->compraModel->relacionarEspecifica($idCompra, $idrecibo);
            if (!$resultadoEspecifica) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla especifica."]);
                return;
            }
            echo json_encode(["success" => true, "message" => "Registro en tabla especifica exitoso."]);
        } elseif ($tipoEntrega === 'Envio') {
            $idDetalleEnvio = $this->compraModel->crearDetalleEnvio($idCompra, $direccion, $totalCompra);
            if (!$idDetalleEnvio) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla detalle_envio."]);
                return;
            }
            echo json_encode(["success" => true, "message" => "Registro en tabla detalle_envio exitoso."]);
            // Paso: Insertar en la tabla envio
            $idEnvio = $this->compraModel->crearEnvio($idDetalleEnvio); // Asegúrate de definir $idVehiculo o de que sea parte de tu lógica
            if (!$idEnvio) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla envio."]);
                return;
            }
            echo json_encode(["success" => true, "message" => "Registro en tabla envio exitoso."]);

            // Paso: Relacionar en la tabla maneja
            $resultadoManeja = $this->compraModel->relacionarManeja($idCompra, $idEnvio);
            if (!$resultadoManeja) {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Error al registrar en la tabla maneja."]);
                return;
            }
            echo json_encode(["success" => true, "message" => "Registro en tabla maneja exitoso."]);
        }
        //Obtenemos idCarrito
        $idCarrito = $this->carritoController->obtenerIdCarrito($idUsuario);
        if (!$idCarrito) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "No se pudo obtener el ID del carrito."]);
            return;
        }
        
        // Confirmar la transacción
        $this->compraModel->commit();
        echo json_encode(["success" => true, "message" => "Orden registrada exitosamente."]);

        // Registrar en la tabla cierra
        $resultadoCierra = $this->compraModel->registrarCierre($idPago, $idCarrito);
        if (!$resultadoCierra) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error al registrar en la tabla cierra."]);
        return;
        }
        echo json_encode(["success" => true, "message" => "Registro en tabla cierra exitoso."]);

        // Eliminar los productos del carrito después de registrar la orden
        $resultadoEliminarProductos = $this->compraModel->eliminarProductosDelCarrito($idCarrito);
        if (!$resultadoEliminarProductos) {
            http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al eliminar los productos del carrito."]);
        return;
        }
        echo json_encode(["success" => true, "message" => "Productos del carrito eliminados exitosamente."]);

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CompraController();
    $controller->procesarCompra();
}
