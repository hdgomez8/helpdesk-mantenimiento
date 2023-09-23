<?php
    class Areas extends Conectar{

        /* TODO: Obtener todos los registros */
        public function get_areas($emp_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_areas WHERE areas_emp_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $emp_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
