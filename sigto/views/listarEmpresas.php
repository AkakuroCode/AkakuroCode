<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <title>Lista de Usuarios Empresa</title>
    <link rel="stylesheet" href="./assets/css/style.css"> <!-- Enlace a la hoja de estilos CSS externa -->
</head>
<body>
    <h1>Lista de Usuarios</h1> <!-- Título principal de la página -->

    <table> <!-- Comienza la tabla para mostrar la lista de usuarios -->
        <thead> <!-- Sección del encabezado de la tabla -->
            <tr> <!-- Fila del encabezado de la tabla -->
                <th>ID</th> <!-- Columna para mostrar el ID del usuario -->
                <th>Email</th> <!-- Columna para mostrar el email del usuario -->
                <th>Nombre</th> <!-- Columna para mostrar el nombre de usuario -->
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th> <!-- Columna para mostrar las acciones disponibles (editar/eliminar) -->
            </tr>
        </thead>
        <tbody> <!-- Cuerpo de la tabla donde se mostrarán los datos de los usuarios -->
            <?php while ($empresa = $empresa->fetch_assoc()) { ?> <!-- Inicio de un bucle que recorre cada usuario obtenido de la base de datos -->
                <tr> <!-- Fila de la tabla para un usuario específico -->
                    <td><?php echo $empresa['idemp']; ?></td> <!-- Celda que muestra el ID del usuario -->
                    <td><?php echo $empresa['email']; ?></td> <!-- Celda que muestra el email del usuario -->
                    <td><?php echo $empresa['nombre']; ?></td> <!-- Celda que muestra el nombre de usuario -->
                    <td><?php echo $empresa['direccion']; ?></td>
                    <td><?php echo $empresa['telefono']; ?></td> <!-- Celda que muestra el número de celular -->
                    <td> <!-- Celda que contiene los enlaces de acciones -->
                        <a class="button edit" href="?action=edit&idemp=<?php echo $empresa['idemp']; ?>">Editar</a> <!-- Enlace para editar al usuario -->
                        <a class="button delete" href="?action=delete&idemp=<?php echo $empresa['idemp']; ?>">Eliminar</a> <!-- Enlace para eliminar al usuario -->
                    </td>
                </tr>
            <?php } ?> <!-- Cierre del bucle PHP -->
        </tbody>
    </table> <!-- Fin de la tabla -->

    <a class="button" href="?action=create">Crear Nuevo Usuario</a> <!-- Enlace para crear un nuevo usuario -->
</body>
</html>
