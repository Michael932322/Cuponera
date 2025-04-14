<?php
session_start();
require_once 'cupon.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$cupon = new Cupon();
$usuario_id = $_SESSION['usuario_id'];
$datos_usuario = $cupon->getUsuarioPorId($usuario_id);
$cupones_usuario = $cupon->obtenerCuponesPorUsuario($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>

<div class="contenedor">
    <a href="../index.php" class="btn-regresar">← Volver al inicio</a>

    <div class="datos-usuario">
        <h2>Datos del Usuario</h2>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($datos_usuario[0]['nombres']) ?></p>
        <p><strong>Apellido:</strong> <?= htmlspecialchars($datos_usuario[0]['apellidos']) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($datos_usuario[0]['telefono']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($datos_usuario[0]['correo']) ?></p>
        <p><strong>Usuario:</strong> <?= htmlspecialchars($datos_usuario[0]['usuario']) ?></p>
    </div>

    <div class="cupones">
        <h2>Cupones Adquiridos</h2>
        <?php if (!empty($cupones_usuario)): ?>
            <?php foreach ($cupones_usuario as $cupon): ?>
                <div class="cupon">
                    <span class="estado-cupon"><?= htmlspecialchars($cupon['estado']) ?></span>
                    <img src="Mostrar_imagen.php?id=<?= $cupon['id'] ?>" alt="Imagen del cupón">
                    <h3><?= htmlspecialchars($cupon['titulo']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($cupon['descripcion'])) ?></p>
                    <p><strong>Precio Regular:</strong> $<?= number_format($cupon['precio_regular'], 2) ?></p>
                    <p><strong>Oferta:</strong> $<?= number_format($cupon['precio_oferta'], 2) ?></p>
                    <p><strong>Válido:</strong> <?= $cupon['fecha_inicio'] ?> a <?= $cupon['fecha_fin'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No has adquirido cupones aún.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>