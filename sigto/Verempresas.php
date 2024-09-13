<?php
// Incluimos el controlador de Producto.
require_once '.\controller\EmpresaController.php';

// Creamos una instancia del controlador de Producto.
$controller = new EmpresaController();
// Determinamos la acción a realizar (crear, listar, editar, eliminar).
$action = isset($_GET['action']) ? $_GET['action'] : 'list'; // Si se pasa un parámetro 'action', se asigna su valor; de lo contrario, se usa 'list' como predeterminado.
$idemp = isset($_GET['idemp']) ? $_GET['idemp'] : null; // Si se pasa un parámetro 'id', se asigna su valor; de lo contrario, se asigna null.

// Manejo de las acciones dependiendo de la solicitud.
switch ($action) {
    case 'create': // Si la acción es 'create'.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la solicitud se realizó mediante POST.
            $response = $controller->create($_POST); // Se llama al método 'create' del controlador y se le pasan los datos enviados por POST.
            echo $response; // Se muestra la respuesta obtenida del controlador.
        } else {
            include 'views/crearEmpresa.php'; // Si no es POST, se incluye la vista para crear un Producto.
        }
        break;
    case 'list': // Si la acción es 'list'.
        $empresa = $controller->readAll(); // Se llama al método 'readAll' del controlador para obtener todos los Productos.
        include 'views/listarEmpresas.php'; // Se incluye la vista que lista todos los Productos.
        break;
    case 'edit': // Si la acción es 'edit'.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la solicitud se realizó mediante POST.
            $response = $controller->update($_POST); // Se llama al método 'update' del controlador con los datos enviados por POST.
            echo $response; // Se muestra la respuesta obtenida del controlador.
        } else {
            $empresa = $controller->readOne($idemp); // Se llama al método 'readOne' del controlador para obtener los datos del Producto con el id dado.
            include 'views/editarEmpresa.php'; // Se incluye la vista para editar un Producto.
        }
        break;
    case 'delete': // Si la acción es 'delete'.
        $response = $controller->delete($idemp); // Se llama al método 'delete' del controlador con el id dado.
        echo $response; // Se muestra la respuesta obtenida del controlador.
        break;
    default: // Si no se especifica ninguna acción o si la acción no coincide con las anteriores.
        $empresa = $controller->readAll(); // Se llama al método 'readAll' del controlador para obtener todos los Productos.
        include 'views/listarEmpresas.php'; // Se incluye la vista que lista todos los Productos.
        break;
}