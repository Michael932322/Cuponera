<?php
require_once 'registroCliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar datos del formulario que no esten vacíos
    if (empty($_POST['nombres']) || empty($_POST['apellidos']) || empty($_POST['telefono']) || 
        empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['contrasena'])) {
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

    //Validar que el correo tenga el formato correcto
    //filter_var en este caso se usa para validar que tenga el formato correcto de un correo electronico
    if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        echo "El correo no es válido.";
        exit;
    }
    //validar que el telefono tenga el formato correcto
    //preg_match es na funcion que sirve para validar el formato de una cadena de texto
    //en este caso se valida que el telefono tenga 8 digitos y que empiece con 6 o 7
    if (!preg_match("/^(?:[67]\d{7}|2\d{7})$/", $_POST['telefono'])) {
        echo "El teléfono no es válido.";
        exit;

    }  
      // Validar si el usuario ya existe
      $registro = new registroCliente();  //creo la instancia de la clase registroCliente ya que 
      //es la que tiene la funcion para validar si el usuario existe y tengo que hacer el encapsulamiento
      //para poder acceder a la funcion ya que viene de otra clase 
      if ($registro->validarUsuario($_POST['usuario'])) {
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
                            title: 'Usuario existente',
                            text: 'El usuario ya está registrado. Por favor, elija otro nombre de usuario.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.history.back();
                        });
                    </script>
                </body>
                </html>";
          exit;
      }
 

    // Preparar los datos
    $datosUsuario =[
        ':nombres' => $_POST['nombres'],
        ':apellidos' => $_POST['apellidos'],
        ':telefono' => $_POST['telefono'],
        ':correo' => $_POST['correo'],
        ':usuario' => $_POST['usuario'],
        ':contrasena' => password_hash($_POST['contrasena'], PASSWORD_DEFAULT), // Encriptar contraseña
        ':tipo' => 'cliente'
    ];
    // Insertar datos en la base de datos
    $registro = new registroCliente();
    if ($registro->insert($datosUsuario)) {
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
                          icon: 'success',
                          title: 'Registro exitoso',
                          text: 'Su cuenta ha sido creada con éxito.',
                          confirmButtonText: 'Aceptar'
                      }).then(() => {
                          window.location.href = '../index.php';
                      });
                  </script>
              </body>
              </html>";
        exit;
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
                          icon: 'error',
                          title: 'Error',
                          text: 'Error al registrar, el correo ya existe.',
                          confirmButtonText: 'Aceptar'
                      }).then(() => {
                          window.location.href = '../index.php';
                        });
                  </script>
              </body>
              </html>";
        exit;
    }
}
?>