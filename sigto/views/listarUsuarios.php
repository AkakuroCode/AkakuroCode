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
    
    <!-- Verifica si hay usuarios para mostrar -->
    <?php if ($usuario ->num_rows > 0): ?>
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
                <!-- Itera sobre los resultados de la base de datos -->
                <?php while ($row = $usuario->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['idus']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['apellido']; ?></td>
                        <td><?php echo $row['fecnac']; ?></td>
                        <td><?php echo $row['direccion']; ?></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="?action=edit&id=<?php echo $row['idus']; ?>">Editar</a> |
                            <a href="?action=delete&id=<?php echo $row['idus']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron usuarios registrados.</p>
    <?php endif; ?>
    
    <br>
    <a href="crearUsuario.php">Crear Nuevo Usuario</a>
    <br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>