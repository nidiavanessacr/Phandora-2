<?php
session_start();
require_once 'config/db.php';

$esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

$sql = "SELECT p.*, c.nombre AS categoria_nombre, c.slug AS categoria_slug
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.categoria_id IN (1,2,3,4)
        ORDER BY c.id, p.id DESC";

$result = $conn->query($sql);
?>


<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Phandora - Consumibles (Comida, Bebidas, Postres y Dulces)</title>
<meta name="description" content="Explora consumibles de Phandora: comida, bebidas, postres y dulces únicos. Productos frescos, snacks y bebidas para todos los gustos.">

<link rel="shortcut icon" href="img/logo.png">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/interfaz.css">

<style>
body{font-family:'Plus Jakarta Sans',sans-serif;}
.producto img{width:400px;height:320px;object-fit:cover;}
.precio{font-size:2rem;font-weight:700;color:white;}
</style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<section class="py-5">

<div class="container px-5 mb-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <input type="text" id="buscador" class="form-control form-control-lg"
      placeholder="Buscar consumibles...">
    </div>
  </div>
</div>

<div class="container px-5 mb-5">
<div class="row gx-5 justify-content-center">
<div class="col-lg-11 col-xl-9 col-xxl-8">

<?php
$currentCategoria = "";
while($p = $result->fetch_assoc()):
  if($currentCategoria != $p['categoria_nombre']):
    if($currentCategoria != "") echo "</div>";
    $currentCategoria = $p['categoria_nombre'];
?>

<h1 class="fw-bolder text-white mb-4 categoria">
  <?= htmlspecialchars($currentCategoria) ?>
</h1>

<div class="mb-5">

<?php endif; ?>

<div class="card overflow-hidden shadow rounded-4 border-0 mb-4 bg-dark producto"
data-nombre="<?= htmlspecialchars($p['nombre']) ?>"
data-categoria="<?= htmlspecialchars($p['categoria_slug']) ?>">

  <div class="card-body p-0">
    <div class="d-flex align-items-center flex-column flex-lg-row">

      <div class="p-5 text-white">

        <h2 class="fw-bolder mb-3"><?= htmlspecialchars($p['nombre']) ?></h2>

        <p class="mb-3"><?= htmlspecialchars($p['descripcion']) ?></p>

        <h4 class="precio mb-4">$<?= number_format($p['precio'],2) ?> MXN</h4>

        <a href="carrito/agregar_carrito.php?id=<?= $p['id'] ?>" class="btn btn-light">
          Agregar al carrito
        </a>

      </div>

      <?php if($esAdmin): ?>
  <div class="mt-3 d-flex gap-2">
    <a href="admin/editar_producto.php?id=<?= $p['id'] ?>" class="btn btn-outline-light btn-sm">
      Editar
    </a>

    <a href="admin/eliminar_producto.php?id=<?= $p['id'] ?>" class="btn btn-outline-danger btn-sm"
       onclick="return confirm('¿Eliminar este producto?')">
      Eliminar
    </a>
  </div>
<?php endif; ?>


      <img src="img/<?= $p['imagen'] ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">

    </div>
  </div>
</div>

<?php endwhile; ?>

</div>
</div>
</div>
</section>

<footer class="bg-dark py-4 mt-auto">
  <div class="container px-5">
    <div class="text-white small">GalloConTennis</div>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function(){
const buscador=document.getElementById('buscador');
const productos=document.querySelectorAll('.producto');

buscador.addEventListener('input',function(){
const texto=this.value.toLowerCase();

productos.forEach(p=>{
  p.style.display = p.innerText.toLowerCase().includes(texto) ? 'block' : 'none';
});

});
});
</script>

</body>
</html>