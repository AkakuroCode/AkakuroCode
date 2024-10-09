<?php
session_start(); // Asegúrate de que esto esté aquí
require_once __DIR__ . '/../controllers/CarritoController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$carritoController = new CarritoController();
$productoController = new ProductoController();
var_dump($_SESSION);
exit;

// Verifica que el usuario esté logueado y tenga un ID de usuario
if (!isset($_SESSION['idus'])) {
    header('Location: /sigto/index.php?action=login');
    exit;
}

$idus = $_SESSION['idus'];
$carritoItems = $carritoController->getItemsByUser($idus);

if (!$carritoItems || $carritoItems->num_rows == 0) {
    echo "No hay productos en el carrito.";
    exit;
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
                    <a href="maincliente.php">Inicio</a>
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
                    <?php 
                    $totalCarrito = 0;
                    while ($item = $carritoItems->fetch_assoc()): 
                        $totalItem = $item['cantidad'] * $item['precio'];
                        $totalCarrito += $totalItem;
                    ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="/sigto/assets/images/<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" style="width: 80px; height: auto; margin-right: 15px;">
                                <div>
                                    <h5><?php echo htmlspecialchars($item['nombre']); ?></h5>
                                    <p>Cantidad: <?php echo $item['cantidad']; ?></p>
                                    <p>Precio unitario: US$<?php echo number_format($item['precio'], 2); ?></p>
                                </div>
                            </div>
                            <div>
                                <p>Total: US$<?php echo number_format($totalItem, 2); ?></p>
                                <form action="?action=update_quantity" method="POST" class="d-inline">
                                    <input type="hidden" name="sku" value="<?php echo $item['sku']; ?>">
                                    <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control mb-2" style="width: 80px;">
                                    <button type="submit" class="btn btn-secondary">Actualizar</button>
                                </form>
                                <form action="?action=delete_from_cart" method="POST" class="d-inline">
                                    <input type="hidden" name="sku" value="<?php echo $item['sku']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Resumen de Compra</h4>
                        <p class="card-text">Total: <strong>US$<?php echo number_format($totalCarrito, 2); ?></strong></p>
                        <a href="?action=checkout" class="btn btn-primary btn-block">Continuar compra</a>
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
    <script src="/sigto/assets/js/script.js"></script>
</body>
</html>
