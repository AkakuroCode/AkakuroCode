<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/FavoritoController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

$favoritoController = new FavoritoController();
$productoController = new ProductoController();
$ofertacontroller = new OfertaController();

$idus = $_SESSION['idus']; // Obtener el id del usuario desde la sesión
$favoritoItems = $favoritoController->getFavoritosByUser($idus); // Obtener los productos favoritos

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Mis Favoritos</title>
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
                        <a class="nav-link nav-icon" href="/sigto/index?action=view_cart">
                        <i class="bi bi-cart"></i> Carrito</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link nav-icon" href="/sigto/index.php?action=logout">
                        <i class="bi bi-door-open">Salir</i></a>
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

    
    <h2 class="text-center">Mis Favoritos</h2>
    
    <main class="container mt-5">
        <!-- Si no hay productos en favoritos -->
        <?php if (!$favoritoItems || empty($favoritoItems)): ?>
            <p class="text-center mt-4">No tienes productos en favoritos.</p>
        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="list-group">
                        <?php foreach ($favoritoItems as $producto): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="/sigto/assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 80px; height: auto; margin-right: 15px;">
                                        <div>
                                            <h5><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                            <!-- Si hay oferta, mostrarla -->
                                            <?php if (isset($producto['preciooferta']) && $producto['preciooferta'] > 0): ?>
                                            <p><strong>Oferta:</strong> <?php echo number_format($producto['porcentaje_oferta'], 2); ?>%</p>
                                            <p><strong>Precio con oferta:</strong> US$<?php echo number_format($producto['preciooferta'], 2); ?></p>
                                            <?php else: ?>
                                            <p><strong>Precio:</strong> US$<?php echo number_format($producto['precio'], 2); ?></p>
                                            <?php endif; ?>


                                            <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Mantener el botón de Ver detalles y el botón de agregar/quitar favoritos -->
                                        <button class="btn-favorito" data-idus="<?php echo $_SESSION['idus']; ?>" data-sku="<?php echo $producto['sku']; ?>">
                                            <img src="/sigto/assets/images/favoritos2.png" alt="Favorito" class="heart-icon" id="favorito-<?php echo $producto['sku']; ?>">
                                        </button>
                                        <?php
                                        // Obtener la cantidad disponible dependiendo del tipo de stock
                                        if (isset($producto['tipo_stock']) && $producto['tipo_stock'] === 'unidad') {
                                            $cantidadDisponible = $productoController->getCantidadDisponiblePorSku($producto['sku']);
                                        } else {
                                            $cantidadDisponible = isset($producto['stock']) ? $producto['stock'] : 0;
                                        }
                                        ?>

                                    <!-- Select de Cantidad basado en la cantidad disponible -->
                                    <form action="/sigto/index?action=add_to_cart" method="POST">
                                        <input type="hidden" name="sku" value="<?php echo $producto['sku']; ?>">
                                        <label for="cantidad">Cantidad:</label>
                                        <select name="cantidad" class="form-control mb-2" style="width: 80px;">
                                            <?php if ($cantidadDisponible > 0): ?>
                                                <?php for ($i = 1; $i <= $cantidadDisponible; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            <?php else: ?>
                                                <option value="0">Sin stock disponible</option>
                                            <?php endif; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary" <?php echo ($cantidadDisponible <= 0) ? 'disabled' : ''; ?>>Comprar</button>
                                    </form>
                                        <a href="/sigto/views/detallesproducto.php?id=<?php echo $producto['sku']; ?>" class="btn btn-info mt-2">Ver detalles</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/sigto/assets/js/favorito.js"></script>
</div>   
</body>
</html>
