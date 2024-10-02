<main class="uptask">
    <?php include dirname(__DIR__) . "/dashboard.php"; ?>

    <section class="acerca">
        <div class="jesusQ">
            <p>Hola, <span><?php echo $usuario["nombre"]; ?></span></p>
            <a href="/logout" class="btn naranja">Cerrar Session</a>
        </div><hr>

        <div>
            <h2>Todos los derechos resevados || JesusQ || <?php echo date("Y"); ?></h2>
            <p>Correo: <strong>jesus08quintanag@gmail.com</strong></p>
            <p>Instagram: <a href="https://www.instagram.com/jesus_equintana" target="_blank"><strong>@jesus_equintana</a></strong></p>
            <p>LinkedIn: <a href="https://www.linkedin.com/in/jesus-quintana-95a66b168" target="_blank"><strong>Jesus Quintana</a></strong></p>
            <p>GiHub: <a href="https://www.github.com/jesusquitana" target="_blank"><strong>JesusQuitana</a></strong></p>
        </div>
        
    </section>
</main>