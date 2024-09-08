<?php
// Incluimos el controlador de Producto.
require_once 'controller/ProductoControllers.php';

// Creamos una instancia del controlador de Producto.
$controller = new ProductoController();
// Determinamos la acción a realizar (crear, listar, editar, eliminar).
$action = isset($_GET['action']) ? $_GET['action'] : 'list'; // Si se pasa un parámetro 'action', se asigna su valor; de lo contrario, se usa 'list' como predeterminado.
$sku = isset($_GET['idProd']) ? $_GET['idProd'] : null; // Si se pasa un parámetro 'id', se asigna su valor; de lo contrario, se asigna null.

// Manejo de las acciones dependiendo de la solicitud.
switch ($action) {
    case 'create': // Si la acción es 'create'.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la solicitud se realizó mediante POST.
            $response = $controller->create($_POST); // Se llama al método 'create' del controlador y se le pasan los datos enviados por POST.
            echo $response; // Se muestra la respuesta obtenida del controlador.
        } else {
            include 'views/CrearProducto.php'; // Si no es POST, se incluye la vista para crear un Producto.
        }
        break;
    case 'list': // Si la acción es 'list'.
        $productos = $controller->readAll(); // Se llama al método 'readAll' del controlador para obtener todos los Productos.
        include 'views/listarProductos.php'; // Se incluye la vista que lista todos los Productos.
        break;
    case 'edit': // Si la acción es 'edit'.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la solicitud se realizó mediante POST.
            $response = $controller->update($_POST); // Se llama al método 'update' del controlador con los datos enviados por POST.
            echo $response; // Se muestra la respuesta obtenida del controlador.
        } else {
            $producto = $controller->readOne($sku); // Se llama al método 'readOne' del controlador para obtener los datos del Producto con el id dado.
            include 'views/editarProducto.php'; // Se incluye la vista para editar un Producto.
        }
        break;
    case 'delete': // Si la acción es 'delete'.
        $response = $controller->delete($sku); // Se llama al método 'delete' del controlador con el id dado.
        echo $response; // Se muestra la respuesta obtenida del controlador.
        break;
    default: // Si no se especifica ninguna acción o si la acción no coincide con las anteriores.
        $productos = $controller->readAll(); // Se llama al método 'readAll' del controlador para obtener todos los Productos.
        include 'views/listarProducto.php'; // Se incluye la vista que lista todos los Productos.
        break;
}