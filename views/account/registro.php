<main class="registro">
    <h1>UpTask</h1>

    <?php
        alertas($alertas);
    ?>
    <section>
        <form class="formulario" method="post">
            <input type="text" name="nombre" id="nombre" max="30" autocomplete="off" placeholder="Tu Nombre" required>

            <input type="email" name="email" id="email" max="30" autocomplete="off" placeholder="Tu Correo" required>

            <input type="password" name="password" id="password" max="60" placeholder="Tu Contraseña" required>

            <input type="password" name="password_repeat" id="password_repeat" max="60" placeholder="Repite tu Contraseña" required>

            <div class="botones">
                <input type="submit" value="Registrarse" class="btn verde">
                <a href="/" class="btn naranja">Volver</a>
            </div>
        </form>
    </section>
</main>
<?php script("modalLoading"); script("quitarAlertas"); ?>