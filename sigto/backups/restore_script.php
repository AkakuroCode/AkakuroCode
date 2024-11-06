<?php
require_once __DIR__ .'/../controllers/RestoreController.php';

if (isset($argv[1])) {
    $filePath = $argv[1];
    $restoreController = new RestoreController();
    $result = $restoreController->restoreBackup($filePath);
    echo $result;
} else {
    echo "Por favor, proporciona la ruta del archivo de respaldo como argumento.\n";
}
?>