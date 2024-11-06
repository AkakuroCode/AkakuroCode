<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/HistorialCompraController.php';


// Incluir el controlador de usuario o la lógica para obtener el usuario logueado
require_once __DIR__ . '/../controllers/UsuarioController.php';

$usuarioController = new UsuarioController();
$usuario = $usuarioController->getUserById($_SESSION['idus']);

// Verificar que se encontró el usuario
if (!$usuario) {
    echo "Error: no se encontró el usuario.";
    exit;
}

$controller = new HistorialCompraController();
$registros = $controller->obtenerHistorialUsuario();

$productoController = new ProductoController();
$productos = $productoController->readVisible(); // Solo productos visibles

if (!$productos) {
    echo "No se encontraron productos.";
}

$fechaActual = date('Y-m-d'); // Obtener la fecha actual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/historialcompra.css">
    <title>Historial de Compras</title>
</head>
<body>
<div class="contenedor"> 
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
                        <a class="nav-link nav-icon" href="/sigto/views/maincliente.php">
                        <i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/views/usuarioperfil.php">
                        <i class="bi bi-person-circle"></i> Perfil</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/index.php?action=view_cart">
                        <i class="bi bi-cart"></i> Carrito</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/index.php?action=logout">
                        <i class="bi bi-door-open"></i>Salir</a>
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
<div class="historial-container">
    <h2>Historial de Compras</h2>
    <table>
        <thead>
            <tr>
                <th>ID Registro</th>
                <th>SKU</th>
                <th>Estado</th>
                <th>Código de Unidad</th>
                <th>Precio Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($registros)): ?>
                <?php foreach ($registros as $registro): ?>
                    <tr>
                        <td><?php echo $registro['idregistrocompra']; ?></td>
                        <td><?php echo $registro['sku']; ?></td>
                        <td><?php echo $registro['estado']; ?></td>
                        <td><?php echo $registro['codigo_unidad']; ?></td>
                        <td><?php echo "$" . number_format($registro['precio_actual'], 2); ?></td>
                        <td><a href="/sigto/views/detallesproducto.php?id=<?php echo $registro['sku']; ?>" class="btn btn-info mb-2">Ver detalles</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay registros en el historial.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</main>

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