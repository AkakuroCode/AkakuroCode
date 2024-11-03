<?php
require_once __DIR__ .'/controllers/BackupController.php';

// Crear una instancia del controlador
$backupController = new BackupController();

// Ejecutar el backup y mostrar el resultado
$result = $backupController->createBackup();
echo $result;
?>