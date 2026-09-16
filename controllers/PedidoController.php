<?php
class PedidoController {
    public function confirmar() {
        // Aquí puedes procesar el guardado del pedido en la base de datos si lo deseas
        
        // Limpiamos el carrito (si usas sesión para él)
        if (isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 60px auto; padding: 40px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; text-align: center; font-family: Arial, sans-serif;">
            <div style="font-size: 3rem; color: #16a34a; margin-bottom: 16px;">✓</div>
            <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 12px;">¡Pedido Finalizado con Éxito!</h1>
            <p style="color: #4b5563; margin-bottom: 24px;">Gracias por tu compra en Spare Parts JB. Tu pedido ha sido procesado correctamente.</p>
            <a href="http://localhost/spare-parts-jb/" style="background-color: #111827; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">Volver al Inicio</a>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }
}