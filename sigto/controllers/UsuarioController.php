<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Utils.php'; // Incluye el archivo Utils.php

class UsuarioController {

    public function create($data) {
        // Verificar si el email ya está registrado en cliente o empresa
        if (isEmailRegistered($data['email'])) {
            return "El email ya está registrado en el sistema.";
        }
        
        $usuario = new Usuario();
        $usuario->setNombre($data['nombre']);
        $usuario->setApellido($data['apellido']);
        $usuario->setFecnac($data['fecnac']);
        $usuario->setDireccion($data['direccion']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setEmail($data['email']);
        $usuario->setPassw($data['passw']);
        if ($usuario->create()) {
            return "Usuario creado exitosamente.";
        } else {
            return "Error al crear usuario.";
        }
    }

    public function getUserById($idus) {
        $usuario = new Usuario();
        $usuario->setId($idus);
        return $usuario->readOne();
    }
    
    public function readAll() {
        $usuario = new Usuario();
        $result = $usuario->readAll();
        
        if (!$result) {
            return "No se pudieron obtener los usuarios.";
        }
        return $result;
    }

    public function readOne($idus) {
        $usuario = new Usuario();
        $usuario->setId($idus);
        return $usuario->readOne();
    }

    public function update($data) {
        $usuario = new Usuario();
        $usuario->setId($data['idus']); // Asegurarse de establecer el ID del usuario
        $usuario->setNombre($data['nombre']);
        $usuario->setApellido($data['apellido']);
        $usuario->setFecnac($data['fecnac']);
        $usuario->setDireccion($data['direccion']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setEmail($data['email']);
        
        // Verificar si se proporcionó una nueva contraseña
        if (!empty($data['passw'])) {
            $usuario->setPassw($data['passw']); // Si se ingresó una nueva contraseña, la actualizamos
        } else {
            // Si no se ingresó una nueva contraseña, obtenemos la actual de la base de datos
            $usuarioData = $usuario->readOne();
            $usuario->setPassw($usuarioData['passw']); // Mantener la contraseña actual
        }
    
        if ($usuario->update()) {
            return "Usuario actualizado exitosamente.";
        } else {
            return "Error al actualizar usuario.";
        }
    }

    // Modificación del método delete para baja lógica
    public function delete($idus) {
        $usuario = new Usuario(); // Instancia del modelo Usuario
        $usuario->setId($idus); // Establece el id del usuario

        // Cambiar el valor de 'activo' a 'no'
        if ($usuario->updateActivo('no')) { // Método para realizar la baja lógica en el modelo
            return true;
        } else {
            return false;
        }
    }
    
    public function login($data) {
        $usuario = new Usuario();
        $usuario->setEmail($data['email']);
        $result = $usuario->login(); // El modelo maneja el login y la obtención de datos del usuario
    
        if ($result) {
            // Verificar si el usuario está inactivo (activo = 'no')
            if ($result['activo'] === 'no') {
                return false; // No permitir el acceso
            }
    
            // Verificar la contraseña
            if (password_verify($data['passw'], $result['passw'])) {
                // Iniciar sesión si aún no está iniciada
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
    
                if (!empty($result['idus'])) {
                    $_SESSION['role'] = 'usuario';
                    $_SESSION['idus'] = $result['idus'];
                    $_SESSION['email'] = $result['email'];
                    return true; // Login exitoso
                } else {
                    echo "Error: el ID de usuario es nulo.";
                    exit;
                }
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }
    
    
    
    
    // Método opcional para obtener el carrito de un usuario
    public function getCarrito($idus) {
        $carritoController = new CarritoController();
        return $carritoController->getItemsByUser($idus);
    }

    public function getUserLogins($idus) {
        $usuario = new Usuario();
        return $usuario->getUserLogins($idus); // Llamamos al método del modelo Usuario
    }


    public function updateStatus() {
        $data = json_decode(file_get_contents("php://input"), true);
        $idus = $data['idus'];
        $estado = $data['estado'];
    
        $usuario = new Usuario();
        $usuario->setId($idus);
    
        if ($usuario->updateActivo($estado)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function actualizarFavorito() {
        error_log("Solicitud recibida en el controlador");  // Registro para asegurarte de que entra a la función
        var_dump($_POST);  // Para verificar qué datos llegan
        die();  // Detener la ejecución temporalmente para que puedas ver el var_dump en la consola
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idus']) && isset($_POST['sku']) && isset($_POST['accion'])) {
            $idus = $_POST['idus'];
            $sku = $_POST['sku'];
            $accion = $_POST['accion'];
    
            $usuarioModel = new Usuario();
            $usuarioModel->actualizarFavorito($idus, $sku, $accion);
    
            // Devuelve una respuesta JSON
            echo json_encode(['status' => 'success', 'message' => "Producto $accion a favoritos"]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos o método no permitido']);
            exit;
        }
    }
    
    
    

    public function esFavorito($idus, $sku) {
            $usuarioModel = new Usuario();
            return $usuarioModel->esFavorito($idus, $sku);  // Llama al método del modelo para comprobar si es favorito
        }
    
}




