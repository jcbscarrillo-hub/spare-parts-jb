<?php
class ProductosController {

    // Método principal para el panel de administración de productos
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario es administrador
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: /spare-parts-jb/home');
            exit();
        }

        // Cargar el modelo de producto si es necesario
        require_once 'models/Producto.php';
        $productoModel = new Producto();
        $productos = $productoModel->obtenerTodos();

        // Cargar la vista de administración de productos
        require_once 'views/productos/admin.php';
    }

    // Alias para que la ruta /productos/admin responda correctamente
    public function admin() {
        $this->index();
    }

    // Método para mostrar el formulario de creación de productos
    public function crear() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: /spare-parts-jb/home');
            exit();
        }

        require_once 'views/productos/crear.php';
    }

    // Método para almacenar un nuevo producto en la base de datos
    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header('Location: /spare-parts-jb/home');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $compatible = $_POST['compatible'] ?? '';
            $categoria = $_POST['categoria'] ?? '';

            // Manejo de la imagen cargada
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = time() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = 'public/uploads/' . $nombreArchivo;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = $nombreArchivo;
                }
            }

            require_once 'models/Producto.php';
            $productoModel = new Producto();
            
            // Asegúrate de que tu modelo tenga un método registrar o crear
            if (method_exists($productoModel, 'crear')) {
                $productoModel->crear($nombre, $precio, $stock, $compatible, $categoria, $imagen);
            }

            header('Location: /spare-parts-jb/productos');
            exit();
        }
    }
}
?>