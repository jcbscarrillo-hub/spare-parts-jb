<?php
class CategoriasController {
    private function conectar() {
        return new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
    }

    public function index() {
        $categorias = [];
        try {
            $db = $this->conectar();
            $stmt = $db->query("SELECT * FROM categorias ORDER BY id_categoria DESC");
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            try {
                $db = $this->conectar();
                $stmt = $db->query("SELECT * FROM categoria ORDER BY id DESC");
                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $ex) {
                $categorias = [];
            }
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: Arial, sans-serif;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 4px;">Gestión de Categorías</h1>
                    <p style="color: #4b5563;">Administra las categorías de productos de Spare Parts JB.</p>
                </div>
                <a href="http://localhost/spare-parts-jb/categorias/crear" style="background-color: #16a34a; color: #ffffff; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                    + Crear Nueva Categoría
                </a>
            </div>

            <table style="width: 100%; border-collapse: collapse; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background-color: #111827; color: #ffffff; text-align: left;">
                        <th style="padding: 12px 16px;">ID</th>
                        <th style="padding: 12px 16px;">Nombre de Categoría</th>
                        <th style="padding: 12px 16px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $cat): ?>
                            <?php 
                                $catId = $cat['id_categoria'] ?? $cat['id'] ?? 1;
                                $catNombre = $cat['nombre'] ?? '';
                            ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px 16px; color: #374151;"><?= htmlspecialchars($catId) ?></td>
                                <td style="padding: 12px 16px; color: #111827; font-weight: bold;"><?= htmlspecialchars($catNombre) ?></td>
                                <td style="padding: 12px 16px; text-align: center; white-space: nowrap;">
                                    <a href="http://localhost/spare-parts-jb/categorias/editar?id=<?= $catId ?>" 
                                       style="background-color: #3b82f6; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; margin-right: 6px;">
                                        Editar
                                    </a>
                                    <a href="http://localhost/spare-parts-jb/categorias/eliminar?id=<?= $catId ?>" 
                                       onclick="return confirm('¿Estás seguro de eliminar esta categoría?');" 
                                       style="background-color: #dc2626; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold;">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="padding: 20px; text-align: center; color: #6b7280;">No hay categorías registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function crear() {
        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; font-family: Arial, sans-serif;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 20px;">Crear Nueva Categoría</h1>
            
            <form action="http://localhost/spare-parts-jb/categorias/guardar" method="POST">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Nombre de la Categoría:</label>
                    <input type="text" name="nombre" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="background-color: #16a34a; color: #ffffff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Guardar Categoría</button>
                    <a href="http://localhost/spare-parts-jb/categorias" style="background-color: #6b7280; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; text-align: center;">Cancelar</a>
                </div>
            </form>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            try {
                $db = $this->conectar();
                $stmt = $db->prepare("INSERT INTO categorias (nombre) VALUES (?)");
                $stmt->execute([$nombre]);
            } catch (Exception $e) {
                try {
                    $db = $this->conectar();
                    $stmt = $db->prepare("INSERT INTO categoria (nombre) VALUES (?)");
                    $stmt->execute([$nombre]);
                } catch (Exception $ex) {}
            }
            header("Location: http://localhost/spare-parts-jb/categorias");
            exit();
        }
    }

    public function editar() {
        if (!isset($_GET['id'])) {
            header("Location: http://localhost/spare-parts-jb/categorias");
            exit();
        }
        $id = $_GET['id'];
        $categoria = null;

        try {
            $db = $this->conectar();
            $stmt = $db->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
            $stmt->execute([$id]);
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            try {
                $db = $this->conectar();
                $stmt = $db->prepare("SELECT * FROM categoria WHERE id = ?");
                $stmt->execute([$id]);
                $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $ex) {}
        }

        if (!$categoria) {
            header("Location: http://localhost/spare-parts-jb/categorias");
            exit();
        }

        $catId = $categoria['id_categoria'] ?? $categoria['id'] ?? $id;
        $catNombre = $categoria['nombre'] ?? '';

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; font-family: Arial, sans-serif;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 20px;">Editar Categoría</h1>
            
            <form action="http://localhost/spare-parts-jb/categorias/actualizar" method="POST">
                <input type="hidden" name="id" value="<?= $catId ?>">
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px; color: #374151;">Nombre de la Categoría:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($catNombre) ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="background-color: #3b82f6; color: #ffffff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Actualizar Categoría</button>
                    <a href="http://localhost/spare-parts-jb/categorias" style="background-color: #6b7280; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; text-align: center;">Cancelar</a>
                </div>
            </form>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            try {
                $db = $this->conectar();
                $stmt = $db->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
                $stmt->execute([$nombre, $id]);
            } catch (Exception $e) {
                try {
                    $db = $this->conectar();
                    $stmt = $db->prepare("UPDATE categoria SET nombre = ? WHERE id = ?");
                    $stmt->execute([$nombre, $id]);
                } catch (Exception $ex) {}
            }
            header("Location: http://localhost/spare-parts-jb/categorias");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $db = $this->conectar();
                $stmt = $db->prepare("DELETE FROM categorias WHERE id_categoria = ?");
                $stmt->execute([$id]);
            } catch (Exception $e) {
                try {
                    $db = $this->conectar();
                    $stmt = $db->prepare("DELETE FROM categoria WHERE id = ?");
                    $stmt->execute([$id]);
                } catch (Exception $ex) {}
            }
        }
        header("Location: http://localhost/spare-parts-jb/categorias");
        exit();
    }
}