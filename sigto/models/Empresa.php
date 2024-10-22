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
        // Aquí especificamos que queremos usar la conexión con rol de 'user' (app_user).
        $database = new Database('user');
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
        $empresa = $result->fetch_assoc();
    
        if ($result->num_rows > 0) {
            // Si las credenciales son correctas, guardamos el login en el historial
            $this->guardarLogin($empresa['idemp']);
            return $empresa;
        } else {
            return false;
        }
    }
    
    private function guardarLogin($idemp) {
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
        $query = "INSERT INTO historial_login (idemp, fecha, hora, url) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $idemp, $fecha, $hora, $url);
    
        if ($stmt->execute()) {
            // Login registrado exitosamente
        } else {
            echo "Error al registrar el login: " . $stmt->error;
        }
    
        // Cerrar el statement después de la inserción
        $stmt->close();
    }
    
    public function getEmpresaLogins($idemp) {
        $query = "SELECT fecha, hora, url FROM historial_login WHERE idemp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idemp);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC); // Retornamos todos los resultados en forma de array asociativo
    }
    
    
    
}
?>
