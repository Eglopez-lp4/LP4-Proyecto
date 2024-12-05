<?php

namespace App\db;
use App\config\responseHTTP;

class sql extends connectionDB{

    //construimos un metodo que me permitara verificar si existe un registro en nuestra base de datos bajpo ciertos parametros y condiciones
    public static function verificarRegistro($sql, $condicion, $params){
        try {
            //abrimos la conexion 
            $con  = self::getConnection();
            $query = $con->prepare($sql); //preparamos la consulta que viene en el parametro $sql
            $query->execute([
                $condicion=>$params   //pasamos la condicion de la consulta y los parametos correspondientes a traves de un array asociativo
            ]);                       // select nombre from tbl_usuario where id = 12345

            //ahora recorremos y contamos los datos retornados 
            $res = ($query->rowCount() == 0) ? false : true; //estos es lo mismo que este haciendo un 
                                                             //if($query->rowCount() == 0){false}else{true}
            return $res; //retornamos la respuesta
        } catch (\PDOException  $e) {
            //mandamos un error y especificamos la clase y el metodo ademas de el error correspondiente
            error_log("sql::verificarRegistro -> ".$e);
            //retornamos el error correspondiente del server
            die(json_encode(responseHTTP::status500()));
        }
    } 
}