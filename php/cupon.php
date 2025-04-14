<?php
include 'conexion.php';
class Cupon extends Conexion {
    public function obtenerCuponesDisponibles() {
        $query = "SELECT id, titulo, imagen, descripcion, precio_regular, precio_oferta, fecha_inicio, fecha_fin, justificacion, cantidad_limite FROM ofertas WHERE estado = 'Aprobada' AND fecha_inicio <= ? AND fecha_fin >= ?";
        $hoy = date('Y-m-d');
        return $this->get_query($query, [$hoy, $hoy]);
    }

    public function getUsuarioPorId($usuarioId) {
        $query = "SELECT id, nombres, apellidos, telefono, correo, usuario FROM usuarios WHERE id = :usuario_id";
        $params = array(':usuario_id' => $usuarioId);
        return $this->get_query($query, $params);
    }    

    public function obtenerCuponPorId($id) {
        $query = "SELECT id, titulo, precio_oferta FROM ofertas WHERE id = ?";
        $resultado = $this->get_query($query, [$id]);
        return $resultado[0] ?? null; // Devuelve el primer resultado o null
    }

    public function obtenerImagenporId($id) {
        $query = "SELECT imagen FROM ofertas WHERE id = :id LIMIT 1";
        $params = [':id' => $id];
        $resultado = $this->get_query($query, $params);
        return $resultado ? $resultado[0] : null;
    }

    public function obtenerCuponesPorUsuario($usuario_id) {
        $query = "SELECT o.id, o.titulo, o.descripcion, o.precio_regular, o.precio_oferta, o.fecha_inicio, o.fecha_fin, c.estado, o.imagen
                    FROM compras c
                    INNER JOIN ofertas o ON c.oferta_id = o.id
                    WHERE c.usuario_id = ? AND c.estado = 'Disponible'";
        return $this->get_query($query, [$usuario_id]);
    }
}
?>
