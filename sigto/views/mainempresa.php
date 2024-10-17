<?php
session_start(); // Iniciar la sesión al comienzo del archivo

require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

$productoController = new ProductoController();
$productos = $productoController->readAllByEmpresa($_SESSION['idemp']); // Recupera todos los productos de la empresa logueada

$ofertaController = new OfertaController(); // Para obtener las ofertas relacionadas

if (!$productos) {
    echo "No se encontraron productos.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Inicio Empresa</title>
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
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/nosotrosempresa.php">Nosotros</a>
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
                    <form class="d-flex" role="search">
                        <input class="rounded-pill mt-2" type="text" placeholder="Buscar..." autocomplete="off" maxlength="50" id="search-words" name="query">
                    </form>
                  </div>
                </div>
              </nav>
    </header>
    
    <main>
               <!-- Carrusel de Bootstrap -->
               <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img src="/sigto/assets/images/carrousel.png" class="img-carrousel d-block w-100" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="/sigto/assets/images/carrousel.png" class="img-carrousel d-block w-100" alt="...">
                          </div>
                          <div class="carousel-item">
                            <img src="/sigto/assets/images/logo akakuro.png" class="img-carrousel d-block w-100" alt="...">
                          </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>

        <p class="relleno">Productos de la Empresa</p>

        <!-- Catálogo de productos -->
        <div class="container mt-5">
            <h2>Mis Productos</h2>
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="/sigto/assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>

                                <?php
                                // Verificar si el producto tiene una oferta activa
                                $oferta = $ofertaController->readBySku($producto['sku']);
                                if ($oferta) {
                                    $precioOferta = $oferta['preciooferta'];
                                    echo "<p class='card-text'><strong>Precio: </strong><span style='text-decoration: line-through;'>US$" . htmlspecialchars($producto['precio']) . "</span></p>";
                                    echo "<p class='card-text'><strong>Oferta: </strong>{$oferta['porcentaje_oferta']}%</p>";
                                    echo "<p class='card-text'><strong>Precio con oferta: </strong>US${precioOferta}</p>";
                                } else {
                                    echo "<p class='card-text'><strong>Precio: </strong>US$" . htmlspecialchars($producto['precio']) . "</p>";
                                    echo "<p class='card-text'><strong>No hay oferta disponible</strong></p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <br><br><br><br><br><br>
    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
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

        <!-- Scripts necesarios -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
