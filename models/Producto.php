<?php
class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos($id_categoria = null) {
        if ($id_categoria) {
            $sql = "SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor 
                    FROM productos p
                    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                    LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                    WHERE p.id_categoria = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_categoria]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor 
                    FROM productos p
                    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                    LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor";
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor 
                FROM productos p
                LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
                LEFT JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
                WHERE p.id_producto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrar($nombre, $descripcion, $precio, $stock, $id_categoria, $id_proveedor) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, id_proveedor) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio, $stock, $id_categoria, $id_proveedor]);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $id_categoria, $id_proveedor) {
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, id_categoria = ?, id_proveedor = ? WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $precio, $stock, $id_categoria, $id_proveedor, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>