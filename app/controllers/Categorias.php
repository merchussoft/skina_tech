<?php

class Categorias {

    private $__database;

    function __construct() {
        $this->__database = new DataBaseMysql();
    }

    function listarCategorias($cod = 0) {
        $where = '';
        if ($cod) {
            $where = "AND cod_categoria = $cod";
        }
        return $this->__database->obtieneDatos([
            'tabla' => 'categorias',
            'lista_campos' => ['cod_categoria', 'categoria', 'if(estado = 1, "activo", "inactivo") as estado', 'estado as active', 'created_at as fecha_creacion'],
            'adicional' => "AND borrado = 1 $where ORDER BY created_at DESC"
        ]);
    }

    function guardarCategorias($data = []) {
        $data_insert = [
            'categoria' => $data['nombre_categoria'],
            'estado' => $data['activo']
        ];
        return General::ErrorMessageSave($this->__database->insertaTabla('categorias', $data_insert));
    }


    function borrarCategorias($cod = 0) {
        return General::ErrorMessageDelete($this->__database->actualizaTabla('categorias', ['borrado' => 0], ['cod_categoria' => $cod]));
    }

    function actualizarCategoria($data = [], $cod = 0) {
        return General::ErrorMessageUpdate($this->__database->actualizaTabla('categorias', $data, ['cod_categoria' => intval($cod)]));
    }

}