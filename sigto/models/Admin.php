<?php
require_once __DIR__ . '/../config/Database.php';

class Admin {
    private $conn;
    private $table_name = "admin";

    private $idad;
    private $email;
    private $passw;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getIdad() {
        return $this->idad;
    }

    public function setIdad($idad) {
        $this->idad = $idad;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassw() {
        return $this->passw;
    }

    public function setPassw($passw) {
        $this->passw = $passw;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            echo "Error en la consulta: " . $this->conn->error;
            return false;
        }
    }
}
?>
