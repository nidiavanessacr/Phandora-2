<?php
session_start();
require_once "../config/db.php";
include "../includes/admin_auth.php";

// TOTAL PEDIDOS
$totalPedidos = $conn->query("
    SELECT COUNT(*) as total 
    FROM carrito
    WHERE estado='comprado'
")->fetch_assoc()["total"];

// PENDIENTES
$pendientes = $conn->query("
    SELECT COUNT(*) as total 
    FROM carrito
    WHERE estado='activo'
")->fetch_assoc()["total"];

// COMPRADOS
$comprados = $conn->query("
    SELECT COUNT(*) as total 
    FROM carrito
    WHERE estado='comprado'
")->fetch_assoc()["total"];

// VENTAS
$ventas = $conn->query("
    SELECT SUM(total) as total 
    FROM carrito
    WHERE estado='comprado'
")->fetch_assoc()["total"];

if (!$ventas) {
    $ventas = 0;
}

// GRÁFICA
$grafica = $conn->query("
    SELECT DATE(fecha) as dia,
           SUM(total) as total
    FROM carrito
    WHERE estado='comprado'
    GROUP BY DATE(fecha)
    ORDER BY fecha DESC
    LIMIT 7
");

$dias = [];
$totales = [];

while ($row = $grafica->fetch_assoc()) {

    $dias[] = $row["dia"];
    $totales[] = $row["total"];
}

$dias = array_reverse($dias);
$totales = array_reverse($totales);

// PEDIDOS
$pedidos = $conn->query("
    SELECT c.*, u.nombre AS usuario_nombre
    FROM carrito c
    INNER JOIN usuarios u 
    ON c.usuario_id = u.id
    WHERE c.estado='comprado'
    ORDER BY c.fecha DESC
");
?>

<!doctype html>
<html lang="es">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
Admin Pedidos - Phandora
</title>

<link rel="shortcut icon" href="../img/logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}

.card-dashboard{
    border:none;
    border-radius:22px;
}

.table-dark{
    border-radius:20px;
    overflow:hidden;
}

.badge-ph{
    padding:.6rem .9rem;
    border-radius:20px;
    font-weight:600;
}
</style>

</head>

<body class="bg-dark text-white">

<?php include "../includes/navbar.php"; ?>

<div class="container py-5">

<h1 class="fw-bold mb-5">
    Dashboard Admin
</h1>

<!-- CARDS -->
<div class="row g-4 mb-5">

<div class="col-md-3">

<div class="card card-dashboard bg-primary text-white p-4 shadow">

<h5>
Total pedidos
</h5>

<h2>
<?= $totalPedidos ?>
</h2>

</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard bg-warning text-dark p-4 shadow">

<h5>
Pendientes
</h5>

<h2>
<?= $pendientes ?>
</h2>

</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard bg-success text-white p-4 shadow">

<h5>
Comprados
</h5>

<h2>
<?= $comprados ?>
</h2>

</div>
</div>

<div class="col-md-3">

<div class="card card-dashboard bg-info text-dark p-4 shadow">

<h5>
Ventas
</h5>

<h2>
$<?= number_format($ventas,2) ?> MXN
</h2>

</div>
</div>

</div>

<!-- GRÁFICA -->
<div class="card bg-dark border-light p-4 rounded-4 mb-5 shadow">

<h4 class="mb-4">
    Ventas recientes
</h4>

<canvas id="ventasChart"></canvas>

</div>

<!-- TABLA -->
<div class="card bg-dark border-light rounded-4 shadow">

<div class="card-body p-4">

<h3 class="mb-4">
    Pedidos realizados
</h3>

<div class="table-responsive">

<table class="table table-dark align-middle">

<thead>

<tr>

<th>ID</th>
<th>Cliente</th>
<th>Producto</th>
<th>Total</th>
<th>Método pago</th>
<th>Ciudad</th>
<th>Dirección</th>
<th>Estado</th>
<th>Fecha</th>

</tr>

</thead>

<tbody>

<?php while($p = $pedidos->fetch_assoc()): ?>

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
$<?= number_format($p["total"],2) ?> MXN
</td>

<td>
<?= htmlspecialchars($p["metodo_pago"] ?? 'No especificado') ?>
</td>

<td>
<?= htmlspecialchars($p["ciudad"] ?? 'Local') ?>
</td>

<td style="min-width:220px;">

<?= htmlspecialchars($p["direccion"] ?? 'Sin dirección') ?>

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
</div>
</div>

</div>

<script>
const ctx = document.getElementById('ventasChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: <?= json_encode($dias) ?>,

        datasets: [{
            label: 'Ventas ($)',
            data: <?= json_encode($totales) ?>,
            borderWidth: 2
        }]
    },

    options: {

        responsive: true,

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>