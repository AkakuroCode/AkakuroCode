<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/Utils.php'; // Incluye el archivo Utils.php

class EmpresaController {

    public function create2($data) {
        // Verificar si el email ya está registrado en cliente o empresa
        if (isEmailRegistered($data['email'])) {
            return "El email ya está registrado en el sistema.";
        }

        $empresa = new Empresa();
        $empresa->setNombre($data['nombre']);
        $empresa->setDireccion($data['direccion']);
        $empresa->setTelefono($data['telefono']);
        $empresa->setEmail($data['email']);
        $empresa->setPassw($data['passw']);
        $empresa->setCuentaBanco($data['cuentabanco']);

        if ($empresa->create2()) {
            return "Empresa creada exitosamente.";
        } else {
            return "Error al crear empresa.";
        }
    }


    public function readAll() {
        $empresa = new Empresa();
        $result = $empresa->readAll();

        if (!$result) {
            return "No se pudieron obtener las empresas.";
        }
        return $result;
    }

    public function readOne($idemp) {
        $empresa = new Empresa();
        $empresa->setId($idemp);
        return $empresa->readOne();
    }

    public function update($data) {
        $empresa = new Empresa();
        $empresa->setId($data['idemp']); // Asegurarse de establecer el ID de la empresa
        $empresa->setNombre($data['nombre']);
        $empresa->setDireccion($data['direccion']);
        $empresa->setTelefono($data['telefono']);
        $empresa->setEmail($data['email']);
        $empresa->setCuentaBanco($data['cuentabanco']);

        // Verificar si se proporcionó una nueva contraseña
        if (!empty($data['passw'])) {
            $empresa->setPassw($data['passw']); // Si se ingresó una nueva contraseña, la actualizamos
        } else {
            // Si no se ingresó una nueva contraseña, obtenemos la actual de la base de datos
            $empresaData = $empresa->readOne();
            $empresa->setPassw($empresaData['passw']); // Mantener la contraseña actual
        }

        if ($empresa->update()) {
            return "Empresa actualizada exitosamente.";
        } else {
            return "Error al actualizar empresa.";
        }
    }

    public function delete($idemp) {
        $empresa = new Empresa();
        $empresa->setId($idemp);
        if ($empresa->delete()) {
            return "Empresa eliminada exitosamente.";
        } else {
            return "Error al eliminar empresa.";
        }
    }

    public function login($data) {
        $empresa = new Empresa();
        $empresa->setEmail($data['email']);
        $result = $empresa->login();

        if ($result) {
            if (password_verify($data['passw'], $result['passw'])) {
                session_start();
                $_SESSION['empresa'] = $result['email'];
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
