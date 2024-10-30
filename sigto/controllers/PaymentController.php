<?php
// controllers/PaymentController.php

require_once '../config/paypalConfig.php'; // Ruta a tu archivo de configuración

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class PaymentController {
    // Método para iniciar el pago
    public function createPayment() {
        global $apiContext;

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Definir el monto de la transacción
        $amount = new Amount();
        $amount->setTotal("10.00"); // Cambia el monto según tu lógica
        $amount->setCurrency("USD");

        // Crear la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("Compra de productos en MiEcommerce");

        // Configurar URLs de retorno y cancelación
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost/sigto/controllers/PaymentController.php?action=executePayment&success=true")
                     ->setCancelUrl("http://localhost/sigto/controllers/PaymentController.php?action=cancelPayment");

        // Crear el pago
        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            // Redirige al usuario a PayPal
            header("Location: " . $payment->getApprovalLink());
            exit;
        } catch (Exception $ex) {
            die($ex);
        }
    }

    // Método para ejecutar el pago una vez aprobado
    public function executePayment() {
        global $apiContext;

        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            $paymentId = $_GET['paymentId'];
            $payerId = $_GET['PayerID'];

            $payment = Payment::get($paymentId, $apiContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            try {
                // Ejecuta el pago
                $result = $payment->execute($execution, $apiContext);

                // Verifica el estado del pago
                if ($result->getState() == 'approved') {
                    echo "Pago exitoso. Gracias por tu compra.";
                    // Aquí puedes actualizar el estado de la orden en tu base de datos
                }
            } catch (Exception $ex) {
                die($ex);
            }
        } else {
            echo "Pago cancelado.";
        }
    }

    // Método para manejar cancelación de pago
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
