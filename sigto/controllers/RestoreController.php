<?php
require_once 'models/Database.php';
require_once 'models/Backup.php';
require_once 'models/Restore.php';

class RestoreController {
    public function restoreBackup($filePath) {
        $db = new Database('admin'); // Cambia el rol según sea necesario
        $conn = $db->getConnection();
        
        if ($conn) {
            if (file_exists($filePath) && is_readable($filePath)) {
                $restore = new Restore($db);
                $result = $restore->restoreBackup($filePath);
                
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
        $logFile = 'logs/restore_log.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }
}
?>
