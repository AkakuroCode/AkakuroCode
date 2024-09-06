<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <title>Lista de productos</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Enlace a la hoja de estilos CSS externa -->
</head>
<body>
    <h1>Lista de productos</h1> <!-- Título principal de la página -->

    <table> <!-- Comienza la tabla para mostrar la lista de pro$productos -->
        <thead> <!-- Sección del encabezado de la tabla -->
            <tr> <!-- Fila del encabezado de la tabla -->
                <th>ID</th> <!-- Columna para mostrar el ID del pro$producto -->
                <th>Nombre</th> <!-- Columna para mostrar el email del pro$producto -->
                <th>Cantidad</th> <!-- Columna para mostrar el nombre de pro$producto -->
                <th>Precio</th> <!-- Columna para mostrar el número de celular del pro$producto -->
                <th>Acciones</th> <!-- Columna para mostrar las acciones disponibles (editar/eliminar) -->
            </tr>
        </thead>
        <tbody> <!-- Cuerpo de la tabla donde se mostrarán los datos de los pro$productos -->
            <?php while ($producto = $productos->fetch_assoc()) { ?> <!-- Inicio de un bucle que recorre cada producto obtenido de la base de datos -->
                <tr> <!-- Fila de la tabla para un producto específico -->
                    <td><?php echo $producto['idProductos']; ?></td> <!-- Celda que muestra el ID del producto -->
                    <td><?php echo $producto['Nombre']; ?></td> <!-- Celda que muestra el email del producto -->
                    <td><?php echo $producto['Cantidad']; ?></td> <!-- Celda que muestra el nombre de producto -->
                    <td><?php echo $producto['Precio']; ?></td> <!-- Celda que muestra el número de celular -->
                    <td> <!-- Celda que contiene los enlaces de acciones -->
                        <a class="button edit" href="?action=edit&idProd=<?php echo $producto['idProductos']; ?>">Editar</a> <!-- Enlace para editar al pro$producto -->
                        <a class="button delete" href="?action=delete&idProd=<?php echo $producto['idProductos']; ?>">Eliminar</a> <!-- Enlace para eliminar al pro$producto -->
                    </td>
                </tr>
            <?php } ?> <!-- Cierre del bucle PHP -->
        </tbody>
    </table> <!-- Fin de la tabla -->

    <a class="button" href="?action=create">Crear Nuevo producto</a> <!-- Enlace para crear un nuevo pro$producto -->
</body>
</html>