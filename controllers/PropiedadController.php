<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{

    public static function index(Router $router)
    {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        //Mensaje condicional
        $resutlado = $_GET['resultado'] ?? null;


        $router->render("propiedades/admin", [
            "propiedades" => $propiedades,
            "resultado" => $resutlado,
            "vendedores" => $vendedores

        ]);
    }




    public static function crear(Router $router)
    {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

            //Subir archivos


            //Genera nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Setear la imagen 
            // Realiza un resize a la img con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $img = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            //Validar
            $errores = $propiedad->validar();

            if (empty($errores)) {
                //Guarda en la db
                //Crear la carpeta para subir imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                //Guarda la imagen en el servidor
                $img->save(CARPETA_IMAGENES . $nombreImagen);

                $propiedad->guardar();
            }
        }

        $router->render("propiedades/crear", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }



    public static function actualizar(Router $router)
    {
        $id = redireciconar("/admin");
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar atributos   
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            //Validaciones
            $errores = $propiedad->validar();

            //Genera nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Subida de archivos
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $img = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {

                    //Almacenar imagen
                    $img->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }
        }

        $router->render("/propiedades/actualizar", [
            "propiedad" => $propiedad,
            "errores" => $errores,
            "vendedores" => $vendedores
        ]);
    }


    public static function eliminar()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];

                if (validarTipo($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();                 
                }
            }
        }
    }
}
