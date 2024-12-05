<?php
//CODIGO PARA VALIDAR QUE LA BASE DE DATOS ESTA CONECTADA
// include "./config/Database.php";

// $db = new Database();
// $valida = $db->connect();

// if($valida){
//     echo"Coneccion establecida correctamente";
// }else {
//     echo"Coneccion no establecida correctamente";}

//MANEJO DE ERRORES
error_reporting(E_ALL);
ini_set('display_errors',1);

// CARGAR EL ARCHIVO DE CONFIGURACION
require_once 'config/config.php';

//AUTOLOAD DE CLASES (esto se encarga de traen los archivos controladores)
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            // var_dump($file);
            require_once $file;
            return;
        }
    }
});

// CREAR UNA INSTANCIA DEL ROUTER
$router = new Router();

$public_routes = [
    '/web',
    '/login',
    '/register',
];

//OBTENER LA RUTA ACTUAL
$current_route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$current_route = str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$current_route);
// $current_route = la ruta despues de la carpeta del proyecto

//echo();
// var_dump(dirname($_SERVER['SCRIPT_NAME']));
// var_dump($current_route);
// die();

$router->add('GET','/web','WebController','index');
$router->add('GET','/login','AuthController','showLogin');
$router->add('GET','/register','AuthController','showRegister');

$router->add('POST','/auth/login','AuthController','login');
$router->add('POST','/auth/register','AuthController','register');

//DESPACHAR LA RUTA
try {
    $router->dispatch($current_route, $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    // Manejar el error
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}