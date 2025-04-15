<?php
session_start();

$usuario_logueado = isset($_SESSION['usuario_id']); 

if ($usuario_logueado) {
  require_once 'php/cupon.php';
  $usuario = new Cupon();
  $datos_usuario = $usuario->getUsuarioPorId($_SESSION['usuario_id']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LA CUPONERA</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="css/carrito.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Black Han Sans' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="imagenes/logo-2.png" alt="Logo" width="40" height="40" class="d-inline-block" id="logo">
      <span class="empresa-nombre"> LA CUPONERA</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav justify-content-end">
      <?php if ($usuario_logueado): ?>
      <li class="nav-item">
        <a class="nav-link" href="php/perfil.php"><?php echo htmlspecialchars($datos_usuario[0]['nombres']); ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="php/logout.php">Cerrar Sesión</a>
      </li>
      <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="php/login.php">Iniciar Sesión</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="php/login.php">Registrarse</a>
      </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="#cupones">Cupones</a>
      </li>
      <!-- Icono del carrito -->
      <li class="nav-item">
            <a class="nav-link" href="php/Pago.php">
            <img src="imagenes/carrito.png" alt="Carrito" width="30">
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Sección inicial -->
<main>
  <section id="copy-registro" class="seccion-primera"> 
    <h1 class="titulo-principal"> Los mejores cupones a un solo click </h1>
    <p class="copy">¿Qué esperas para empezar a canjear?</p>
  </section>

  <!-- Sección de ofertas -->
  <?php
  require_once 'php/cupon.php';
  $cupon = new Cupon();
  $cupones = $cupon->obtenerCuponesDisponibles();
  ?>

  <div class="container">
    <div class="row gy-3" id="cupones">
      <?php if (count($cupones) > 0): ?>
        <?php foreach ($cupones as $oferta): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
            <img src="php/Mostrar_imagen.php?id=<?php echo $oferta['id']; ?>" class="card-img-top" alt="Imagen de promoción">
              <div class="card-body">
                <h4 class="card-title"><?php echo htmlspecialchars($oferta['titulo']); ?></h4>
                <p class="card-text">
                  <?php echo nl2br(htmlspecialchars($oferta['descripcion'])); ?><br><br>
                  <strong>Precio Regular:</strong> $<?php echo number_format($oferta['precio_regular'], 2); ?><br>
                  <strong>Oferta:</strong> $<?php echo number_format($oferta['precio_oferta'], 2); ?><br>
                  <strong>Válido:</strong> <?php echo $oferta['fecha_inicio']; ?> a <?php echo $oferta['fecha_fin']; ?><br>
                  <?php if (!empty($oferta['cantidad_limite'])): ?>
                    <strong>Límite:</strong> <?php echo $oferta['cantidad_limite']; ?><br>
                  <?php endif; ?>
                </p>
                <div class="btn-contenedor">
                <?php if ($usuario_logueado): ?>
                    <form action="php/Agregar_carrito.php" method="POST">
                        <input type="hidden" name="oferta_id" value="<?php echo $oferta['id']; ?>">
                        <button type="submit" class="btn-card">Agregar al Carrito</button>
                    </form>
                    <?php else: ?>
                    <button type="button" class="btn-card" onclick="window.location.href='php/login.php'">Inicia sesión para agregar</button>
                    <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12">
          <p>No hay ofertas disponibles en este momento.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<!-- Footer -->
<footer>
  <div class="logo-footer">
    <a class="navbar-brand" href="#">
      <img src="imagenes/logo-2.png" alt="Logo" class="d-inline-block">
      <span class="empresa-nombre"> LA CUPONERA</span>
    </a>
  </div>
  <div class="copyright-seccion">
    <p style="text-align: center;">©2025 LA CUPONERA. Todos los derechos reservados.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>