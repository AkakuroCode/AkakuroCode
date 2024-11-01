<?php
require_once __DIR__ . '/../controllers/ProductoController.php';

$productoController = new ProductoController();

// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si la sesión de empresa está activa
if (!isset($_SESSION['idemp'])) {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}

// Obtener productos solo de la empresa logueada
$productoController->handleRequest();
$productos = $productoController->readAllByEmpresa($_SESSION['idemp']);

if (!$productos) {
    echo "No se encontraron productos.";
}

// Mostrar productos en una tabla
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/admin.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img class="w-50" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/mainempresa.php">Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/agregarproducto.php">Agregar Producto</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/listarproductos.php">Ver Productos</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index.php?action=logout">Salir</a>
                    </li>
                </ul>
                <form id="search-form" action="/sigto/views/catalogo.php" method="GET" autocomplete="off">
                    <input type="text" id="search-words" name="query" placeholder="Buscar productos..." onkeyup="showSuggestions(this.value)">
                    <div id="suggestions"></div> <!-- Div para mostrar las sugerencias -->
                    </form>
            </div>
        </div>
    </nav>
</header>
<div class="panel-gestion">
    <h1>Lista de Productos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Oferta</th>
                <th>Precio con Oferta</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Origen</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($producto = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['sku']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>

                    <!-- Mostrar oferta solo si existe -->
                    <td>
                        <?php 
                        echo isset($producto['porcentaje_oferta']) ? htmlspecialchars($producto['porcentaje_oferta']) . "%" : "Sin oferta"; 
                        ?>
                    </td>

                    <!-- Precio con oferta o precio normal -->
                    <td>
                        <?php 
                        echo isset($producto['preciooferta']) ? htmlspecialchars($producto['preciooferta']) : htmlspecialchars($producto['precio']);
                        ?>
                    </td>

                    <!-- Fechas de la oferta -->
                    <td><?php echo isset($producto['fecha_inicio']) ? htmlspecialchars($producto['fecha_inicio']) : "N/A"; ?></td>
                    <td><?php echo isset($producto['fecha_fin']) ? htmlspecialchars($producto['fecha_fin']) : "N/A"; ?></td>

                    <td><?php echo htmlspecialchars($producto['estado']); ?></td>
                    <td><?php echo htmlspecialchars($producto['origen']); ?></td>
                    <td><?php echo htmlspecialchars($producto['precio']); ?></td>

                    <!-- Mostrar stock -->
                    <td>
                        <?php 
                        if ($producto['tipo_stock'] === 'unidad') {
                            // Obtener la cantidad disponible de productos por unidad
                            $cantidadDisponible = $productoController->getCantidadDisponiblePorSku($producto['sku']);
                            echo htmlspecialchars($cantidadDisponible);
                        } else {
                            // Mostrar el stock normal para tipo "cantidad"
                            echo htmlspecialchars($producto['stock']);
                        }
                        ?>
                    </td>

                    <td><img src="/sigto/assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 100px; height: auto;"></td>

                    <td>
                        <!-- Botón Editar -->
                        <a href="../sigto/index?action=edit3&sku=<?php echo htmlspecialchars($producto['sku']); ?>" class="btn btn-primary">Editar</a>
                        <br>

                        <!-- Mostrar el botón de desactivar si el producto está visible -->
                        <?php if ($producto['visible'] == 1): ?>
                        <button class="btn btn-danger" onclick="window.location.href='?action=desactivar&sku=<?php echo $producto['sku']; ?>'">Desactivar</button>
                        <?php else: ?>
                        <!-- Mostrar el botón de activar si el producto está oculto -->
                        <button class="btn btn-success" onclick="window.location.href='?action=activar&sku=<?php echo $producto['sku']; ?>'">Activar</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-item">
            <p>Contacto</p>
            <a href="/sigto/views/nosotroscliente.php">Nosotros</a>
            <br>
            <a href="tel:+598 92345888">092345888</a>
            <br>
            <a href="mailto: oceantrade@gmail.com">oceantrade@gmail.com</a>
            <br>
            <a href="reclamosempresa.php">Reclamos</a>
        </div>
        <div class="footer-item">
            <p>Horario de Atención <br><br>Lunes a Viernes de 10hs a 18hs</p>
        </div>

        <div class="footer-redes">
            <a href="https://www.facebook.com/"><img class="redes" src="/sigto/assets/images/facebook logo.png" alt="Facebook"></a>
            <a href="https://twitter.com/home"><img class="redes" src="/sigto/assets/images/x.png" alt="Twitter"></a>
            <a href="https://www.instagram.com/"><img class="redes" src="/sigto/assets/images/ig logo.png" alt="Instagram"></a>
        </div>
    </div>
</footer>
<script src="/sigto/assets/js/searchbar.js"></script>

</body>
</html>
