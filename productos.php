<?php
session_start();

if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

// Funciones
function agregarProducto($nombre, $cantidad, $valor, $modelo) {
    $producto = [
        'nombre' => $nombre,
        'cantidad' => $cantidad,
        'valor' => $valor,
        'modelo' => $modelo
    ];
    $_SESSION['productos'][] = $producto;
    return "Producto agregado exitosamente.";
}

function buscarProductoPorModelo($modelo) {
    foreach ($_SESSION['productos'] as $producto) {
        if ($producto['modelo'] === $modelo) {
            return $producto;
        }
    }
    return "Producto no encontrado.";
}

function mostrarProductos() {
    return $_SESSION['productos'];
}

function actualizarProducto($modelo, $nombre, $cantidad, $valor) {
    foreach ($_SESSION['productos'] as &$producto) {
        if ($producto['modelo'] === $modelo) {
            $producto['nombre'] = $nombre;
            $producto['cantidad'] = $cantidad;
            $producto['valor'] = $valor;
            return "Producto actualizado exitosamente.";
        }
    }
    return "Producto no encontrado.";
}

function calcularValorTotal() {
    $total = 0;
    foreach ($_SESSION['productos'] as $producto) {
        $total += $producto['valor'] * $producto['cantidad'];
    }
    return $total;
}

function filtrarProductosPorValor($valorEspecifico) {
    $productosFiltrados = [];
    foreach ($_SESSION['productos'] as $producto) {
        if ($producto['valor'] > $valorEspecifico) {
            $productosFiltrados[] = $producto;
        }
    }
    return $productosFiltrados;
}

function listarModelosDisponibles() {
    $modelos = [];
    foreach ($_SESSION['productos'] as $producto) {
        $modelos[] = $producto['modelo'];
    }
    return $modelos;
}

function calcularValorPromedio() {
    $totalValor = 0;
    $totalCantidad = 0;
    foreach ($_SESSION['productos'] as $producto) {
        $totalValor += $producto['valor'] * $producto['cantidad'];
        $totalCantidad += $producto['cantidad'];
    }
    return $totalCantidad ? $totalValor / $totalCantidad : 0;
}

function limpiarResultados() {
    $_SESSION['productos'] = [];
    return "Datos de productos limpiados exitosamente.";
}

// Manejo de formularios
$resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    switch ($accion) {
        case 'agregar':
            $resultado = agregarProducto($_POST['nombre'], $_POST['cantidad'], $_POST['valor'], $_POST['modelo']);
            break;
        case 'buscar':
            $resultado = buscarProductoPorModelo($_POST['modelo']);
            break;
        case 'mostrar':
            $resultado = mostrarProductos();
            break;
        case 'actualizar':
            $resultado = actualizarProducto($_POST['modelo'], $_POST['nombre'], $_POST['cantidad'], $_POST['valor']);
            break;
        case 'valorTotal':
            $resultado = calcularValorTotal();
            break;
        case 'filtrar':
            $resultado = filtrarProductosPorValor($_POST['valorEspecifico']);
            break;
        case 'listarModelos':
            $resultado = listarModelosDisponibles();
            break;
        case 'valorPromedio':
            $resultado = calcularValorPromedio();
            break;
        case 'limpiar':
            $resultado = limpiarResultados();
            break;
    }
    echo json_encode($resultado);
}
?>