<?php require_once 'views/layouts/header.php'; ?>

<main class="container" style="display: flex; justify-content: center; align-items: center; min-height: 75vh; padding: 20px 0;">
    <div style="background: #ffffff; width: 100%; max-width: 420px; padding: 35px 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #eee;">
        
        <h2 style="text-align: center; margin-bottom: 25px; color: #222; font-size: 26px; font-weight: 700;">Iniciar Sesión</h2>

        <?php if (isset($_GET['registrado'])): ?>
            <div style="background-color: #e6fffa; color: #007a5e; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px; border: 1px solid #b2f5ea;">
                ¡Registro exitoso! Ya puedes iniciar sesión.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px; border: 1px solid #ffcccc;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/spare-parts-jb/auth/login" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            
            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; font-size: 14px; color: #444;">Correo Electrónico *</label>
                <input type="email" id="email" name="email" required placeholder="tu@correo.com" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-weight: 600; font-size: 14px; color: #444;">Contraseña *</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box;">
            </div>

            <button type="submit" style="background-color: #e60000; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; transition: background 0.3s;">
                Ingresar
            </button>

        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
            ¿No tienes cuenta? <a href="/spare-parts-jb/auth/registro" style="color: #e60000; text-decoration: none; font-weight: bold;">Regístrate aquí</a>
        </p>

    </div>
</main>

<?php require_once 'views/layouts/footer.php'; ?>