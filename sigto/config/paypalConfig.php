<?php
require_once __DIR__ . '/../vendor/autoload.php';



use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

$apiContext = new ApiContext(
    new OAuthTokenCredential(
        'AShlUkfl78xGwqeOVkB8B854CyYgEXzOvZHb8ajFHZmrxSiX8-dwVqAPLE62B6lLhGrJ1U8wsWkfR3KQ',    // Reemplaza con el Client ID copiado
        'EB4ceY2EHVlTywzB1u9uNVEVHiphG678H7HZ6O5wAbzaC4INegcKnhYgQtwN5gP4ZPT4KoEmCg2y6fXw' // Reemplaza con el Secret copiado
    )
);

$apiContext->setConfig([
    'mode' => 'sandbox', // En producción, cambia a 'live'
    'log.LogEnabled' => true,
    'log.FileName' => '../PayPal.log',
    'log.LogLevel' => 'FINE'
]);
