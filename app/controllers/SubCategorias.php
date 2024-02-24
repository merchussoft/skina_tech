<?php

class SubCategorias {

    private $__subCategModel;
    private $__database;

    function __construct() {
        $this->__s_c_Model = new SubCategoriasModel();
    }

    function listarSubCategorias($cod=0){
        return $this->__s_c_Model->verSubCategorias($cod);
    }

    function guardarSubCategorias($data = []) {
        $data_insert = [
            'sub_categoria' => $data['nombre'],
            'estado' => $data['activo'],
            'cod_categoria' => $data['categoria']
        ];
        return General::ErrorMessageSave($this->__s_c_Model->guardarSubCategorias($data_insert));
    }

    function eliminarSubCategorias($cod = 0) {
        return General::ErrorMessageDelete($this->__s_c_Model->eliminarSubCategorias($cod));
    }

    function actualizarSubCategorias($data = [], $cod = 0) {
        return General::ErrorMessageUpdate($this->__s_c_Model->actualizaSubCategorias($data, $cod));
    }

}