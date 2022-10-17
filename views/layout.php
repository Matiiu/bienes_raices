<?php
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? null;

if (!isset($init)) {
    $init = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/build/img/iconBienes.png">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Bienes Raices</title>
</head>

<body>
    <header class="header <?php echo $init ? 'inicio' : '' ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <div class="nav-icon">

                        <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Icono Dark Mode">

                        <div class="nav-login ">
                            <a class="nav-login-boton" href=" <?php echo !$auth ?  '/login' : '/logout' ?> ">
                                <img src="/build/img/icon-login.svg" alt="Icono Login" width="40" height="35">
                            </a>
                            <?php if (!$auth) : ?>
                                <a class="nav-enlace-login" href="/login">Iniciar Sesión</a>
                            <?php else : ?>
                                <a class="nav-enlace-login" href="/logout">Cerrar Sesión</p>
                                <?php endif; ?>
                        </div>
                    </div>
                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>

                    </nav>
                </div>
            </div>
            <!--.barra -->
            <?php echo $init ? "<h1> Venta de Casas y Departamentos de Lujo </h1>" : ''; ?>
        </div>
    </header>

    <?php echo $contenido; ?>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="/nosotros">Nosotros</a>
                <a href="/propiedades">Anuncios</a>
                <a href="/blog">Blog</a>
                <a href="/contacto">Contacto</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos reservados <?php echo date('Y'); ?> &copy;</p>
    </footer>

    <script src="/build/js/bundle.min.js"></script>



</body>

</html>