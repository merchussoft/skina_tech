<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthJwt {
    function __constructor() {}

    public function __invoke(Request $req, Response $res, $next) {
        $auth_header = $req->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $auth_header);
        if ($token) {
            try {
                JWT::decode($token, new Key(SECRET_KEY_JWT, ALGORIT_JWT));
                return $next($req, $res);
            } catch (Exception $e) {
                $res->getBody()->write(json_encode(['code' => 401, 'data' => ['message' => 'Token inválido']]));
                return $res->withHeader('Content-Type', 'application/json')->withStatus(401);
            }
        } else {
            $res->getBody()->write(json_encode(['code' => 401, 'data' => ['message' => 'Token no proporcionado']]));
            return $res->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }

}