<?php
session_start();
require_once "../config/db.php";
include "../includes/admin_auth.php";

// Total pedidos
$totalPedidos = $conn->query("SELECT COUNT(*) as total FROM carrito")->fetch_assoc()["total"];

// Pendientes
$pendientes = $conn->query("SELECT COUNT(*) as total FROM carrito WHERE estado='activo'")->fetch_assoc()["total"];

// Enviados
$enviados = $conn->query("SELECT COUNT(*) as total FROM carrito WHERE estado='comprado'")->fetch_assoc()["total"];

// Ventas totales
$ventas = $conn->query("SELECT SUM(producto_precio * cantidad) as total FROM carrito WHERE estado='comprado'")->fetch_assoc()["total"];
if (!$ventas) $ventas = 0;

// últimos 7 registros (simulación de ventas)
$grafica = $conn->query("
    SELECT DATE(fecha) as dia, SUM(producto_precio * cantidad) as total
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
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Admin Dashboard - Phandora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-dark text-white">

<div class="container py-5">

<h1 class="mb-4">Dashboard Admin</h1>

<!-- CARDS -->
<div class="row g-4 mb-5">

  <div class="col-md-3">
    <div class="card bg-primary text-white p-3 rounded-4">
      <h5>Total pedidos</h5>
      <h2><?= $totalPedidos ?></h2>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-warning text-dark p-3 rounded-4">
      <h5>Pendientes</h5>
      <h2><?= $pendientes ?></h2>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-success text-white p-3 rounded-4">
      <h5>Enviados</h5>
      <h2><?= $enviados ?></h2>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-info text-dark p-3 rounded-4">
      <h5>Ventas</h5>
      <h2>$<?= number_format($ventas,2) ?></h2>
    </div>
  </div>

</div>

<!-- GRÁFICA -->
<div class="card bg-dark border-light p-4 rounded-4">
  <h4 class="mb-3">Ventas recientes</h4>
  <canvas id="ventasChart"></canvas>
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
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>