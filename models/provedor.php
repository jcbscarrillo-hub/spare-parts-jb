<?php
class Proveedor {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM proveedores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($nombre, $contacto, $telefono) {
        $sql = "INSERT INTO proveedores (nombre, contacto, telefono) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $contacto, $telefono]);
    }
}
?>