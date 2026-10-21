<?php
require_once 'models/Producto.php';
require_once __DIR__ . '/../config/database.php';

class CarritoController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $carrito = $_SESSION['carrito'] ?? [];
        require_once 'views/carrito/index.php';
    }

    public function agregar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_producto = $_POST['id_producto'] ?? null;
            $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

            if ($id_producto) {
                if (isset($_SESSION['carrito'][$id_producto])) {
                    $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
                } else {
                    $productoModel = new Producto();
                    $producto = $productoModel->obtenerPorId($id_producto);

                    if ($producto) {
                        $_SESSION['carrito'][$id_producto] = [
                            'id_producto' => $producto['id_producto'] ?? $producto['id'] ?? $id_producto,
                            'nombre'      => $producto['nombre'],
                            'precio'      => $producto['precio'],
                            'imagen'      => $producto['imagen'],
                            'cantidad'    => $cantidad
                        ];
                    }
                }
            }
        }
        header('Location: /spare-parts-jb/carrito');
        exit();
    }

    public function vaciar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['carrito']);
        header('Location: /spare-parts-jb/carrito');
        exit();
    }

    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id'] ?? null;
        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
        header('Location: /spare-parts-jb/carrito');
        exit();
    }

    public function finalizarCompra() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['id_usuario'] ?? $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            die("Error: No hay una sesión de usuario activa. Inicia sesión de nuevo.");
        }

        if (empty($_SESSION['carrito'])) {
            die("Error: El carrito está vacío.");
        }

        try {
            $pdo = Database::getConnection();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $carrito = $_SESSION['carrito'];
            $totalPedido = 0;

            foreach ($carrito as $item) {
                $totalPedido += ($item['precio'] * $item['cantidad']);
            }

            $pdo->beginTransaction();

            // 1. Insertar pedido
            $stmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, fecha) VALUES (?, ?, NOW())");
            $stmt->execute([$user_id, $totalPedido]);
            $pedido_id = $pdo->lastInsertId();

            // 2. Insertar detalle
            $stmtDetalle = $pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            
            foreach ($carrito as $item) {
                $prod_id = $item['id_producto'] ?? 0;
                $stmtDetalle->execute([$pedido_id, $prod_id, $item['cantidad'], $item['precio']]);
            }

            $pdo->commit();

            unset($_SESSION['carrito']);
            
            // Pantalla de éxito limpia
            require_once 'views/layouts/header.php';
            ?>
            <div style="max-width: 600px; margin: 60px auto; padding: 40px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; text-align: center; font-family: Arial, sans-serif;">
                <div style="font-size: 3rem; color: #16a34a; margin-bottom: 16px;">✓</div>
                <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 12px;">¡Compra Realizada con Éxito!</h1>
                <p style="color: #4b5563; margin-bottom: 24px;">Tu pedido ha sido registrado correctamente en la base de datos.</p>
                <a href="/spare-parts-jb/reportes" style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Ver Reportes de Ventas</a>
            </div>
            <?php
            require_once 'views/layouts/footer.php';
            exit();

        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "<div style='background:#fee2e2; color:#b91c1c; padding:20px; margin:20px; border-radius:6px; font-family:sans-serif;'>";
            echo "<h3>Ocurrió un error en la base de datos:</h3>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "</div>";
            exit();
        }
    }
}