<?php
session_start();
require_once '../config/db.php';

// 🔒 seguridad
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🔎 obtener carrito activo
$sql = "SELECT * 
        FROM carrito 
        WHERE usuario_id = ? 
        AND estado = 'activo'
        ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Phandora - Tu carrito</title>
<meta name="description" content="Revisa los productos que has agregado a tu carrito en Phandora.">

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">

<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }
.producto-img { width: 110px; height: 110px; object-fit: cover; border-radius: 12px; }
.card-carrito { background: #1c1c1c; color: white; }
</style>
</head>

<body class="bg-dark">

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">

<h1 class="fw-bolder text-white mb-4">Tu carrito</h1>

<?php if ($result->num_rows == 0): ?>

    <div class="card card-carrito border-0 shadow rounded-4">
        <div class="card-body p-5 text-center">
            <h4 class="text-white">Tu carrito está vacío</h4>
            <p class="text-white-50">Agrega productos para comenzar tu compra</p>
        </div>
    </div>

<?php else: ?>

    <?php while($row = $result->fetch_assoc()): ?>

        <?php $subtotal = $row["producto_precio"] * $row["cantidad"]; ?>
        <?php $total += $subtotal; ?>

        <div class="card card-carrito border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">
                    <img 
                        src="../img/<?= htmlspecialchars($row["producto_imagen"] ?? 'default.png') ?>" 
                        class="producto-img"
                        alt="<?= htmlspecialchars($row["producto_nombre"]) ?>"
                    >

                    <div>
                        <h4 class="mb-1"><?= htmlspecialchars($row["producto_nombre"]) ?></h4>
                        <p class="text-white-50 mb-0">
                            Cantidad: <?= $row["cantidad"] ?>
                        </p>
                    </div>
                </div>

                <div class="text-end">
                    <p class="mb-1">
                        $<?= number_format($row["producto_precio"], 2) ?> x <?= $row["cantidad"] ?>
                    </p>

                    <h5 class="mb-3">
                        Subtotal: $<?= number_format($subtotal, 2) ?> MXN
                    </h5>

                    <form action="eliminar_carrito.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Eliminar
                        </button>
                    </form>
                </div>

            </div>
        </div>

    <?php endwhile; ?>

    <div class="card card-carrito border-0 shadow rounded-4 mt-4">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <h3 class="m-0">Total: $<?= number_format($total, 2) ?> MXN</h3>

            <a href="../checkout.php" class="btn btn-light">
                Finalizar compra
            </a>

        </div>
    </div>

<?php endif; ?>

</div>
</section>

</body>
</html>