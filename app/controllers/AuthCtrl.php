<?php

use Firebase\JWT\JWT;

class AuthCtrl {

    protected $__key_sercret;
    protected $__database;

    function __construct() {
        $this->__key_sercret = SECRET_KEY_JWT;
        $this->__database = new DataBaseMysql();
    }

    function login($data = []) {
        $validate  = $this->validarUsuario($data);
        if(isset($validate['passw']) && md5($data['password']) === $validate['passw']) {
            $tokenId    = base64_encode(random_bytes(32));
            $expire     = time() + 600; // 10 minutos de tiempo de vida

            $payload = [
                'jti'  => $tokenId, // ID único del token
                'exp'  => $expire,  // Tiempo de expiración del token
                'data' => [
                    'rol' => $validate['perfil'],
                    'user' => $validate['cod_user'],
                ]
            ];

            $token = JWT::encode($payload, $this->__key_sercret, ALGORIT_JWT);
            return ['code' => 200, 'data' => ['token' => $token, 'usuario' => $data['usuario'], 'user' => $validate['cod_user'], 'perfil' => $validate['perfil']]];
        } else {
            return ['code' => 401, 'data'=>['message' => 'Password o usuario incorrecto por favor validar']];
        }

    }


    function validarUsuario($data = []) {
        $user_validate = $this->__database->obtieneDatos([
            'tabla' => 'usuarios',
            'lista_campos' => ['count(cod_usuario) as validate, contrasenia, cod_perfil as rol, cod_usuario as cod_user'],
            'adicional' => 'AND estado = 1 AND borrado = 1 AND usuario = "' . $data['usuario'] . '" LIMIT 1'
        ])['data'][0];

       if($user_validate['validate']) {
            return ['user' => $data['usuario'], 'passw' => $user_validate['contrasenia'], 'perfil' => $user_validate['rol'], 'cod_user' => $user_validate['cod_user']];
       } else {
           return ['code' => 401, 'data'=>['message' => 'el usuario no existe']];
       }
    }
}