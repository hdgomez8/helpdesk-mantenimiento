<?php
    class Ubicacion extends Conectar{

        /* TODO: Obtener todos los registros */
        public function get_ubicacion($area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_ubicacion WHERE ubicacion_area_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
