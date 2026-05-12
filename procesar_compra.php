<?php
session_start();
require_once 'config/db.php';

// 🔒 validar sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🔒 validar método POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: checkout.php");
    exit;
}

// 📥 obtener datos del formulario
$metodo_pago = $_POST["metodo_pago"] ?? '';
$direccion = $_POST["direccion"] ?? '';
$ciudad = $_POST["ciudad"] ?? '';
$codigo_postal = $_POST["codigo_postal"] ?? '';

if (empty($metodo_pago)) {
    die("Método de pago inválido");
}

// 🛒 obtener carrito activo
$sql = "SELECT * FROM carrito
        WHERE usuario_id = ?
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows <= 0) {
    die("No hay productos en el carrito");
}

$total = 0;

// 📦 procesar productos
while($producto = $result->fetch_assoc()){

    $subtotal = $producto["producto_precio"] * $producto["cantidad"];
    $total += $subtotal;

    // 🔻 descontar stock
    $sqlStock = "UPDATE productos
                 SET stock = stock - ?
                 WHERE nombre = ?
                 AND stock >= ?";

    $stmtStock = $conn->prepare($sqlStock);

    $stmtStock->bind_param(
        "isi",
        $producto["cantidad"],
        $producto["producto_nombre"],
        $producto["cantidad"]
    );

    $stmtStock->execute();
}

// 💰 impuestos
$iva = $total * 0.16;
$total_final = $total + $iva;

// ✅ actualizar carrito como comprado
$sql = "UPDATE carrito
        SET estado = 'comprado',
            metodo_pago = ?,
            direccion = ?,
            ciudad = ?,
            codigo_postal = ?,
            total = ?,
            fecha = NOW()
        WHERE usuario_id = ?
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssdi",
    $metodo_pago,
    $direccion,
    $ciudad,
    $codigo_postal,
    $total_final,
    $usuario_id
);

$stmt->execute();

?>

<!doctype html>
<html lang="es">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
Compra confirmada - Phandora
</title>

<link rel="shortcut icon" href="img/logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- ✨ ESTILO GENERAL DE PHANDORA -->
<link rel="stylesheet" href="css/interfaz.css">

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}

/* ✨ tarjeta principal */
.card-confirmacion{
    background:rgba(28,28,28,.90);
    border:none;
    border-radius:28px;
    backdrop-filter:blur(8px);
    color:white;
}

/* ✨ forzar texto claro */
.card-confirmacion h1,
.card-confirmacion h2,
.card-confirmacion h3,
.card-confirmacion h4,
.card-confirmacion h5,
.card-confirmacion p,
.card-confirmacion strong,
.card-confirmacion li{
    color:white !important;
}

/* ✨ subtítulos suaves */
.text-phandora{
    color:#f8d4ff !important;
}

/* ✨ alert términos */
.alert{
    background:#232323;
    border:none;
    color:white;
    border-radius:20px;
}

/* ✨ líneas */
hr{
    border-color:rgba(255,255,255,.12);
}

/* ✨ botón */
.btn-light{
    border-radius:14px;
    font-weight:600;
}
</style>

</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-7">

<div class="card-confirmacion shadow p-5 text-center">

<h1 class="fw-bold mb-4">
    ¡Compra confirmada!
</h1>

<p class="mb-4" style="color:#f8d4ff;">
    Gracias por comprar en Phandora.
</p>

<hr class="border-secondary">

<div class="text-start mt-4">

<h4 class="mb-3">
    Resumen de compra
</h4>

<p>
<strong>Método de pago:</strong>
<?= htmlspecialchars($metodo_pago) ?>
</p>

<?php if(!empty($direccion)): ?>

<p>
<strong>Dirección:</strong>
<?= htmlspecialchars($direccion) ?>
</p>

<p>
<strong>Ciudad:</strong>
<?= htmlspecialchars($ciudad) ?>
</p>

<p>
<strong>Código postal:</strong>
<?= htmlspecialchars($codigo_postal) ?>
</p>

<?php else: ?>

<p>
<strong>Entrega:</strong>
Entrega local
</p>

<?php endif; ?>

<hr class="border-secondary">

<p>
<strong>Subtotal:</strong>
$<?= number_format($total,2) ?> MXN
</p>

<p>
<strong>IVA (16%):</strong>
$<?= number_format($iva,2) ?> MXN
</p>

<h3 class="mt-4">
Total pagado:
$<?= number_format($total_final,2) ?> MXN
</h3>

</div>

<div class="alert alert-secondary mt-4 text-start">

<h5>
Términos y condiciones
</h5>

<ul class="mb-0">

<li>
Todos los pagos son simulados con fines académicos.
</li>

<li>
Todos los precios están expresados en pesos mexicanos (MXN).
</li>

<li>
Los tiempos de entrega pueden variar según el tipo de producto.
</li>

<li>
Los productos coleccionables y no perecederos pueden requerir envío físico.
</li>

</ul>

</div>

<a href="main.php" class="btn btn-light mt-4">
Volver al inicio
</a>

</div>

</div>

</div>

</div>

</body>
</html>