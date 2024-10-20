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
    <script>
        function toggleMenu(userId) {
            var element = document.getElementById('logins-' + userId);
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
                            <button class="btn-baja" onclick="cambiarEstado(<?php echo $usuario['idus']; ?>, 'no')">Dar de baja</button>
                        <?php else: ?>
                            <button class="btn-alta" onclick="cambiarEstado(<?php echo $usuario['idus']; ?>, 'si')">Dar de alta</button>
                        <?php endif; ?>

                        <button type="button" class="btn view-logins-btn" onclick="toggleMenu(<?php echo $usuario['idus']; ?>)">Ver Logins</button>
                    </td>
                </tr>
                <!-- Fila que contiene el historial de logins del usuario, inicialmente oculta -->
                <tr id="logins-<?php echo $usuario['idus']; ?>" style="display:none;">
                    <td colspan="8">
                        <?php
                        // Obtener los logins desde el controlador
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
                        <a id="eliminar" class="btn" href="/sigto/index.php?action=delete2&idemp=<?php echo $empresa['idemp']; ?>">Eliminar</a>
                        <!-- Botón para ver logins -->
                        <button type="button" class="btn view-logins-btn" onclick="toggleEmpresaMenu(<?php echo $empresa['idemp']; ?>)">Ver Logins</button>
                    </td>
                </tr>
                <!-- Fila que contiene el historial de logins de la empresa, inicialmente oculta -->
                <tr id="logins-empresa-<?php echo $empresa['idemp']; ?>" style="display:none;">
                    <td colspan="7">
                        <?php
                        // Obtener los logins desde el controlador
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

    
</script>

</body>
</html>
