<?php
require_once __DIR__ .'/controllers/RestoreController.php';

// Verificar que se pase el archivo de respaldo como argumento al script
if (isset($argv[1])) {
    $filePath = $argv[1];
    
    // Crear una instancia del controlador
    $restoreController = new RestoreController();
    
    // Ejecutar la restauración y mostrar el resultado
    $result = $restoreController->restoreBackup($filePath);
    echo $result;
} else {
    echo "Por favor, proporciona la ruta del archivo de respaldo como argumento.\n";
}
?>