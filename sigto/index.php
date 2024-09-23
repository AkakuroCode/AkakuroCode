<?php
// Inicia una sesión o reanuda la sesión existente
session_start();

// Incluye el archivo del controlador 'UsuarioController.php'
require_once __DIR__ . '/controllers/UsuarioController.php';

// Crea una instancia del controlador de usuario
$controller = new UsuarioController();

// Obtiene la acción solicitada desde la URL, o establece 'login' como acción predeterminada
$action = isset($_GET['action']) ? $_GET['action'] : 'default';

// Obtiene el ID del usuario desde la URL, si existe
$idus = isset($_GET['idus']) ? $_GET['idus'] : null;

// Si no hay un usuario en sesión y la acción no es 'login' ni 'create', redirige al formulario de login
if (!isset($_SESSION['usuario']) && $action !== 'login' && $action !== 'create' && $action !== 'edit' && $action !== 'delete'&& $action !== 'default') {
    header('Location: ?action=login');
    exit; // Termina el script después de redirigir
}


// Controla las diferentes acciones posibles utilizando una estructura switch
switch ($action) {
    case 'create': // Crear un nuevo usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se envía el formulario de creación (método POST), llama al método 'create' del controlador
            echo $controller->create($_POST);
            header('Location: /sigto/index.php?action=list');
            exit;
        } else {
            // Si no, muestra el formulario de creación de usuario
            include __DIR__ . '/views/crearUsuario.php';
        }
        break;
    
    case 'list': // Listar todos los usuarios
        // Obtiene la lista de usuarios llamando al método readAll() del controlador
        $usuario = $controller->readAll();
        include __DIR__ . '/views/listarUsuarios.php';
        break;

    case 'edit': // Editar un usuario existente
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se envía el formulario de edición (método POST), llama al método 'update' del controlador
            echo $controller->update($_POST);
            header('Location: ?action=list');
            exit;
        } else {
            // Si no, obtiene los datos del usuario y muestra el formulario de edición
            $usuario = $controller->readOne($idus);
            include __DIR__ . '/views/editarUsuario.php';
        }
        break;

    case 'delete': // Eliminar un usuario
        // Llama al método 'delete' del controlador y muestra el resultado
        echo $controller->delete($idus);
        header('Location: ?action=list');
        exit;
    
    case 'login': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                var_dump($_POST);  // Para ver si se están recibiendo los datos del formulario
                $loginResult = $controller->login($_POST);
                if ($loginResult) {
                    header('Location: /sigto/index.php?action=list');
                    exit;
                } else {
                    $error = "Nombre de usuario o contraseña incorrectos.";
                }
            }
            include __DIR__ . '/views/loginUsuario.php';
            break;
        

    case 'logout': // Cerrar sesión
        // Destruye la sesión y redirige al formulario de login
        session_destroy();
        header('Location: ?action=login');
        exit;

    default: // Acción por defecto: listar usuarios
        // Si la acción no coincide con ninguno de los casos anteriores, muestra la lista de usuarios
        $usuario = $controller->readAll();
        include __DIR__ . '/index.html';
        break;
}
?>
