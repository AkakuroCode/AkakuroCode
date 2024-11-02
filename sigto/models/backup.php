<?php
class Backup {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function createBackup($backupFilePath) {
        $command = "mysqldump --user={$this->db->username} --password={$this->db->password} --host={$this->db->host} {$this->db->db_name} > {$backupFilePath}";
        exec($command, $output, $resultCode);
        return $resultCode === 0 ? "Backup realizado con éxito en {$backupFilePath}" : "Error al realizar el backup.";
    }
}
?>
