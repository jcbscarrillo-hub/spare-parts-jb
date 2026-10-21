<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Control de acceso: solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /spare-parts-jb/home');
    exit();
}

require_once 'views/layouts/header.php'; 
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <h2 style="color: #111827; font-size: 1.8rem; font-weight: bold; margin: 0;">📊 Reporte General de Ventas - Spare Parts JB</h2>
        <button onclick="window.print()" style="background-color: #eab308; color: #111827; padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 14px;">Imprimir Reporte</button>
    </div>

    <!-- Tarjetas de Resumen -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: #ffffff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #2563eb; border-top: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 8px; font-weight: bold;">INGRESOS TOTALES HISTÓRICOS</p>
            <h3 style="color: #111827; font-size: 2rem; font-weight: bold; margin: 0;">$<?php echo number_format($resumen['ingresos_totales'] ?? 0, 2); ?></h3>
        </div>
        <div style="background: #ffffff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #16a34a; border-top: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 8px; font-weight: bold;">TRANSACCIONES REALIZADAS</p>
            <h3 style="color: #111827; font-size: 2rem; font-weight: bold; margin: 0;"><?php echo $resumen['total_pedidos'] ?? 0; ?></h3>
        </div>
        <div style="background: #ffffff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #d97706; border-top: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 8px; font-weight: bold;">PRODUCTOS VENDIDOS (UNIDADES)</p>
            <h3 style="color: #111827; font-size: 2rem; font-weight: bold; margin: 0;"><?php echo $resumen['total_unidades'] ?? 0; ?></h3>
        </div>
    </div>

    <!-- Tabla de Últimos Pedidos -->
    <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="padding: 20px; background: #12151c; color: #ffffff; font-weight: bold; font-size: 1.1rem;">
            Últimos Pedidos Registrados
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb; color: #374151;">
                        <th style="padding: 15px;">ID PEDIDO</th>
                        <th style="padding: 15px;">PRODUCTO</th>
                        <th style="padding: 15px;">CLIENTE</th>
                        <th style="padding: 15px;">FECHA</th>
                        <th style="padding: 15px;">CANTIDAD</th>
                        <th style="padding: 15px;">TOTAL RECAUDADO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ultimosPedidos)): ?>
                        <?php foreach ($ultimosPedidos as $item): ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 15px; font-weight: bold; color: #dc2626;">#<?php echo htmlspecialchars($item['id_pedido'] ?? ''); ?></td>
                                <td style="padding: 15px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if (!empty($item['producto_imagen'])): ?>
                                            <img src="/spare-parts-jb/public/uploads/<?php echo htmlspecialchars($item['producto_imagen']); ?>" 
                                                 alt="Producto" 
                                                 style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;"
                                                 onerror="this.onerror=null; this.src='/spare-parts-jb/<?php echo htmlspecialchars($item['producto_imagen']); ?>';">
                                        <?php else: ?>
                                            <div style="width: 45px; height: 45px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #9ca3af;">Sin foto</div>
                                        <?php endif; ?>
                                        <span style="font-weight: 500; color: #111827;"><?php echo htmlspecialchars($item['producto_nombre'] ?? ''); ?></span>
                                    </div>
                                </td>
                                <td style="padding: 15px; color: #4b5563;"><?php echo htmlspecialchars($item['cliente'] ?? ''); ?></td>
                                <td style="padding: 15px; color: #4b5563;"><?php echo htmlspecialchars($item['fecha'] ?? ''); ?></td>
                                <td style="padding: 15px; color: #4b5563;"><?php echo htmlspecialchars($item['cantidad'] ?? ''); ?></td>
                                <td style="padding: 15px; font-weight: bold; color: #16a34a;">$<?php echo number_format($item['total'] ?? 0, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 30px; text-align: center; color: #6b7280;">No hay pedidos registrados todavía.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>