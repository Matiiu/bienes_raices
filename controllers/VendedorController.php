<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{

    public static function crear(Router $router)
    {
        $vendedor = new Vendedor;      

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crear una nueva instacia
            $vendedor = new Vendedor($_POST['vendedor']);
        
            //Validar que no haya campos vacios
            $errores = $vendedor->validar();
        
            if(empty($errores)) {
                $vendedor->guardar();
            }
        
        }
        $errores = Vendedor::getErrores();
        $router->render("vendedores/crear",[
            "errores" => $errores,
            "vendedor" => $vendedor,
           

        ]);
    }


    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = redireciconar("/admin");
        $vendedor = Vendedor::find($id);
       

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Asignar valores
            $args = $_POST['vendedor'];
        
            //Sincronizar objeto en memoria
            $vendedor->sincronizar($args);
        
            //valifaciones
            $errores = $vendedor->validar();
        
            if( empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("vendedores/actualizar", [
            "errores" => $errores,            
            "vendedor" => $vendedor,
           
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
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();                 
                }
            }
        }
    }
}
