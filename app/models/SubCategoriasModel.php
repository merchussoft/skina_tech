<?php

class SubCategoriasModel {

    private $__database;

    function __construct() {
        $this->__database = new DataBaseMysql();
    }


    function verSubCategorias($cod=0) {
        $adicional = ($cod) ? " AND sc.cod_sub_categorias = $cod" : "";
        $sql = 'SELECT cod_sub_categorias, sub_categoria, sc.estado, sc.cod_categoria, c.categoria ';
        $sql .= ' FROM categorias c ';
        $sql .= ' INNER JOIN sub_categorias sc ON sc.cod_categoria = c.cod_categoria ';
        $sql .= " WHERE c.estado =1 AND sc.estado = 1 AND sc.borrado= 1 $adicional ORDER BY sc.created_at DESC ";

        return $this->__database->querySimple($sql);
    }

    function guardarSubCategorias($data= []) {
        return $this->__database->insertaTabla('sub_categorias', $data);
    }

    function eliminarSubCategorias($cod= 0) {
        return $this->__database->actualizaTabla('sub_categorias', ['borrado' => 0] , ['cod_sub_categorias' => $cod]);
    }


    function actualizaSubCategorias($data=[], $cod= 0) {
        return $this->__database->actualizaTabla('sub_categorias', $data, ['cod_sub_categorias' => intval($cod)]);
    }

}