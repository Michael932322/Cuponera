<?php
require_once 'conexion.php';
class registroCliente extends Conexion {
    //funcion para insertar los datos del usuario en la base de datos
    public function insert($datosUsuario = array()) {
    if($this->validarUsuario($datosUsuario[':usuario'])) {
    }
    //Insertar los datos en la tabla usuarios de la base de datos
    else {
        $query = "INSERT INTO usuarios (nombres, apellidos, telefono, correo, usuario, contrasena, tipo) 
                  VALUES (:nombres, :apellidos, :telefono, :correo, :usuario, :contrasena, :tipo)";
                 return $this->set_query($query, $datosUsuario);
         }
    }
       
    //Funcion para iniciar sesion, se le pasa el correo y la contraseña
    public function loginCliente($correo, $contrasena) {
        // Consulta para obtener el hash de la contraseña
        $query = "SELECT correo, contrasena FROM usuarios WHERE correo = :correo";
        $params = array(':correo' => $correo);

        $resultado = $this->get_query($query, $params);

        if (!empty($resultado) && password_verify($contrasena, $resultado[0]['contrasena'])) {
            // Iniciar sesión si las credenciales son correctas
            session_start();
            $_SESSION['correo'] = $resultado[0]['correo'];
            return true;
        } else {
            return false;
        }
    }

    //Funcion para validar que el usuario no exista en la base de datos y si existe que no se agregue
    public function validarUsuario($usuario) {
        $query = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
        $params = array(':usuario' => $usuario);
        $resultado = $this->get_query($query, $params);
        return !empty($resultado); // Devuelve true si el usuario ya existe, false si no existe
    }

    public function getUsuarioPorCorreo($correo) {
        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $params = array(':correo' => $correo);
        
        $resultado = $this->get_query($query, $params);
        
        if (!empty($resultado)) {
            return $resultado[0]; 
        }
        
        return null;
    }


}
