<?php
class ClientesController {
    private function conectar() {
        return new PDO('mysql:host=localhost;dbname=spare_parts_jb;charset=utf8', 'root', '');
    }

    private function obtenerTablaActiva($db) {
        $tablas = ['usuarios', 'users', 'cliente', 'clientes'];
        foreach ($tablas as $t) {
            try {
                $stmt = $db->query("SELECT 1 FROM $t LIMIT 1");
                if ($stmt) return $t;
            } catch (Exception $e) {
                continue;
            }
        }
        return 'clientes';
    }

    private function obtenerColumnaId($db, $tabla) {
        try {
            $stmt = $db->query("DESCRIBE $tabla");
            $columnas = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach (['id_cliente', 'id_usuario', 'id', 'user_id'] as $col) {
                if (in_array($col, $columnas)) return $col;
            }
        } catch (Exception $e) {}
        return 'id_cliente';
    }

    public function index() {
        $clientes = [];
        try {
            $db = $this->conectar();
            $tablaActiva = $this->obtenerTablaActiva($db);
            $idCol = $this->obtenerColumnaId($db, $tablaActiva);
            
            $stmt = $db->query("SELECT * FROM $tablaActiva ORDER BY $idCol DESC");
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $clientes = [];
        }

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: Arial, sans-serif;">
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 1.8rem; font-weight: bold; color: #111827; margin-bottom: 4px;">Módulo de Clientes</h1>
                <p style="color: #4b5563;">Listado de usuarios registrados en Spare Parts JB.</p>
            </div>

            <table style="width: 100%; border-collapse: collapse; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background-color: #111827; color: #ffffff; text-align: left;">
                        <th style="padding: 12px 16px;">ID</th>
                        <th style="padding: 12px 16px;">Nombre</th>
                        <th style="padding: 12px 16px;">Correo Electrónico</th>
                        <th style="padding: 12px 16px;">Rol / Tipo</th>
                        <th style="padding: 12px 16px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <?php 
                                $idVal = $c[$idCol] ?? $c['id_cliente'] ?? $c['id_usuario'] ?? $c['id'] ?? 1;
                                $nombreVal = $c['nombre'] ?? $c['name'] ?? '';
                                $correoVal = $c['correo'] ?? $c['email'] ?? '';
                            ?>
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px 16px; color: #374151;"><?= htmlspecialchars($idVal) ?></td>
                                <td style="padding: 12px 16px; color: #111827; font-weight: bold;"><?= htmlspecialchars($nombreVal) ?></td>
                                <td style="padding: 12px 16px; color: #374151;"><?= htmlspecialchars($correoVal) ?></td>
                                <td style="padding: 12px 16px;">
                                    <span style="background: #f3f4f6; color: #374151; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Cliente</span>
                                </td>
                                <td style="padding: 12px 16px; text-align: center; white-space: nowrap;">
                                    <a href="http://localhost/spare-parts-jb/clientes/editar?id=<?= $idVal ?>" 
                                       style="background-color: #3b82f6; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; margin-right: 6px;">
                                        Editar
                                    </a>
                                    <a href="http://localhost/spare-parts-jb/clientes/eliminar?id=<?= $idVal ?>" 
                                       onclick="return confirm('¿Estás seguro de eliminar este cliente?');" 
                                       style="background-color: #dc2626; color: #ffffff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold;">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: #6b7280;">No hay clientes registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
        require_once 'views/layouts/footer.php';
    }

    public function editar() {
        if (!isset($_GET['id'])) {
            header("Location: http://localhost/spare-parts-jb/clientes");
            exit();
        }
        $id = $_GET['id'];
        $cliente = null;

        try {
            $db = $this->conectar();
            $tablaActiva = $this->obtenerTablaActiva($db);
            $idCol = $this->obtenerColumnaId($db, $tablaActiva);

            $stmt = $db->prepare("SELECT * FROM $tablaActiva WHERE $idCol = ?");
            $stmt->execute([$id]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}

        if (!$cliente) {
            header("Location: http://localhost/spare-parts-jb/clientes");
            exit();
        }

        $nombreVal = $cliente['nombre'] ?? $cliente['name'] ?? '';
        $correoVal = $cliente['correo'] ?? $cliente['email'] ?? '';

        require_once 'views/layouts/header.php';
        ?>
        <div style="max-width: 600px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 8px; font-family: Arial, sans-serif;">
            <h1 style="font-size: 1.5rem; font-weight: bold; color: #111827; margin-bottom: 20px;">Editar Cliente</h1>
            
            <form action="http://localhost/spare-parts-jb/clientes/actualizar" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Nombre del Cliente:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($nombreVal) ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 6px;">Correo Electrónico:</label>
                    <input type="email" name="correo" value="<?= htmlspecialchars($correoVal) ?>" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="background-color: #3b82f6; color: #ffffff; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Actualizar Cliente</button>
                    <a href="http://localhost/spare-parts-jb/clientes" style="background-color: #6b7280; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; text-align: center;">Cancelar</a>
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
            $correo = $_POST['correo'] ?? '';

            try {
                $db = $this->conectar();
                $tablaActiva = $this->obtenerTablaActiva($db);
                $idCol = $this->obtenerColumnaId($db, $tablaActiva);

                foreach (['correo', 'email'] as $colCorreo) {
                    try {
                        $stmt = $db->prepare("UPDATE $tablaActiva SET nombre = ?, $colCorreo = ? WHERE $idCol = ?");
                        $stmt->execute([$nombre, $correo, $id]);
                        break;
                    } catch (Exception $ex) {}
                }
            } catch (Exception $e) {}
            
            header("Location: http://localhost/spare-parts-jb/clientes");
            exit();
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $db = $this->conectar();
                $tablaActiva = $this->obtenerTablaActiva($db);
                $idCol = $this->obtenerColumnaId($db, $tablaActiva);

                $stmt = $db->prepare("DELETE FROM $tablaActiva WHERE $idCol = ?");
                $stmt->execute([$id]);
            } catch (Exception $e) {}
        }
        header("Location: http://localhost/spare-parts-jb/clientes");
        exit();
    }
}