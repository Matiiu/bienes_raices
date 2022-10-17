<?php

define('TEMPLATES_URL', __DIR__.'/templates');
define('FUNCIONES_URL', __DIR__.'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . "/imagenes/");

function incluirTemplate(string $n, bool $init = false)
{

    include TEMPLATES_URL . "/${n}.php";
}


function autenticado() {
    session_start();   

    if (!$_SESSION['login']) {
      header('Location: /');
    } 
}


function debuguear($v) {
    echo '<pre>'; 
     var_dump($v); 
     echo '</pre>'; 
     exit;   
     
}

//Escapar/sanitizar el HTML
function s($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido 
function validarTipo($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);

}

//Muestra mensajes 
function mostrarNotificacion($codigo) {
    $mensaje = '';
    switch($codigo) {
        case 1: 
            $mensaje = 'Creado Correctamente';
            break;
        case 2: 
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3: 
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;

}

function redireciconar(string $url) {
    //Validar que sea id válido 
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: ${$url}");
}

return $id;
}
