<?php
require_once __DIR__ .'/../config/Database.php';
require_once __DIR__ .'/../models/backup.php';

class BackupController {
    public function createBackup() {
        $db = new Database('admin'); // Cambia el rol según sea necesario
        $conn = $db->getConnection();
        
        if ($conn) {
            $backup = new Backup($db);
            $backupFilePath = '../backups/oceantrade_' . date('Y-m-d_H-i-s') . '.sql';
            $result = $backup->createBackup($backupFilePath);
            
            $this->logBackupAction('Backup realizado con éxito en ' . $backupFilePath);
            return $result;
        } else {
            $this->logBackupAction('Error: No se pudo establecer la conexión a la base de datos.');
            return 'No se pudo establecer la conexión a la base de datos.';
        }
    }

    private function logBackupAction($message) {
        $logFile = '../logs/backup_log.txt';
        file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }
}
?>
