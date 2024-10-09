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
    

    public function delete($idus) {
        $usuario = new Usuario();
        $usuario->setId($idus);
        if ($usuario->delete()) {
            return "Usuario eliminado exitosamente.";
        } else {
            return "Error al eliminar usuario.";
        }
    }

    public function login($data) {
        $usuario = new Usuario();
        $usuario->setEmail($data['email']);
        $result = $usuario->login();
    
        if ($result) {
            if (password_verify($data['passw'], $result['passw'])) {
                // Iniciar una nueva sesión para el usuario
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
    
                // Establecer las variables de sesión
                $_SESSION['role'] = 'usuario';
                $_SESSION['idus'] = $result['idus'];  // Guardar el ID del usuario en la sesión
                $_SESSION['email'] = $result['email'];  // Guardar el email del usuario
    
    
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    
    
}

?>
