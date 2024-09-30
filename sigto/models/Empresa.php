<?php
require_once __DIR__ . '/../config/Database.php';

class Empresa {
    private $conn;
    private $table_name = "empresa";

    private $idemp;
    private $nombre;
    private $direccion;
    private $telefono;
    private $email;
    private $passw;
    private $cuentabanco;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getId() {
        return $this->idemp;
    }

    public function setId($idemp) {
        $this->idemp = $idemp;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new Exception("Email no válido");
        }
    }

    public function getPassw() {
        return $this->passw;
    }

    public function setPassw($passw) {
        $this->passw = $passw;
    }

    public function getCuentaBanco() {
        return $this->cuentabanco;
    }

    public function setCuentaBanco($cuentabanco) {
        $this->cuentabanco = $cuentabanco;
    }

    public function create2() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=?, direccion=?, telefono=?, email=?, passw=?, cuentabanco=?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssss", $this->nombre, $this->direccion, $this->telefono, $this->email, $hashedPassword, $this->cuentabanco);
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error en la ejecución: " . $stmt->error;
            return false;
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($query);
        
        if (!$result) {
            echo "Error en la consulta SQL: " . $this->conn->error;
            return false;
        }
        
        return $result;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idemp = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idemp);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre=?, direccion=?, telefono=?, email=?, passw=?, cuentabanco=? 
                  WHERE idemp=?";
        $stmt = $this->conn->prepare($query);
    
        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssssi", $this->nombre, $this->direccion, $this->telefono, $this->email, $hashedPassword, $this->cuentabanco, $this->idemp);
    
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idemp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idemp);
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Devolvemos toda la información de la empresa, incluido el idemp
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    
}
?>
