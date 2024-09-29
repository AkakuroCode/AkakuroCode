<?php
session_start();
require_once __DIR__ . '/../controllers/ProductoController.php';

$productoController = new ProductoController();

// Verificar si el usuario es una empresa
if (!isset($_SESSION['empresa'])) {
    echo "Acceso denegado. Solo las empresas pueden ver los productos.";
    exit;
}

// Obtener todos los productos
$productos = $productoController->readAll();

if (!$productos) {
    echo "No se encontraron productos.";
    exit;
}

// Mostrar productos en una tabla
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Asegúrate de incluir tu CSS -->
</head>
<body>
    <h1>Lista de Productos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Oferta</th>
                <th>Fecha de Oferta</th>
                <th>Estado</th>
                <th>Origen</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($producto = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['sku']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($producto['oferta']); ?></td>
                    <td><?php echo htmlspecialchars($producto['fecof']); ?></td>
                    <td><?php echo htmlspecialchars($producto['estado']); ?></td>
                    <td><?php echo htmlspecialchars($producto['origen']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
