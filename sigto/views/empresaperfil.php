<?php
// Iniciar sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir el controlador de empresa o la lógica para obtener la empresa logueada
require_once __DIR__ . '/../controllers/EmpresaController.php';

$empresaController = new EmpresaController();
$empresa = $empresaController->readOne($_SESSION['idemp']);

// Verificar que se encontró la empresa
if (!$empresa) {
    echo "Error: no se encontró la empresa.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Empresa</title>
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/sigto/assets/css/style.css"> <!-- Estilos personalizados -->
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
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/mainempresa.php">
                        <i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/empresaperfil.php"><i class="bi bi-building"></i> Perfil</a>
                        </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/views/agregarproducto.php"><i class="bi bi-plus-circle"></i> Agregar</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="text-white fs-4 text-decoration-none" href="/sigto/index.php?action=logout">
                        <i class="bi bi-door-closed"></i> Salir</a>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 p-5 bg-white shadow-lg rounded">
                <h2 class="text-center mb-4">Perfil de <?php echo htmlspecialchars($empresa['nombre']); ?></h2>
                <div class="d-flex flex-column align-items-center">
                    <a href="/sigto/index.php?action=edit_empresa" class="btn btn-outline-primary btn-lg mb-2">Editar Información</a>
                    <a href="verHistorialVenta.php" class="btn btn-outline-secondary btn-lg mb-2">Historial de Ventas</a>
                    <a href="listarproductos.php" class="btn btn-outline-secondary btn-lg">Mis Productos</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <p>Contacto</p>
                <a href="/sigto/views/nosotrosempresa.php">Nosotros</a>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/sigto/assets/js/searchbar.js"></script>
</div>
</body>
</html>
