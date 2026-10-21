<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

class ReportesController {
    
    public function index() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: /spare-parts-jb/home');
            exit;
        }

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $pdo = Database::getConnection();

        // 1. Obtener totales generales
        $stmtTotales = $pdo->query("
            SELECT 
                COUNT(DISTINCT p.id) AS total_pedidos, 
                COALESCE(SUM(p.total), 0) AS ingresos_totales,
                COALESCE(SUM(dp.cantidad), 0) AS total_unidades
            FROM pedidos p
            LEFT JOIN detalle_pedido dp ON p.id = dp.pedido_id
        ");
        $resumen = $stmtTotales->fetch(PDO::FETCH_ASSOC);

        // 2. Obtener lista de pedidos
        $stmtPedidos = $pdo->query("
            SELECT 
                p.id AS id_pedido, 
                p.total, 
                p.fecha, 
                COALESCE(u.nombre, 'Cliente') AS cliente,
                dp.cantidad,
                dp.producto_id
            FROM pedidos p 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            LEFT JOIN detalle_pedido dp ON p.id = dp.pedido_id
            ORDER BY p.fecha DESC 
            LIMIT 15
        ");
        $pedidosBrutos = $stmtPedidos->fetchAll(PDO::FETCH_ASSOC);

        $ultimosPedidos = [];
        foreach ($pedidosBrutos as $item) {
            $producto_nombre = 'Producto no disponible';
            $producto_imagen = '';

            if (!empty($item['producto_id'])) {
                // Buscando usando id_producto que es como se llama en la tabla productos
                $stmtProd = $pdo->prepare("SELECT nombre, imagen FROM productos WHERE id_producto = ? LIMIT 1");
                $stmtProd->execute([$item['producto_id']]);
                $prod = $stmtProd->fetch(PDO::FETCH_ASSOC);

                if ($prod) {
                    $producto_nombre = $prod['nombre'];
                    $producto_imagen = $prod['imagen'];
                }
            }

            $item['producto_nombre'] = $producto_nombre;
            $item['producto_imagen'] = $producto_imagen;
            $ultimosPedidos[] = $item;
        }

        require_once 'views/admin/reportes.php';
    }
}