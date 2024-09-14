<?php
// Datos de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oceantrade";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Ejecutar la consulta
$query = "SELECT * FROM cliente";
$usuario = $conn->query($query);
?>
