<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Parts JB - Repuestos de Motos</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f8fafc; color: #1e293b; }
        
        .main-header {
            background-color: #111827 !important;
            padding: 14px 0 !important;
            width: 100% !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .nav-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0 20px !important;
        }
        .logo {
            color: #ffffff !important;
            font-size: 1.35rem !important;
            font-weight: 800 !important;
            text-decoration: none !important;
        }
        .nav-links {
            display: flex !important;
            gap: 16px !important;
            align-items: center !important;
            font-size: 0.85rem !important;
        }
        .nav-links a { 
            text-decoration: none !important; 
        }
        .nav-links a:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="nav-container">
            <a href="http://localhost/spare-parts-jb/home" class="logo">
                Spare Parts <span style="color: #dc2626;">JB</span>
            </a>

            <nav class="nav-links">
                <a href="http://localhost/spare-parts-jb/home" style="color: #ffffff;">Catálogo</a>
                <a href="http://localhost/spare-parts-jb/home?categoria=1" style="color: #facc15; font-weight: bold;">Cascos</a>
                <a href="http://localhost/spare-parts-jb/home?categoria=2" style="color: #facc15; font-weight: bold;">Accesorios</a>
                <a href="http://localhost/spare-parts-jb/home?categoria=3" style="color: #facc15; font-weight: bold;">Repuestos</a>
                <a href="http://localhost/spare-parts-jb/clientes" style="color: #facc15; font-weight: bold;">Admin Clientes</a>
                <a href="http://localhost/spare-parts-jb/productos" style="color: #facc15; font-weight: bold; text-decoration: none;">Admin Productos</a>
                <a href="http://localhost/spare-parts-jb/categorias" style="color: #facc15; font-weight: bold;">Admin Categorías</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span style="color: #ffffff;">Hola, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
                    <a href="http://localhost/spare-parts-jb/auth/logout" style="color: #ffffff;">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="http://localhost/spare-parts-jb/auth/login" style="color: #ffffff;">Iniciar Sesión</a>
                    <a href="http://localhost/spare-parts-jb/auth/register" style="color: #ffffff;">Registrarse</a>
                <?php endif; ?>

                <a href="http://localhost/spare-parts-jb/carrito" style="color: #dc2626; font-weight: bold;">🛒 Carrito</a>
            </nav>
        </div>
    </header>