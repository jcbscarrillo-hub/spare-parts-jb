<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Parts JB</title>
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="/spare-parts-jb/public/css/style.css">
</head>
<body style="background-color: #ffffff; color: #111827; font-family: sans-serif; margin: 0;">

    <!-- Barra de Navegación Principal -->
    <header style="background-color: #12151c; border-bottom: 1px solid #2d3748; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        
        <!-- Logo / Nombre -->
        <div>
            <a href="/spare-parts-jb/home" style="color: #ffffff; text-decoration: none; font-size: 20px; font-weight: bold; display: block; line-height: 1.1;">
                Spare Parts <br><span style="color: #dc2626;">JB</span>
            </a>
        </div>

        <!-- Enlaces del Menú -->
        <nav style="display: flex; gap: 15px; align-items: center; font-size: 14px; flex-wrap: wrap;">
            
            <!-- Opciones del Catálogo -->
            <a href="/spare-parts-jb/home" onclick="irACategoria('todos'); return false;" style="color: #d1d5db; text-decoration: none; cursor: pointer;">Catálogo</a>
            <a href="/spare-parts-jb/home" onclick="irACategoria('cascos'); return false;" style="color: #d1d5db; text-decoration: none; cursor: pointer;">Cascos</a>
            <a href="/spare-parts-jb/home" onclick="irACategoria('accesorios'); return false;" style="color: #d1d5db; text-decoration: none; cursor: pointer;">Accesorios</a>
            <a href="/spare-parts-jb/home" onclick="irACategoria('repuestos'); return false;" style="color: #d1d5db; text-decoration: none; cursor: pointer;">Repuestos</a>

            <!-- Opción de Tratamiento de datos -->
            <a href="#" onclick="abrirModalDatos(event)" style="color: #d1d5db; text-decoration: none; cursor: pointer;">Tratamiento de datos</a>

            <!-- Opciones de administración (Visible únicamente para administradores) -->
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="/spare-parts-jb/clientes" style="color: #eab308; text-decoration: none; font-weight: bold;">Admin Clientes</a>
                <a href="/spare-parts-jb/productos" style="color: #eab308; text-decoration: none; font-weight: bold;">Admin Productos</a>
                <a href="/spare-parts-jb/categorias" style="color: #eab308; text-decoration: none; font-weight: bold;">Admin Categorías</a>
                <a href="/spare-parts-jb/reportes" style="color: #eab308; text-decoration: none; font-weight: bold;">Reportes</a>
            <?php endif; ?>

            <!-- Sesión y Carrito -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: #eab308;">Hola, <?= htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario') ?></span>
                <a href="/spare-parts-jb/auth/logout" style="color: #ef4444; text-decoration: none;">Cerrar Sesión</a>
            <?php else: ?>
                <a href="/spare-parts-jb/auth/login" style="color: #d1d5db; text-decoration: none;">Iniciar Sesión</a>
                <a href="/spare-parts-jb/auth/registro" style="background-color: #eab308; color: #111827; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold;">Registrarse</a>
            <?php endif; ?>

            <a href="/spare-parts-jb/carrito" style="color: #d1d5db; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                🛒 Carrito
            </a>
        </nav>
    </header>

    <!-- Ventana Modal de Tratamiento de Datos -->
    <div id="modalTratamientoDatos" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); justify-content: center; align-items: center; z-index: 9999;">
        <div style="background-color: #1e222a; width: 550px; max-width: 90%; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.5); font-family: sans-serif; color: #e5e7eb;">
            <div style="background-color: #12151c; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d3748;">
                <span style="font-weight: bold; font-size: 16px; color: #ffffff;">Tratamiento de datos</span>
                <button onclick="cerrarModalDatos()" style="background: none; border: none; color: #9ca3af; font-size: 20px; cursor: pointer; font-weight: bold;">&times;</button>
            </div>
            <div style="padding: 20px; font-size: 14px; line-height: 1.6; color: #d1d5db; text-align: left;">
                <p style="margin: 0;">
                    El presente proyecto tiene fines exclusivamente académicos. Los datos utilizados durante el desarrollo, las pruebas y la demostración del sistema son ficticios y fueron creados únicamente con fines de simulación. El sistema no recolecta, almacena ni procesa datos personales reales de estudiantes, docentes o terceros.
                </p>
            </div>
            <div style="padding: 15px 20px; background-color: #12151c; display: flex; justify-content: flex-end; border-top: 1px solid #2d3748;">
                <button onclick="cerrarModalDatos()" style="background-color: #eab308; color: #111827; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px;">
                    Entendido
                </button>
            </div>
        </div>
    </div>

    <script>
        function irACategoria(cat) {
            const secTodos = document.getElementById('seccion-todos');
            
            // Si estamos en la vista principal (home), filtramos directamente
            if (secTodos) {
                filtrarCategoria(cat);
            } else {
                // Si estamos en cualquier panel de admin, redirigimos al home con el filtro
                window.location.href = '/spare-parts-jb/home?cat=' + cat;
            }
        }

        function filtrarCategoria(cat) {
            const secTodos = document.getElementById('seccion-todos');
            const seccionesCat = document.querySelectorAll('.seccion-categoria');

            if (!secTodos) return;

            if (cat === 'todos') {
                secTodos.style.display = 'block';
                seccionesCat.forEach(sec => sec.style.display = 'none');
            } else {
                secTodos.style.display = 'none';
                seccionesCat.forEach(sec => {
                    if (sec.id === 'sec-' + cat) {
                        sec.style.display = 'block';
                    } else {
                        sec.style.display = 'none';
                    }
                });
            }
        }

        // Al cargar la página, si viene con parámetro 'cat' en la URL, aplicamos el filtro
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const catParam = urlParams.get('cat');
            if (catParam) {
                filtrarCategoria(catParam);
            }
        });

        function abrirModalDatos(event) {
            event.preventDefault();
            document.getElementById('modalTratamientoDatos').style.display = 'flex';
        }

        function cerrarModalDatos() {
            document.getElementById('modalTratamientoDatos').style.display = 'none';
        }
    </script>