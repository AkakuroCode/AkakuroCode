<?php
require_once __DIR__ . '/../config/Database.php';

class Categoria {
    private $conn;
    private $table_name = "categoria";

    public function __construct($operation = 'read') {
        if ($operation === 'write') {
            $database = new Database('admin'); // app_user para operaciones privadas
        } else {
            $database = new Database('guest'); // guest_user para lecturas públicas
        }
        $this->conn = $database->getConnection();
    }

    // Método para obtener todas las categorías
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para asignar una categoría a un producto
    public function asignarCategoria($sku, $idcat) {
        $query = "INSERT INTO pertenece (sku, idcat) VALUES (?, ?) 
                  ON DUPLICATE KEY UPDATE idcat = VALUES(idcat)"; // Esto actualiza si ya existe
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ii", $sku, $idcat);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al asignar la categoría: " . $stmt->error;
            return false;
        }
    }

    // Método para agregar una nueva categoría
    public function create($nombre, $descripcion) {
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("ss", $nombre, $descripcion);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al agregar la categoría: " . $stmt->error;
            return false;
        }
    }

// Método para actualizar una categoría existente
public function update($id, $nombre, $descripcion) {
    $query = "UPDATE " . $this->table_name . " SET nombre = ?, descripcion = ? WHERE idcat = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("ssi", $nombre, $descripcion, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al actualizar la categoría: " . $stmt->error;
        return false;
    }
}

// Método para borrar una categoría existente
public function delete($id) {
    $query = "DELETE FROM " . $this->table_name . " WHERE idcat = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $this->conn->error;
        return false;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error al borrar la categoría: " . $stmt->error;
        return false;
    }
}



}
?>
