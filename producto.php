<?php
require_once 'config/db.php';

$slug = $_GET['slug'] ?? '';

$sql = "SELECT * FROM productos WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();

$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado";
    exit;
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?php echo $producto['meta_titulo'] ?? $producto['nombre']; ?></title>
<meta name="description" content="<?php echo $producto['meta_descripcion']; ?>">
<link rel="stylesheet" href="css/interfaz.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container py-5 text-white">

    <div class="row">
        <div class="col-md-6">
            <img src="img/<?php echo $producto['imagen']; ?>" class="img-fluid rounded">
        </div>

        <div class="col-md-6">
            <h1><?php echo $producto['nombre']; ?></h1>
            <p><?php echo $producto['descripcion']; ?></p>
            <h3>$<?php echo $producto['precio']; ?> MXN</h3>

            <a href="carrito/agregar_carrito.php?id=<?php echo $producto['id']; ?>" 
               class="btn btn-success">
               Agregar al carrito
            </a>
        </div>
    </div>

</div>

</body>
</html>