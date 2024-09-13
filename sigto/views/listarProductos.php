<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> 
    <title>Lista de productos</title>
    <link rel="stylesheet" href="./assets/css/style.css"> <!-- Enlace a la hoja de estilos CSS externa -->
</head>
<body>
    <h1>Lista de productos</h1> <!-- Título principal de la página -->
 <div>
    
 </div>
    <table> <!-- Comienza la tabla para mostrar la lista de pro$productos -->
        <thead> <!-- Sección del encabezado de la tabla -->                
            <tr> <!-- Fila del encabezado de la tabla -->
                <img src="" alt="">
                <th>SKU</th>
                <th>Nombre</th> <!-- Columna para mostrar el email del pro$producto -->
                <th>Descripcion</th>
                <th>Oferta</th>
                <th>Estado</th>
                <th>Origen</th> <!-- Columna para mostrar el nombre de pro$producto -->
                <th>Precio</th>
                <th>Stock</th> <!-- Columna para mostrar el número de celular del pro$producto -->
                <th>Acciones</th> <!-- Columna para mostrar las acciones disponibles (editar/eliminar) -->
            </tr>
        </thead>
        <tbody> <!-- Cuerpo de la tabla donde se mostrarán los datos de los pro$productos -->
            <?php while ($producto = $producto->fetch_assoc()) { ?> <!-- Inicio de un bucle que recorre cada producto obtenido de la base de datos -->
                <tr> <!-- Fila de la tabla para un producto específico -->
                    <td><?php echo $producto['sku']; ?></td> <!-- Celda que muestra el ID del producto -->
                    <td><?php echo $producto['nombre']; ?></td> <!-- Celda que muestra el email del producto -->
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td><?php echo $producto['oferta']; ?></td>
                    <td><?php echo $producto['estado']; ?></td>
                    <td><?php echo $producto['origen']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['stock']; ?></td> <!-- Celda que muestra el nombre de producto -->
                    <td> <!-- Celda que contiene los enlaces de acciones -->
                        <a class="button edit" href="?action=edit&sku=<?php echo $producto['sku']; ?>">Editar</a> <!-- Enlace para editar al producto -->
                        <a class="button delete" href="?action=delete&sku=<?php echo $producto['sku']; ?>">Eliminar</a> <!-- Enlace para eliminar al pro$producto -->
                    </td>
                </tr>
            <?php } ?> <!-- Cierre del bucle PHP -->
        </tbody>
    </table> <!-- Fin de la tabla -->

    <a class="button" href="?action=create">Crear Nuevo producto</a> <!-- Enlace para crear un nuevo pro$producto -->
</body>
</html>
