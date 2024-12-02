<?php

include "./config/Database.php";

$db = new Database();
$valida = $db->connect();

if($valida){
    echo"Coneccion establecida correctamente";
}else {
    echo"Coneccion no establecida correctamente";
}
