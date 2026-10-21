<?php
class Database {
    public static function getConnection() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=spare_parts_jb', 'root', '');
            // ESTA LÍNEA ES CLAVE PARA VER ERRORES:
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}