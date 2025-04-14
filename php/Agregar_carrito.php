<?php
session_start();
require_once 'Compra.php'; 

function agregarCarrito($usuario_id, $oferta_id) {
    $compra = new Compra();
    return $compra->guardarCupon($usuario_id, $oferta_id);
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oferta_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $oferta_id = intval($_POST['oferta_id']);

    $codigo = agregarCarrito($usuario_id, $oferta_id);

    if ($codigo) {
        header("Location: ../index.php?mensaje=agregado&codigo=$codigo");
    } else {
        header("Location: ../index.php?mensaje=error");
    }
    exit;
} else {
    header("Location: ../index.php");
    exit;
}