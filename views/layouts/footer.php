<?php
// Fin de la página / Footer general
?>

<!-- Sección ¿Quiénes somos? -->
<div style="background-color: #12151c; border-top: 1px solid #2d3748; padding: 35px 20px; text-align: center; font-family: sans-serif; color: #e5e7eb; margin-top: 50px;">
    <div style="max-width: 700px; margin: 0 auto;">
        <h3 style="color: #ffffff; font-size: 20px; margin-bottom: 20px; font-weight: bold;">¿Quiénes somos?</h3>
        
        <!-- Fotos y Nombres de los Creadores -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 40px; margin-bottom: 20px; flex-wrap: wrap;">
            
            <!-- Creador 1: Brayan -->
            <div style="text-align: center;">
                <img src="/spare-parts-jb/public/img/brayan.png" 
                     alt="Brayan Hincapié" 
                     style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 2px solid #eab308; box-shadow: 0 4px 10px rgba(0,0,0,0.5);"
                     onerror="this.onerror=null; this.src='/spare-parts-jb/public/uploads/brayan.png';">
                <p style="margin: 8px 0 0 0; font-weight: bold; color: #eab308; font-size: 15px;">Brayan Hincapié</p>
                <span style="font-size: 12px; color: #9ca3af;">Desarrollador</span>
            </div>

            <!-- Creador 2: Anderson -->
            <div style="text-align: center;">
                <img src="/spare-parts-jb/public/img/anderson.png" 
                     alt="Anderson Carrillo" 
                     style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 2px solid #eab308; box-shadow: 0 4px 10px rgba(0,0,0,0.5);"
                     onerror="this.onerror=null; this.src='/spare-parts-jb/public/uploads/anderson.png';">
                <p style="margin: 8px 0 0 0; font-weight: bold; color: #eab308; font-size: 15px;">Anderson Carrillo</p>
                <span style="font-size: 12px; color: #9ca3af;">Desarrollador</span>
            </div>

        </div>

        <p style="font-size: 14px; color: #9ca3af; line-height: 1.6; margin: 0;">
            Desarrolladores y creadores de este proyecto enfocado en ofrecer soluciones eficientes para la gestión y administración de repuestos y accesorios para motocicletas.
        </p>
    </div>
</div>

<!-- Pie de página inferior -->
<footer style="background-color: #0b0e14; color: #9ca3af; text-align: center; padding: 15px; font-size: 12px; font-family: sans-serif;">
    <p style="margin: 0;">&copy; <?= date('Y') ?> Spare Parts JB. Todos los derechos reservados. Fines académicos. SENA CDM.</p>
</footer>

</body>
</html>