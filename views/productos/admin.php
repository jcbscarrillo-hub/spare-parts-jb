<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Gestión de Productos</h2>
        <p>Administra el inventario, crea nuevos artículos o elimina productos existentes.</p>

        <?php if ($esAdmin): ?>
            <div class="mb-3">
                <a href="index.php?controlador=producto&accion=crear" class="btn btn-success">+ Crear Nuevo Producto</a>
            </div>
        <?php endif; ?>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($productos) && is_array($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['id_producto']; ?></td>
                            <td>
                                <img src="<?php echo $producto['imagen'] ?? 'public/img/default.png'; ?>" alt="" width="50">
                            </td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo $producto['stock']; ?></td>
                            <td>
                                <?php if ($esAdmin): ?>
                                    <a href="index.php?controlador=producto&accion=editar&id=<?php echo $producto['id_producto']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="index.php?controlador=producto&accion=eliminar&id=<?php echo $producto['id_producto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                                <?php else: ?>
                                    <span class="text-muted">Solo lectura</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>