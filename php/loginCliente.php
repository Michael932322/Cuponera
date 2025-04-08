<?php
session_start(); // Iniciar la sesión al principio del archivo
require_once 'registroCliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo= $_POST['correo'];
    $contrasena = $_POST['contrasena'];

//Validar para campos vacios
if(empty($correo) || empty($contrasena)) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Campos vacíos',
                text: 'Todos los campos son obligatorios.',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.history.back();
            });
        </script>
    </body>
    </html>";
exit;
}

}

    $registroCliente = new registroCliente(); 
    if ($registroCliente->loginCliente($correo, $contrasena)) {
        $usuario = $registroCliente->getUsuarioPorCorreo($correo);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_correo'] = $usuario['correo'];
        header('Location: ../index.php');
        exit();
    } else {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Datos incorrectos',
                    text: 'Correo o contraseña incorrectos.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>";
  exit;
    }
?>




