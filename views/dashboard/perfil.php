<main class="uptask">
    <?php include dirname(__DIR__) . "/dashboard.php"; ?>

    <section class="perfil">
        <div class="jesusQ">
            <p>Hola, <span><?php echo $session["nombre"]; ?></span></p>
            <a href="/logout" class="btn naranja">Cerrar Session</a>
        </div><hr>

        <div class="info_perfil">
            <h2>Información del Perfil</h2>

            <?php
                alertas($alertas);
            ?>

            <form class="formulario" method="post">
                <input type="text" name="nombre" id="nombre" value="<?php echo $usuario->nombre; ?>">
                <input type="email" name="email" id="email" value="<?php echo $usuario->email; ?>">

                <h3>Cambiar Contraseña</h3>
                <input type="password" name="password" id="password" placeholder="Nueva Contraseña">
                <input type="password" name="password_repeat" id="password_repeat" placeholder="Repite la Contraseña">

                <div>
                    <input type="submit" value="Guardar Información" class="btn verde">
                </div>
            </form>
        </div>  
    </section>
</main>