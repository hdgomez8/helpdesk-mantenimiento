<?php
    class Empresa extends Conectar{

        /* TODO: Obtener todos los registros */
        public function get_empresa(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_empresa WHERE est=1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
