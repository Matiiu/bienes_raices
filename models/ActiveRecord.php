<?php

namespace Model;

class ActiveRecord
{
    //DB
    protected static $db;
    protected static $colDB = [];
    protected static $tabla = '';
    //Errores
    protected static $errores = [];   

    //Definir la conexión a la DB
    public static function setDB($database) {
        self::$db = $database;
    }
   
    public function guardar()
    {
        if (!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function crear()
    {
        //Sanitizar 
        $atributos = $this->sanitizarAtributos();

      
        //Note: join() toma dos parametros 1- El separador 2-El arrelo que se va aplanar
        //De esta manera se reemplaza el query comvencional keys = Se refiere a las colomnas de la db. value: valor que se le asigna
        $query = "INSERT INTO ". static::$tabla  ." ( ";
        $query .=  join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ' ) ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar()
    {
        //Sanitizar 
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }
        $query = "UPDATE ". static::$tabla  ." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }

    //Eliminar registros
    public function eliminar()
    {
        //ELIMINAR LA PROPIEDAD
        $query = "DELETE FROM ". static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    //Identificar y unir los atributos de la DB
    public function atributos()
    {
        $atributos = [];
        foreach (static::$colDB as $col) {
            if ($col === 'id') continue;
            $atributos[$col] = $this->$col;
        }
        return $atributos;
    }


    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subir archivos 
    public function setImagen($imagen)
    {
        //Asignar a l atributo de imagen el nombre de la imagen

        if (!is_null($this->id)) {
            //Elimina imagen previa 
            $this->borrarImagen();
        }
        if ($imagen) {
            //Asignarle  al atributo de imagen el nombre de la imagen
            $this->imagen = $imagen;
        }
    }

    //Elimina el archivo 
    public function borrarImagen()
    {
        //Comprobar si existe aarchivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Validación
    public static function  getErrores() {
        return static::$errores;
    }

    public function validar() {        
        static::$errores = [];
        return static::$errores;
    }

    //Listar el registro 
    public static function all()
    {
        $query = "SELECT * FROM ". static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Obtiene determinado numero de registros 
    public static function get($cantidad)
    {
        $query = "SELECT * FROM ". static::$tabla . " LIMIT " .$cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Busca un registro por id
    public static function find($id)
    {
        $query = "SELECT * FROM ". static::$tabla ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    public static function consultarSQL($query)
    {
        //Consutlar db 
        $resultado = self::$db->query($query);
        //Iterar resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria 
        $resultado->free();
        //Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincronizar el objeto en memoria con los  cambios actiualizados por el user
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
