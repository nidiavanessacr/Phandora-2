<?php
session_start();
require_once '../config/db.php';

/* solo admin */
if (!isset($_SESSION["usuario_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: productos.php");
    exit;
}

$id = intval($_GET["id"]);
$error = "";

/* producto */
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

/* categorías */
$categorias = $conn->query("SELECT id, nombre FROM categorias ORDER BY id ASC");

/* guardar cambios */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"]);
    $slug = trim($_POST["slug"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = floatval($_POST["precio"]);
    $imagen = trim($_POST["imagen"]);
    $stock = intval($_POST["stock"]);
    $categoria_id = intval($_POST["categoria_id"]);
    $meta_titulo = trim($_POST["meta_titulo"]);
    $meta_descripcion = trim($_POST["meta_descripcion"]);

    $tipo = ($categoria_id == 5) ? "coleccionable" : "consumible";

    if ($nombre === "" || $precio <= 0 || $categoria_id <= 0) {
        $error = "Completa los campos obligatorios.";
    } else {

        if ($slug === "") {
            $slug = strtolower($nombre);
            $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
            $slug = trim($slug, '-');
        }

        $sql = "UPDATE productos SET
                    nombre = ?,
                    slug = ?,
                    descripcion = ?,
                    precio = ?,
                    imagen = ?,
                    stock = ?,
                    categoria_id = ?,
                    meta_titulo = ?,
                    meta_descripcion = ?,
                    tipo = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssdsiisssi",
            $nombre,
            $slug,
            $descripcion,
            $precio,
            $imagen,
            $stock,
            $categoria_id,
            $meta_titulo,
            $meta_descripcion,
            $tipo,
            $id
        );

        if ($stmt->execute()) {
            header("Location: productos.php");
            exit;
        } else {
            $error = "No se pudo actualizar el producto.";
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Editar producto - Phandora</title>

<link rel="shortcut icon" href="../img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/interfaz.css">
</head>

<body>

<?php include '../includes/navbar.php'; ?>

<section class="py-5">
<div class="container px-5">
<div class="row justify-content-center">
<div class="col-lg-8">

    <div class="card bg-dark text-white border-0 shadow rounded-4">
        <div class="card-body p-5">

            <h1 class="fw-bolder mb-4">Editar producto</h1>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="<?= htmlspecialchars($producto["nombre"]) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input
                        type="text"
                        name="slug"
                        class="form-control"
                        value="<?= htmlspecialchars($producto["slug"]) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($producto["descripcion"]) ?></textarea>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio *</label>
                        <input
                            type="number"
                            step="0.01"
                            name="precio"
                            class="form-control"
                            value="<?= $producto["precio"] ?>"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            value="<?= $producto["stock"] ?>">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input
                        type="text"
                        name="imagen"
                        class="form-control"
                        value="<?= htmlspecialchars($producto["imagen"]) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría *</label>
                    <select name="categoria_id" class="form-select" required>

                        <?php while($c = $categorias->fetch_assoc()): ?>
                            <option
                                value="<?= $c["id"] ?>"
                                <?= ($producto["categoria_id"] == $c["id"]) ? "selected" : "" ?>>
                                <?= htmlspecialchars($c["nombre"]) ?>
                            </option>
                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta título</label>
                    <input
                        type="text"
                        name="meta_titulo"
                        class="form-control"
                        value="<?= htmlspecialchars($producto["meta_titulo"]) ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label">Meta descripción</label>
                    <textarea name="meta_descripcion" class="form-control" rows="2"><?= htmlspecialchars($producto["meta_descripcion"]) ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-success">
                        Guardar cambios
                    </button>

                    <a href="productos.php" class="btn btn-outline-light">
                        Cancelar
                    </a>
                </div>

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