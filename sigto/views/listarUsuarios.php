<?php
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/EmpresaController.php';
require_once __DIR__ . '/../controllers/CategoriaController.php';
require_once __DIR__ . '/../controllers/HistorialCompraController.php';

$idus = null;

// Instancia del controlador de usuario
$usuarioController = new UsuarioController();
$usuarios = $usuarioController->readAll(); // Obtener todos los usuarios

// Instancia del controlador de empresa
$empresaController = new EmpresaController();
$empresas = $empresaController->readAll(); // Obtener todas las empresas

// Instancia del controlador de categorías
$categoriaController = new CategoriaController();
$categorias = $categoriaController->getAllCategorias(); // Obtener todas las categorías

// Instancia del controlador de historial de compras
$historialCompraModel = new HistorialCompraController();
$historial = $historialCompraModel->obtenerHistorialPorUsuarioAdmin($idus);


// Manejar la solicitud de agregar una nueva categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category-name'], $_POST['category-description'])) {
    $nombre = $_POST['category-name'];
    $descripcion = $_POST['category-description'];

    if ($categoriaController->addCategoria($nombre, $descripcion)) {
        echo "<script>alert('Categoría agregada con éxito.');</script>";
    } else {
        echo "<script>alert('Error al agregar la categoría.');</script>";
    }
}

// Manejar la solicitud de actualización de categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-category-id'], $_POST['update-category-name'], $_POST['update-category-description'])) {
    $id = $_POST['update-category-id'];
    $nombre = $_POST['update-category-name'];
    $descripcion = $_POST['update-category-description'];

    if ($categoriaController->updateCategoria($id, $nombre, $descripcion)) {
        echo "<script>alert('Categoría actualizada con éxito.');</script>";
    } else {
        echo "<script>alert('Error al actualizar la categoría.');</script>";
    }
}

// Manejar la solicitud de eliminación de categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-category-id'])) {
    $id = $_POST['delete-category-id'];

    if ($categoriaController->deleteCategoria($id)) {
        echo "<script>alert('Categoría borrada con éxito.');</script>";
    } else {
        echo "<script>alert('Error al borrar la categoría.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios y Empresas</title>
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/admin.css">
    <script>
        function toggleMenu(userId) {
            var element = document.getElementById('logins-' + userId);
            if (element.style.display === 'none') {
                element.style.display = 'table-row';
            } else {
                element.style.display = 'none';
            }
        }

        function toggleCompras(userId) {
            var element = document.getElementById('compras-' + userId);
            if (element.style.display === 'none') {
                element.style.display = 'table-row';
            } else {
                element.style.display = 'none';
            }
        }

        function toggleEmpresaMenu(empId) {
            var element = document.getElementById('logins-empresa-' + empId);
            if (element.style.display === 'none') {
                element.style.display = 'table-row';
            } else {
                element.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<nav class="navbar">
    <ul class="nav-menu">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link">Categorías</a>
            <div class="dropdown-content">
                <button class="dropdown-btn" onclick="showBox('add-box')">Agregar</button>
                <button class="dropdown-btn" onclick="showBox('update-box')">Actualizar</button>
                <button class="dropdown-btn" onclick="showBox('delete-box')">Borrar</button>
            </div>
        </li>
    </ul>
</nav>

<!-- Cuadros de diálogo para cada acción -->
<div id="add-box" class="action-box" style="display: none;">
    <h2>Agregar Categoría</h2>
    <button class="close-btn" onclick="closeBox('add-box')">&times;</button>
    <form id="add-category-form" method="POST" action="">
        <label for="category-name">Nombre:</label>
        <input type="text" id="category-name" name="category-name" required><br><br>

        <label for="category-description">Descripción (máximo 255 caracteres):</label>
        <textarea id="category-description" name="category-description" maxlength="255" required></textarea><br><br>

        <button type="submit">Agregar Categoría</button>
    </form>
</div>


<div id="update-box" class="action-box" style="display: none;">
    <h2>Actualizar Categoría</h2>
    <button class="close-btn" onclick="closeBox('update-box')">&times;</button>
    <form id="update-category-form" method="POST" action="">
        <label for="update-category-id">ID de la Categoría:</label>
        <select id="update-category-id" name="update-category-id" required>
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo htmlspecialchars($categoria['idcat']); ?>">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="update-category-name">Nuevo Nombre:</label>
        <input type="text" id="update-category-name" name="update-category-name" required><br><br>

        <label for="update-category-description">Nueva Descripción:</label>
        <textarea id="update-category-description" name="update-category-description" maxlength="255" required></textarea><br><br>

        <button type="submit">Actualizar Categoría</button>
    </form>
</div>



<div id="delete-box" class="action-box" style="display: none;">
    <h2>Borrar Categoría</h2>
    <button class="close-btn" onclick="closeBox('delete-box')">&times;</button>
    <form id="delete-category-form" method="POST" action="">
        <label for="categoria">Categoría:</label>
        <select id="categoria" name="delete-category-id" required>
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo htmlspecialchars($categoria['idcat']); ?>">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Borrar Categoría</button>
    </form>
</div>

<div class="panel-gestion">
    <h1>Lista de Usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($usuarios && $usuarios->num_rows > 0): ?>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['idus']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['fecnac']; ?></td>
                        <td><?php echo $usuario['direccion']; ?></td>
                        <td><?php echo $usuario['telefono']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td>
                            <a id="editar" class="btn" href="/sigto/index.php?action=edit&idus=<?php echo $usuario['idus']; ?>">Editar</a>
                            <!-- Verificar si el usuario está activo o inactivo -->
                            <?php if ($usuario['activo'] == 'si'): ?>
                            <button class="btn-baja" onclick="cambiarEstadoUsuario(<?php echo $usuario['idus']; ?>, 'no')">Dar de baja</button>
                            <?php else: ?>
                            <button class="btn-alta" onclick="cambiarEstadoUsuario(<?php echo $usuario['idus']; ?>, 'si')">Dar de alta</button>
                            <?php endif; ?>
                            <button class="btn view-logins-btn" onclick="toggleMenu(<?php echo $usuario['idus']; ?>)">Ver Logins</button>
                            <button class="btn view-compras-btn" onclick="toggleCompras(<?php echo $usuario['idus']; ?>)">Ver Compras</button>
                        </td>
                    </tr>

                    <!-- Historial de logins del usuario -->
                    <tr id="logins-<?php echo $usuario['idus']; ?>" style="display:none;">
                        <td colspan="8">
                            <?php
                            $logins = $usuarioController->getUserLogins($usuario['idus']);
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logins as $login): ?>
                                    <tr>
                                        <td><?php echo $login['fecha']; ?></td>
                                        <td><?php echo $login['hora']; ?></td>
                                        <td><?php echo $login['url']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Historial de compras del usuario -->
                    <tr id="compras-<?php echo $usuario['idus']; ?>" style="display:none;">
                        <td colspan="8">
                            <?php
                            $compras = $historialCompraModel->obtenerHistorialPorUsuarioAdmin($usuario['idus']);
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID Registro</th>
                                        <th>SKU</th>
                                        <th>Estado</th>
                                        <th>Código de Unidad</th>
                                        <th>Precio Actual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($compras as $compra): ?>
                                    <tr>
                                        <td><?php echo $compra['idregistrocompra']; ?></td>
                                        <td><?php echo $compra['sku']; ?></td>
                                        <td><?php echo $compra['estado']; ?></td>
                                        <td><?php echo $compra['codigo_unidad']; ?></td>
                                        <td><?php echo "US$ " . number_format($compra['precio_actual'], 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="panel-gestion">
    <h1>Lista de Empresas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la Empresa</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Cuenta de Banco</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($empresas && $empresas->num_rows > 0): ?>
                <?php while ($empresa = $empresas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $empresa['idemp']; ?></td>
                        <td><?php echo $empresa['nombre']; ?></td>
                        <td><?php echo $empresa['direccion']; ?></td>
                        <td><?php echo $empresa['telefono']; ?></td>
                        <td><?php echo $empresa['email']; ?></td>
                        <td><?php echo $empresa['cuentabanco']; ?></td>
                        <td>
                            <a id="editar" class="btn" href="/sigto/index.php?action=edit2&idemp=<?php echo $empresa['idemp']; ?>">Editar</a>
                            <!-- Verificar si la empresa está activa o inactiva -->
                            <?php if ($empresa['activo'] == 'si'): ?>
                            <button class="btn-baja" onclick="cambiarEstadoEmpresa(<?php echo $empresa['idemp']; ?>, 'no')">Dar de baja</button>
                            <?php else: ?>
                            <button class="btn-alta" onclick="cambiarEstadoEmpresa(<?php echo $empresa['idemp']; ?>, 'si')">Dar de alta</button>
                            <?php endif; ?>
                            <button class="btn view-logins-btn" onclick="toggleEmpresaMenu(<?php echo $empresa['idemp']; ?>)">Ver Logins</button>
                        </td>
                    </tr>

                    <!-- Historial de logins de la empresa -->
                    <tr id="logins-empresa-<?php echo $empresa['idemp']; ?>" style="display:none;">
                        <td colspan="7">
                            <?php
                            $logins_empresa = $empresaController->getEmpresaLogins($empresa['idemp']);
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logins_empresa as $login_empresa): ?>
                                    <tr>
                                        <td><?php echo $login_empresa['fecha']; ?></td>
                                        <td><?php echo $login_empresa['hora']; ?></td>
                                        <td><?php echo $login_empresa['url']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay empresas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<a id="logout" class="btn" href="/sigto/index.php?action=logout">Cerrar Sesión</a>

</body>
</html>
<script>
    function cambiarEstado(idus, estado) {
        fetch('/sigto/index.php?action=updateStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                idus: idus,
                estado: estado
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Recargar la página para actualizar los botones
            } else {
                alert('Error al cambiar el estado del usuario.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function cambiarEstadoEmpresa(idemp, estado) {
    fetch('/sigto/index.php?action=updateEmpresaStatus', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            idemp: idemp,
            estado: estado
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Recargar la página para actualizar los botones
        } else {
            alert('Error al cambiar el estado de la empresa.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


    
</script>


<script>
    function showBox(boxId) {
        const boxes = document.querySelectorAll('.action-box');
        boxes.forEach(box => box.style.display = 'none');
        document.getElementById(boxId).style.display = 'block';
    }
</script>

<script>
    function closeBox(boxId) {
        document.getElementById(boxId).style.display = 'none';
    }
</script>

<script src="/sigto/assets/js/admin.js"></script>


</body>
</html>



