<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <h1>Editar Producto</h1>
    <form action="?action=edit&sku=<?php echo $producto['sku']; ?>" method="post">
        <input type="hidden" name="sku" value="<?php echo $producto['sku']; ?>">
  
        <label for="Nombre">Nombre:</label>

        <input type="Nombre" name="Nombre" value="<?php echo $producto['nombre']; ?>" required><br>

        <label for="">Descripcion</label>

        <input type="descripcion" nane="descripcion" value ="<?php echo $producto['descripcion'];?>" required> <br>

        <label for="oferta">Oferta</label>

        <input type="oferta" name="descripcion" value ="<?php echo $producto['oferta'];?>" required> <br>

        <label for="estado">Estado</label>

        <input type="estado" name="estado" value ="<?php echo $producto['estado'];?>" required> <br>

        <label for="origen">Origen</label>

        <input type="origen" name="estado" value ="<?php echo $producto['origen'];?>" required> <br>

        <label for="Cantidad">Cantidad de producto:</label>

        <input type="text" name="Cantidad" value="<?php echo $producto['stock'];?>" required><br>

        <label for="Precio">Precio:</label>

        <input type="text" name="Precio" value="<?php echo $producto['precio']; ?>" required><br>

        <input type="submit" value="Actualizar">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>