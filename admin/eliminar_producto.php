<?php
session_start();
require_once '../config/db.php';

/* 🔒 solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

/* validar id */
if (!isset($_GET["id"])) {
    header("Location: productos.php");
    exit;
}

$id = intval($_GET["id"]);

/* obtener producto */
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    header("Location: productos.php");
    exit;
}

/* eliminar */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: productos.php");
    exit;
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Eliminar producto - Phandora</title>

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">
</head>

<body>

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">
<div class="row justify-content-center">
<div class="col-lg-7">

    <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-5">

            <h1 class="fw-bolder mb-4">Eliminar producto</h1>

            <p class="text-white-50 mb-4">
                Estás a punto de eliminar este producto de forma permanente.
            </p>

            <div class="card bg-black border-0 rounded-4 mb-4">
                <div class="card-body p-4">

                    <h3 class="mb-2">
                        <?= htmlspecialchars($producto["nombre"]) ?>
                    </h3>

                    <p class="mb-2 text-white-50">
                        <?= htmlspecialchars($producto["descripcion"]) ?>
                    </p>

                    <h5 class="mb-0">
                        $<?= number_format($producto["precio"], 2) ?> MXN
                    </h5>

                </div>
            </div>

            <form method="POST" class="d-flex gap-2">

                <button
                    type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                    Eliminar definitivamente
                </button>

                <a href="productos.php" class="btn btn-outline-light">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>