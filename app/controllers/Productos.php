<?php

class Productos {

    private $__pmodel;

    function __construct() {
        $this->__pmodel = new ProductosModel();
    }


    function listarProductos($cod = 0) {
        return $this->__pmodel->listarProductos($cod);
    }

    function guardarProducto($data = []) {
        $validacion = $this->__pmodel->validarAsociacion($data)['data'][0]['validado'];
        if ($validacion) {
            $insert_producto = [
                "producto" => $data['nombre_producto'],
                "cod_categoria" => $data['categoria']
            ];
            $result_producto = $this->__pmodel->guardarProducto($insert_producto);
            if ($result_producto['data'] > 0) {
                $insert_scp = [
                    "cod_sub_categorias" => $data['cod_sc'],
                    "cod_producto" => $result_producto['data'],
                    "disponible" => 1
                ];
                return General::ErrorMessageSave($this->__pmodel->guardarProductoSubCategoria($insert_scp));
            } else {
                return General::ErrorMessageSave($result_producto);
            }
        } else {
            return ["code" => 403, "data" => ['message' => 'No existe relacion entre la categoria y la subcategoria']];
        }


    }

    function deleteProducto($data=[]) {
        return General::ErrorMessageDelete($this->__pmodel->deleteProducto($data));
    }

    function editarProducto($data=[]){
        return $this->__pmodel->editarProducto($data);
    }


}