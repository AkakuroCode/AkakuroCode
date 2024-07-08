<?php
session_start();

// Definir las funciones
function agregarUsuario($usuarios, $nombre, $edad, $email) {
    $usuarios[] = [
        'nombre' => $nombre,
        'contraseña' => $contraseña       
    ];
    return $usuarios;
}


function mostrarUsuarios($usuarios) {
    $result = '';
    foreach ($usuarios as $usuario) {
        $result .= "Nombre: " . $usuario['nombre'] . "<br>";
        
   
    }
    return $result;
}


// Inicializar el array de usuarios en la sesión
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$usuarios = $_SESSION['usuarios'];
$resultado = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $nombre = $_POST['nombre'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';
    

    switch ($accion) {
        case 'agregar':
            $usuarios = agregarUsuario($usuarios, $nombre, $edad, $email);
            $resultado = "Usuario agregado correctamente.<br>";
            break;
        
        
        case 'mostrar':
            $resultado = mostrarUsuarios($usuarios);
            break;
        

        case 'limpiar':
            $_SESSION['usuarios'] = [];
            $resultado = "Resultados limpiados correctamente.<br>";
            session_destroy();
            break;

        default:
            $resultado = "Acción no válida.";
    }

    $_SESSION['usuarios'] = $usuarios;
    $_SESSION['resultado'] = $resultado;
}

// Redirigir de vuelta a index.php
header("Location: formulario.php");
exit();
?>
