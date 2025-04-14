<?php
abstract class Conexion {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db_name ='cuponera';
    protected $conn; //Para que las clases hijas puedan acceder a la conexion

    protected function open_db() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo("Error de conexión: " . $e->getMessage());
        }
    }

    protected function close_db() {
        $this->conn = null;
    }


//esta funcion sirve para hacer consultas a la base de datos, ya sea para 
//obtener datos o para insertar, actualizar o eliminar datos
//la funcion get_query se usa para obtener datos de la base de datos
    protected function get_query($query,$params=array()){
        try{
            $rows=[];
            $this->open_db();
            $stm=$this->conn->prepare($query);
            $stm->execute($params);
            while($rows[]=$stm->fetch(PDO::FETCH_ASSOC));
            $this->close_db();
            array_pop($rows);//Quitar el ultimo elemento
            return $rows;
        }
        catch(Exception $e){
            $this->close_db();
            return [];
        }
    }

    //la funcion set_query se usa para hacer consultas a la base de datos
    //la funcion get_query se usa para obtener datos de la base de datos

    protected function set_query($query,$params=array()){
        try{
            $this->open_db();
            $stm=$this->conn->prepare($query);
            $stm->execute($params);
            $affectedRows=$stm->rowCount();
            $this->close_db();
            return $affectedRows;
        }  
        catch(Exception $e){
            $this->close_db();
            return 0;
        }
    }
}