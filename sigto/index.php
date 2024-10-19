<?php
// Inicia una sesión o reanuda la sesión existente
date_default_timezone_set('America/Argentina/Buenos_Aires');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye los controladores necesarios
require_once __DIR__ . '/controllers/UsuarioController.php';
require_once __DIR__ . '/controllers/EmpresaController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/ProductoController.php';
require_once __DIR__ . '/controllers/CarritoController.php'; // Nuevo controlador para el carrito

// Crea una instancia de cada controlador
$controller = new UsuarioController();
$controller2 = new EmpresaController();
$controller3 = new AdminController();
$controller4 = new ProductoController();
$carritoController = new CarritoController(); // Controlador de carrito

$idus = isset($_GET['idus']) ? (int)$_GET['idus'] : (isset($_SESSION['idus']) ? $_SESSION['idus'] : null);
$idemp = isset($_GET['idemp']) ? (int)$_GET['idemp'] : (isset($_SESSION['idemp']) ? $_SESSION['idemp'] : null);
$idad = isset($_GET['idad']) ? (int)$_GET['idad'] : (isset($_SESSION['idad']) ? $_SESSION['idad'] : null);


// Obtiene la acción solicitada desde la URL, o establece 'login' como acción predeterminada
$action = isset($_GET['action']) ? $_GET['action'] : 'default';

// Validación de sesión y redirección en caso de roles incorrectos
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'usuario':
            if (!isset($_SESSION['idus']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
                header('Location: ?action=login');
                exit;
            }
            break;
        case 'empresa':
            if (!isset($_SESSION['idemp']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
                header('Location: ?action=login');
                exit;
            }
            break;
        case 'admin':
            if (!isset($_SESSION['idad']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
                header('Location: ?action=login');
                exit;
            }
            break;
    }
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
    
    case 'list2': // Redirigir a la lista de productos
            $empresa = $controller2->readAll();
            $producto = $controller4->readAll();
            include __DIR__ . '/views/listarproductos.php'; // Asegúrate de que esta vista exista
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
       // Depuración para verificar si la sesión de admin está activa
            if ($_SESSION['role'] !== 'admin' || !isset($_SESSION['idad'])) {
                echo "Error: No tienes permisos o la sesión de administrador no es válida.";
                exit;
            }
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

    case 'edit3': // Editar un producto existente
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo $controller4->update($_POST);
                header('Location: ?action=list2'); // Redirigir a la lista de productos
                exit;
            } else {
                // Si no, muestra el formulario de edición del producto
                $sku = $_GET['sku']; // Obtener el SKU del producto a editar
                $productoSeleccionado = $controller4->readOne($sku);
                include __DIR__ . '/views/editarProducto.php'; // Carga la vista para editar el producto
            }
        break;

    case 'edit_profile': // Editar información del usuario logueado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Si se envía el formulario de edición, llama al método 'update' del controlador
                echo $controller->update($_POST);
                // Redirigir al perfil del usuario
                header('Location: /sigto/views/usuarioperfil.php');
                exit;
            } else {
                // Obtener el ID del usuario logueado desde la sesión
                $idus = $_SESSION['idus'];
                // Obtener los datos del usuario logueado para mostrarlos en el formulario de edición
                $usuario = $controller->readOne($idus);
                include __DIR__ . '/views/mieditar.php'; // Cargar el formulario de edición de perfil
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
        
                // Intentar iniciar sesión como usuario
                $loginUsuario = $controller->login(['email' => $email, 'passw' => $passw]);
        
                if ($loginUsuario) {
                    // Redireccionar al maincliente si el login es exitoso
                    header('Location: /sigto/views/maincliente.php');
                    exit;
                } else {
                    // Intentar iniciar sesión como empresa
                    $loginEmpresa = $controller2->login(['email' => $email, 'passw' => $passw]);
        
                    if ($loginEmpresa) {
                        // Redireccionar al mainempresa si el login es exitoso
                        header('Location: /sigto/views/mainempresa.php');
                        exit;
                    } else {
                        // Intentar iniciar sesión como admin
                        $loginAdmin = $controller3->login(['email' => $email, 'passw' => $passw]);
        
                        if ($loginAdmin) {
                            // Redireccionar a la vista de admin
                            header('Location: /sigto/views/listarUsuarios.php');
                            exit;
                        } else {
                            // Mostrar mensaje de error si el login falla
                            $error = "Email o contraseña incorrectos.";
                        }
                    }
                }
            }
            include __DIR__ . '/views/loginUsuario.php';
            break;
        
        

    case 'activar':
            if (isset($_GET['sku'])) {
                    $controller4->restore($_GET['sku']); // Activa el producto
                }
                header('Location: ?action=list2');
            exit;
            
    case 'desactivar':
                if (isset($_GET['sku'])) {
                    $controller4->softDelete($_GET['sku']); // Desactiva el producto
                }
            
                header('Location: ?action=list2');
            exit;

     // Case para ver el carrito
     case 'view_cart':
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'usuario' && isset($_SESSION['idus'])) {
            $idus = $_SESSION['idus'];
            $carritoItems = $carritoController->getItemsByUser($idus);
            include __DIR__ . '/views/verCarrito.php';
        } else {
            header('Location: ?action=login');
        }
        break;

    // Case para agregar un producto al carrito
    case 'add_to_cart':
        // Verificar si el usuario es un cliente
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'usuario' && isset($_SESSION['idus'])) {
            $idus = $_SESSION['idus'];
    
            // Obtener los datos enviados por el formulario
            $sku = isset($_POST['sku']) ? (int)$_POST['sku'] : null;
            $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
    
            // Validar que SKU y cantidad sean válidos
            if ($sku && $cantidad > 0) {
                $result = $carritoController->addItem($idus, $sku, $cantidad);
                if ($result) {
                    // Redirigir al carrito después de agregar el producto
                    header('Location: ?action=view_cart');
                } else {
                    echo "Error al agregar el producto al carrito.";
                }
            } else {
                echo "Datos inválidos para agregar al carrito.";
            }
        } else {
            // Si no está autenticado, redirigir al login
            header('Location: ?action=login');
        }
        break;
    // Case para actualizar la cantidad de un producto en el carrito
    case 'update_quantity':
        header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idus'], $_POST['sku'], $_POST['cantidad'])) {
            $idus = (int)$_POST['idus'];
            $sku = (int)$_POST['sku'];
            $cantidad = (int)$_POST['cantidad'];
    
            if ($cantidad > 0) {
                $result = $carritoController->updateQuantity($idus, $sku, $cantidad);
                if ($result) {
                    // Calcula el nuevo subtotal y total del carrito después de actualizar
                    $items = $carritoController->getItemsByUser($idus);
                    $subtotal = 0;
                    $totalCarrito = 0;
                    foreach ($items as $item) {
                        if ($item['sku'] == $sku) {
                            $subtotal = $item['precio_actual'] * $cantidad;
                        }
                        $totalCarrito += $item['subtotal'];
                    }
    
                    echo json_encode([
                        'status' => 'success',
                        'subtotal' => number_format($subtotal, 2),
                        'totalCarrito' => number_format($totalCarrito, 2)
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la cantidad.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'La cantidad debe ser mayor a cero.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        }
        exit;
    
    // Case para eliminar un producto del carrito
    case 'delete_from_cart':
        if (isset($_POST['sku']) && isset($_SESSION['idus'])) {
            $sku = (int)$_POST['sku'];
            $idus = (int)$_SESSION['idus'];
            $resultado = $carritoController->removeItem($idus, $sku);
    
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos faltantes para eliminar el producto.']);
        }
        exit;
            


    case 'logout': // Cerrar sesión
        // Destruye la sesión y redirige al formulario de login
        session_destroy();
        header('Location: ?action=login');
        exit;

    default:
        include __DIR__ . '/views/mainvisitante.php';
    break;
}
?>