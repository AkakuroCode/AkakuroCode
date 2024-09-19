<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<body>
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
            <?php if (!empty($usuario)): ?>
            <?php foreach ($usuario as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['idus']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['fecnac']; ?></td>
                    <td><?php echo $usuario['direccion']; ?></td>
                    <td><?php echo $usuario['telefono']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <a href="../index.php?action=edit&idus=<?php echo $usuario['idus']; ?>">Editar</a>
                        <a href="../index.php?action=delete&idus=<?php echo $usuario['idus']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No hay usuarios registrados.</td>
            </tr>
        <?php endif; ?>
            </tbody>
        </table>

            
    <br>
    <a href="../index.php?action=create">Crear Nuevo Usuario</a>
    <br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>