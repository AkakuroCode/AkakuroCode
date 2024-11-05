<?php
require_once __DIR__ .'/../config/Database.php';
require_once __DIR__ .'/../models/backup.php';
require_once __DIR__ .'/../models/restore.php';

class RestoreController {
    public function restoreBackup($filePath) {
        $db = new Database('admin'); // Cambia el rol según sea necesario
        $conn = $db->getConnection();

        if ($conn) {
            if (file_exists($filePath) && is_readable($filePath)) {
                $restore = new Restore($db);
                $result = $restore->restoreBackup($filePath);

                // Registrar la acción en el log
                $this->logRestoreAction('Restauración completada desde ' . $filePath);
                return $result;
            } else {
                $this->logRestoreAction('Error: El archivo de respaldo no existe o no es accesible.');
                return 'El archivo de respaldo no existe o no es accesible.';
            }
        } else {
            $this->logRestoreAction('Error: No se pudo establecer la conexión a la base de datos.');
            return 'No se pudo establecer la conexión a la base de datos.';
        }
    }

    private function logRestoreAction($message) {
        $logDir = __DIR__ . '/../logs'; // Ubicación de la carpeta logs
        $logFile = $logDir . '/restore_log.txt';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }
}
?>