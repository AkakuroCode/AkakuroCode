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
            <?php foreach ($usuario as $row): ?>
                <tr>
                    <td><?php echo $row['idus']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['fecnac']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['telefono']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="../index.php?action=edit&idus=<?php echo $row['idus']; ?>">Editar</a>
                        <a href="../index.php?action=delete&idus=<?php echo $row['idus']; ?>">Eliminar</a>
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