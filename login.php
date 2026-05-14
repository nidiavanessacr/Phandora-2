<?php
session_start();
require_once 'config/db.php';

$error = "";

/* si ya está logueado */
if (isset($_SESSION['usuario_id'])) {
  header("Location: main.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $error = "Completa todos los campos";
  } else {

    $sql = "SELECT id, nombre, email, password, rol 
            FROM usuarios 
            WHERE email = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

      /* SESIÓN UNIFICADA (NAVBAR) */
      $_SESSION['usuario_id'] = $user['id'];
      $_SESSION['usuario_nombre'] = $user['nombre'];
      $_SESSION['rol'] = $user['rol'];

      if ($user['rol'] === 'admin') {
        header("Location: admin/dashboard.php");
      } else {
        header("Location: main.php");
      }
      exit();

    } else {
      $error = "Credenciales incorrectas";
    }
  }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Phandora - Login</title>

  <link rel="shortcut icon" href="img/logo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/interfaz.css" />
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <!--  DISEÑO ORIGINAL SIN CAMBIOS -->
      <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-4">

        <h3 class="text-center mb-4">Iniciar sesión</h3>

        <?php if ($error != ""): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">

          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button class="btn btn-success w-100">
            Iniciar sesión
          </button>

          <div class="text-center mt-3">
            <a href="registro.php" class="text-info">Crear cuenta</a>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>