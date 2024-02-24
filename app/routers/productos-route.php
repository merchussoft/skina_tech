<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$__p_ctrl = new Productos();
$jwt_decode = new AuthJwt();

$app->get('/productos', function (Request $request, Response $response, $args) use ($__p_ctrl) {
    $result = $__p_ctrl->listarProductos();
    return $response
        ->withStatus($result['code'])
        ->write(json_encode($result));
});


$app->post('/productos/crear', function (Request $request, Response $response, $args) use ($__p_ctrl) {
    $result = $__p_ctrl->guardarProducto($request->getParsedBody());
    return $response
        ->withStatus($result['code'])
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/productos/delete', function (Request $request, Response $response, $args) use ($__p_ctrl) {
    $result = $__p_ctrl->deleteProducto($request->getParsedBody());
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/productos/editar', function (Request $request, Response $response, $args) use ($__p_ctrl) {
    $result = $__p_ctrl->editarProducto($request->getParsedBody());
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);
