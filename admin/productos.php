<?php
session_start();
require_once '../config/db.php';

/* 🔒 solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        ORDER BY p.id DESC";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Phandora - Administración de productos</title>
<meta name="description" content="Panel de administración de productos de Phandora">

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">

<style>
body{
    font-family:'Plus Jakarta Sans',sans-serif;
}
.tabla-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:12px;
}
</style>
</head>

<body class="bg-dark">

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="fw-bolder text-white mb-1">Productos</h1>
            <p class="text-white-50 mb-0">Administración de catálogo</p>
        </div>

        <a href="agregar_producto.php" class="btn btn-light">
            + Agregar producto
        </a>
    </div>

    <div class="card bg-dark border-0 shadow rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-dark align-middle mb-0">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while($p = $result->fetch_assoc()): ?>

                        <tr>
                            <td><?= $p["id"] ?></td>

                            <td>
                                <img
                                    src="../img/<?= htmlspecialchars($p["imagen"]) ?>"
                                    class="tabla-img"
                                    alt="<?= htmlspecialchars($p["nombre"]) ?>">
                            </td>

                            <td><?= htmlspecialchars($p["nombre"]) ?></td>

                            <td><?= htmlspecialchars($p["categoria_nombre"] ?? '-') ?></td>

                            <td><?= htmlspecialchars($p["tipo"]) ?></td>

                            <td>$<?= number_format($p["precio"], 2) ?></td>

                            <td><?= $p["stock"] ?></td>

                            <td class="text-end">

                                <a href="editar_producto.php?id=<?= $p["id"] ?>"
                                   class="btn btn-sm btn-outline-light">
                                    Editar
                                </a>

                                <a href="eliminar_producto.php?id=<?= $p["id"] ?>"
                                   class="btn btn-sm btn-outline-danger">
                                    Eliminar
                                </a>

                            </td>
                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>