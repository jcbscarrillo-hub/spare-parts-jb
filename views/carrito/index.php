<?php require_once 'views/layouts/header.php'; ?>

<main class="container">
    <h2 style="text-align: center; margin: 30px 0;">Tu Carrito de Compras</h2>

    <?php if (!empty($carrito)): ?>
        <table class="tabla-carrito" style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <thead>
                <tr style="background-color: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px;">Producto</th>
                    <th style="padding: 12px;">Precio</th>
                    <th style="padding: 12px;">Cantidad</th>
                    <th style="padding: 12px;">Subtotal</th>
                    <th style="padding: 12px; text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($carrito as $id => $item): 
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px; display: flex; align-items: center; gap: 15px;">
                            <img src="/spare-parts-jb/public/uploads/<?= htmlspecialchars($item['imagen'] ?? 'default.jpg') ?>" 
                                 alt="<?= htmlspecialchars($item['nombre']) ?>" 
                                 style="width: 50px; height: 50px; object-fit: contain;">
                            <span><?= htmlspecialchars($item['nombre']) ?></span>
                        </td>
                        <td style="padding: 12px;">$<?= number_format($item['precio'], 2) ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <?= $item['cantidad'] ?>
                        </td>
                        <td style="padding: 12px;">$<?= number_format($subtotal, 2) ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="/spare-parts-jb/carrito/eliminar?id=<?= $id ?>" style="color: #dc2626; text-decoration: none; font-weight: bold;">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Acciones del Carrito -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; gap: 10px;">
                <a href="/spare-parts-jb/home" class="btn" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold;">+ Agregar más productos</a>
                <a href="/spare-parts-jb/carrito/vaciar" class="btn" style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold;">Vaciar Carrito</a>
            </div>
            
            <div style="text-align: right;">
                <h3 style="margin-bottom: 15px;">Total: <span style="color: #dc2626;">$<?= number_format($total, 2) ?></span></h3>
                <a href="/spare-parts-jb/pedido/confirmar" class="btn" style="background-color: #dc2626; color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Finalizar Compra</a>
            </div>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 50px 0;">
            <p style="font-size: 1.2rem; color: #6b7280; margin-bottom: 20px;">Tu carrito está vacío actualmente.</p>
            <a href="/spare-parts-jb/home" style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold;">Ir al Catálogo</a>
        </div>
    <?php endif; ?>
</main>

<?php require_once 'views/layouts/footer.php'; ?>