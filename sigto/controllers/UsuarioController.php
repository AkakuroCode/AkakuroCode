?php
require_once 'models/Usuario.php';

class UsuarioController {

    public function create($data) {
        $usuario = new Usuario();
        $usuario->setEmail($data['email']);
        $usuario->setNombreUsuario($data['nombreUsuario']);
        $usuario->setCelular($data['celular']);
        $usuario->setContrasena($data['contrasena']);
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

    public function readOne($id) {
        $usuario = new Usuario();
        $usuario->setId($id);
        return $usuario->readOne();
    }

    public function update($data) {
        $usuario = new Usuario();
        $usuario->setId($data['id']);
        $usuario->setEmail($data['email']);
        $usuario->setNombreUsuario($data['nombreUsuario']);
        $usuario->setCelular($data['celular']);
        $usuario->setContrasena($data['contrasena']);
        if ($usuario->update()) {
            return "Usuario actualizado exitosamente.";
        } else {
            return "Error al actualizar usuario.";
        }
    }

    public function delete($id) {
        $usuario = new Usuario();
        $usuario->setId($id);
        if ($usuario->delete()) {
            return "Usuario eliminado exitosamente.";
        } else {
            return "Error al eliminar usuario.";
        }
    }

    public function login($data) {
        $usuario = new Usuario();
        $usuario->setNombreUsuario($data['nombreUsuario']);
        $usuario->setContrasena($data['contrasena']);
        $result = $usuario->login();
        if ($result) {
            // Login exitoso
            $_SESSION['usuario'] = $result['nombreUsuario'];
            return true;
        } else {
            // Login fallido
            return false;
        }
    }
}

?>
