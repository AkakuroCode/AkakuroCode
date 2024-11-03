<?php
class Backup {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function createBackup($backupFilePath) {
        $username = $this->db->getUsername();
        $password = $this->db->getPassword();
        $host = $this->db->getHost();
        $dbName = $this->db->getDbName();

        $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        $command = "{$mysqldumpPath} --user={$username} --password={$password} --host={$host} {$dbName} > {$backupFilePath}";
        
        exec($command, $output, $resultCode);

        return $resultCode === 0 ? "Backup realizado con éxito en {$backupFilePath}" : "Error al realizar el backup.";
    }
}