<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    
    public function login($data) {
        $admin = new Admin();
        $admin->setEmail($data['email']);
        $result = $admin->login();
    
        if ($result) {
            if (password_verify($data['passw'], $result['passw'])) {
                // Asegurarse de que no haya otra sesión activa (como empresa o usuario)
                session_start();
                session_unset();  // Elimina todas las variables de sesión actuales
                session_destroy(); // Destruye la sesión actual, si la hay
    
                // Iniciar una nueva sesión para el admin
                session_start();
                $_SESSION['role'] = 'admin';  // Identifica el rol
                $_SESSION['admin'] = $result['email'];  // Guardar el email del admin
    
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
