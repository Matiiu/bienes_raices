<?php 

require 'funciones.php';
require 'config/db.php';
require __DIR__ .'/../vendor/autoload.php';

//Conexión a DB
$db = connectionDB();

use Model\ActiveRecord;

ActiveRecord::setDB($db);

