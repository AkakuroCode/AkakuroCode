
<?php
session_start();
$resultado = '';

// Verificar si hay un resultado almacenado en la sesión
if (isset($_SESSION['resultado'])) {
    $resultado = $_SESSION['resultado'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <form action="procesamiento.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br>
        
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña"><br>
        
        
        <input type="radio" id="agregar" name="accion" value="agregar">
        <label for="agregar">Agregar</label><br>
        
        
        <input type="radio" id="mostrar" name="accion" value="mostrar">
        <label for="mostrar">Mostrar</label><br>
        
        <input type="submit" value="Enviar">
    </form>

    <form action="procesamiento.php" method="POST">
        <input type="hidden" name="accion" value="limpiar">
        <input type="submit" value="Limpiar Resultados">
    </form>

    <!-- <div id="resultados">
    
       
    </div> -->

    <div id="resultados">
    <?php echo $resultado; 
   
    ?>
    
    </div>

    
</body>
</html>
