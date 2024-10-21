<?php
require_once __DIR__ . '/../config/Database.php';

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
        $query = "INSERT INTO " . $this->table_name . " SET nombre=?, apellido=?, fecnac=?, direccion=?, telefono=?, email=?, passw=?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }
    
        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssss", $this->nombre, $this->apellido, $this->fecnac, $this->direccion, $this->telefono, $this->email, $hashedPassword);
    
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
        $query = "SELECT * FROM " . $this->table_name . " WHERE idus = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->idus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre=?, apellido=?, fecnac=?, direccion=?, telefono=?, email=?, passw=? 
                  WHERE idus=?";
        $stmt = $this->conn->prepare($query);
    
        $hashedPassword = password_hash($this->passw, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssssi", $this->nombre, $this->apellido, $this->fecnac, $this->direccion, $this->telefono, $this->email, $hashedPassword, $this->idus);
    
        return $stmt->execute();
    }

    public function updateActivo($estado) {
        $query = "UPDATE cliente SET activo = ? WHERE idus = ?";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }
    
        $stmt->bind_param("si", $estado, $this->idus);
        return $stmt->execute();
    }
    
    
    
    

    public function login() {
        $query = "SELECT idus, email, passw, activo FROM cliente WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }
        
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false; // Usuario no encontrado
        }
    }
    
    
    private function guardarLogin($idus) {
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $url = $_SERVER['REQUEST_URI']; // La URL actual del login
    
        // Verificar si la URL ya existe en la tabla `pagina`
        $query_check = "SELECT COUNT(*) FROM pagina WHERE url = ?";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bind_param("s", $url);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        
        // Cerrar el statement para liberar los resultados de la consulta anterior
        $stmt_check->close();
    
        if ($count == 0) {
            // Si la URL no existe, insertarla en la tabla `pagina`
            $query_insert_url = "INSERT INTO pagina (url, estado) VALUES (?, 'activo')";
            $stmt_insert_url = $this->conn->prepare($query_insert_url);
            $stmt_insert_url->bind_param("s", $url);
            $stmt_insert_url->execute();
            
            // Cerrar el statement después de la inserción
            $stmt_insert_url->close();
        }
    
        // Ahora puedes insertar el login en historial_logins
        $query = "INSERT INTO historial_login (idus, fecha, hora, url) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $idus, $fecha, $hora, $url);
    
        if ($stmt->execute()) {
            // Login registrado exitosamente
        } else {
            echo "Error al registrar el login: " . $stmt->error;
        }
    
        // Cerrar el statement después de la inserción
        $stmt->close();
    }
    public function getUserLogins($idus) {
        $query = "SELECT fecha, hora, url FROM historial_login WHERE idus = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idus);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC); // Retornamos todos los resultados en forma de array asociativo
    }
    
    
    
    
    
}
?>
