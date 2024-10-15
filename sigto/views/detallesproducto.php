<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/EmpresaController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

// Verificar si el SKU del producto fue pasado correctamente en la URL
if (!isset($_GET['id'])) {
    echo "Producto no especificado.";
    exit;
}

$sku = $_GET['id']; // Obtener el SKU del producto de la URL
$productoController = new ProductoController();
$producto = $productoController->readOne($sku); // Obtener el producto por SKU

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

// Obtener la información de la empresa (vendedor)
$empresaController = new EmpresaController();
$empresa = $empresaController->readOne($producto['idemp']); // Obtener la empresa propietaria del producto

$ofertaController = new OfertaController();
$oferta = $ofertaController->readBySku($sku); // Obtener la oferta asociada al producto, si la hay

$fechaActual = date('Y-m-d'); // Obtener la fecha actual
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
</head>
<body>
    <header>
        <nav class="mi-navbar">
            <div class="mi-navbar-container">
                <h1><img class="mi-navbar-logo" src="/sigto/assets/images/navbar logo.png" alt="OceanTrade"></h1>
                <div class="mi-navbar-items">
                    <a href="maincliente.php">Inicio</a>
                    <a href="/sigto/views/usuarioperfil.php">Perfil</a> 
                    <a href="/sigto/index?action=view_cart">Carrito</a>
                    <a href="nosotroscliente.php">Nosotros</a>
                    <a href="/sigto/index.php?action=logout">Salir</a>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Mostrar la imagen del producto -->
                <img src="/sigto/assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
            <div class="col-md-6">
                <!-- Mostrar los detalles del producto -->
                <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>

                <?php
                // Verificar si el producto tiene una oferta activa
                if ($oferta && $oferta['fecha_inicio'] <= $fechaActual && $oferta['fecha_fin'] >= $fechaActual) {
                    $precioOferta = $oferta['preciooferta'];
                    echo "<p><strong>Precio: </strong><del>US$" . htmlspecialchars($producto['precio']) . "</del></p>";
                    echo "<p><strong>Oferta: </strong>{$oferta['porcentaje_oferta']}%</p>";
                    echo "<p><strong>Precio con oferta: </strong>US$" . htmlspecialchars($precioOferta) . "</p>";
                } else {
                    echo "<p><strong>Precio: </strong>US$" . htmlspecialchars($producto['precio']) . "</p>";
                    echo "<p><strong>No hay oferta disponible</strong></p>";
                }
                ?>

                <!-- Select de Cantidad basado en el Stock -->
                <form action="/sigto/index?action=add_to_cart" method="POST">
                    <input type="hidden" name="sku" value="<?php echo $producto['sku']; ?>">
                    <label for="cantidad">Cantidad:</label>
                    <select name="cantidad" class="form-control mb-2" style="width: 80px;">
                        <?php for ($i = 1; $i <= $producto['stock']; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Comprar</button>
                </form>

                <!-- Botón de Contactar al Vendedor (WhatsApp) -->
                <a href="https://api.whatsapp.com/send?phone=<?php echo htmlspecialchars($empresa['telefono']); ?>&text=Hola, estoy interesado en el producto <?php echo htmlspecialchars($producto['nombre']); ?>" class="btn btn-success mt-3">
                    Contactar al Vendedor
                </a> <!-- Enlace para abrir WhatsApp -->
                
                <!-- Botón para volver a la página anterior -->
                <a href="javascript:history.back()" class="btn btn-secondary mt-3">Volver</a>

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

</body>
</html>
