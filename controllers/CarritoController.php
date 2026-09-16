<?php
require_once 'models/Producto.php';

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
                            'id_producto' => $producto['id_producto'],
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
}