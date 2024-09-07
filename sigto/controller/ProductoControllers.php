<?php
// Incluimos el modelo producto.
require_once 'models/Productos.php';

class ProductoController {
    // Método para crear un nuevo productos.
    public function create($data1) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo producto.
        $producto->setNom($data1['Nombre']); // Asignamos el nombre del producto utilizando el dato proporcionado.
        $producto->setDesc($data1['Descripcion']);
        $producto->setEstado($data1['Estado']);
        $producto->setOrigen($data1['Origen']);
        $producto->setPrecio($data1['Precio']);
        $producto->setCantidad($data1['Cantidad']); 
     if ($producto->create()) { // Intentamos crear el producto en la base de datos.
            return "Producto creado exitosamente."; // Si la creación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al crear producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para leer todos los productos.
    public function readAll() {
        $producto = new Productos(); // Creamos una nueva instancia del modelo producto.
        return $producto->readAll(); // Retornamos todos los productos utilizando el método readAll del modelo producto.
    }

    // Método para leer un producto específico por su ID.
    public function readOne($sku) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo producto.
        $producto->setIdProd($sku); // Asignamos el ID del producto que queremos leer.
        return $producto->readOne(); // Retornamos los datos del producto con el ID especificado.
    }

    // Método para actualizar un producto existente.
    public function update($data1) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo producto.
        $producto->setIdProd($data1['idProd']); // Asignamos el ID del producto que se va a actualizar.
        $producto->setNom($data1['Nombre']); 
        $producto->setDesc($data1['Descripcion']);
        $producto->setOferta($data1['Oferta']);
        $producto->setFecof($data1['Fecof']);
        $producto->setEstado($data1['Estado']);
        $producto->setOrigen($data1['Origen']);
        $producto->setPrecio($data1['Precio']); 
        $producto->setCantidad($data1['Cantidad']); 
        if ($producto->update()) { // Intentamos actualizar el producto en la base de datos.
            return "Producto actualizado exitosamente."; // Si la actualización fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al actualizar Producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }

    // Método para eliminar un producto por su ID.
    public function delete($sku) {
        $producto = new Productos(); // Creamos una nueva instancia del modelo producto.
        $producto->setIdProd($sku); // Asignamos el ID del producto que se va a eliminar.
        if ($producto->delete()) { // Intentamos eliminar el producto de la base de datos.
            return "Producto eliminado exitosamente."; // Si la eliminación fue exitosa, devolvemos un mensaje de éxito.
        } else {
            return "Error al eliminar Producto."; // Si hubo un error, devolvemos un mensaje de error.
        }
    }
}
?>
