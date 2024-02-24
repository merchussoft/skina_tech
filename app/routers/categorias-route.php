<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$categorias = new Categorias();
$jwt_decode = new AuthJwt();

$app->get('/categorias', function (Request $request, Response $response) use ($categorias){
    $ver_categorias = $categorias->listarCategorias();
    return $response
        ->withStatus($ver_categorias['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($ver_categorias['data']));
});

$app->get('/categorias/{cod}', function (Request $request, Response $response, $args) use ($categorias){
    $ver_categorias = $categorias->listarCategorias($args['cod']);
    return $response
        ->withStatus($ver_categorias['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($ver_categorias['data']));
});

$app->post('/categorias/crear', function (Request $request, Response $response) use ($categorias) {
    $result = $categorias->guardarCategorias($request->getParsedBody());
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/categorias/update/{cod}', function (Request $request, Response $response, $args) use ($categorias) {
    $result = $categorias->actualizarCategoria($request->getParsedBody(), $args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->get('/categorias/delete/{cod}', function (Request $request, Response $response, $args) use ($categorias) {
    $result = $categorias->borrarCategorias($args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);