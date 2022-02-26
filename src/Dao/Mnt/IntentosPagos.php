<?php
    namespace Dao\Mnt;

use Dao\Table;

    class IntentosPagos extends Table 
    {
        public static function obtenerTodos()
        {
            $sqlstr = "select * from intentospagos";
            return self::obtenerRegistros(
                $sqlstr, 
                array()
            );
        }

        public static function obtenerPorIntId($intid)
        {
            $sqlstr = "select * from intentospagos where id=:id;";
            return self::obtenerUnRegistro(
                $sqlstr,
                array("id" => $intid)
            );
            
        }

        public static function agregarIntentosPagos($cliente, $monto, $fechaVencimiento, $estado)
        {
            $sqlstr= "INSERT INTO intentospagos (fecha,cliente,monto,fechaVencimiento,estado) 
            values (:fecha, :cliente, :monto, :fechaVencimiento, :estado);";
            return self::executeNonQuery(
                $sqlstr,
                array(
                    "fecha"=> date('Y-m-d H:i:s'),
                    "cliente"=>$cliente,
                    "monto"=>$monto,
                    "fechaVencimiento"=>$fechaVencimiento,
                    "estado"=>$estado
                )
            );
        }

        public static function modificarIntentosPagos($cliente, $monto, $fechaVencimiento, $estado, $id)
        {
            $sqlstr = "UPDATE intentospagos set cliente=:cliente, monto=:monto, 
            fechaVencimiento = :fechaVencimiento, estado = :estado where id=:id";
            return self::executeNonQuery(
                $sqlstr,
                array(
                    "cliente"=>$cliente,
                    "monto"=>$monto,
                    "fechaVencimiento"=>$fechaVencimiento,
                    "estado"=>$estado,
                    "id"=>$id
                )
            );
        }
        public static function eliminarIntentosPagos($id)
        {
            $sqlstr = "DELETE FROM intentospagos where id=:id";
            return self::executeNonQuery(
                $sqlstr,
                array(
                    "id"=>$id
                )
            );
        }
    }
?>