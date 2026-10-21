<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Control de acceso para administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /spare-parts-jb/home');
    exit();
}

require_once 'views/layouts/header.php';
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="color: #111827; font-size: 1.8rem; font-weight: bold; margin: 0;">Gestión de Productos</h2>
            <p style="color: #6b7280; font-size: 0.95rem; margin-top: 5px;">Administra el inventario, crea nuevos artículos o elimina productos existentes.</p>
        </div>
        <a href="/spare-parts-jb/productos/crear" style="background-color: #16a34a; color: #ffffff; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px;">
            + Crear Nuevo Producto
        </a>
    </div>

    <!-- Tabla de Productos -->
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                <thead>
                    <tr style="background: #12151c; color: #ffffff;">
                        <th style="padding: 15px;">ID</th>
                        <th style="padding: 15px;">Imagen</th>
                        <th style="padding: 15px;">Nombre</th>
                        <th style="padding: 15px;">Precio</th>
                        <th style="padding: 15px;">Stock</th>
                        <th style="padding: 15px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $p): ?>
                            <tr style="border-bottom: 1px solid #e5e7eb; color: #374151;">
                                <td style="padding: 15px; font-weight: bold;"><?= htmlspecialchars($p['id'] ?? $p['id_producto'] ?? ''); ?></td>
                                <td style="padding: 15px;">
                                    <?php if (!empty($p['imagen'])): ?>
                                        <img src="/spare-parts-jb/public/uploads/<?= htmlspecialchars($p['imagen']); ?>" 
                                             alt="Producto" 
                                             style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;"
                                             onerror="this.onerror=null; this.src='/spare-parts-jb/public/img/<?= htmlspecialchars($p['imagen']); ?>';">
                                    <?php else: ?>
                                        <div style="width: 45px; height: 45px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #9ca3af;">Sin foto</div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 15px; font-weight: bold; color: #111827;"><?= htmlspecialchars($p['nombre'] ?? ''); ?></td>
                                <td style="padding: 15px; font-weight: bold; color: #16a34a;">$<?= number_format($p['precio'] ?? 0, 2); ?></td>
                                <td style="padding: 15px;"><?= htmlspecialchars($p['stock'] ?? 0); ?></td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 8px;">
                                        <a href="/spare-parts-jb/productos/editar?id=<?= $p['id'] ?? $p['id_producto']; ?>" style="background-color: #2563eb; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold;">Editar</a>
                                        <a href="/spare-parts-jb/productos/eliminar?id=<?= $p['id'] ?? $p['id_producto']; ?>" onclick="return confirm('¿Deseas eliminar este producto?');" style="background-color: #ef4444; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold;">Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 30px; text-align: center; color: #6b7280;">No hay productos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>