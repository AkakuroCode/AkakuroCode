<?php
class Restore {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function restoreBackup($backupFilePath) {
        $command = "mysql --user={$this->db->username} --password={$this->db->password} --host={$this->db->host} {$this->db->db_name} < {$backupFilePath}";
        exec($command, $output, $resultCode);
        return $resultCode === 0 ? "Restauración completada con éxito." : "Error al restaurar la base de datos.";
    }
}
?>
