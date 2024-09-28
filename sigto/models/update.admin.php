<?php
require_once __DIR__ . '/../config/Database.php';

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Especificar el email del admin y la nueva contraseña
$adminEmail = 'torrescristian661@gmail.com';
$newPassword = '123456';

// Hashear la nueva contraseña
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Preparar la consulta para actualizar la contraseña en la tabla admin
$query = "UPDATE admin SET passw = ? WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $hashedPassword, $adminEmail);

if ($stmt->execute()) {
    echo "Contraseña del administrador actualizada correctamente.";
} else {
    echo "Error al actualizar la contraseña del administrador: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
