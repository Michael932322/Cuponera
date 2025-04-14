<?php
require_once 'cupon.php';
$cupon = new Cupon();

if (isset($_GET['id'])) {
    $imagen = $cupon->obtenerImagenporId($_GET['id']); 

    if ($imagen) {
        header("Content-Type: image/jpeg"); 
        echo $imagen['imagen']; 
    } else {
        http_response_code(404);
        echo "Imagen no encontrada";
    }
}
?>