<?php
class Restore {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function restoreBackup($backupFilePath) {
        // Usamos los getters de Database para obtener los datos de conexión
        $username = $this->db->getUsername();
        $password = $this->db->getPassword();
        $host = $this->db->getHost();
        $dbName = $this->db->getDbName();

        // Comando para restaurar el archivo SQL en la base de datos
        $command = "mysql --user={$username} --password={$password} --host={$host} {$dbName} < {$backupFilePath}";

        // Ejecutamos el comando
        exec($command, $output, $resultCode);

        // Retornamos el resultado de la restauración
        return $resultCode === 0 ? "Restauración completada con éxito." : "Error al restaurar la base de datos.";
    }
}
?>