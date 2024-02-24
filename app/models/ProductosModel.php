<?php

class ProductosModel {

    private $__database;

    function __construct() {
        $this->__database = new DataBaseMysql();
    }

    function listarProductos($cod = 0) {
        $adicional = ($cod) ? " AND sc.cod_producto = $cod" : "";
        $sql = 'SELECT c.cod_categoria, c.categoria, p.cod_producto, p.producto, sc.cod_sub_categorias, sc.sub_categoria, cod_sub_categoria_producto ';
        $sql .= ' FROM categorias c ';
        $sql .= ' INNER JOIN productos p ON p.cod_categoria = c.cod_categoria ';
        $sql .= ' INNER JOIN sub_categorias_productos scp ON scp.cod_producto = p.cod_producto ';
        $sql .= ' INNER JOIN sub_categorias sc ON sc.cod_sub_categorias = scp.cod_sub_categorias ';
        $sql .= " WHERE c.estado =1 AND sc.estado = 1 AND p.borrado = 1 $adicional ORDER BY p.created_at DESC ";

        return $this->__database->querySimple($sql);
    }


    function guardarProducto($data = []) {
        return $this->__database->insertaTabla('productos', $data);
    }

    function guardarProductoSubCategoria($data = []) {
        return $this->__database->insertaTabla('sub_categorias_productos', $data);
    }

    function validarAsociacion($data = []) {
        return $this->__database->obtieneDatos([
            'tabla' => 'sub_categorias',
            'campo' => 'cod_sub_categorias',
            'valor' => $data['cod_sc'],
            'lista_campos' => ['count(cod_sub_categorias) as validado'],
            'adicional' => 'AND cod_categoria=' . $data['categoria']
        ]);
    }

    function deleteProducto($data=[]){
        return $this->__database->actualizaTabla('productos', ['borrado' => 0] , ['cod_producto' => $data['producto']]);
    }


    function editarProducto($data=[]){
        try {
            $data_update = ['producto' => $data['nombre_producto'], 'cod_categoria' => intval($data['categoria'])];
            $this->__database->actualizaTabla('productos', $data_update, ['cod_producto' => intval($data['cod_product'])]);
            $this->__database->actualizaTabla('sub_categorias_productos', ['cod_sub_categorias' => intval($data['cod_sc'])], ['cod_sub_categoria_producto' => intval($data['cod_scp'])]);
            return ['code' => 200, 'data' => ['message' => 'Producto actualizado exitosamente']];
        } catch (Exception $e) {
            return ['code' => 403, 'data' => ['message' => 'Error al actualizar el producto']];
        }

    }


}