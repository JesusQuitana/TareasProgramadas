<main class="registro">
    <h1>UpTask</h1>

<?php
    alertas($alertas);
?>
    <p>Ingresa el Token Enviado a tu correo</p>
    <section>
        <form class="formulario tokens" method="post">
            <input type="number" class="token">
            <input type="number" class="token">
            <input type="number" class="token">
            <input type="number" class="token">
            <input type="number" class="token">
            <input type="number" class="token">

            <div class="botones">
                <input type="submit" value="Confirmar" class="btn verde">
            </div>
        </form>
    </section>
</main>
<?php
    script("confirmar");
    script("quitarAlertas");
?>