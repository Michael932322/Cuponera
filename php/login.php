<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y login</title>
    <link rel="stylesheet" href="../css/estilo_login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="../imagenes/logo-2.ico">
</head>
<body>
    
    <main>
    <div class="contenedor__caja">
        <div class="caja__trasera"> 
            <div class="caja__login">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para entrar en la pagina</p>
                <button id="btn_login">Iniciar sesión</button>
            </div> 
            <div class="caja__registro">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Registrate para tener una cuenta</p>
                <button id="btn_registro">Registrarse</button>
            </div> 
         </div>
    
           <!--Formulario para iniciar sesion-->
     <div class="contenedor__login-registro">
        <form  action="loginCliente.php" method="POST" class="formulario__login">
                <h2>Iniciar sesión</h2>
                <input type="text" placeholder="Correo electronico" name="correo">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <button>Iniciar sesión</button>

        </form>
         <!--Formulario para registrarse-->
        <form action="registroPost.php" method="POST" class="formulario__registro">
            <h2>Registrarse</h2>
            <input type="text" placeholder="Nombre " name="nombres">
            <input type="text" placeholder="Apellido" name="apellidos">
            <input type="text" placeholder="Teléfono" name="telefono">            
            <input type="text"  placeholder="Correo electronico" name="correo">
            <input type="text" placeholder="Usuario" name="usuario">
            <input type="password" placeholder="Contraseña" name="contrasena">
            <button>Registrarse</button>
        </form>


    </div>
</div>
</main>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/script.js"></script>  
</body>
</html>