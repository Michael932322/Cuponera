<?php
include 'conexion.php';
class Cupon extends Conexion {
    public function obtenerCuponesDisponibles() {
        $query = "SELECT id, titulo, descripcion, precio_regular, precio_oferta, fecha_inicio, fecha_fin, justificacion, cantidad_limite FROM ofertas WHERE estado = 'Aprobada' AND fecha_inicio <= ? AND fecha_fin >= ?";
        $hoy = date('Y-m-d');
        return $this->get_query($query, [$hoy, $hoy]);
    }

    public function getUsuarioPorId($usuarioId) {
        $query = "SELECT id, nombres, apellidos FROM usuarios WHERE id = :usuario_id";
        $params = array(':usuario_id' => $usuarioId);
        return $this->get_query($query, $params);
    }

    public function obtenerCuponPorId($id) {
        $query = "SELECT id, titulo, precio_oferta FROM ofertas WHERE id = ?";
        $resultado = $this->get_query($query, [$id]);
        return $resultado[0] ?? null; // Devuelve el primer resultado o null
    }
}
?>
