<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Phandora</title>

  <link rel="shortcut icon" href="img/logo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="css/interfaz.css">
</head>

<body>

  <!-- Barra superior -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="main.php">
        <img src="img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
        Phandora
      </a>
    </div>
  </nav>

  <!-- Menú -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="login.php">Inicio de Sesión</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">

          <li class="nav-item">
            <a class="nav-link" href="main.php">Principal</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="coleccionable.php">Coleccionables</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="consumible.php">Consumibles</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="carrito.php">Carrito</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="login.php">Iniciar Sesión</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <h1 class="text-white">Bienvenido a Phandora</h1>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>