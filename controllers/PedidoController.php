<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/spare-parts-jb/config/database.php';

class PedidoController {
    public function confirmar() {
        $pdo = Database::getConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el ID de usuario de la sesión de manera segura
        $user_id = $_SESSION['id_usuario'] ?? $_SESSION['user_id'] ?? null;

        // Si no ha iniciado sesión, lo mandamos al login o le avisamos
        if (!$user_id) {
            die("Error: No hay una sesión de usuario activa para asociar el pedido.");
        }

        // Validar si el carrito tiene productos
        if (empty($_SESSION['carrito'])) {
            die("Error: El carrito está vacío.");
        }

        $carrito = $_SESSION['carrito'];
        $totalPedido = 0;

        foreach ($carrito as $item) {
            $totalPedido += ($item['precio'] * $item['cantidad']);
        }

        try {
            $pdo->beginTransaction();

            // 1. Insertar el pedido en la tabla pedidos
            $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, fecha) VALUES (?, ?, NOW())");
            $stmt->execute([$user_id, $totalPedido]);
            $pedido_id = $pdo->lastInsertId();

            // 2. Insertar los productos en detalle_pedido
            $stmtDetalle = $pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            
            foreach ($carrito as $item) {
                $producto_id = $item['id_producto'] ?? $item['id'] ?? 0;
                $cantidad = $item['cantidad'];
                $precio = $item['precio'];

                $stmtDetalle->execute([$pedido_id, $producto_id, $cantidad, $precio]);
            }

            $pdo->commit();

            // Vaciar el carrito después de una compra exitosa
            unset($_SESSION['carrito']);

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<h3>Error al procesar la compra en la Base de Datos:</h3>";
            echo "<pre>" . $e->getMessage() . "</pre>";
            exit;
        }

        // Mostrar pantalla de éxito
        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 60px auto; padding: 40px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; text-align: center; font-family: Arial, sans-serif;">
            <div style="font-size: 3rem; color: #16a34a; margin-bottom: 16px;">✓</div>
            <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 12px;">¡Pedido Registrado con Éxito!</h1>
            <p style="color: #4b5563; margin-bottom: 24px;">Tu compra se ha guardado correctamente en el sistema.</p>
            <a href="http://localhost/spare-parts-jb/reportes" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block; margin-right: 10px;">Ver Reporte de Ventas</a>
            <a href="http://localhost/spare-parts-jb/" style="background-color: #111827; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Volver al Inicio</a>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }
}