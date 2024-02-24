<?php

class UsuariosModel {

    private $__database;

    function __construct() {
        $this->__database = new DataBaseMysql();
    }

    function listarUsuario($cod_user=0) {
        $where = ($cod_user) ? " AND cod_usuario=$cod_user " : '';
        $sql = 'SELECT u.cod_usuario, u.usuario, if(estado=1, "Activo", "Inactivo") as activo, u.estado, p.perfil, u.cod_perfil';
        $sql .= ' FROM usuarios u ';
        $sql .= ' INNER JOIN perfiles p ON p.cod_perfil = u.cod_perfil ';
        $sql .= " WHERE u.borrado= 1 $where ORDER BY u.created_at DESC ";

        return $this->__database->querySimple($sql);
    }

    function eliminarUsuario($cod= 0){
        return $this->__database->actualizaTabla('usuarios', ['borrado' => 0] , ['cod_usuario' => $cod]);
    }

    function agregarUsuario($data=[]) {
        return $this->__database->insertaTabla('usuarios', $data);
    }

    function actualizarUsuario($data=[], $cod_user=0) {
        return $this->__database->actualizaTabla('usuarios', $data, ['cod_usuario' => $cod_user]);
    }

    function listarPerfiles() {
        return $this->__database->obtieneDatos([
            'tabla' => 'perfiles',
            'adicional' => 'ORDER BY perfil ASC'
        ]);
    }
}