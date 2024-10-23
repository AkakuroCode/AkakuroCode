<?php
class Database {
    private $host = "127.0.0.1"; // Dirección del host de la base de datos.
    private $db_name = "oceantrade"; // Nombre de la base de datos.
    private $username; // Usuario dinámico según el rol.
    private $password; // Contraseña dinámica según el rol.
    private $conn; // Variable para almacenar la conexión a la base de datos.

    // Método constructor que recibe el rol del usuario y asigna las credenciales correctas
    public function __construct($role = 'guest') {
        switch ($role) {
            case 'admin':
                // Conexión para administradores (puedes elegir dev_user o dba_user)
                $this->username = 'dba_user'; // o 'dev_user' según el nivel de permisos que prefieras
                $this->password = 'password_dba'; // O la contraseña de dev_user
                break;
            case 'user':
                // Conexión para usuarios o empresas
                $this->username = 'app_user';
                $this->password = 'password_app';
                break;
            default:
                // Conexión por defecto para guest_user (catálogo visible sin loguearse)
                $this->username = 'guest_user';
                $this->password = 'password_guest';
                break;
        }
    }

    // Método para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            // Verificar si la conexión fue exitosa.
            if ($this->conn->connect_error) {
                throw new Exception("Error en la conexión: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Mostrar mensaje de error
            echo $e->getMessage();
        }
        return $this->conn;
    }
}
?>
