<?php
session_start();

// Definir las funciones
function agregarUsuario($usuarios, $nombre, $edad, $email) {
    $usuarios[] = [
        'nombre' => $nombre,
        'edad' => $edad,
        'email' => $email
    ];
    return $usuarios;
}

function buscarUsuarioPorEmail($usuarios, $email) {
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] == $email) {
            return "Nombre: " . $usuario['nombre'] . "<br>";
        }
    }
    return "Email no encontrado.<br>";
}

function mostrarUsuarios($usuarios) {
    $result = '';
    foreach ($usuarios as $usuario) {
        $result .= "Nombre: " . $usuario['nombre'] . ", Edad: " . $usuario['edad'] . "<br>";
        
   
    }
    return $result;
}

function actualizarUsuario($usuarios, $email, $nombre, $edad) {
    foreach ($usuarios as &$usuario) {
        if ($usuario['email'] == $email) {
            $usuario['nombre'] = $nombre;
            $usuario['edad'] = $edad;
            break;
        }
    }
    return $usuarios;
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
    $edad = $_POST['edad'] ?? '';
    $email = $_POST['email'] ?? '';

    switch ($accion) {
        case 'agregar':
            $usuarios = agregarUsuario($usuarios, $nombre, $edad, $email);
            $resultado = "Usuario agregado correctamente.<br>";
            break;
        
        case 'buscar':
            $resultado = buscarUsuarioPorEmail($usuarios, $email);
            break;
        
        case 'mostrar':
            $resultado = mostrarUsuarios($usuarios);
            break;
        
        case 'actualizar':
            $usuarios = actualizarUsuario($usuarios, $email, $nombre, $edad);
            $resultado = "Usuario actualizado correctamente.<br>";
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
