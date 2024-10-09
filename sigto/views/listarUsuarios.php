<?php
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/EmpresaController.php';

// Instancia del controlador de usuario
$usuarioController = new UsuarioController();
$usuarios = $usuarioController->readAll(); // Obtener todos los usuarios

// Instancia del controlador de empresa
$empresaController = new EmpresaController();
$empresas = $empresaController->readAll(); // Obtener todas las empresas
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios y Empresas</title>
    <link rel="stylesheet" href="/sigto/assets/css/style.css">
    <link rel="stylesheet" href="/sigto/assets/css/admin.css">
</head>
<body>
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
                        <a href="/sigto/index.php?action=edit&idus=<?php echo $usuario['idus']; ?>">Editar</a>
                        <a href="/sigto/index.php?action=delete&idus=<?php echo $usuario['idus']; ?>">Eliminar</a>
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

    <br>
    <br>

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
                        <a href="/sigto/index.php?action=edit2&idemp=<?php echo $empresa['idemp']; ?>">Editar</a>
                        <a href="/sigto/index.php?action=delete2&idemp=<?php echo $empresa['idemp']; ?>">Eliminar</a>
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

    <br>
    <br>

    <a href="/sigto/index.php?action=logout">
    <button type="button">Cerrar Sesión</button>
    </a>

</div>
</body>
</html>
