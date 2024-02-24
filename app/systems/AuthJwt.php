<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthJwt {
    function __constructor() {}

    public function __invoke(Request $req, Response $response, $next) {
        $auth_header = $req->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $auth_header);
        if ($token) {
            try {
                JWT::decode($token, new Key(SECRET_KEY_JWT, ALGORIT_JWT));
                return $next($req, $response);
            } catch (Exception $e) {
                $response->getBody()->write(json_encode(['code' => 401, 'data' => ['message' => 'Token inválido']]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        } else {
            $response->getBody()->write(json_encode(['code' => 401, 'data' => ['message' => 'Token no proporcionado']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }

}