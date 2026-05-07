<?php
require_once 'config/db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'cliente')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error al registrar";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Phandora - Registro</title>

  <link rel="shortcut icon" href="img/logo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/interfaz.css" />
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

      <div class="card bg-dark text-white shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

          <h2 class="text-center mb-4">Crear cuenta</h2>

          <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger">
              <?= $mensaje ?>
            </div>
          <?php endif; ?>

          <form action="registro.php" method="POST">

            <div class="mb-3">
              <label class="form-label">Nombre de usuario</label>
              <input type="text" class="form-control" name="nombre" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" name="password2" required>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-2">
              Registrarse
            </button>

            <div class="text-center mt-3">
              <small>
                ¿Ya tienes cuenta?
                <a href="login.php" class="text-info">Inicia sesión</a>
              </small>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>

</div>

<footer class="bg-dark py-4 mt-auto">
  <div class="container px-5">
    <div class="row align-items-center justify-content-between flex-column flex-sm-row">
      <div class="col-auto">
        <div class="small m-0 text-white">Phandora</div>
      </div>
      <div class="col-auto">
        <a class="small" href="#">GitHub</a>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>