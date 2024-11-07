<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/CarritoController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$carritoController = new CarritoController();
$productoController = new ProductoController();

$idus = $_SESSION['idus'];
$carritoItems = $carritoController->getItemsByUser($idus); // Asegúrate de que esta función ahora también obtenga los datos de `detalle_carrito`.

$totalCarrito = 0;
if ($carritoItems && !empty($carritoItems)) {
    foreach ($carritoItems as $item) {
        $totalCarrito += $item['subtotal']; // Sumar el subtotal de cada producto al total del carrito
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Carrito de Compras</title>
</head>
<body>
<div class="contenedor">
    <header>
        <nav class="navbar navbar-expand-sm bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/sigto/views/maincliente.php"><img class="w-50" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item mx-3">
                            <a class="nav-link nav-icon" href="/sigto/views/maincliente.php"><i class="bi bi-house-door"></i> Inicio</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link nav-icon" href="/sigto/views/usuarioperfil.php"><i class="bi bi-person-circle"></i> Perfil</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link nav-icon" href="/sigto/index.php?action=view_cart"><i class="bi bi-cart"></i> Carrito</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link nav-icon" href="/sigto/index.php?action=logout"><i class="bi bi-door-closed"></i> Salir</a>
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
    
    <h2 class="text-center">Carrito de Compras</h2>
    
    <main class="container mt-5">
        <!-- Si no hay productos en el carrito -->
        <?php if (!$carritoItems || empty($carritoItems)): ?>
            <p class="text-center mt-4">No hay productos en el carrito.</p>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="list-group">
                        <?php foreach ($carritoItems as $item): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="/sigto/assets/images/<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" style="width: 80px; height: auto; margin-right: 15px;">
                                        <div>
                                            <h5><?php echo htmlspecialchars($item['nombre']); ?></h5>
                                            <p id="cantidad-<?php echo $item['sku']; ?>">Cantidad: <?php echo $item['cantidad']; ?></p>
                                            <p>Precio unitario: US$<?php echo number_format($item['precio_actual'], 2); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p>Total: US$<span class="item-total" id="item-total-<?php echo $item['sku']; ?>"><?php echo number_format($item['subtotal'], 2); ?></span></p>
                                        <!-- Agrega este input oculto después de calcular $totalCarrito en PHP -->
                                        <input type="hidden" id="total-carrito" value="<?php echo number_format($totalCarrito, 2); ?>">

                                        <div class="botones-container">
                                            <form class="update-form" data-sku="<?php echo $item['sku']; ?>" data-idus="<?php echo $idus; ?>">
                                                <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control mb-2 cantidad-input" style="width: 80px;">
                                                <button type="button" class="btn btn-secondary btn-actualizar" onclick="updateQuantity(this)">Actualizar</button>
                                            </form>
                                            <form class="delete-form" data-sku="<?php echo $item['sku']; ?>" data-idus="<?php echo $idus; ?>">
                                                <button type="button" class="btn btn-danger btn-eliminar" onclick="deleteItem(this)">Eliminar</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Mostrar Resumen de compra solo si hay productos -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Resumen de Compra</h4>
                            <p class="card-text">Total: <strong>US$<span id="total"><?php echo number_format($totalCarrito, 2); ?></span></strong></p>
                            <a href="/sigto/views/metodoEntrega.php" class="btn btn-primary btn-block">Continuar compra</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
                <a href="\sigto\views\reclamoscliente.php">Reclamos</a>
            </div>
            <div class="footer-item">
                <p>Horario de Atención <br><br>Lunes a Viernes de 10hs a 18hs</p>
            </div>
            
            <div class="footer-redes">
                <a href="https://www.facebook.com/AkakuroCode/"><img class="redes" src="/sigto/assets/images/facebook logo.png" alt="Facebook"></a>
                <a href="https://x.com/AkakuroCode"><img class="redes" src="/sigto/assets/images/x.png" alt="Twitter"></a>
                <a href="https://www.instagram.com/akakurocode/"><img class="redes" src="/sigto/assets/images/ig logo.png" alt="Instagram"></a>
            </div>
        </div>
    </footer>

    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Tu script personalizado -->
    <script src="/sigto/assets/js/update.js"></script>
    <script src="/sigto/assets/js/searchbar.js"></script>
</div>   
</body>
</html>
