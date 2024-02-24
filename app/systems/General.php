<?php

class General {

    private $__database;

    function __construct() {
        $this->__database = new DataBaseMysql();
    }

    static function ErrorMessageSave($data = []) {
        $message = ['message' => 'Error al guardar el registro. Podria estar duplicado'];
        if ($data['code'] === 200) {
            $message = ['message' => 'Registro guardado exitosamente.'];
        }
        return ["code" => $data['code'], 'data' => $message];
    }

    static function ErrorMessageDelete($data = []) {
        $message = ['message' => 'Error al eliminar el registro'];
        if ($data['code'] === 200) {
            $message = ['message' => 'Registro eliminado exitosamente'];
        }
        return ["code" => $data['code'], 'data' => $message];
    }

    static function ErrorMessageUpdate($data = []) {
        $message = ['message' => 'Error al actualizar el registro. Podria estar duplicado'];
        if ($data['code'] === 200) {
            $message = ['message' => 'Registro actualizado exitosamente.'];
        }
        return ["code" => $data['code'], 'data' => $message];
    }


    static function logsDatabase($data) {
        $archivo = LOGS . "log_prueba.txt";
        $fp = fopen($archivo, 'a');
        fputs($fp, "Fecha " . date("d-m-Y h:i:s A ") . $data . "\n");
        fclose($fp);
    }
}