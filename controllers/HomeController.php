<?php
require_once 'models/Producto.php';

class HomeController {
    public function index() {
        $productoModel = new Producto();
        
        // Obtener la categoría si viene por URL (ej. ?categoria=1)
        $id_categoria = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;
        
        // Pasar la categoría al modelo para filtrar los productos
        $productos = $productoModel->obtenerTodos($id_categoria);
        
        require_once 'views/home/index.php';
    }
}