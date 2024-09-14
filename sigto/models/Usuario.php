<?php
require 'config/Database.php';

class Usuario {
    private $conn;
    private $table_name = "cliente";

    private $idus;
    private $nombre;
    private $apellido;
    private $fecnac;
    private $direccion;
    private $telefono;
    private $email;
    private $passw;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getId() {
        return $this->idus;
    }

    public function setId($idus) {
        $this->idus = $idus;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido ($apellido) {
        $this->apellido = $apellido;
    }

    public function getFecnac() {
        return $this->fecnac;
    }

    public function setFecnac($fecnac) {
        // Obtener la fecha actual
        $fechaActual = date('Y-m-d');
    
        // Comparar la fecha de nacimiento con la fecha actual
        if ($fecnac >= $fechaActual) {
            throw new Exception("La fecha de nacimiento debe ser menor a la fecha actual.");
        }
    
        // Si pasa la validación, asignar el valor
        $this->fecnac = $fecnac;
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

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=?, apellido=?, direccion=?, telefono=?, email=?, passw=?";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("ssissss", $this->nombre, $this->apellido, $this->fecnac, $this->direccion, $this->telefono, $this->email, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=?, apellido=?, fecnac=?, direccion=?, telefono=?, email=?, passw=? WHERE idus=?";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("ssissss", $this->nombre, $this->apellido, $this->fecnac, $this->direccion, $this->telefono, $this->email, $hashedPassword, $this->idus);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idus = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idus);
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario && password_verify($this->passw, $usuario['passw'])) {
            return $usuario;
        } else {
            return false;
        }
    }
}
?>
