<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$productos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()["total"];
$usuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()["total"];
$pedidos = $conn->query("SELECT COUNT(*) AS total FROM pedidos")->fetch_assoc()["total"];

$totalVentas = $conn->query("
    SELECT COALESCE(SUM(total),0) AS total
    FROM pedidos
")->fetch_assoc()["total"];

$ultimosPedidos = $conn->query("
    SELECT p.id, u.nombre, p.total, p.estado, p.fecha
    FROM pedidos p
    INNER JOIN usuarios u ON p.usuario_id = u.id
    ORDER BY p.id DESC
    LIMIT 5
");
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Panel de administración - Phandora</title>

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">
</head>

<body>

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container">

  <h1 class="text-white fw-bold mb-4">Panel de administración</h1>

  <div class="row g-4 mb-5">

    <div class="col-md-3">
      <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-4">
          <h6 class="text-white-50">Productos</h6>
          <h2 class="fw-bold"><?= $productos ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-4">
          <h6 class="text-white-50">Usuarios</h6>
          <h2 class="fw-bold"><?= $usuarios ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-4">
          <h6 class="text-white-50">Pedidos</h6>
          <h2 class="fw-bold"><?= $pedidos ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-4">
          <h6 class="text-white-50">Ventas</h6>
          <h2 class="fw-bold">$<?= number_format($totalVentas, 2) ?></h2>
        </div>
      </div>
    </div>

  </div>

  <div class="card bg-dark text-white border-0 shadow rounded-4">
    <div class="card-body p-4">

      <h4 class="mb-4">Últimos pedidos</h4>

      <?php if ($ultimosPedidos->num_rows > 0): ?>

        <div class="table-responsive">
          <table class="table table-dark table-hover align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>

            <?php while($p = $ultimosPedidos->fetch_assoc()): ?>
              <tr>
                <td>#<?= $p["id"] ?></td>
                <td><?= htmlspecialchars($p["nombre"]) ?></td>
                <td>$<?= number_format($p["total"], 2) ?></td>
                <td><?= ucfirst($p["estado"]) ?></td>
                <td><?= $p["fecha"] ?></td>
              </tr>
            <?php endwhile; ?>

            </tbody>
          </table>
        </div>

      <?php else: ?>

        <p class="text-white-50 mb-0">Aún no hay pedidos registrados.</p>

      <?php endif; ?>

    </div>
  </div>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>