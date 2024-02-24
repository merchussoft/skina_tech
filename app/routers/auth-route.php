<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$auth_ctrl = new AuthCtrl();

$app->post('/login', function (Request $request, Response $response, array $args) use ($auth_ctrl) {
    $result_login = $auth_ctrl->Login($request->getParsedBody());
    return $response
        ->withStatus($result_login['code'])
        ->write(json_encode($result_login));
});
