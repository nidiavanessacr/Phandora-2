<?php
session_start();
require_once '../config/db.php';

// 🔒 seguridad: usuario logueado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🔥 aceptar POST o GET
$producto_id = $_POST["id"] ?? $_GET["id"] ?? null;

if (!$producto_id) {
    die("ID de producto inválido");
}

// 🔎 obtener producto
$sql = "SELECT id, nombre, precio, imagen, stock
        FROM productos
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();

$result = $stmt->get_result();

$producto = $result->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado");
}

// 🚫 validar stock
if ($producto["stock"] <= 0) {
    die("Sin stock disponible");
}

// 🧠 verificar si ya existe
$sql = "SELECT id, cantidad
        FROM carrito
        WHERE usuario_id = ?
        AND producto_nombre = ?
        AND estado = 'activo'
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $usuario_id, $producto["nombre"]);
$stmt->execute();

$result = $stmt->get_result();

// ➕ actualizar cantidad
if ($row = $result->fetch_assoc()) {

    $nuevaCantidad = $row["cantidad"] + 1;

    $sql = "UPDATE carrito
            SET cantidad = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nuevaCantidad, $row["id"]);
    $stmt->execute();

} else {

    // 🆕 insertar producto
    $sql = "INSERT INTO carrito
    (
        usuario_id,
        producto_nombre,
        producto_precio,
        producto_imagen,
        cantidad,
        estado
    )
    VALUES
    (
        ?, ?, ?, ?, 1, 'activo'
    )";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isds",
        $usuario_id,
        $producto["nombre"],
        $producto["precio"],
        $producto["imagen"]
    );

    $stmt->execute();
}

// 🔁 regresar al carrito
header("Location: ver_carrito.php");
exit;
?>