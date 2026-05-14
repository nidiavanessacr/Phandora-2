<?php
session_start();
require_once '../config/db.php';

// validar admin
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

// productos
$productos = $conn->query("
    SELECT COUNT(*) AS total 
    FROM productos
")->fetch_assoc()["total"];

// usuarios
$usuarios = $conn->query("
    SELECT COUNT(*) AS total 
    FROM usuarios
")->fetch_assoc()["total"];

// pedidos comprados
$pedidos = $conn->query("
    SELECT COUNT(*) AS total 
    FROM carrito
    WHERE estado='comprado'
")->fetch_assoc()["total"];

// ventas
$totalVentas = $conn->query("
    SELECT COALESCE(SUM(total),0) AS total
    FROM carrito
    WHERE estado='comprado'
")->fetch_assoc()["total"];

// últimos pedidos
$ultimosPedidos = $conn->query("
    SELECT 
        c.*,
        u.nombre AS usuario_nombre
    FROM carrito c
    INNER JOIN usuarios u
    ON c.usuario_id = u.id
    WHERE c.estado='comprado'
    ORDER BY c.fecha DESC
    LIMIT 5
");
?>

<!doctype html>
<html lang="es">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
Panel de administración - Phandora
</title>

<link rel="shortcut icon" href="../img/logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../css/interfaz.css">

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}

.card-dashboard{
    background:#1c1c1c;
    color:white;
    border:none;
    border-radius:24px;
}

.table-dark{
    border-radius:20px;
    overflow:hidden;
}

.badge-ph{
    padding:.5rem .9rem;
    border-radius:20px;
    font-weight:600;
}
</style>

</head>

<body class="bg-dark text-white">

<?php include '../includes/navbar.php'; ?>

<section class="py-5">

<div class="container">

<h1 class="fw-bold mb-5">
    Panel de administración
</h1>

<!-- CARDS -->
<div class="row g-4 mb-5">

<div class="col-md-3">

<div class="card card-dashboard shadow">

<div class="card-body p-4">

<h6 class="text-white-50">
    Productos
</h6>

<h2 class="fw-bold">
    <?= $productos ?>
</h2>

</div>
</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard shadow">

<div class="card-body p-4">

<h6 class="text-white-50">
    Usuarios
</h6>

<h2 class="fw-bold">
    <?= $usuarios ?>
</h2>

</div>
</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard shadow">

<div class="card-body p-4">

<h6 class="text-white-50">
    Pedidos realizados
</h6>

<h2 class="fw-bold">
    <?= $pedidos ?>
</h2>

</div>
</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard shadow">

<div class="card-body p-4">

<h6 class="text-white-50">
    Ventas totales
</h6>

<h2 class="fw-bold">
    $<?= number_format($totalVentas, 2) ?> MXN
</h2>

</div>
</div>
</div>

</div>

<!-- ÚLTIMOS PEDIDOS -->
<div class="card card-dashboard shadow">

<div class="card-body p-4">

<h3 class="mb-4">
    Últimos pedidos
</h3>

<?php if ($ultimosPedidos->num_rows > 0): ?>

<div class="table-responsive">

<table class="table table-dark table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>Cliente</th>
<th>Producto</th>
<th>Total</th>
<th>Método</th>
<th>Envío</th>
<th>Estado</th>
<th>Fecha</th>

</tr>

</thead>

<tbody>

<?php while($p = $ultimosPedidos->fetch_assoc()): ?>

<tr>

<td>
#<?= $p["id"] ?>
</td>

<td>
<?= htmlspecialchars($p["usuario_nombre"]) ?>
</td>

<td>
<?= htmlspecialchars($p["producto_nombre"]) ?>
</td>

<td>
$<?= number_format($p["total"], 2) ?> MXN
</td>

<td>
<?= htmlspecialchars($p["metodo_pago"] ?? 'No especificado') ?>
</td>

<td>

<?php if(!empty($p["direccion"])): ?>

<span class="badge bg-info text-dark badge-ph">
    Envío
</span>

<?php else: ?>

<span class="badge bg-secondary badge-ph">
    Local
</span>

<?php endif; ?>

</td>

<td>

<span class="badge bg-success badge-ph">
    Comprado
</span>

</td>

<td>
<?= $p["fecha"] ?>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php else: ?>

<p class="text-white-50 mb-0">
    Aún no hay pedidos registrados.
</p>

<?php endif; ?>

</div>

</div>

</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>