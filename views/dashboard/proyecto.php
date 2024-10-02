<main class="uptask">
    <?php include dirname(__DIR__) . "/dashboard.php"; ?>

    <input type="hidden" name="ulr" id="url" value="<?php echo $proyecto; ?>">

    <section class="proyectoAll">
        <div class="jesusQ">
            <p>Hola, <span><?php echo $usuario["nombre"]; ?></span></p>
            <a href="/logout" class="btn naranja">Cerrar Session</a>
        </div><hr>

        <div class="tareas">
            <div class="new">
                <a class="btn verde" id="newTarea">Crear Nuevo Tarea</a>
            </div>

            <div class="delete">
                <a class="btn rojo" id="eliminarProyecto">Eliminar Proyecto</a>
            </div>

            <div id="tareas">
                
            </div>
        </div>
        
    </section>
</main>
<?php script("proyectoTarea"); ?>