<?php
class Database {
    private $host = "localhost";
    private $database = "oceantrade";
    private $user = "root";
    private $password = "";
    private $conn; // Variable para almacenar la conexión

    // Método para obtener la conexión
    public function getConnection() {
        // Reportar errores de MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Intentar la conexión
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            $this->conn->set_charset("utf8"); // Establecer el conjunto de caracteres

        } catch (mysqli_sql_exception $e) {
            // Manejar errores de conexión
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }

        return $this->conn;
    }

    // Método para cerrar la conexión
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Instancia de la clase Database
$db = new Database();

// Obtener la conexión
$conn = $db->getConnection();

// Verificar la conexión
if ($conn) {
    echo "Conexión exitosa a la base de datos.";
}

// Cerrar la conexión (opcional, cuando ya no la necesites)
// $db->closeConnection();
?>
