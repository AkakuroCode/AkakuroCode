<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    
    public function login($data) {
        $admin = new Admin();
        $admin->setEmail($data['email']);
        $result = $admin->login();
    
        if ($result) {
            if (password_verify($data['passw'], $result['passw'])) {
                // Iniciar sesión si aún no está iniciada
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Limpiar variables de sesión de otros roles si es necesario, sin destruir toda la sesión
                session_unset();  // Elimina variables de sesión pero mantiene la sesión activa
                
                // Guardar datos en la sesión
                $_SESSION['role'] = 'admin';  // Identifica el rol
                $_SESSION['idad'] = $result['idad'];  // Guardar el ID del admin
                $_SESSION['email'] = $result['email'];  // Guardar el email del admin
    
                // Redirigir a la vista de admin
                header('Location: /sigto/views/listarUsuarios.php');
                exit;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
