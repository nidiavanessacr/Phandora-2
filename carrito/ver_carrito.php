<?php
session_start();
require_once '../config/db.php';

// 🔒 seguridad
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

// 🔎 obtener carrito activo
$sql = "SELECT * 
        FROM carrito 
        WHERE usuario_id = ? 
        AND estado = 'activo'
        ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$requiereEnvio = false;
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Phandora - Tu carrito</title>
<meta name="description" content="Revisa los productos que has agregado a tu carrito en Phandora.">

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}

.producto-img{
    width:110px;
    height:110px;
    object-fit:cover;
    border-radius:12px;
}

.card-carrito{
    background:#1c1c1c;
    color:white;
}

.total-box{
    font-size:1.2rem;
}

.impuesto{
    color:#bdbdbd;
}

.alert-phandora{
    background:#232323;
    border:1px solid #343434;
    color:white;
    border-radius:20px;
}
</style>
</head>

<body class="bg-dark">

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">

<h1 class="fw-bolder text-white mb-4">
    Tu carrito
</h1>

<?php if ($result->num_rows == 0): ?>

    <div class="card card-carrito border-0 shadow rounded-4">
        <div class="card-body p-5 text-center">

            <h4 class="text-white">
                Tu carrito está vacío
            </h4>

            <p class="text-white-50">
                Agrega productos para comenzar tu compra
            </p>

        </div>
    </div>

<?php else: ?>

    <?php while($row = $result->fetch_assoc()): ?>

        <?php
        $subtotal = $row["producto_precio"] * $row["cantidad"];
        $total += $subtotal;

        // Detectar productos que requieren envío
        $nombreProducto = strtolower($row["producto_nombre"]);

        if (
            str_contains($nombreProducto, 'figura') ||
            str_contains($nombreProducto, 'peluche') ||
            str_contains($nombreProducto, 'llavero') ||
            str_contains($nombreProducto, 'mochila') ||
            str_contains($nombreProducto, 'coleccion')
        ) {
            $requiereEnvio = true;
        }
        ?>

        <div class="card card-carrito border-0 shadow rounded-4 mb-4">

            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">

                    <img 
                        src="../img/<?= htmlspecialchars($row["producto_imagen"] ?? 'default.png') ?>" 
                        class="producto-img"
                        alt="<?= htmlspecialchars($row["producto_nombre"]) ?>"
                    >

                    <div>

                        <h4 class="mb-1">
                            <?= htmlspecialchars($row["producto_nombre"]) ?>
                        </h4>

                        <p class="text-white-50 mb-0">
                            Cantidad: <?= $row["cantidad"] ?>
                        </p>

                    </div>
                </div>

                <div class="text-end">

                    <p class="mb-1">
                        $<?= number_format($row["producto_precio"], 2) ?>
                        x
                        <?= $row["cantidad"] ?>
                    </p>

                    <h5 class="mb-3">
                        Subtotal:
                        $<?= number_format($subtotal, 2) ?> MXN
                    </h5>

                    <form action="eliminar_carrito.php" method="POST">

                        <input type="hidden" name="id" value="<?= $row["id"] ?>">

                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Eliminar
                        </button>

                    </form>

                </div>

            </div>
        </div>

    <?php endwhile; ?>

    <?php
    // IVA 16%
    $iva = $total * 0.16;
    $totalFinal = $total + $iva;
    ?>

    <!-- INFO IMPUESTOS -->
    <div class="alert alert-phandora mb-4">

        <h5 class="fw-bold mb-3">
            Calculadora de impuestos
        </h5>

        <p class="mb-2">
            Subtotal:
            <strong>$<?= number_format($total, 2) ?> MXN</strong>
        </p>

        <p class="mb-2 impuesto">
            IVA (16%):
            $<?= number_format($iva, 2) ?> MXN
        </p>

        <h4 class="mt-3">
            Total final:
            $<?= number_format($totalFinal, 2) ?> MXN
        </h4>

        <small class="text-white-50">
            Todos los precios están expresados en pesos mexicanos (MXN).
        </small>

    </div>

    <!-- INFO ENVÍO -->
    <div class="alert alert-phandora mb-4">

        <h5 class="fw-bold mb-3">
            Información de envío
        </h5>

        <?php if($requiereEnvio): ?>

            <p class="mb-0">
                Algunos productos de tu carrito requieren envío físico.
                Durante el checkout podrás ingresar tus datos de entrega.
            </p>

        <?php else: ?>

            <p class="mb-0">
                Tus productos corresponden principalmente a alimentos preparados
                o consumo rápido, por lo que la entrega se considera local.
            </p>

        <?php endif; ?>

    </div>

    <!-- TÉRMINOS -->
    <div class="alert alert-phandora mb-4">

        <h5 class="fw-bold mb-3">
            Términos y condiciones
        </h5>

        <p class="mb-2">
            Al continuar con la compra aceptas los términos y condiciones de Phandora.
        </p>

        <ul class="mb-2">
            <li>Todos los precios están expresados en pesos mexicanos (MXN).</li>
            <li>Los métodos de pago son únicamente demostrativos para fines académicos.</li>
            <li>Los tiempos de entrega pueden variar dependiendo del tipo de producto.</li>
            <li>Los coleccionables y productos no perecederos pueden requerir envío.</li>
        </ul>

    </div>

    <!-- TOTAL Y CHECKOUT -->
    <div class="card card-carrito border-0 shadow rounded-4 mt-4">

        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h3 class="m-0 total-box">
                    Total:
                    $<?= number_format($totalFinal, 2) ?> MXN
                </h3>

                <small class="text-white-50">
                    IVA incluido
                </small>

            </div>

            <div class="d-flex gap-2">

                <a href="vaciar_carrito.php" class="btn btn-outline-light">
                    Vaciar carrito
                </a>

                <a href="checkout.php" class="btn btn-light">
                    Finalizar compra
                </a>

            </div>

        </div>
    </div>

<?php endif; ?>

</div>
</section>

</body>
</html>