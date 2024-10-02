<main class="olvido">
    <h1>UpTask</h1>
    
    <section id="olvido_contain">
        <div class="alertas">
            <?php
            alertas($alertas);
            ?>
        </div>
        <form method="post" action="/reestablecer" class="formulario">
            <input type="email" name="email" id="email" autocomplete="off" placeholder="Ingresa tu Correo Registrado" required>

            <div class="botones">
                <input type="submit" value="Enviar" class="btn verde" id="submit">
                <a href="/" class="btn naranja">Volver</a>
            </div>
        </form>
    </section>
</main>
<?php
script("modalLoading");
script("quitarAlertas");
?>