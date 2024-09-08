<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Crear Usuario</h1>
    <form action="?action=create" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="nombreUsuario">Nombre de Usuario:</label>
        <input type="text" name="nombreUsuario" required><br>
        <label for="celular">Celular:</label>
        <input type="text" name="celular" required><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br>
        <input type="submit" value="Crear">
    </form>
    <a class="button" href="?action=list">Volver a la lista</a>
</body>
</html>
