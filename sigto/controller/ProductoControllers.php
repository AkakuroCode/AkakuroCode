<?php
// Incluimos el modelo Usuario.
require_once 'models/Productos.php';

class ProductoController {
    // Método para crear un nuevo usuario.
    public function create($data1) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo Usuario.
        $producto->setNom($data1['Nombre']); // Asignamos el email del usuario utilizando el dato proporcionado.
        $producto->setDesc($data1['Descripcion']);
        $producto->set
        $producto->setCantidad($data1['Cantidad']); // Asignamos el nombre de usuario.
        $producto->setPrecio($data1['Precio']); // Asignamos el número de celular del usuario.
     if ($producto->create()) { // Intentamos crear el usuario en la base de datos.
            return "Producto creado exitosamente."; // Si la creación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al crear producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para leer todos los usuarios.
    public function readAll() {
        $producto = new Productos(); // Creamos una nueva instancia del modelo Usuario.
        return $producto->readAll(); // Retornamos todos los usuarios utilizando el método readAll del modelo Usuario.
    }

    // Método para leer un usuario específico por su ID.
    public function readOne($idProducto) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo Usuario.
        $producto->setIdProd($idProducto); // Asignamos el ID del usuario que queremos leer.
        return $producto->readOne(); // Retornamos los datos del usuario con el ID especificado.
    }

    // Método para actualizar un usuario existente.
    public function update($data1) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo Usuario.
        $producto->setIdProd($data1['idProd']); // Asignamos el ID del usuario que se va a actualizar.
        $producto->setNom($data1['Nombre']); // Actualizamos el email del usuario.
        $producto->setCantidad($data1['Cantidad']); // Actualizamos el nombre de usuario.
        $producto->setPrecio($data1['Precio']); // Actualizamos el número de celular del usuario.
        if ($producto->update()) { // Intentamos actualizar el usuario en la base de datos.
            return "Producto actualizado exitosamente."; // Si la actualización fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al actualizar Producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para eliminar un usuario por su ID.
    public function delete($idProducto) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo Usuario.
        $producto->setIdProd($idProducto); // Asignamos el ID del usuario que se va a eliminar.
        if ($producto->delete()) { // Intentamos eliminar el usuario de la base de datos.
            return "Producto eliminado exitosamente."; // Si la eliminación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al eliminar Producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }
}
?>
