<main class="contenedor conetenido-centrado">
    <h1>Iniciar Sesión</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" action="/login">

        <fieldset>
            <legend>E-mail y Password</legend>
            <label for="email">E-mail:</label>
            <input type="email" placeholder="Tu E-mail" name="email" id="email" require>

            <label for="pass">Password:</label>
            <input type="password" placeholder="Tu Password" name="password" id="pass" require>
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">



    </form>
</main> 