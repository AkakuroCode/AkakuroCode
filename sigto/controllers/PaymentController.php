<?php

class PaymentController {
    private $clientId;
    private $clientSecret;

    public function __construct() {
        $this->clientId = "AceErLCZ6XmVz4t3eQ-HNTR6L60MWTPws4Z8K2tdjiVaK05pJeuAhxWm2MEibyVMiCSQdqm10Y9ocAHm";
        $this->clientSecret = "ELZU9uezhrkkF1VRZUKeteCrpkA6oXEWYkFCalmWxB7zHaNmmM1JUMmCSSpfDuqzYwqJtHMXwzHMWvMd";
    }

    private function getAccessToken() {
        $url = "https://api.sandbox.paypal.com/v1/oauth2/token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ":" . $this->clientSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Accept-Language: en_US"
        ]);

        $response = curl_exec($ch);
        $accessToken = json_decode($response)->access_token;
        curl_close($ch);

        return $accessToken;
    }

    public function createPayment() {
        $accessToken = $this->getAccessToken();
        $url = "https://api.sandbox.paypal.com/v2/checkout/orders";
        $data = [
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

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $accessToken
        ]);

        $response = curl_exec($ch);
        $order = json_decode($response);
        curl_close($ch);

        foreach ($order->links as $link) {
            if ($link->rel === "approve") {
                // Redirige al usuario a PayPal para completar el pago
                header("Location: " . $link->href);
                exit;
            }
        }
    }

    public function executePayment() {
        $orderId = $_GET['token'] ?? null;

        if ($orderId) {
            $accessToken = $this->getAccessToken();
            $url = "https://api.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ]);

            $response = curl_exec($ch);
            $result = json_decode($response);
            curl_close($ch);

            if ($result->status === "COMPLETED") {
                echo "Pago completado con éxito. Gracias por tu compra.";
                // Aquí puedes actualizar el estado de la orden en tu base de datos
            } else {
                echo "El pago no se pudo completar.";
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
