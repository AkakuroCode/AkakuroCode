<?php
// Inicia una sesión o reanuda la sesión existente
session_start();

// Incluye el archivo del controlador 'UsuarioController.php'
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/EmpresaController.php';
require_once __DIR__ . '/controllers/AdminController.php';

// Crea una instancia del controlador de usuario
$controller = new UsuarioController();
$controller2 = new EmpresaController();
$controller3 = new AdminController();

// Obtiene la acción solicitada desde la URL, o establece 'login' como acción predeterminada
$action = isset($_GET['action']) ? $_GET['action'] : 'default';

// Obtiene el ID del usuario desde la URL, si existe
$idus = isset($_GET['idus']) ? $_GET['idus'] : null;
$idemp = isset($_GET['idemp']) ? $_GET['idemp'] : null;
$idad = isset($_GET['idad']) ? $_GET['idad'] : null;

// Si no hay un usuario en sesión y la acción no es 'login' ni 'create', redirige al formulario de login
if (!isset($_SESSION['usuario']) && $action !== 'login' && $action !== 'create' && $action !== 'edit' && $action !== 'delete' && $action !== 'default') {
    header('Location: ?action=login');
    exit; // Termina el script después de redirigir
}
if (!isset($_SESSION['empresa']) && $action !== 'login' && $action !== 'create2' && $action !== 'edit2' && $action !== 'delete2' && $action !== 'default') {
    header('Location: ?action=login');
    exit; // Termina el script después de redirigir
}
if (!isset($_SESSION['admin']) && $action !== 'login' && $action !== 'create2' && $action !== 'edit2' && $action !== 'delete2' && $action !== 'default') {
    header('Location: ?action=login');
    exit; // Termina el script después de redirigir
}

// Controla las diferentes acciones posibles utilizando una estructura switch
switch ($action) {
    case 'create': // Crear un nuevo usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se envía el formulario de creación (método POST), llama al método 'create' del controlador
            echo $controller->create($_POST);
            header('Location: /sigto/index.php?action=login');
            exit;
        } else {
            // Si no, muestra el formulario de creación de usuario
            include __DIR__ . '/views/crearUsuario.php';
        }
        break;

    case 'create2': // Crear un nuevo usuario
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Si se envía el formulario de creación (método POST), llama al método 'create' del controlador
                echo $controller2->create2($_POST);
                header('Location: /sigto/index.php?action=login');
                exit;
            } else {
                // Si no, muestra el formulario de creación de usuario
                include __DIR__ . '/views/crearEmpresa.php';
            }
        break;    
    
    case 'list': // Listar todos los usuarios
        // Obtiene la lista de usuarios llamando al método readAll() del controlador
        $usuario = $controller->readAll();
        $empresa = $controller2->readAll();
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

    case 'edit2': // Editar un usuario existente
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Si se envía el formulario de edición (método POST), llama al método 'update' del controlador
                echo $controller2->update($_POST);
                header('Location: ?action=list');
                exit;
            } else {
                // Si no, obtiene los datos del usuario y muestra el formulario de edición
                $empresa = $controller2->readOne($idemp);
                include __DIR__ . '/views/editarEmpresa.php';
            }
        break;

    case 'delete': // Eliminar un usuario
        // Llama al método 'delete' del controlador y muestra el resultado
        echo $controller->delete($idus);
        header('Location: ?action=list');
        exit;

    case 'delete2': // Eliminar una empresa
            // Llama al método 'delete' del controlador y muestra el resultado
            echo $controller2->delete($idemp);
            header('Location: ?action=list');
        exit;    
    
        case 'login': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $passw = $_POST['passw'];
        
                // Primero intentamos iniciar sesión como usuario
                $loginUsuario = $controller->login(['email' => $email, 'passw' => $passw]);
                
                if ($loginUsuario) {
                    // Si el login es exitoso para un usuario, redirigir a la vista de cliente
                    header('Location: /sigto/views/maincliente.php');
                    exit;
                } else {
                    // Si no es usuario, intentamos iniciar sesión como empresa
                    $loginEmpresa = $controller2->login(['email' => $email, 'passw' => $passw]);
                    
                    if ($loginEmpresa) {
                        // Si el login es exitoso para una empresa, redirigir a la vista de empresa
                        header('Location: /sigto/views/mainempresa.php');
                        exit;
                    } else {
                        // Si no es usuario ni empresa, intentamos iniciar sesión como admin
                        $loginAdmin = $controller3->login(['email' => $email, 'passw' => $passw]);
        
                        if ($loginAdmin) {
                            // Si el login es exitoso para un admin, redirigir a la vista de admin
                            header('Location: /sigto/views/listarUsuarios.php');
                            exit;
                        } else {
                            // Si falla tanto para usuario, empresa como para admin, mostrar un mensaje de error
                            $error = "Email o contraseña incorrectos.";
                        }
                    }
                }
            }
            // Incluir la vista de login con el posible mensaje de error
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
        include __DIR__ . '/views/mainvisitante.php';
    break;
}
?>