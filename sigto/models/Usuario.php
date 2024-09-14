<?php
require 'config/Database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    private $id;
    private $email;
    private $nombreUsuario;
    private $celular;
    private $contrasena;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET email=?, nombreUsuario=?, celular=?, contrasena=?";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $this->email, $this->nombreUsuario, $this->celular, $hashedPassword);

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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET email=?, nombreUsuario=?, celular=?, contrasena=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssi", $this->email, $this->nombreUsuario, $this->celular, $hashedPassword, $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nombreUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        if ($usuario && password_verify($this->contrasena, $usuario['contrasena'])) {
            return $usuario;
        } else {
            return false;
        }
    }
}
?>
