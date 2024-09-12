<?php
// Incluimos el modelo Empresa.
require_once '/Users/51245320/Desktop/UTU/ProyectoSIGTO/ProgDiseño/AkakuroCode/sigto/models/Empresas.php';

class EmpresaController {
    // Método para crear un nuevo empresa$empresa.
    public function create($data) {
        $empresa = new Empresa(); // Creamos una nueva instancia del modelo Empresa.
        $empresa->setEmail($data['email']); // Asignamos el email del empresa$empresa utilizando el dato proporcionado.
        $empresa->setNombre($data['nombre']); // Asignamos el nombre de empresa$empresa.
        $empresa->setDirecc($data['direccion']);
        $empresa->setTelefono($data['telefono']); // Asignamos el número de celular del empresa$empresa.
        $empresa->setContraseña($data['contraseña']); // Asignamos la contraseña del empresa$empresa.
        if ($empresa->create()) { // Intentamos crear el empresa$empresa en la base de datos.
            return "Empresa creado exitosamente."; // Si la creación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al crear empresa."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para leer todos los Empresas.
    public function readAll() {
        $empresa = new Empresa(); // Creamos una nueva instancia del modelo Empresa.
        return $empresa->readAll(); // Retornamos todos los Empresas utilizando el método readAll del modelo Empresa.
    }

    // Método para leer un empresa$empresa específico por su ID.
    public function readOne($idemp) {
        $empresa= new Empresa(); // Creamos una nueva instancia del modelo Empresa.
        $empresa->setIdEmp($idemp); // Asignamos el ID del empresa$empresa que queremos leer.
        return $empresa->readOne(); // Retornamos los datos del empresa$empresa con el ID especificado.
    }

    // Método para actualizar un empresa$empresa existente.
    public function update($data) {
        $empresa = new Empresa(); // Creamos una nueva instancia del modelo Empresa.
        $empresa->setIdEmp($data['idemp']); // Asignamos el ID del empresa$empresa que se va a actualizar.
        $empresa->setEmail($data['email']); // Actualizamos el email del empresa$empresa.
        $empresa->setNombre($data['nombre']); // Actualizamos el nombre de empresa$empresa.
        $empresa->setDirecc($data['direccion']);
        $empresa->setTelefono($data['telefono']); // Actualizamos el número de celular del empresa$empresa.
        $empresa->setContraseña($data['contraseña']); // Actualizamos la contraseña del empresa$empresa.
        if ($empresa->update()) { // Intentamos actualizar el empresa$empresa en la base de datos.
            return "Empresa actualizado exitosamente."; // Si la actualización fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al actualizar empresa."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para eliminar un empresa$empresa por su ID.
    public function delete($idemp) {
        $empresa = new Empresa(); // Creamos una nueva instancia del modelo Empresa.
        $empresa->setIdEmp($idemp); // Asignamos el ID del empresa$empresa que se va a eliminar.
        if ($empresa->delete()) { // Intentamos eliminar el empresa$empresa de la base de datos.
            return "Empresa eliminado exitosamente."; // Si la eliminación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al eliminar empresa."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }
}
?>
