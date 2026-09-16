<?php require_once 'views/layouts/header.php'; ?>

<style>
.catalog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.hero-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: #111827;
    margin-bottom: 8px;
    text-align: center;
}

.hero-subtitle {
    color: #4b5563;
    font-size: 0.95rem;
    text-align: center;
    margin-bottom: 30px;
}

.grid-productos {
    display: grid !important;
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 20px !important;
    width: 100% !important;
}

@media (max-width: 1024px) {
    .grid-productos { grid-template-columns: repeat(2, 1fr) !important; }
}

@media (max-width: 600px) {
    .grid-productos { grid-template-columns: 1fr !important; }
}

.card-product {
    background: #ffffff !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
    display: flex !important;
    flex-direction: column !important;
    border: 1px solid #e5e7eb !important;
}

.card-img-wrapper {
    width: 100% !important;
    height: 200px !important;
    background-color: #000000 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden !important;
    padding: 10px !important;
}

.card-img-wrapper img {
    max-width: 85% !important;
    max-height: 85% !important;
    object-fit: contain !important;
    background-color: #ffffff !important;
    border-radius: 4px !important;
}

.card-content {
    padding: 16px !important;
    display: flex !important;
    flex-direction: column !important;
    flex-grow: 1 !important;
}

.category-badge {
    display: inline-block !important;
    font-size: 0.75rem !important;
    color: #6b7280 !important;
    background: #f3f4f6 !important;
    padding: 2px 6px !important;
    border-radius: 4px !important;
    margin-bottom: 8px !important;
    align-self: flex-start !important;
}

.card-content h3 {
    font-size: 1rem !important;
    font-weight: bold !important;
    color: #111827 !important;
    margin: 0 0 10px 0 !important;
    min-height: 40px !important;
    line-height: 1.3 !important;
}

.moto-info {
    font-size: 0.85rem !important;
    color: #374151 !important;
    margin-bottom: 12px !important;
}

.product-price {
    font-size: 1.2rem !important;
    font-weight: bold !important;
    color: #dc2626 !important;
    margin: 0 0 8px 0 !important;
}

.stock-info {
    font-size: 0.8rem !important;
    margin-bottom: 15px !important;
}

.stock-info.in-stock { color: #16a34a !important; }
.stock-info.out-stock { color: #dc2626 !important; }

.btn-buy {
    width: 100% !important;
    padding: 10px !important;
    background-color: #dc2626 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 6px !important;
    font-weight: bold !important;
    font-size: 0.9rem !important;
    cursor: pointer !important;
    transition: background-color 0.2s ease !important;
}

.btn-buy:hover { background-color: #b91c1c !important; }
.btn-buy:disabled { background-color: #9ca3af !important; cursor: not-allowed !important; }
</style>

<main class="catalog-container">
    <section>
        <h1 class="hero-title">Catálogo de Repuestos y Accesorios</h1>
        <p class="hero-subtitle">Encuentra repuestos garantizados para tu motocicleta con disponibilidad en tiempo real.</p>
    </section>

    <div class="grid-productos">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <article class="card-product">
                    <div class="card-img-wrapper">
                        <?php 
                            $nombreImagen = !empty($producto['imagen']) ? $producto['imagen'] : 'default.jpg';
                            $rutaImagen = 'http://localhost/spare-parts-jb/public/uploads/' . $nombreImagen;
                        ?>
                        <img src="<?= htmlspecialchars($rutaImagen) ?>" 
                             alt="<?= htmlspecialchars($producto['nombre'] ?? 'Producto') ?>"
                             onerror="this.onerror=null; this.src='http://localhost/spare-parts-jb/public/uploads/casco.jpg';">
                    </div>

                    <div class="card-content">
                        <span class="category-badge"><?= htmlspecialchars($producto['categoria'] ?? 'General') ?></span>
                        
                        <h3><?= htmlspecialchars($producto['nombre'] ?? '') ?></h3>

                        <p class="moto-info">
                            <strong>Compatible con:</strong> <?= htmlspecialchars($producto['tipo_moto'] ?? $producto['descripcion'] ?? 'Universal') ?>
                        </p>

                        <p class="product-price">$<?= number_format($producto['precio'] ?? 0, 2) ?></p>

                        <p class="stock-info <?= (($producto['stock'] ?? 0) > 0) ? 'in-stock' : 'out-stock' ?>">
                            <?= (($producto['stock'] ?? 0) > 0) ? 'Stock disponible: ' . $producto['stock'] : 'Agotado' ?>
                        </p>

                        <form action="http://localhost/spare-parts-jb/carrito/agregar" method="POST" style="margin-top: auto;">
                            <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?? '' ?>">
                            <button type="submit" class="btn-buy" <?= (($producto['stock'] ?? 0) <= 0) ? 'disabled' : '' ?>>
                                Comprar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%; grid-column: 1 / -1;">No hay productos registrados en esta categoría por el momento.</p>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'views/layouts/footer.php'; ?>