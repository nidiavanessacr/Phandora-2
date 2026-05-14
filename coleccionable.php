<?php
session_start();
require_once 'config/db.php';

$esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

$sql = "SELECT * FROM productos WHERE categoria_id = 5 ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Coleccionables - Phandora | Figuras, peluches y más</title>
<meta name="description" content="Coleccionables de Phandora: figuras, peluches, mochilas, llaveros y artículos exclusivos de anime, gaming y cultura pop.">

<link rel="shortcut icon" href="img/logo.png">

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/interfaz.css">

<style>
body{
  font-family:'Plus Jakarta Sans',sans-serif;
}
.producto img{
  width:400px;
  height:320px;
  object-fit:cover;
}
.precio{
  font-size:2rem;
  font-weight:700;
  color:white;
}
</style>
</head>

<body>

<?php include 'includes/navbar.php'; ?>

<section class="py-5">

<div class="container px-5 mb-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <input type="text" id="buscador" class="form-control form-control-lg"
      placeholder="Buscar coleccionables...">
    </div>
  </div>
</div>

<div class="container px-5 mb-5">
<div class="row justify-content-center">
<div class="col-lg-11 col-xl-9 col-xxl-8">

<h1 class="fw-bolder text-white mb-4">Coleccionables</h1>

<?php while($p = $result->fetch_assoc()): ?>

<div class="card overflow-hidden shadow rounded-4 border-0 mb-5 bg-dark producto"
data-nombre="<?= htmlspecialchars($p['nombre']) ?>">

  <div class="card-body p-0">
    <div class="d-flex align-items-center flex-column flex-lg-row">

      <div class="p-5 text-white">

        <h2 class="fw-bolder mb-3">
          <?= htmlspecialchars($p['nombre']) ?>
        </h2>

        <p class="mb-3">
          <?= htmlspecialchars($p['descripcion']) ?>
        </p>

        <h4 class="precio mb-4">
          $<?= number_format($p['precio'],2) ?> MXN
        </h4>

        <!-- BOTÓN CORREGIDO A POST -->
        <form action="carrito/agregar_carrito.php" method="POST" style="display:inline;">
          <input type="hidden" name="id" value="<?= $p['id'] ?>">
          <button type="submit" class="btn btn-light">
            Agregar al carrito
          </button>
        </form>

        <?php if($esAdmin): ?>
  <div class="mt-3 d-flex gap-2">
    <a href="admin/editar_producto.php?id=<?= $p['id'] ?>" class="btn btn-outline-light btn-sm">
      Editar
    </a>

    <a href="admin/eliminar_producto.php?id=<?= $p['id'] ?>"
       class="btn btn-outline-danger btn-sm"
       onclick="return confirm('¿Eliminar este producto?')">
      Eliminar
    </a>
  </div>
<?php endif; ?>

      </div>

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
  const buscador = document.getElementById('buscador');
  const productos = document.querySelectorAll('.producto');

  buscador.addEventListener('input', function(){
    const texto = this.value.toLowerCase();

    productos.forEach(p=>{
      p.style.display = p.innerText.toLowerCase().includes(texto)
        ? 'block'
        : 'none';
    });
  });
});
</script>

</body>
</html>