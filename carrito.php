<?php
session_start();
require_once 'config/db.php';

$usuario_id = $_SESSION['usuario_id'] ?? 0;

$sql = "SELECT * FROM carrito 
        WHERE usuario_id = $usuario_id 
        AND estado = 'activo'";

$result = $conn->query($sql);

$total = 0;
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Carrito de compras | Phandora</title>
<meta name="description" content="Revisa tu carrito de compras en Phandora. Productos seleccionados listos para finalizar tu pedido.">

<link rel="shortcut icon" href="img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/interfaz.css">

<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }
.card-carrito img { width: 110px; height: 110px; object-fit: cover; }
</style>
</head>

<body class="bg-dark">

<?php include 'includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">

<h1 class="fw-bolder text-white mb-4">Tu carrito</h1>

<?php if ($result->num_rows == 0): ?>

  <div class="card bg-dark border-0 shadow rounded-4">
    <div class="card-body p-5 text-center text-white">
      Tu carrito está vacío
    </div>
  </div>

<?php else: ?>

<?php while($item = $result->fetch_assoc()): 
$total += $item["producto_precio"] * $item["cantidad"];
?>

<div class="card bg-dark border-0 shadow rounded-4 mb-4 card-carrito">

  <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div class="d-flex align-items-center gap-4">

      <img src="img/<?= $item["producto_imagen"] ?? 'default.png' ?>" class="rounded-3">

      <div>
        <h4 class="text-white mb-1">
          <?= htmlspecialchars($item["producto_nombre"]) ?>
        </h4>

        <p class="text-white-50 mb-0">
          Cantidad: <?= $item["cantidad"] ?>
        </p>
      </div>

    </div>

    <div class="text-end">
      <h5 class="text-white">
        $<?= number_format($item["producto_precio"] * $item["cantidad"], 2) ?> MXN
      </h5>

      <a href="carrito/eliminar_carrito.php?id=<?= $item["id"] ?>"
         class="btn btn-sm btn-outline-light">
        Eliminar
      </a>
    </div>

  </div>
</div>

<?php endwhile; ?>

<!-- TOTAL -->
<div class="card bg-dark border-0 shadow rounded-4 mt-4">
  <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

    <h3 class="text-white m-0">
      Total: $<?= number_format($total, 2) ?> MXN
    </h3>

    <div>
      <a href="carrito/vaciar_carrito.php" class="btn btn-outline-light me-2">
        Vaciar carrito
      </a>

      <a href="checkout.php" class="btn btn-light">
        Finalizar compra
      </a>
    </div>

  </div>
</div>

<?php endif; ?>

</div>
</section>

</body>
</html>