<main class="registro">
    <h1>UpTask</h1>

<?php
    alertas($alertas);
?>
    <section>
        <form class="formulario tokens" method="post">
            <input type="number" class="token" tabindex="1">
            <input type="number" class="token" tabindex="2">
            <input type="number" class="token" tabindex="3">
            <input type="number" class="token" tabindex="4">
            <input type="number" class="token" tabindex="5">
            <input type="number" class="token" tabindex="6">
            
            <div class="botones">
                <input type="submit" value="Confirmar" class="btn verde">
            </div>
            <input type="hidden" id="email" value="<?php echo $email; ?>">
        </form>
    </section>
</main>
<?php script("olvido"); script("quitarAlertas"); ?>