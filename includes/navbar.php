<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Detectar si estamos dentro de /admin
|--------------------------------------------------------------------------
*/
$enAdmin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;

$base = $enAdmin ? '../' : '';

$usuario = $_SESSION["usuario_nombre"] ?? null;
$logueado = isset($_SESSION["usuario_id"]);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">

    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $base ?>main.php">
      <img src="<?= $base ?>img/logo.png" width="32" height="32" alt="Phandora">
      <span>Phandora</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav ms-auto align-items-lg-center gap-2">

        <li class="nav-item">
          <a class="nav-link" href="<?= $base ?>main.php">Inicio</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= $base ?>coleccionable.php">Coleccionables</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= $base ?>consumible.php">Consumibles</a>
        </li>

        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-1" href="<?= $base ?>carrito.php">
            <i class="bi bi-cart3 fs-5"></i>
            Carrito
          </a>
        </li>

        <?php if ($logueado): ?>

          <li class="nav-item">
            <span class="nav-link text-white">
              👤 <?= htmlspecialchars($usuario) ?>
            </span>
          </li>

          <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
            <li class="nav-item">
              <a class="nav-link text-warning" href="<?= $base ?>admin/dashboard.php">
                Admin
              </a>
            </li>
          <?php endif; ?>

          <li class="nav-item">
            <a class="nav-link text-danger fw-semibold d-flex align-items-center gap-1" href="<?= $base ?>logout.php">
              <i class="bi bi-box-arrow-right"></i>
              Cerrar sesión
            </a>
          </li>

        <?php else: ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>login.php">
              Iniciar sesión
            </a>
          </li>

        <?php endif; ?>

      </ul>

    </div>

  </div>
</nav>