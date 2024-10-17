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
$carritoItems = $carritoController->getItemsByUser($idus);

if (!$carritoItems || empty($carritoItems)) {
    echo "No hay productos en el carrito.";
    exit;
}

// Inicializar la variable $totalCarrito
$totalCarrito = 0;
foreach ($carritoItems as $item) {
    $totalCarrito += $item['subtotal'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/reclamos.css">
    <title>Carrito de Compras</title>
</head>
<body>
    <header>
        <nav class="mi-navbar">
            <div class="mi-navbar-container">
                <h1>
                    <img class="mi-navbar-logo" src="/sigto/assets/images/navbar logo.png" alt="OceanTrade">
                </h1>
                <div class="mi-navbar-items">
                    <form action="ruta/destino" method="GET" class="search-form">
                        <input class="searchbar" type="text" placeholder="Buscar..." autocomplete="off" maxlength="50" id="search-words" name="query">
                    </form>
                    <a href="/sigto/views/maincliente.php">Inicio</a>
                    <a href="/sigto/views/usuarioperfil.php">Perfil</a> 
                    <a href="/sigto/index?action=view_cart">Carrito</a>
                    <a href="nosotroscliente.php">Nosotros</a>
                    <a href="/sigto/index.php?action=logout">Salir</a>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="container mt-5">
        <h2>Carrito de Compras</h2>
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
                                    <form class="update-form" data-sku="<?php echo $item['sku']; ?>" data-idus="<?php echo $idus; ?>">
                                    <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control mb-2 cantidad-input" style="width: 80px;">
                                    <button type="button" class="btn btn-secondary" onclick="updateQuantity(this)">Actualizar</button>
                                    </form>
                                    <form class="delete-form" data-sku="<?php echo $item['sku']; ?>" data-idus="<?php echo $idus; ?>">
                                    <button type="button" class="btn btn-danger" onclick="deleteItem(this)">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
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
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
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

    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Tu script personalizado -->
    <script src="/sigto/assets/js/update.js"></script>
</body>
</html>
