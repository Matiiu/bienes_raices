<?php

function connectionDB() : mysqli {
$db = new mysqli('localhost', 'root', '', 'bienes_raices');

if(!$db) {
    echo 'Error no se pudo conectar';
    exit; 
} 

return $db;

}