<main class="uptask">
    <?php include dirname(__DIR__) . "/dashboard.php"; ?>

    <section class="proyectoAll">
        <div class="jesusQ">
            <p>Hola, <span><?php echo $usuario["nombre"]; ?></span></p>
            <a href="/logout" class="btn naranja">Cerrar Session</a>
        </div><hr>
        
        <div class="proyectos">
            <div class="new">
                <a class="btn verde" id="newProyecto">Crear Nuevo Proyecto</a>
            </div>    

            <?php
                foreach($proyectos as $proyecto) {
                    echo "<a href='/proyecto?proyecto=$proyecto->url'>";
                    echo "<article class='proyecto' id='$proyecto->id'>";
                    echo "<h3>$proyecto->proyecto</h3>";
                    echo "</article>";
                    echo "</a>";
                }
            ?>
            </a>
        </div>
    </section>
</main>
<?php script("proyectos"); ?>