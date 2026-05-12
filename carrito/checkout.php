<?php
session_start();
require_once "../config/db.php";

// 🔒 validar login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🛒 obtener carrito activo
$sql = "SELECT * 
        FROM carrito
        WHERE usuario_id = ?
        AND estado = 'activo'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();

$carrito = [];

$subtotal = 0;
$tieneEnvio = false;

while($item = $result->fetch_assoc()){

    $carrito[] = $item;

    $subtotal += $item["producto_precio"] * $item["cantidad"];

    // 🔎 detectar productos con envío
    $nombre = strtolower($item["producto_nombre"]);

    if(
        str_contains($nombre, 'figura') ||
        str_contains($nombre, 'peluche') ||
        str_contains($nombre, 'llavero') ||
        str_contains($nombre, 'mochila') ||
        str_contains($nombre, 'coleccion')
    ){
        $tieneEnvio = true;
    }
}

// 🚫 carrito vacío
if(empty($carrito)){
    header("Location: ver_carrito.php");
    exit;
}

$iva = $subtotal * 0.16;

$costoEnvio = 0;

/*
    CASO 1:
    Productos que siempre requieren envío
*/
if($tieneEnvio){
    $costoEnvio = 80;
}

/*
    CASO 2:
    Solo aplica si NO es envío obligatorio
*/
if(!$tieneEnvio && isset($_POST['tipo_entrega']) && $_POST['tipo_entrega'] == 'domicilio'){
    $costoEnvio = 50;
}

$totalFinal = $subtotal + $iva + $costoEnvio;
?>

<!doctype html>
<html lang="es">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
Checkout - Phandora
</title>

<link rel="shortcut icon" href="../img/logo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../css/interfaz.css">

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}

.card-dark{
    background:#1c1c1c;
    color:white;
    border:none;
}

.form-control,
.form-select{
    background:#2b2b2b;
    border:none;
    color:white;
}

.form-control:focus,
.form-select:focus{
    background:#2b2b2b;
    color:white;
    box-shadow:none;
}

.resumen{
    position: sticky;
    top: 20px;
    z-index: 1;
}
</style>

</head>

<body class="bg-dark text-white">

<?php include "../includes/navbar.php"; ?>

<section class="py-5">

<div class="container">

<h1 class="fw-bold mb-5">
    Finalizar compra
</h1>

<form action="../procesar_compra.php" method="POST">

<div class="row g-4 align-items-start">

<!-- FORMULARIO -->
<div class="col-lg-7">

<!-- MÉTODO PAGO -->
<div class="card card-dark rounded-4 shadow p-4 mb-4">

<h3 class="mb-4">
    Método de pago
</h3>

<div class="mb-3">

<label class="form-label">
    Selecciona un método
</label>

<select 
name="metodo_pago" 
class="form-select"
required
>

<option value="">
    Selecciona...
</option>

<option value="Mercado Pago">
    Mercado Pago
</option>

<option value="PayPal">
    PayPal
</option>

<option value="Tarjeta de crédito">
    Tarjeta de crédito
</option>

<option value="Tarjeta de débito">
    Tarjeta de débito
</option>

</select>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
    Número de tarjeta
</label>

<input 
type="text"
name="numero_tarjeta"
class="form-control"
placeholder="1234 5678 9012 3456"
>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
    MM/AA
</label>

<input 
type="text"
name="expiracion"
class="form-control"
placeholder="08/28"
>

</div>

<div class="col-md-3 mb-3">

<label class="form-label">
    CVV
</label>

<input 
type="text"
name="cvv"
class="form-control"
placeholder="123"
>

</div>

</div>

</div>

<!-- ENVÍO -->
<div class="card card-dark rounded-4 shadow p-4 mb-4">

<h3 class="mb-4">
    Tipo de entrega
</h3>

<?php if($tieneEnvio): ?>

<p class="text-white-50">
    Algunos productos requieren envío físico.
</p>

<input type="hidden" name="tipo_entrega" value="envio">

<div id="datosEnvio">

    <div class="mb-3">

        <label class="form-label">
            Dirección
        </label>

        <input 
        type="text"
        name="direccion"
        class="form-control"
        placeholder="Calle y número"
        required
        >

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="form-label">
                Ciudad
            </label>

            <input 
            type="text"
            name="ciudad"
            class="form-control"
            placeholder="Ciudad"
            required
            >

        </div>

        <div class="col-md-6 mb-3">

            <label class="form-label">
                Código postal
            </label>

            <input 
            type="text"
            name="codigo_postal"
            class="form-control"
            placeholder="00000"
            required
            >

        </div>

    </div>

</div>

<?php else: ?>

<div class="form-check mb-3">

<input 
class="form-check-input"
type="radio"
name="tipo_entrega"
value="tienda"
checked
>

<label class="form-check-label">
    Recoger en tienda
</label>

</div>

<div class="form-check mb-4">

<input 
class="form-check-input"
type="radio"
name="tipo_entrega"
value="domicilio"
>

<label class="form-check-label">
    Servicio a domicilio (+$50 MXN)
</label>

</div>

<div id="datosEnvio" style="display:none;">

    <div class="mb-3">

        <label class="form-label">
            Dirección
        </label>

        <input 
        type="text"
        name="direccion"
        class="form-control"
        placeholder="Calle y número"
        >

    </div>

    <div class="row">

        <div class="col-md-6 mb-3">

            <label class="form-label">
                Ciudad
            </label>

            <input 
            type="text"
            name="ciudad"
            class="form-control"
            placeholder="Ciudad"
            >

        </div>

        <div class="col-md-6 mb-3">

            <label class="form-label">
                Código postal
            </label>

            <input 
            type="text"
            name="codigo_postal"
            class="form-control"
            placeholder="00000"
            >

        </div>

    </div>

</div>

<?php endif; ?>

</div>

</div>

<!-- TÉRMINOS -->
<div class="card card-dark rounded-4 shadow p-4 mb-4">

<h3 class="mb-3">
    Términos y condiciones
</h3>

<ul class="text-white-50">

<li>
Todos los precios están expresados en MXN.
</li>

<li>
Los pagos son simulados para fines académicos.
</li>

<li>
Los tiempos de entrega pueden variar.
</li>

<li>
Los productos físicos pueden requerir envío.
</li>

</ul>

<div class="form-check mt-4">

<input 
class="form-check-input"
type="checkbox"
required
>

<label class="form-check-label">
    Acepto los términos y condiciones
</label>

</div>

</div>

</div>

<!-- RESUMEN -->
<div class="col-lg-5">

<div class="card card-dark rounded-4 shadow p-4 resumen">

<h3 class="mb-4">
    Resumen del pedido
</h3>

<?php foreach($carrito as $item): ?>

<div class="d-flex justify-content-between mb-3">

<div>

<strong>
<?= htmlspecialchars($item["producto_nombre"]) ?>
</strong>

<br>

<small class="text-white-50">
Cantidad:
<?= $item["cantidad"] ?>
</small>

</div>

<div>

$<?= number_format(
$item["producto_precio"] * $item["cantidad"],
2
) ?>

</div>

</div>

<?php endforeach; ?>

<hr>

<div class="d-flex justify-content-between mb-2">

<span>
Subtotal
</span>

<span>
$<?= number_format($subtotal,2) ?> MXN
</span>

</div>

<div class="d-flex justify-content-between mb-2 text-white-50">

<span>
IVA (16%)
</span>

<span>
$<?= number_format($iva,2) ?> MXN
</span>

</div>

<hr>

<div class="d-flex justify-content-between fs-4 fw-bold">

<span>
Total
</span>

<span>
$<?= number_format($totalFinal,2) ?> MXN
</span>

</div>

<button type="submit" class="btn btn-light w-100 mt-4">
    Confirmar compra
</button>

</div>

</div>

</div>

</form>

</div>

</section>
<script>

const radiosEntrega = document.querySelectorAll('input[name="tipo_entrega"]');
const datosEnvio = document.getElementById('datosEnvio');

radiosEntrega.forEach(radio => {
    radio.addEventListener('change', () => {

        const seleccionado = document.querySelector('input[name="tipo_entrega"]:checked').value;

        if(seleccionado === 'domicilio'){
            datosEnvio.style.display = 'block';
        } else {
            datosEnvio.style.display = 'none';
        }

    });
});

</script>
</body>
</html>