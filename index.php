<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;

require './config.php';
require './autoload.php';
spl_autoload_register("api_autoload");

$settings = require SYSTEMS . '/settingSlim.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// aqui se establecen las rutas que vamos a usar
include ROUTERS . 'auth-route.php';
include ROUTERS. 'categorias-route.php';
include ROUTERS . 'subCategorias-route.php';
include ROUTERS . 'productos-route.php';
include ROUTERS . 'usuarios-route.php';


$app->run();