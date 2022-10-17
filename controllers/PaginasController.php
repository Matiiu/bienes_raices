<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);

        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "init" => true

        ]);
    }



    public static function nosotros(Router $router)
    {
        $router->render("paginas/nosotros");
    }


    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = redireciconar("/propiedades");

        //Validar la propiedad por su id      
        $propiedad = Propiedad::find($id);

        $router->render("paginas/propiedad", [
            "propiedad" => $propiedad
        ]);
    }


    public static function blog(Router $router)
    {
        $router->render("paginas/blog");
    }


    public static function entrada(Router $router)
    {
        $router->render("paginas/entrada");
    }


    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            //Crear una instancia de PHPMailer
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '8a364e287d35ce';
            $mail->Password = '43ab617bf5b4a8';
            $mail->SMTPSecure = 'tls'; //transport legent seccurity
            $mail->Port = 2525;

            //Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'Bienes Raices');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir contenido
            $contenido = "<html>";
            $contenido .= "<p>Tienes un nuevo mensaje</p>";
            $contenido .= "<p>Nombre: " . $respuestas['nombre'] . "</p>";
            $contenido .= "<p>Mensaje: " . $respuestas['mensaje'] . "</p>";
            $contenido .= "<p>Vende o Compra: " . $respuestas['opciones'] . "</p>";
            $contenido .= "<p>Precio o Presupuesto  : $" . $respuestas['presupuesto'] . "</p>";
            $contenido .= "<p>Eligió ser contactado por: " . $respuestas['contacto'] . "</p>";
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= "<p>Teléfono: " . $respuestas['tel'] . "</p>";
                $contenido .= "<p>Fecha de Contacto: " . $respuestas['fecha'] . "</p>";
                $contenido .= "<p>Hora: " . $respuestas['hora'] . "</p>";
            } else {
                $contenido .= "<p>Email: " . $respuestas['email'] . "</p>";
            }

         
           

            $contenido .= "</html>";

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es teco alternativo sin HTML';

            //Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "El mensaje no  se pudo enviar...";
            }
        }
        $router->render("paginas/contacto", [
            "mensaje" => $mensaje
        ]);
    }
}
