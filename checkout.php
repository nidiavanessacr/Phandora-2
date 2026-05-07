<?php
session_start();
require_once "config/db.php";

// 🔒 validar login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🔎 obtener carrito activo desde BD (NO sesión)
$sql = "SELECT * 
        FROM carrito 
        WHERE usuario_id = ? 
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: carrito.php");
    exit;
}

$conn->begin_transaction();

try {

    $total = 0;

    // 🔥 calcular total primero
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $subtotal = $row["producto_precio"] * $row["cantidad"];
        $total += $subtotal;
        $items[] = $row;
    }

    // 🧾 crear pedido
    $sql = "INSERT INTO pedidos (usuario_id, total, estado)
            VALUES (?, ?, 'pendiente')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $usuario_id, $total);
    $stmt->execute();

    $pedido_id = $stmt->insert_id;

    // 📦 insertar detalle_pedido
    foreach ($items as $item) {

        // 🔎 obtener producto_id real
        $sql = "SELECT id FROM productos WHERE nombre = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $item["producto_nombre"]);
        $stmt->execute();
        $res = $stmt->get_result();
        $prod = $res->fetch_assoc();

        $producto_id = $prod["id"] ?? null;

        if (!$producto_id) continue;

        $sql = "INSERT INTO detalle_pedido 
        (pedido_id, producto_id, cantidad, precio)
        VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "iiid",
            $pedido_id,
            $producto_id,
            $item["cantidad"],
            $item["producto_precio"]
        );

        $stmt->execute();

        // 🧹 marcar carrito como comprado
        $sql = "UPDATE carrito 
                SET estado = 'comprado' 
                WHERE id = ?";

        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("i", $item["id"]);
        $stmt2->execute();
    }

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    die("Error en checkout: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">

<title>Compra confirmada - Phandora</title>
<meta name="description" content="Tu compra en Phandora ha sido procesada correctamente.">

<link rel="shortcut icon" href="img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
</head>

<body class="bg-dark text-white">

<?php include "includes/navbar.php"; ?>

<div class="container py-5 text-center">

    <h1 class="mb-3">🎉 ¡Compra realizada con éxito!</h1>

    <p class="mb-4">
        Tu pedido ha sido registrado correctamente y está en estado <b>pendiente</b>.
    </p>

    <div class="mb-4">
        <h4>Total pagado: $<?= number_format($total, 2) ?> MXN</h4>
        <p class="text-white-50">Gracias por tu compra en Phandora</p>
    </div>

    <a href="main.php" class="btn btn-success me-2">
        Volver a la tienda
    </a>

    <a href="carrito.php" class="btn btn-outline-light">
        Ver carrito
    </a>

</div>

</body>
</html>