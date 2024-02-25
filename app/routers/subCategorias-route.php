<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$sc_ci = new SubCategorias();
$jwt_decode = new AuthJwt();

$app->get('/subcategorias', function (Request $request, Response $response, $args) use ($sc_ci){
    $result = $sc_ci->listarSubCategorias();
    return $response
        ->withStatus($result['code'])
        ->write(json_encode($result));
});

$app->get('/subcategorias/{cod}', function (Request $request, Response $response, $args) use ($sc_ci){
    $result = $sc_ci->listarSubCategorias($args['cod']);
    return $response
        ->withStatus($result['code'])
        ->write(json_encode($result));
});


$app->post('/subcategorias/crear', function (Request $request, Response $response) use ($sc_ci) {
    $result = $sc_ci->guardarSubCategorias($request->getParsedBody());
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);



$app->get('/subcategorias/delete/{cod}', function (Request $request, Response $response, $args) use ($sc_ci) {
    $result = $sc_ci->eliminarSubCategorias($args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/subcategorias/update/{cod}', function (Request $request, Response $response, $args) use ($sc_ci) {
    $result = $sc_ci->actualizarSubCategorias($request->getParsedBody(), $args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);