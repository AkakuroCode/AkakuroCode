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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <title>Inicio Empresa</title>
</head>
<body>
    <header>
        <nav class="mi-navbar">
           <div class="mi-navbar-container">
               <h1>
                    <img class="mi-navbar-logo2" src="/sigto/assets/images/navbar logo 2.png" alt="OceanTrade">
               </h1>
               <div class="mi-navbar-items">
                    <form action="ruta/destino" method="GET" class="search-form"> <!-- Ajusta 'action' y 'method' según el backend -->
                        <input class="searchbar" type="text" placeholder="Buscar..." autocomplete="off" maxlength="50" id="search-words" name="query">
                    </form>
                    <a href="mainempresa.php">Inicio</a>
                    <a href="/sigto/views/agregarproducto.php">Agregar Producto</a>
                    <a href="../index.php?action=list2">Ver mis productos</a>
                    <a href="nosotrosempresa.php">Nosotros</a>
                    <a href="../index.php?action=logout">Salir</a>
                </div>
            </div>
        </nav>
    </header>
    
    <main>
        <!-- Carrusel de Bootstrap -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/sigto/assets/images/carrousel.png" class="d-block w-100" alt="Primera imagen">
                </div>
                <div class="carousel-item">
                    <img src="/sigto/assets/images/carrousel.png" class="d-block w-100" alt="Segunda imagen">
                </div>
                <div class="carousel-item">
                    <img src="/sigto/assets/images/carrousel.png" class="d-block w-100" alt="Tercera imagen">
                </div>
                <div class="carousel-item">
                    <img src="/sigto/assets/images/carrousel.png" class="d-block w-100" alt="Cuarta imagen">
                </div>
                <div class="carousel-item">
                    <img src="/sigto/assets/images/carrousel.png" class="d-block w-100" alt="Quinta imagen">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
