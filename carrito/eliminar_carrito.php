<?php
session_start();
require_once '../config/db.php';

// validar sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// Aceptar POST o GET (flexible para botones/enlaces)
$carrito_id = $_POST["id"] ?? $_GET["id"] ?? null;

if (!$carrito_id) {
    die("ID inválido");
}

// verificar que el item exista y pertenezca al usuario
$sql = "SELECT id 
        FROM carrito 
        WHERE id = ? 
        AND usuario_id = ? 
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $carrito_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result->fetch_assoc()) {
    die("Producto no encontrado en el carrito");
}

// eliminar del carrito
$sql = "DELETE FROM carrito 
        WHERE id = ? 
        AND usuario_id = ? 
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $carrito_id, $usuario_id);
$stmt->execute();

//  regresar al carrito
header("Location: ../carrito.php");
exit;
?>