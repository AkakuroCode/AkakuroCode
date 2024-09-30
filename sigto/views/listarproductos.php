<?php
session_start();
require_once __DIR__ . '/../controllers/ProductoController.php';

$productoController = new ProductoController();

// Verificar si el usuario es una empresa
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'empresa') {
    echo "Acceso denegado. Solo las empresas pueden ver los productos.";
    exit;
}

// Obtener todos los productos de la empresa
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
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
                <th>Precio</th>
                <th>Stock</th>
                <th>imagen</th>
                <th>Acciones</th> <!-- Nueva columna para acciones -->
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
                    <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><img src="../assets/images/<?= $producto['imagen'] ?>" width="50"></td>
                    <td>
                        <a href="editarProducto.php?sku=<?php echo $producto['sku']; ?>">Editar</a>
                        <a href="eliminarProducto.php?sku=<?php echo $producto['sku']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="agregarproducto.php">Agregar Producto</a>
    <a href="/sigto/views/mainempresa.php">Volver al Inicio</a>
</body>
</html>
