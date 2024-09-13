<?php
session_start();

if (!isset($_SESSION['producto'])) {
    $_SESSION['producto'] = [];
}

// Funciones
function agregarProducto($nombre, $cantidad, $valor, $modelo,$estado) {
    $producto = [
        'nombre' => $nombre,
        'cantidad' => $cantidad,
        'valor' => $valor,
        'modelo' => $modelo,
        'estado' => $estado
    ];
    $_SESSION['producto'][] = $producto;
    return "Producto agregado exitosamente.";
}

function mostrarProductos() {
    return $_SESSION['producto'];
}

function actualizarProducto($modelo, $nombre, $cantidad, $valor,$estado) {
    foreach ($_SESSION['producto'] as &$producto) {
        if ($producto['modelo'] === $modelo) {
            $producto['nombre'] = $nombre;
            $producto['cantidad'] = $cantidad;
            $producto['valor'] = $valor;
            $producto['estado'] = $estado;
            return "Producto actualizado exitosamente.";
        }
    }
    return "Producto no encontrado.";
}




function listarModelosDisponibles() {
    $modelos = [];
    foreach ($_SESSION['productos'] as $producto) {
        $modelos[] = $producto['modelo'];
    }
    return $modelos;
}


function limpiarResultados() {
    $_SESSION['productos'] = [];
    return "productos limpiados exitosamente.";
}

// Manejo de formularios
$resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    switch ($accion) {
        case 'agregar':
            $resultado = agregarProducto($_POST['nombre'], $_POST['cantidad'], $_POST['valor'], $_POST['modelo'], $_POST['estado']);
            break;
        case 'mostrar':
            $resultado = mostrarProductos();
            break;
        case 'actualizar':
            $resultado = actualizarProducto($_POST['modelo'], $_POST['nombre'], $_POST['cantidad'], $_POST['valor'], $_POST['estadoN']);
            break;
        case 'limpiar':
            $resultado = limpiarResultados();
            break;
    }
    echo json_encode($resultado);
}
?>