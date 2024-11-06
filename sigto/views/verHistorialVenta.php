<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Venta.php';

// Asegúrate de que la empresa esté logueada y tenga su ID en la sesión
$idemp = $_SESSION['idemp'] ?? null;
if (!$idemp) {
    echo "<p>Error: No se ha identificado la empresa. Por favor, inicie sesión.</p>";
    exit;
}

// Crear instancia del modelo Venta y obtener el historial de ventas
$ventaModel = new Venta();
$ventas = $ventaModel->obtenerHistorialVentas($idemp);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/historialventa.css">
    <title>Historial de Ventas</title>
</head>
<body>
<div class="contenedor">
    <header>
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
                <div class="container-fluid">
                  <a class="navbar-brand" href="/sigto/views/mainempresa.php"><img class="w-50" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                      <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/mainempresa.php"><i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/agregarproducto.php"><i class="bi bi-plus-circle"></i> Agregar</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/listarproductos.php"><i class="bi bi-view-list"></i> Mis productos</a>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/verHistorialVenta.php"><i class="bi bi-cash-coin"></i> Ventas</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index.php?action=logout"><i class="bi bi-door-closed"></i> Salir</a>
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
<main>
<br>
<div class="ventas-container">
<h2>Historial de Ventas</h2>


<?php if (!empty($ventas)): ?>
    <?php foreach ($ventas as $venta): ?>
        <div class="venta">
            <h3>Venta ID: <?= $venta['idventa'] ?></h3>
            <p>Fecha: <?= $venta['fecha'] ?></p>
            
            <!-- Inicializa el total de la venta -->
            <?php $totalVenta = 0; ?>

            <!-- Detalles de la venta -->
            <div class="detalle-venta">
                <h4>Detalles de Productos Vendidos:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($venta['detalles'] as $detalle): ?>
                            <tr>
                                <td><?= $detalle['sku'] ?></td>
                                <td><?= $detalle['nombre_producto'] ?></td>
                                <td><?= $detalle['cantidad'] ?></td>
                                <td>$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
                                <td>
                                <a href="/sigto/views/listarproductos.php" class="btn btn-primary">Ver en lista</a>
                                </td>
                            </tr>
                            <?php 
                            // Sumar el subtotal de cada producto al total de la venta
                            $totalVenta += $detalle['subtotal']; 
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mostrar el total de la venta -->
            <p>Total vendido: $<?= number_format($totalVenta, 2) ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No se han registrado ventas hasta ahora.</p>
<?php endif; ?>

</div>
</main>
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
            <a href="reclamoscliente.php">Reclamos</a>
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

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/sigto/assets/js/searchbar.js"></script>
<script src="/sigto/assets/js/favorito.js"></script>


</body>
</html>