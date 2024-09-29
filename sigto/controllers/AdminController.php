<?php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    
    public function login($data) {
        $admin = new Admin();
        $admin->setEmail($data['email']);
        $result = $admin->login();

        if ($result && password_verify($data['passw'], $result['passw'])) {
            session_start();
            $_SESSION['admin'] = $result['email'];
            return true;
        } else {
            return false;
        }
    }
}
?>
