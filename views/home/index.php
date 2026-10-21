<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Incluir la cabecera (header) -->
<?php include_once 'views/layouts/header.php'; ?>

<main style="max-width: 1200px; margin: 0 auto; padding: 40px 20px; font-family: sans-serif;">
    
    <!-- Título y subtítulo -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: #111827; font-size: 28px; font-weight: bold; margin-bottom: 10px;">
            Catálogo de Repuestos y Accesorios
        </h1>
        <p style="color: #4b5563; font-size: 16px; margin: 0;">
            Encuentra repuestos garantizados para tu motocicleta con disponibilidad en tiempo real.
        </p>
    </div>

    <?php
    // Agrupar productos por categoría
    $categorias = [
        'REPUESTOS' => [],
        'CASCOS' => [],
        'ACCESORIOS' => []
    ];

    if (!empty($productos)) {
        foreach ($productos as $prod) {
            $catNombre = strtoupper(trim($prod['categoria_nombre'] ?? $prod['categoria'] ?? ''));
            if (strpos($catNombre, 'CASCO') !== false) {
                $categorias['CASCOS'][] = $prod;
            } elseif (strpos($catNombre, 'ACCESORIO') !== false) {
                $categorias['ACCESORIOS'][] = $prod;
            } else {
                $categorias['REPUESTOS'][] = $prod;
            }
        }
    }
    ?>

    <!-- 1. VISTA GENERAL (CATÁLOGO COMPLETO SIN TÍTULOS DE CATEGORÍA) -->
    <div id="seccion-todos" style="display: block; margin-bottom: 40px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                        
                        <!-- Imagen -->
                        <div style="text-align: center; margin-bottom: 15px;">
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="/spare-parts-jb/public/uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="max-height: 150px; object-fit: contain;">
                            <?php else: ?>
                                <div style="height: 150px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 14px;">Sin imagen</div>
                            <?php endif; ?>
                        </div>

                        <!-- Información -->
                        <div>
                            <h3 style="color: #1f2937; font-size: 16px; font-weight: bold; margin: 0 0 8px 0; min-height: 40px;"><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <p style="color: #6b7280; font-size: 13px; margin: 0 0 8px 0;">Compatible con: <?= htmlspecialchars($producto['compatible'] ?? 'Universal') ?></p>
                            <p style="color: #dc2626; font-size: 18px; font-weight: bold; margin: 0 0 8px 0;">$<?= number_format($producto['precio'], 2) ?></p>
                            <p style="color: #059669; font-size: 12px; margin: 0 0 15px 0;">Stock disponible: <?= htmlspecialchars($producto['stock'] ?? '0') ?></p>
                        </div>

                        <!-- Botón Comprar -->
                        <div>
                            <form action="/spare-parts-jb/carrito/agregar" method="POST">
                                <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?? $producto['id'] ?>">
                                <button type="submit" style="width: 100%; background-color: #dc2626; color: #ffffff; border: none; padding: 10px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.2s;">
                                    Comprar
                                </button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; color: #6b7280; font-size: 16px;">No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. VISTAS FILTRADAS POR CATEGORÍA (OCULTAS POR DEFECTO HASTA QUE SE SELECCIONEN) -->
    <?php foreach ($categorias as $nombreCategoria => $listaProductos): ?>
        <?php if (!empty($listaProductos)): ?>
            <div class="seccion-categoria" id="sec-<?= strtolower($nombreCategoria) ?>" style="display: none; margin-bottom: 40px;">
                
                <div style="border-bottom: 2px solid #dc2626; margin: 20px 0 20px 0; padding-bottom: 8px;">
                    <h2 style="color: #111827; font-size: 22px; font-weight: bold; margin: 0; text-transform: uppercase;">
                        <?= $nombreCategoria ?>
                    </h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
                    <?php foreach ($listaProductos as $producto): ?>
                        <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                            
                            <div style="text-align: center; margin-bottom: 15px;">
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img src="/spare-parts-jb/public/uploads/<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" style="max-height: 150px; object-fit: contain;">
                                <?php else: ?>
                                    <div style="height: 150px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 14px;">Sin imagen</div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <span style="font-size: 11px; color: #6b7280; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 5px;">
                                    <?= htmlspecialchars($nombreCategoria) ?>
                                </span>
                                <h3 style="color: #1f2937; font-size: 16px; font-weight: bold; margin: 0 0 8px 0; min-height: 40px;"><?= htmlspecialchars($producto['nombre']) ?></h3>
                                <p style="color: #6b7280; font-size: 13px; margin: 0 0 8px 0;">Compatible con: <?= htmlspecialchars($producto['compatible'] ?? 'Universal') ?></p>
                                <p style="color: #dc2626; font-size: 18px; font-weight: bold; margin: 0 0 8px 0;">$<?= number_format($producto['precio'], 2) ?></p>
                                <p style="color: #059669; font-size: 12px; margin: 0 0 15px 0;">Stock disponible: <?= htmlspecialchars($producto['stock'] ?? '0') ?></p>
                            </div>

                            <div>
                                <form action="/spare-parts-jb/carrito/agregar" method="POST">
                                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?? $producto['id'] ?>">
                                    <button type="submit" style="width: 100%; background-color: #dc2626; color: #ffffff; border: none; padding: 10px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.2s;">
                                        Comprar
                                    </button>
                                </form>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</main>

<!-- Incluir el pie de página (footer) -->
<?php include_once 'views/layouts/footer.php'; ?>