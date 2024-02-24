<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$user_ctrl = new Usuarios();
$jwt_decode = new AuthJwt();

$app->get('/users', function (Request $request, Response $response, array $args) use ($user_ctrl) {
    $listar_usuario = $user_ctrl->listarUsuario();
    return $response
        ->withStatus($listar_usuario['code'])
        ->write(json_encode($listar_usuario));
})->add($jwt_decode);


$app->get('/users/{cod}', function (Request $request, Response $response, $args) use ($user_ctrl) {
    $result = $user_ctrl->listarUsuario($args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->get('/users/delete/{cod}', function (Request $request, Response $response, $args) use ($user_ctrl) {
    $result = $user_ctrl->eliminarUsuario($args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/users/crear', function (Request $request, Response $response) use ($user_ctrl) {
    $result = $user_ctrl->agregarUsuario($request->getParsedBody());
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->post('/users/update/{cod}', function (Request $request, Response $response, $args) use ($user_ctrl) {
    $result = $user_ctrl->actualizarUsuario($request->getParsedBody(), $args['cod']);
    return $response
        ->withStatus($result['code'])
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
})->add($jwt_decode);

$app->get('/perfil', function (Request $request, Response $response, array $args) use ($user_ctrl) {
    $listar = $user_ctrl->listarPerfiles();
    return $response
        ->withStatus($listar['code'])
        ->write(json_encode($listar));
});
