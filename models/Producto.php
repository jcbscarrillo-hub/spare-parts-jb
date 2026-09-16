<?php
class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos($id_categoria = null) {
        if ($id_categoria) {
            $sql = "SELECT p.*, c.nombre AS categoria 
                    FROM productos p 
                    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                    WHERE p.id_categoria = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_categoria]);
            return $stmt->fetchAll();
        } else {
            $sql = "SELECT p.*, c.nombre AS categoria 
                    FROM productos p 
                    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria";
            return $this->db->query($sql)->fetchAll();
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}