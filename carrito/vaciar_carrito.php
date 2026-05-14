<?php
session_start();
require_once '../config/db.php';

// validar sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// eliminar SOLO el carrito activo del usuario
$sql = "DELETE FROM carrito 
        WHERE usuario_id = ? 
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

// regresar al carrito
header("Location: ../carrito.php");
exit;
?>