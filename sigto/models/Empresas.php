<?php
// Incluimos el archivo de configuración de la base de datos.
require 'config/Database.php';

class Empresa {
    // Conexión a la base de datos y nombre de la tabla.
    private $conn;
    private $table_name = "empresa";

    // Atributos privados.
    private $idemp;
    private $nombre;
    private $direccion;
    private $telefono;
    private $email;
    private $passw;

    // Constructor para inicializar la conexión a la base de datos.
    public function __construct() {
        $database = new Database(); // Creamos una instancia de la clase Database.
        $this->conn = $database->getConnection(); // Obtenemos la conexión a la base de datos.
    }

    // Getters y Setters para los atributos.
    public function getIdEmp() {
        return $this->idemp; // Retornamos el ID del usuario.
    }

    public function setIdEmp($idemp) {
        $this->idemp = $idemp; // Asignamos el ID de la empresa.
    }
    public function getNombre() {
        return $this->nombre; // Retornamos nombre de la empresa
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre; // Asignamos nombre de la empresa
    }
    public function getDirecc() {
        return $this->direcc; // Retornamos direccion de la empresa
    }

    public function setDirecc($direccion) {
        $this->direcc = $direccion; // Asignamos direccion de la empresa
    }
    public function getEmail() {
        return $this->email; // Retornamos el email de la empresa
    }

    public function setEmail($email) {
        $this->email = $email; // Asignamos el email de la empresa
    }


    public function getTelefono() {
        return $this->telefono; // Retornamos el número de celular de la empresa
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono; // Asignamos el número de celular de la empresa
    }

    public function getContraseña() {
        return $this->contraseña; // Retornamos la contraseña de la empresa
    }

    public function setContraseña($passw) {
        $this->contraseña = $passw; // Asignamos la contraseña de la empresa
    }

    // Método para crear un nuevo usuario empresa.
    public function create() {
        // Creamos una consulta SQL para insertar un nuevo registro en la tabla de empresa.
        $query = "INSERT INTO " . $this->table_name . " SET email=?, nombre=?,direccion=?, telefono=?, passw=?";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Aplicamos un hash a la contraseña para almacenarla de manera segura.
        $hashedPassword = password_hash($this->contraseña, PASSWORD_DEFAULT);
        
        // Unimos los valores a los parámetros de la consulta SQL.
        $stmt->bind_param("sssis", $this->email, $this->nombre,$this->direcc, $this->telefono, $hashedPassword);
        
        // Ejecutamos la consulta y verificamos si se ejecutó correctamente.
        if ($stmt->execute()) {
            return true; // Retornamos true si el usuario fue creado exitosamente.
        } else {
            // Manejo de errores: mostramos el error y retornamos false.
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    
    // Método para leer todos los usuarios.
    public function readAll() {
        // Consulta SQL para seleccionar todos los registros de la tabla de usuarios.
        $query = "SELECT * FROM " . $this->table_name;
        
        // Ejecutamos la consulta y almacenamos el resultado.
        $result = $this->conn->query($query);
        return $result; // Retornamos el resultado de la consulta.
    }

    // Método para leer un usuario específico por su ID.
    public function readOne() {
        // Consulta SQL para seleccionar un registro específico por ID.
        $query = "SELECT * FROM " . $this->table_name . " WHERE idemp = ? LIMIT 0,1";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Unimos el ID al parámetro de la consulta SQL.
        $stmt->bind_param("i", $this->idemp);
        
        // Ejecutamos la consulta.
        $stmt->execute();
        
        // Obtenemos el resultado y retornamos el registro como un arreglo asociativo.
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para actualizar un usuario existente.
    public function update() {
        // Consulta SQL para actualizar un registro en la tabla de usuarios.
        $query = "UPDATE " . $this->table_name . " SET email=?, nombre=?,direccion=?, telefono=?, contraseña=? WHERE idemp =?";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Aplicamos un hash a la nueva contraseña.
        $hashedPassword = password_hash($this->contraseña, PASSWORD_DEFAULT);
        
        // Unimos los valores a los parámetros de la consulta SQL.
        $stmt->bind_param("sssisi", $this->email, $this->nombre,$this->direcc, $this->telefono, $hashedPassword, $this->idemp);
        
        // Ejecutamos la consulta y retornamos el resultado (true si fue exitoso, false si no lo fue).
        return $stmt->execute();
    }

    // Método para eliminar un usuario por su ID.
    public function delete() {
        // Consulta SQL para eliminar un registro específico por ID.
        $query = "DELETE FROM " . $this->table_name . " WHERE idemp = ?";
        
        // Preparamos la consulta SQL.
        $stmt = $this->conn->prepare($query);
        
        // Unimos el ID al parámetro de la consulta SQL.
        $stmt->bind_param("i", $this->idemp);
        
        // Ejecutamos la consulta y retornamos el resultado (true si fue exitoso, false si no lo fue).
        return $stmt->execute();
    }
}
?>
