<?php
require_once __DIR__ . '/../controllers/ProductoController.php';

$productoController = new ProductoController();

// Verifica si la sesión de empresa está activa
if (!isset($_SESSION['idemp'])) {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}

// Obtener productos solo de la empresa logueada
$productos = $productoController->readAllByEmpresa($_SESSION['idemp']);

if (!$productos) {
    echo "No se encontraron productos.";
    exit;
}

// Mostrar productos en una tabla
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/admin.css">
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
                    <a href="/sigto/views/mainempresa.php">Inicio</a>
                    <a href="/sigto/views/agregarproducto.php">Agregar Producto</a>
                    <a href="/sigto/views/nosotrosempresa.php">Nosotros</a>
                    <a href="../index.php?action=logout">Salir</a>
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
                <th>Imagenes</th>
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
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><img src="/sigto/assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 100px; height: auto;"></td>
                    <td>
                        <a href="?action=edit3&sku=<?php echo $producto['sku']; ?>">Editar</a>
                        <a href="?action=delete3&sku=<?php echo $producto['sku']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</a>
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
                <a href="https://www.facebook.com/"><img class="redes" src="/sigto/assets/images/facebook logo.png"  alt="Facebook"></a>
                <a href="https://twitter.com/home"><img class="redes" src="/sigto/assets/images/x.png"  alt="Twitter"></a>
                <a href="https://www.instagram.com/"><img class="redes" src="/sigto/assets/images/ig logo.png"  alt="Instagram"></a>
            </div>
        </div>
    </footer>
</body>
</html>
