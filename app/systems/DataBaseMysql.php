<?php

class DataBaseMysql {

    private $_dbHost;
    protected $_dbName;
    private $_dbUser;
    private $_dbPassword;
    static private $_connection;
    private $_cursor;


    function __construct() {
        $this->_dbHost = DB_HOST;
        $this->_dbUser = DB_USER;
        $this->_dbPassword = DB_PASS;
        $this->_dbName = DB_NAME;

        $this->conexion();
    }

    private function conexion() {
        if (!self::$_connection) {
            self::$_connection = new PDO("mysql:host=$this->_dbHost;dbname=$this->_dbName", $this->_dbUser, $this->_dbPassword);
            self::$_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    private function executeQuery($sql, $data = []) {
        ob_start();
        $this->_cursor = self::$_connection->prepare($sql);
        $result = $this->_cursor->execute($data);
        $this->_cursor->debugDumpParams();
        General::logsDatabase(ob_get_clean());
        return $result;
    }

    private function resultDataQuery($sql, $data = [], $tipo_operacion = "SELECT") {
        try {
            $this->executeQuery($sql, $data);
            $data_error = ["code" => 403, "data" => ['message'=> 'La consulta no devolvió ningún resultado.']];
            switch ($tipo_operacion) {
                case 'SELECT':
                    $resultado = $this->_cursor->fetchAll(PDO::FETCH_ASSOC);
                    return count($resultado) ? ["code" => 200, "data" => $resultado] : $data_error;
                case 'INSERT':
                    $resultado = self::$_connection->lastInsertId();
                    return $resultado ? ["code" => 200, "data" => intval($resultado)] : $data_error;
                case 'UPDATE' || 'DELETE':
                    $resultado =  $this->_cursor->rowCount();
                    return $resultado ? ["code" => 200, "data" => intval($resultado)] : $data_error;
            }
        } catch (Exception $e) {
            return ["code" => 503, "data" => ["message" => $e->getMessage()]];
        }
    }


    function obtieneDatos($data = []) {
        $lista_campos = isset($data['lista_campos']) ? implode(", ", $data['lista_campos']) : '*';
        $campo = isset($data['campo']) ? $data['campo'] : 1;
        $valor = isset($data['valor']) ? $data['valor'] : 1;
        $adiconal = '';
        $tabla = $data['tabla'];
        if (isset($data['adicional'])) $adiconal = ' ' . $data['adicional'];
        $sql = "SELECT $lista_campos FROM $tabla WHERE $campo = $valor $adiconal";
        return $this->resultDataQuery($sql);
    }

    function insertaTabla($tabla, $data_insert = []) {
        $key = "";
        $param_insert = "";
        $valores = [];

        foreach ($data_insert as $clave => $valor) {
            $key .= "$clave, ";
            $param_insert .= "?, ";
            $valores[] = $valor;
        }

        // Eliminar la última coma y espacio de $key y de $param_insert
        $key = rtrim($key, ", ");
        $param_insert = rtrim($param_insert, ", ");

        $sql = "INSERT INTO $tabla($key) VALUES ($param_insert)";
        return $this->resultDataQuery($sql, $valores, 'INSERT');
    }

    function querySimple($sql) {
        return $this->resultDataQuery($sql);
    }

    function actualizaTabla($tabla, $data_update = [], $data_where = []) {

        $sql = "UPDATE $tabla SET ";
        $valores = [];

        foreach ($data_update as $clave => $valor) {
            $sql .= "$clave = ?, ";
            $valores[] = $valor;
        }
        $sql = rtrim($sql, ", ");

        if (!empty($data_where)) {
            $sql .= " WHERE ";
            foreach ($data_where as $clave => $valor) {
                $sql .= "$clave = ? AND ";
                $valores[] = $valor;
            }
            $sql = rtrim($sql, "AND ");
        }

        return $this->resultDataQuery($sql, $valores, 'UPDATE');
    }


    function deleteDataTabla($tabla, $where =[]) {
        $sql = "DELETE FROM $tabla WHERE ";
        $valores = [];

        foreach ($where as $clave => $valor) {
            $sql .= "$clave = ? AND ";
            $valores[] = $valor;
        }
        $sql = rtrim($sql, "AND ");

        return $this->resultDataQuery($sql, $valores, 'DELETE');
    }

}