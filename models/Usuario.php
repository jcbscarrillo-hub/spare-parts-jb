<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function registrar($nombre, $email, $password, $telefono, $direccion) {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, email, password, telefono, direccion, id_rol) VALUES (?, ?, ?, ?, ?, 2)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $email, $hashPassword, $telefono, $direccion]);
    }

    public function obtenerPorEmail($email) {
        $sql = "SELECT u.*, r.nombre AS rol FROM usuarios u JOIN roles r ON u.id_rol = r.id_rol WHERE u.email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function emailExiste($email) {
        $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}