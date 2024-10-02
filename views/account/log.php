<main class="log">
    <h1>UpTask</h1>

    <section>
        <?php
        alertas($alertas);
        ?>
        <form class="formulario" method="post">
            <input type="email" name="email" id="email" max="30" autocomplete="off" placeholder="Tu Correo" required>

            <input type="password" name="password" id="password" max="60" placeholder="Tu Contraseña" required>

            <input type="submit" value="Ingresar" class="btn verde">
        </form>

        <div class="acciones">
            <a href="/registro">&raquo; Registrarse &laquo;</a>
            <a href="/olvido">&raquo; Olvido de Contraseña &laquo;</a>
        </div>
    </section>
</main>
<?php script("quitarAlertas"); ?>