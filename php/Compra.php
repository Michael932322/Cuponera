<?php
require_once 'conexion.php';

class Compra extends Conexion {
    
    public function guardarCupon($usuario_id, $oferta_id) {
        $codigo = strtoupper(bin2hex(random_bytes(4))); 
        $fecha_compra = date("Y-m-d H:i:s");
        $estado = 'Pendiente'; 

        $query = "INSERT INTO compras (usuario_id, oferta_id, codigo, fecha_compra, estado, empleado_id, fecha_canje)
                  VALUES (:usuario_id, :oferta_id, :codigo, :fecha_compra, :estado, NULL, NULL)";

        $params = [
            ':usuario_id' => $usuario_id,
            ':oferta_id' => $oferta_id,
            ':codigo' => $codigo,
            ':fecha_compra' => $fecha_compra,
            ':estado' => $estado
        ];

        $resultado = $this->set_query($query, $params);
        return $resultado > 0 ? $codigo : false;
    }

    // Obtener los cupones pendientes de un usuario
    public function obtenerCuponesPendientes($usuario_id) {
        $query = "SELECT cc.id, cc.codigo, cc.fecha_compra, o.titulo, o.precio_oferta
                    FROM compras cc
                    INNER JOIN ofertas o ON cc.oferta_id = o.id
                    WHERE cc.usuario_id = :usuario_id AND cc.estado = 'Pendiente'";

        $params = [':usuario_id' => $usuario_id];

        return $this->get_query($query, $params);
    }

    // Eliminar un cupón pendiente del carrito
    public function eliminarCuponPendiente($cupon_id, $usuario_id) {
        $query = "DELETE FROM compras
                  WHERE id = :id AND usuario_id = :usuario_id AND estado = 'Pendiente'";

        $params = [
            ':id' => $cupon_id,
            ':usuario_id' => $usuario_id
        ];

        return $this->set_query($query, $params) > 0;
    }

    public function finalizarCompra($usuario_id) {
        $queryObtener = "SELECT oferta_id FROM compras WHERE usuario_id = :usuario_id AND estado = 'Pendiente'";
        $ofertas = $this->get_query($queryObtener, [':usuario_id' => $usuario_id]);
    
        foreach ($ofertas as $oferta) {
            $oferta_id = $oferta['oferta_id'];
            $queryRestar = "UPDATE ofertas SET cantidad_limite = cantidad_limite - 1 WHERE id = :oferta_id AND cantidad_limite > 0";
            $this->set_query($queryRestar, [':oferta_id' => $oferta_id]);
        }
    
        $queryActualizar = "UPDATE compras SET estado = 'Disponible' WHERE usuario_id = :usuario_id AND estado = 'Pendiente'";
        $this->set_query($queryActualizar, [':usuario_id' => $usuario_id]);
    }
       
}
?>