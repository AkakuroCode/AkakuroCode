<?php
require_once __DIR__ . '/../models/Usuario.php';


class UsuarioController {

    public function create($data) {
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
        return $usuario->readAll();
    }

    public function readOne($idus) {
        $usuario = new Usuario();
        $usuario->setId($idus);
        return $usuario->readOne();
    }

    public function update($data) {
        $usuario = new Usuario();
            $usuario->setNombre($data['nombre']);
            $usuario->setApellido($data['apellido']);
            $usuario->setFecnac($data['fecnac']);
            $usuario->setDireccion($data['direccion']);
            $usuario->setTelefono($data['telefono']);
            $usuario->setEmail($data['email']);
            $usuario->setPassw($data['passw']);
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
        $usuario->setEmail($data["email"]);
        $usuario->setPassw($data['passw']);
        $result = $usuario->login();
        if ($result) {
            // Login exitoso, retornar true
            $_SESSION['usuario'] = $result['email'];
            return true;
        } else {
            // Login fallido, retornar false
            return false;
        }
    }
    
}

?>
