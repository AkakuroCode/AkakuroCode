<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentController {
    private $client;

    public function __construct() {
        $clientId = "AShlUkfl78xGwqeOVkB8B854CyYgEXzOvZHb8ajFHZmrxSiX8-dwVqAPLE62B6lLhGrJ1U8wsWkfR3KQ";
        $clientSecret = "EB4ceY2EHVlTywzB1u9uNVEVHiphG678H7HZ6O5wAbzaC4INegcKnhYgQtwN5gP4ZPT4KoEmCg2y6fXw";

        // Configura el entorno de PayPal (Sandbox o producción)
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayment() {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        
        // Configura los detalles del pago
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => "10.00" // Cambia esto al monto dinámico de tu compra
                ]
            ]],
            "application_context" => [
                "cancel_url" => "http://localhost/sigto/controllers/PaymentController.php?action=cancelPayment",
                "return_url" => "http://localhost/sigto/controllers/PaymentController.php?action=executePayment"
            ]
        ];

        try {
            // Ejecuta la solicitud para crear el pago
            $response = $this->client->execute($request);
            foreach ($response->result->links as $link) {
                if ($link->rel === "approve") {
                    // Redirige al usuario a PayPal para completar el pago
                    header("Location: " . $link->href);
                    exit;
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function executePayment() {
        $orderId = $_GET['token'] ?? null;
        
        if ($orderId) {
            $request = new OrdersCaptureRequest($orderId);
            
            try {
                $response = $this->client->execute($request);
                if ($response->result->status === "COMPLETED") {
                    echo "Pago completado con éxito. Gracias por tu compra.";
                    // Aquí puedes actualizar el estado de la orden en tu base de datos
                } else {
                    echo "El pago no se pudo completar.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Token de pago no encontrado.";
        }
    }

    public function cancelPayment() {
        echo "El pago ha sido cancelado.";
    }
}

// Llamada al controlador en función de la acción solicitada
$action = $_GET['action'] ?? null;
$controller = new PaymentController();

if ($action === 'createPayment') {
    $controller->createPayment();
} elseif ($action === 'executePayment') {
    $controller->executePayment();
} elseif ($action === 'cancelPayment') {
    $controller->cancelPayment();
}
