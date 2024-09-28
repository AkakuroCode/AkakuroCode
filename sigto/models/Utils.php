<?php
require_once __DIR__ . '/../config/Database.php';

function isEmailRegistered($email) {
    $database = new Database();
    $conn = $database->getConnection();

    // Verifica en la tabla cliente
    $queryCliente = "SELECT email FROM cliente WHERE email = ?";
    $stmtCliente = $conn->prepare($queryCliente);
    $stmtCliente->bind_param("s", $email);
    $stmtCliente->execute();
    $resultCliente = $stmtCliente->get_result();

    if ($resultCliente->num_rows > 0) {
        return true; // El email ya está registrado en la tabla cliente
    }

    // Verifica en la tabla empresa
    $queryEmpresa = "SELECT email FROM empresa WHERE email = ?";
    $stmtEmpresa = $conn->prepare($queryEmpresa);
    $stmtEmpresa->bind_param("s", $email);
    $stmtEmpresa->execute();
    $resultEmpresa = $stmtEmpresa->get_result();

    if ($resultEmpresa->num_rows > 0) {
        return true; // El email ya está registrado en la tabla empresa
    }

    return false; // El email no está registrado en ninguna tabla
}
?>
