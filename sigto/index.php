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

// Verificación de roles
// Verificación para usuarios, empresas y admins
if (isset($_SESSION['role']) && $_SESSION['role'] === 'usuario' && !isset($_SESSION['idus']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
    header('Location: ?action=login');
    exit;
}
if (isset($_SESSION['role']) && $_SESSION['role'] === 'empresa' && !isset($_SESSION['idemp']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
    header('Location: ?action=login');
    exit;
}
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && !isset($_SESSION['idad']) && $action !== 'login' && $action !== 'create' && $action !== 'create2' && $action !== 'default') {
    header('Location: ?action=login');
    exit;
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
            if ($_SESSION['role'] !== 'empresa') {
                header('Location: ?action=login');
                exit;
            }
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
                // Si se envía el formulario de edición (método POST), llama al método 'update' del controlador
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
    
    case 'delete3': // Eliminar un producto
            $sku = $_GET['sku']; // Obtener el SKU del producto a eliminar
            echo $controller4->delete($sku);
            header('Location: ?action=list2'); // Redirigir a la lista de productos
        exit;
    
    case 'login': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_POST['email'];
                $passw = $_POST['passw'];
                
                // Primero intentamos iniciar sesión como usuario
                $loginUsuario = $controller->login(['email' => $email, 'passw' => $passw]);
    
                if ($loginUsuario) {
                    header('Location: /sigto/views/maincliente.php');
                    exit;
                } else {
                    // Si no es usuario, intentamos iniciar sesión como empresa
                    $loginEmpresa = $controller2->login(['email' => $email, 'passw' => $passw]);
    
                    if ($loginEmpresa) {
                        header('Location: /sigto/views/mainempresa.php');
                        exit;
                    } else {
                        // Si no es usuario ni empresa, intentamos iniciar sesión como admin
                        $loginAdmin = $controller3->login(['email' => $email, 'passw' => $passw]);
    
                        if ($loginAdmin) {
                            header('Location: /sigto/views/listarUsuarios.php');
                            exit;
                        } else {
                            // Si falla tanto para usuario, empresa como para admin, mostrar un mensaje de error
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
        if (isset($_POST['sku'], $_POST['cantidad']) && isset($_SESSION['idus'])) {
            $sku = (int)$_POST['sku'];
            $cantidad = (int)$_POST['cantidad'];
            $idus = (int)$_SESSION['idus'];
            
            // Actualizar la cantidad en el carrito
            $resultado = $carritoController->updateQuantity($idus, $sku, $cantidad);
    
            if ($resultado) {
                // Calcular el nuevo subtotal para el producto actualizado
                $producto = $productoController->readOne($sku);
                $precioActual = $producto['precio_actual']; // Asegúrate de obtener el precio correcto, ya sea oferta o normal
                $newSubtotal = $precioActual * $cantidad;
    
                echo json_encode(['success' => true, 'newSubtotal' => $newSubtotal]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la cantidad.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos faltantes para actualizar la cantidad.']);
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