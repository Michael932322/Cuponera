<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'Compra.php';
$usuario_id = $_SESSION['usuario_id'];
$compra = new Compra();

if (isset($_GET['eliminar'])) {
    $cupon_id = intval($_GET['eliminar']);
    $compra->eliminarCuponPendiente($cupon_id, $usuario_id);
    header("Location: Pago.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $compra->finalizarCompra($usuario_id); 
    header("Location: Pago.php?success=1");
    exit();
}

$cupones = $compra->obtenerCuponesPendientes($usuario_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/Pago.css?v=1.1" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="../index.php" class="btn-regresar">← Volver al inicio</a>

        <div class="titulo text-center">
            <h4>RESUMEN DE PAGO</h4>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">¡Compra realizada con éxito!</div>
        <?php endif; ?>
        <table class="table table-group-divider">
            <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Nombre cupón</th>
                    <th scope="col">Código</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php if (!empty($cupones)): ?>
                    <?php $total = 0; ?>
                    <?php foreach ($cupones as $index => $cupon): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($cupon['titulo']) ?></td>
                            <td><?= $cupon['codigo'] ?></td>
                            <td><?= $cupon['fecha_compra'] ?></td>
                            <td>$<?= number_format($cupon['precio_oferta'], 2) ?></td>
                            <td>
                                <a href="?eliminar=<?= $cupon['id'] ?>" class="btn btn-danger btn-sm">X</a>
                            </td>
                        </tr>
                        <?php $total += $cupon['precio_oferta']; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay cupones en tu carrito.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if (!empty($cupones)): ?>
            <div class="text-center">
                <button class="btn btn-primary mt-3" onclick="mostrarFormulario()">Continuar con la compra</button>
            </div>

            <form method="POST" id="formulario-pago" class="mt-4">
                <h5>Datos de tarjeta (simulado)</h5>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre en la tarjeta</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="numero" class="form-label">Número de tarjeta</label>
                    <input type="text" class="form-control" id="numero" maxlength="16" required>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="exp" class="form-label">Fecha de expiración</label>
                        <input type="text" class="form-control" id="exp" placeholder="MM/AA" required>
                    </div>
                    <div class="col">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" maxlength="4" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="comprar" class="btn btn-success">Comprar</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function mostrarFormulario() {
            document.getElementById('formulario-pago').style.display = 'block';
        }
    </script>
</body>
</html>