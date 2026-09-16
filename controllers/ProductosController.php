<?php
class ProductosController {
    public function index() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
            $stmt = $db->query("SELECT * FROM productos ORDER BY id_producto DESC");
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $productos = [];
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: Arial, sans-serif;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 4px;">Gestión de Productos</h1>
                    <p style="color: #4b5563;">Administra el inventario, crea nuevos artículos o elimina productos existentes.</p>
                </div>
                <a href="http://localhost/spare-parts-jb/productos/crear" style="background-color: #16a34a; color: #ffffff; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                    + Crear Nuevo Producto
                </a>
            </div>

            <table style="width: 100%; border-collapse: collapse; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background-color: #111827; color: #ffffff; text-align: left;">
                        <th style="padding: 12px 16px;">ID</th>
                        <th style="padding: 12px 16px;">Imagen</th>
                        <th style="padding: 12px 16px;">Nombre</th>
                        <th style="padding: 12px 16px;">Precio</th>
                        <th style="padding: 12px 16px;">Stock</th>
                        <th style="padding: 12px 16px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $p): ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px 16px; color: #374151;"><?= htmlspecialchars($p['id_producto'] ?? '') ?></td>
                                <td style="padding: 12px 16px;">
                                    <img src="http://localhost/spare-parts-jb/public/uploads/<?= htmlspecialchars($p['imagen'] ?? 'default.jpg') ?>" alt="" style="width: 40px; height: 40px; object-fit: contain; background: #000; border-radius: 4px;">
                                </td>
                                <td style="padding: 12px 16px; color: #111827; font-weight: bold;"><?= htmlspecialchars($p['nombre'] ?? '') ?></td>
                                <td style="padding: 12px 16px; color: #dc2626; font-weight: bold;">$<?= number_format($p['precio'] ?? 0, 2) ?></td>
                                <td style="padding: 12px 16px; color: #374151;"><?= htmlspecialchars($p['stock'] ?? 0) ?></td>
                                <td style="padding: 12px 16px; text-align: center; white-space: nowrap;">
                                    <a href="http://localhost/spare-parts-jb/productos/editar?id=<?= $p['id_producto'] ?>" 
                                       style="background-color: #3b82f6; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; margin-right: 6px;">
                                        Editar
                                    </a>
                                    <a href="http://localhost/spare-parts-jb/productos/eliminar?id=<?= $p['id_producto'] ?>" 
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?');" 
                                       style="background-color: #dc2626; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold;">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 20px; text-align: center; color: #6b7280;">No hay productos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
            $stmt = $db->query("SELECT * FROM categorias");
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $categorias = [];
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; font-family: Arial, sans-serif;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 20px;">Crear Nuevo Producto</h1>
            
            <form action="http://localhost/spare-parts-jb/productos/guardar" method="POST" enctype="multipart/form-data">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Nombre del Producto:</label>
                    <input type="text" name="nombre" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Descripción:</label>
                    <textarea name="descripcion" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"></textarea>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Precio ($):</label>
                        <input type="number" step="0.01" name="precio" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Stock:</label>
                        <input type="number" name="stock" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Categoría:</label>
                    <select name="id_categoria" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: #fff;">
                        <option value="">Seleccione una categoría</option>
                        <?php foreach ($categorias as $cat): ?>
                            <?php $catId = $cat['id_categoria'] ?? $cat['id'] ?? $cat['categoria_id'] ?? 1; ?>
                            <option value="<?= $catId ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Nombre del archivo de imagen (ej. repuesto.jpg):</label>
                    <input type="text" name="imagen" placeholder="default.jpg" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                    <small style="color: #6b7280; display: block; margin-top: 4px;">Asegúrate de colocar la imagen en la carpeta public/uploads/</small>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="background-color: #16a34a; color: #ffffff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Guardar Producto</button>
                    <a href="http://localhost/spare-parts-jb/productos" style="background-color: #6b7280; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; text-align: center;">Cancelar</a>
                </div>
            </form>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $id_categoria = $_POST['id_categoria'] ?? 1;
            $imagen = $_POST['imagen'] ?? 'default.jpg';

            try {
                $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $db->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, imagen) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $descripcion, $precio, $stock, $id_categoria, $imagen]);
            } catch (Exception $e) {
                echo "Error al guardar: " . $e->getMessage();
                exit();
            }
            
            header("Location: http://localhost/spare-parts-jb/productos");
            exit();
        }
    }

    public function editar() {
        if (!isset($_GET['id'])) {
            header("Location: http://localhost/spare-parts-jb/productos");
            exit();
        }
        $id = $_GET['id'];
        
        try {
            $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
            $stmt = $db->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmtCat = $db->query("SELECT * FROM categorias");
            $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $producto = null;
            $categorias = [];
        }

        if (!$producto) {
            header("Location: http://localhost/spare-parts-jb/productos");
            exit();
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; font-family: Arial, sans-serif;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 20px;">Editar Producto</h1>
            
            <form action="http://localhost/spare-parts-jb/productos/actualizar" method="POST">
                <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Nombre del Producto:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Descripción:</label>
                    <textarea name="descripcion" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 6px;">Precio ($):</label>
                        <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: bold; margin-bottom: 6px;">Stock:</label>
                        <input type="number" name="stock" value="<?= $producto['stock'] ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Categoría:</label>
                    <select name="id_categoria" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; background: #fff;">
                        <?php foreach ($categorias as $cat): ?>
                            <?php $catId = $cat['id_categoria'] ?? $cat['id'] ?? $cat['categoria_id'] ?? 1; ?>
                            <option value="<?= $catId ?>" <?= ($catId == $producto['id_categoria']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Nombre del archivo de imagen:</label>
                    <input type="text" name="imagen" value="<?= htmlspecialchars($producto['imagen']) ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="background-color: #3b82f6; color: #ffffff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Actualizar Producto</button>
                    <a href="http://localhost/spare-parts-jb/productos" style="background-color: #6b7280; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; text-align: center;">Cancelar</a>
                </div>
            </form>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_producto'];
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $id_categoria = $_POST['id_categoria'] ?? 1;
            $imagen = $_POST['imagen'] ?? 'default.jpg';

            try {
                $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $db->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, id_categoria = ?, imagen = ? WHERE id_producto = ?");
                $stmt->execute([$nombre, $descripcion, $precio, $stock, $id_categoria, $imagen, $id]);
            } catch (Exception $e) {
                echo "Error al actualizar: " . $e->getMessage();
                exit();
            }
            
            header("Location: http://localhost/spare-parts-jb/productos");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $db = new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
                $stmt = $db->prepare("DELETE FROM productos WHERE id_producto = ?");
                $stmt->execute([$id]);
            } catch (Exception $e) {
                // Manejo de errores
            }
        }
        header("Location: http://localhost/spare-parts-jb/productos");
        exit();
    }
}