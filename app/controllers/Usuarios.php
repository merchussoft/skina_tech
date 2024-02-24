<?php

class Usuarios {

    private $__users_model;

    function __construct() {
        $this->__users_model = new UsuariosModel();
    }

    function listarUsuario($cod_user=0 ) {
        return $this->__users_model->listarUsuario($cod_user);
    }

    function eliminarUsuario($cod = 0) {
        return General::ErrorMessageDelete($this->__users_model->eliminarUsuario($cod));
    }

    function agregarUsuario($data = []) {
        $data['contrasenia'] = md5($data['contrasenia']);
        return General::ErrorMessageSave($this->__users_model->agregarUsuario($data));
    }

    function actualizarUsuario($data = [], $cod_user = 0) {
        if (isset($data['contrasenia']) && $data['contrasenia']) {
            $data['contrasenia'] = md5($data['contrasenia']);
        } else {
            unset($data['contrasenia']);
        }
        return General::ErrorMessageUpdate($this->__users_model->actualizarUsuario($data, $cod_user));
    }

    function listarPerfiles() {
        return $this->__users_model->listarPerfiles();
    }

}