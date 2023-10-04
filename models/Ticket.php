<?php
class Ticket extends Conectar
{

    /* TODO: insertar nuevo ticket */
    public function insert_ticket($usu_id, $emp_id, $area_id, $ubicacion_id, $tick_titulo, $tick_descrip)
    {
        // Imprimir el valor de $emp_id en la consola
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_ticket (tick_id,usu_id,emp_id,area_id,ubicacion_id,sis_id,tip_mant_id,tick_titulo,tick_descrip,tick_estado,fech_crea,usu_asig,fech_asig,prio_id,est) VALUES (NULL,?,?,?,?,NULL,NULL,?,?,'Cliente',now(),NULL,NULL,NULL,'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->bindValue(2, $emp_id);
        $sql->bindValue(3, $area_id);
        $sql->bindValue(4, $ubicacion_id);
        $sql->bindValue(5, $tick_titulo);
        $sql->bindValue(6, $tick_descrip);
        $sql->execute();

        $sql1 = "select last_insert_id() as 'tick_id';";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    /* TODO: Listar ticket Clientes */
    public function listar_ticket_Cliente()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_estado,
                    tm_ticket.fech_crea,
                    tm_ticket.fech_cierre,
                    tm_ticket.usu_asig,
                    tm_ticket.fech_asig,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_usuario.usu_correo,
                    tm_ticket.prio_id,
                    tm_prioridad.prio_nom
                    FROM 
                    tm_ticket
                    INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                    INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
                    WHERE
                    tm_ticket.tick_estado = 'Cliente'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_ticket_x_usu($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.fech_cier_tecn,
                tm_ticket.fech_cier_usu,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_ticket.fech_sol_mater,
                tm_ticket.fech_sol_proveedor,
                tm_ticket.fech_asig_con_mater,
                tm_ticket.fech_env_compras,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo
                FROM 
                tm_ticket
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.est = 1
                AND tm_ticket.usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_x_usu_est_pend_cierr_cliente($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_estado,
                    tm_ticket.fech_crea,
                    tm_ticket.fech_cierre,
                    tm_ticket.fech_cier_tecn,
                    tm_ticket.fech_cier_usu,
                    tm_ticket.usu_asig,
                    tm_ticket.fech_asig,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_usuario.usu_correo
                    FROM 
                    tm_ticket
                    INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                    WHERE
                    tm_ticket.est = 1
                    AND tm_ticket.tick_estado = 'Cierre Técnico'
                    AND tm_usuario.usu_id=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_x_usu_est_pend_cierr_cliente_general($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                        tm_ticket.tick_id,
                        tm_ticket.usu_id,
                        tm_ticket.tick_titulo,
                        tm_ticket.tick_descrip,
                        tm_ticket.tick_estado,
                        tm_ticket.fech_crea,
                        tm_ticket.fech_cierre,
                        tm_ticket.fech_cier_tecn,
                        tm_ticket.fech_cier_usu,
                        tm_ticket.usu_asig,
                        tm_ticket.fech_asig,
                        tm_usuario.usu_nom,
                        tm_usuario.usu_ape,
                        tm_usuario.usu_correo
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        AND tm_ticket.tick_estado = 'Cierre Técnico'
                        AND tm_usuario.usu_id != ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_x_est_pend_cierr_jefe_mant()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                        tm_ticket.tick_id,
                        tm_ticket.usu_id,
                        tm_ticket.tick_titulo,
                        tm_ticket.tick_descrip,
                        tm_ticket.tick_estado,
                        tm_ticket.fech_crea,
                        tm_ticket.fech_cierre,
                        tm_ticket.fech_cier_tecn,
                        tm_ticket.fech_cier_usu,
                        tm_ticket.usu_asig,
                        tm_ticket.fech_asig,
                        tm_usuario.usu_nom,
                        tm_usuario.usu_ape,
                        tm_usuario.usu_correo
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        AND tm_ticket.tick_estado = 'Cierre Cliente'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_x_est_con_materiales()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                            tm_ticket.tick_id,
                            tm_ticket.usu_id,
                            tm_ticket.tick_titulo,
                            tm_ticket.tick_descrip,
                            tm_ticket.tick_estado,
                            tm_ticket.fech_crea,
                            tm_ticket.fech_cierre,
                            tm_ticket.fech_cier_tecn,
                            tm_ticket.fech_cier_usu,
                            tm_ticket.usu_asig,
                            tm_ticket.fech_asig,
                            tm_usuario.usu_nom,
                            tm_usuario.usu_ape,
                            tm_usuario.usu_correo
                            FROM 
                            tm_ticket
                            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                            WHERE
                            tm_ticket.est = 1
                            AND tm_ticket.tick_estado = 'Asignado Con Materiales'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de usuario */
    public function listar_x_est_con_materiales_tecnico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                                tm_ticket.tick_id,
                                tm_ticket.usu_id,
                                tm_ticket.tick_titulo,
                                tm_ticket.tick_descrip,
                                tm_ticket.tick_estado,
                                tm_ticket.fech_crea,
                                tm_ticket.fech_cierre,
                                tm_ticket.fech_cier_tecn,
                                tm_ticket.fech_cier_usu,
                                tm_ticket.usu_asig,
                                tm_ticket.fech_asig,
                                tm_usuario.usu_nom,
                                tm_usuario.usu_ape,
                                tm_usuario.usu_correo
                                FROM 
                                tm_ticket
                                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                                WHERE
                                tm_ticket.est = 1
                                AND tm_ticket.tick_estado = 'Asignado Con Materiales' and tm_ticket.usu_asig = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_responsable($usu_asig)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.fech_cier_tecn,
                tm_ticket.fech_cier_usu,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_ticket.fech_sol_mater,
                tm_ticket.fech_sol_proveedor,
                tm_ticket.fech_asig_con_mater,
                tm_ticket.fech_env_compras,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo
                    FROM 
                    tm_ticket
                    INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                    WHERE
                    tm_ticket.est = 1
                    AND tm_ticket.usu_asig = ? and tm_ticket.tick_estado = 'Asignado'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asig);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_responsable_pendiente_tecnicos($usu_asig)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_estado,
                    tm_ticket.fech_crea,
                    tm_ticket.fech_cierre,
                    tm_ticket.fech_cier_tecn,
                    tm_ticket.fech_cier_usu,
                    tm_ticket.usu_asig,
                    tm_ticket.fech_asig,
                    tm_ticket.fech_sol_mater,
                    tm_ticket.fech_sol_proveedor,
                    tm_ticket.fech_asig_con_mater,
                    tm_ticket.fech_env_compras,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_usuario.usu_correo
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        AND tm_ticket.usu_asig != ? and tm_ticket.tick_estado = 'Asignado'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asig);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_responsable_tecnico($usu_asig)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                        tm_ticket.tick_id,
                        tm_usuario.usu_correo,
                        tm_ticket.tick_titulo,
                        tm_ticket.tick_descrip,
                        tm_ticket.tick_estado,
                        tm_ticket.fech_crea,
                        tm_ticket.fech_cierre,
                        tm_ticket.usu_asig,
                        tm_ticket.fech_asig
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        AND tm_ticket.usu_asig = ? and tm_ticket.tick_estado = 'Asignado'";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asig);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

        /* TODO: Listar ticket segun id de Responsable */
        public function listar_ticket_x_responsable_tecnico_consultar($usu_asig)
        {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_estado,
                    tm_ticket.fech_crea,
                    tm_ticket.fech_cierre,
                    tm_ticket.fech_cier_tecn,
                    tm_ticket.fech_cier_usu,
                    tm_ticket.usu_asig,
                    tm_ticket.fech_asig,
                    tm_ticket.fech_sol_mater,
                    tm_ticket.fech_sol_proveedor,
                    tm_ticket.fech_asig_con_mater,
                    tm_ticket.fech_env_compras,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_usuario.usu_correo
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        AND tm_ticket.usu_asig = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_responsable_proveedores()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                        tm_ticket.tick_id,
                        tm_usuario.usu_correo,
                        tm_ticket.tick_titulo,
                        tm_ticket.tick_descrip,
                        tm_ticket.tick_estado,
                        tm_ticket.fech_crea,
                        tm_ticket.fech_cierre,
                        tm_ticket.usu_asig,
                        tm_ticket.fech_asig
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        and tm_ticket.tick_estado = 'Pendiente Proveedor'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_compra_materiales()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                        tm_ticket.tick_id,
                        tm_usuario.usu_correo,
                        tm_ticket.tick_titulo,
                        tm_ticket.fech_crea,
                        tm_ticket.fech_cierre,
                        tm_ticket.fech_sol_mater,
                        tm_ticket.usu_asig,
                        tm_ticket.fech_asig
                        FROM 
                        tm_ticket
                        INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                        WHERE
                        tm_ticket.est = 1
                        and 
                        (tm_ticket.tick_estado = 'Pendiente Materiales')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Listar ticket segun id de Responsable */
    public function listar_ticket_x_compra_materiales_en_compras()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                            tm_ticket.tick_id,
                            tm_usuario.usu_correo,
                            tm_ticket.tick_titulo,
                            tm_ticket.fech_crea,
                            tm_ticket.fech_cierre,
                            tm_ticket.fech_sol_mater,
                            tm_ticket.usu_asig,
                            tm_ticket.fech_asig
                            FROM 
                            tm_ticket
                            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                            WHERE
                            tm_ticket.est = 1
                            and 
                            (tm_ticket.tick_estado = 'En Compras')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Mostrar ticket segun id de ticket */
    public function listar_ticket_x_id($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_diag_mant,
                tm_ticket.tick_descrip_act_rep_efec,
                tm_ticket.tick_estado,
                tm_usuario.usu_correo,
                tm_usuario.usu_nom,
                tm_empresa.emp_nom,
                tm_areas.areas_nom,
                tm_ubicacion.ubicacion_nom,
                (select tm_usuario.usu_correo from tm_usuario where tm_usuario.usu_id = tm_ticket.usu_asig) as correo_soporte,
                tm_tipo_mantenimiento.tip_man_nom,
                tm_sistemas.sis_nom,
                tm_prioridad.prio_nom,
                (select tm_usuario.usu_nom from tm_usuario where tm_usuario.usu_id = tm_ticket.usu_asig) as nombre_soporte
                FROM 
                tm_ticket
                INNER join tm_usuario on tm_usuario.usu_id = tm_ticket.usu_id
                INNER join tm_empresa on tm_empresa.emp_id = tm_ticket.emp_id
                INNER join tm_areas on tm_areas.areas_id = tm_ticket.area_id
                INNER join tm_ubicacion on tm_ubicacion.ubicacion_id = tm_ticket.ubicacion_id
                INNER join tm_tipo_mantenimiento on tm_tipo_mantenimiento.tip_man_id = tm_ticket.tip_mant_id
                INNER join tm_sistemas on tm_sistemas.sis_id = tm_ticket.sis_id
                INNER join tm_prioridad on tm_prioridad.prio_id = tm_ticket.prio_id
                WHERE
                tm_ticket.est = 1
                AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // echo '<script>console.log('.json_encode($resultado).')</script>';

        return $resultado;
    }

    /* TODO: Mostrar ticket segun id de ticket */
    public function listar_ticket_x_id_correo($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.tick_titulo,
                    tm_usuario.usu_correo,
                    tm_usuario.usu_nom
                    FROM 
                    tm_ticket
                    INNER join tm_usuario on tm_usuario.usu_id = tm_ticket.usu_id
                    WHERE
                    tm_ticket.est = 1
                    AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // echo '<script>console.log('.json_encode($resultado).')</script>';

        return $resultado;
    }

    /* TODO: Mostrar ticket segun id de ticket */
    public function listar_ticket_x_id_gestionar($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_estado,
                    tm_usuario.usu_correo,
                    tm_empresa.emp_nom,
                    tm_areas.areas_nom,
                    tm_ubicacion.ubicacion_nom
                    FROM 
                    tm_ticket
                    INNER join tm_usuario on tm_usuario.usu_id = tm_ticket.usu_id
                    INNER join tm_empresa on tm_empresa.emp_id = tm_ticket.emp_id
                    INNER join tm_areas on tm_areas.areas_id = tm_ticket.area_id
                    INNER join tm_ubicacion on tm_ubicacion.ubicacion_id = tm_ticket.ubicacion_id
                    WHERE
                    tm_ticket.est = 1
                    AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // echo '<script>console.log('.json_encode($resultado).')</script>';

        return $resultado;
    }

    /* TODO: Mostrar ticket segun id de ticket */
    public function listar_ticket_x_id_x_responsable($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                    tm_ticket.tick_id,
                    tm_ticket.usu_id,
                    tm_ticket.tick_titulo,
                    tm_ticket.tick_descrip,
                    tm_ticket.tick_diag_mant,
                    tm_ticket.tick_descrip_act_rep_efec,
                    tm_ticket.tick_num_requisicion,
                    tm_ticket.tick_estado,
                    tm_tipo_mantenimiento.tip_man_nom,
                    tm_sistemas.sis_nom,
                    tm_prioridad.prio_nom,
                    tm_areas.areas_nom,
                    tm_empresa.emp_nom,
                    tm_ubicacion.ubicacion_nom,
                    tm_usuario.usu_correo,
                    (select tm_usuario.usu_nom from tm_usuario where tm_usuario.usu_id = tm_ticket.usu_asig) as nombre_soporte
                    FROM 
                    tm_ticket
                    INNER join tm_tipo_mantenimiento on tm_tipo_mantenimiento.tip_man_id = tm_ticket.tip_mant_id
                    INNER join tm_sistemas on tm_sistemas.sis_id = tm_ticket.sis_id
                    INNER join tm_empresa on tm_empresa.emp_id = tm_ticket.emp_id
                    INNER join tm_prioridad on tm_prioridad.prio_id = tm_ticket.prio_id
                    INNER join tm_usuario on tm_usuario.usu_id = tm_ticket.usu_id
                    INNER join tm_ubicacion on tm_ubicacion.ubicacion_id = tm_ticket.ubicacion_id
                    INNER join tm_areas on tm_areas.areas_id = tm_ticket.area_id
                    WHERE
                    tm_ticket.est = 1
                    AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // echo '<script>console.log('.json_encode($resultado).')</script>';

        return $resultado;
    }

    /* TODO: Mostrar ticket segun id de ticket */
    public function listar_materiales_x_tick_id($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT M.nombre as nombre, MS.cantidad as cantidad
            FROM tm_materialsolicitado MS
            JOIN tm_solicitudmateriales S ON MS.solicitud_id = S.solicitud_id
            JOIN tm_ticket T ON S.tick_id = T.tick_id
            JOIN tm_material M ON MS.material_id = M.material_id
            WHERE T.tick_id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();
        // echo '<script>console.log('.json_encode($resultado).')</script>';

        return $resultado;
    }
    /* TODO: Mostrar todos los ticket */
    public function listar_ticket()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.fech_cier_tecn,
                tm_ticket.fech_cier_usu,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_ticket.fech_sol_mater,
                tm_ticket.fech_sol_proveedor,
                tm_ticket.fech_asig_con_mater,
                tm_ticket.fech_env_compras,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo
                FROM 
                tm_ticket
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.est = 1
                ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Mostrar detalle de ticket por id de ticket */
    public function listar_ticketdetalle_x_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id
                FROM 
                td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                tick_id =?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        $resultado = $sql->fetchAll();

        echo '<script>';
        echo 'console.log(' . json_encode($resultado) . ')';
        echo '</script>';

        return $resultado;
    }

    /* TODO: Insert ticket detalle */
    public function insert_ticketdetalle($tick_id, $usu_id, $tickd_descrip)
    {
        $conectar = parent::conexion();
        parent::set_names();

        /* TODO:Obtener usuario asignado del tick_id */
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $usu_asig = $row["usu_asig"];
            $usu_crea = $row["usu_id"];
        }

        /* TODO: si Rol es 1 = Usuario insertar alerta para usuario soporte */
        if ($_SESSION["rol_id"] == 1) {
            /* TODO: Guardar Notificacion de nuevo Comentario */
            $sql0 = "INSERT INTO tm_notificacion (not_id,usu_id,not_mensaje,tick_id,est) VALUES (null, $usu_asig ,'Tiene una nueva respuesta del usuario con nro de ticket : ',$tick_id,2)";
            $sql0 = $conectar->prepare($sql0);
            $sql0->execute();
            /* TODO: Else Rol es = 2 Soporte Insertar alerta para usuario que genero el ticket */
        } else {
            /* TODO: Guardar Notificacion de nuevo Comentario */
            $sql0 = "INSERT INTO tm_notificacion (not_id,usu_id,not_mensaje,tick_id,est) VALUES (null,$usu_crea,'Tiene una nueva respuesta de soporte del ticket Nro : ',$tick_id,2)";
            $sql0 = $conectar->prepare($sql0);
            $sql0->execute();
        }

        $sql = "INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->bindValue(3, $tickd_descrip);
        $sql->execute();

        /* TODO: Devuelve el ultimo ID (Identty) ingresado */
        $sql1 = "select last_insert_id() as 'tickd_id';";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    /* TODO: Insert ticket detalle asignacion*/
    public function insert_ticketdetalle_asignacion($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();

        /* TODO:Obtener usuario asignado del tick_id */
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);


        $sql = "INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();

        /* TODO: Devuelve el ultimo ID (Identty) ingresado */
        $sql1 = "select last_insert_id() as 'tickd_id';";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $resultado = $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    /* TODO: Insertar linea adicional de detalle al cerrar el ticket */
    public function insert_ticketdetalle_cerrar($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "call sp_i_ticketdetalle_01(?,?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Insertar linea adicional al reabrir el ticket */
    public function insert_ticketdetalle_reabrir($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "	INSERT INTO td_ticketdetalle 
                    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
                    VALUES 
                    (NULL,?,?,'Ticket Re-Abierto...',now(),'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket */
    public function update_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    tick_estado = 'Cerrado',
                    fech_cierre = now()
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_tecnico($tick_id, $tickd_descrip_diag_mant, $tickd_descrip_act_rep_efec)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                    set	
                        tick_estado = 'Cierre Técnico',
                        fech_cier_tecn = now(),
                        tick_descrip_act_rep_efec = ?,
                        tick_diag_mant = ?
                    where
                        tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tickd_descrip_act_rep_efec);
        $sql->bindValue(2, $tickd_descrip_diag_mant);
        $sql->bindValue(3, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_tecnico_con_materiales($tick_id, $tickd_descrip_diag_mant, $tickd_descrip_act_rep_efec)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                        set	
                            tick_estado = 'Cierre Técnico',
                            fech_cier_tecn = now(),
                            tick_descrip_act_rep_efec = ?,
                            tick_diag_mant = ?
                        where
                            tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tickd_descrip_act_rep_efec);
        $sql->bindValue(2, $tickd_descrip_diag_mant);
        $sql->bindValue(3, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_tecnico_materiales($tick_id, $materiales, $tickd_descrip_diag_mant)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Crear una nueva solicitud de materiales
        $sql = "INSERT INTO tm_solicitudmateriales (tick_id, fecha_solicitud,estado) VALUES (?, NOW(),'Solicitado')";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $tick_id);
        $stmt->execute();

        // Obtener el ID de la solicitud recién creada
        $solicitud_id = $conectar->lastInsertId();

        // Registrar los materiales asociados a la solicitud
        foreach ($materiales as $material) {
            $descripcion = $material["descripcion"];
            $unidad = $material["unidad"];
            $cantidad = $material["cantidad"];

            // Insertar el material en la tabla de materiales de la solicitud
            $this->insert_material_en_solicitud($solicitud_id, $descripcion, $unidad, $cantidad);
        }

        $sql = "update tm_ticket 
                        set	
                            tick_estado = 'Pendiente Materiales',
                            fech_sol_mater = now(),
                            tick_diag_mant = ?
                        where
                            tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tickd_descrip_diag_mant);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_tecnico_proveedor($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                            set	
                                tick_estado = 'Pendiente Proveedor',
                                fech_sol_proveedor = now(),
                                usu_asig = '622'
                            where
                                tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_jefe_reasignar_con_materiales($tick_id, $campoRequisicion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                            set	
                                tick_estado = 'Asignado Con Materiales',
                                fech_asig_con_mater = now(),
                                tick_num_requisicion = ?
                            where
                                tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $campoRequisicion);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_jefe_enviado_a_compras($tick_id, $campoOrdenCompra)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                                set	
                                    tick_estado = 'En Compras',
                                    fech_env_compras = now(),
                                    tick_num_ord_compra = ?
                                where
                                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $campoOrdenCompra);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_jefe_cerrado($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                                set	
                                    tick_estado = 'Cerrado',
                                    fech_cierre = now()
                                where
                                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: actualizar ticket por tecnico */
    public function update_ticket_x_cliente($tick_id, $opcionSatisfaccion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                        set	
                            tick_estado = 'Cierre Cliente',
                            fech_cier_usu = now(),
                            satisfaccion = ?
                        where
                            tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $opcionSatisfaccion);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Cambiar estado del ticket al reabrir */
    public function reabrir_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    tick_estado = 'Abierto'
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Actualizar usu_asig con usuario de soporte asignado */
    public function update_ticket_asignacion(
        $tick_id,
        $usu_id_tecnico,
        $tip_mant_id,
        $sis_id,
        $pri_id,
        $tickd_descripusu
    ) {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    usu_asig = ?,
                    fech_asig = now(),
                    sis_id=?,
                    prio_id=?,
                    tip_mant_id=?,
                    tick_estado='Asignado',
                    tick_descrip=?
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id_tecnico);
        $sql->bindValue(2, $sis_id);
        $sql->bindValue(3, $pri_id);
        $sql->bindValue(4, $tip_mant_id);
        $sql->bindValue(5, $tickd_descripusu);
        $sql->bindValue(6, $tick_id);
        $sql->execute();

        /* TODO: Guardar Notificacion en la tabla */
        $sql1 = "INSERT INTO tm_notificacion (not_id,usu_id,not_mensaje,tick_id,est) VALUES (null,?,'Se le ha asignado el ticket Nro : ',?,2)";
        $sql1 = $conectar->prepare($sql1);
        $sql1->bindValue(1, $usu_id_tecnico);
        $sql1->bindValue(2, $tick_id);
        $sql1->execute();

        return $resultado = $sql->fetchAll();
    }

    /* TODO: Obtener total de tickets */
    public function get_ticket_total_gestionar()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Cliente'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_materiales()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Pendiente Materiales'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_realizar()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Asignado'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_realizar_proveedores()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tm_ticket.tick_estado = 'Pendiente Proveedor'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_realizar_x_tecnico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Asignado' and usu_asig = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_realizar_x_tecnico_jefe($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Asignado' and usu_asig != ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_visto_bueno()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Cierre Técnico'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_visto_bueno_general($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Cierre Técnico' AND usu_asig != ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_x_Cerrar()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Cierre Cliente'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_con_materiales()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Asignado Con Materiales'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_en_compras()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'En Compras'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_total_con_materiales_tecnico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_estado = 'Asignado Con Materiales' and usu_asig = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Obtener total de tickets */
    public function get_ticket_total()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado = 'Cliente";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Total de ticket Abiertos */
    public function get_ticket_totalabierto()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Abierto'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Total de ticket Cerrados */
    public function get_ticket_totalcerrado()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Cerrado'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO:Total de ticket por categoria */
    public function get_ticket_grafico()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) AS total
                FROM   tm_ticket   
                WHERE    
                tm_ticket.est = 1
                ORDER BY total DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_materiales($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT M.nombre as nombre ,U.unidad_nombre as unidad ,MS.cantidad as cantidad
        FROM tm_materialsolicitado MS
        JOIN tm_solicitudmateriales S ON MS.solicitud_id = S.solicitud_id
        JOIN tm_ticket T ON S.tick_id = T.tick_id
        JOIN tm_material M ON MS.material_id = M.material_id
        join tm_unidades U on U.unidad_id = MS.unidad_id
        WHERE T.tick_id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insert_material_en_solicitud($solicitud_id, $descripcion, $unidad, $cantidad)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_materialsolicitado (solicitud_id, material_id,unidad_id,cantidad) VALUES (?, ?,?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $solicitud_id);
        $sql->bindValue(2, $descripcion);
        $sql->bindValue(3, $unidad);
        $sql->bindValue(4, $cantidad);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Actualizar valor de estrellas de encuesta */
    public function insert_encuesta($tick_id, $tick_estre, $tick_comment)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "update tm_ticket 
                set	
                    tick_estre = ?,
                    tick_coment = ?
                where
                    tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_estre);
        $sql->bindValue(2, $tick_comment);
        $sql->bindValue(3, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /* TODO: Actualizar valor de estrellas de encuesta */
    public function filtrar_ticket()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.tick_titulo,
            tm_ticket.tick_descrip,
            tm_ticket.tick_estado,
            tm_ticket.fech_crea,
            tm_ticket.fech_cierre,
            tm_ticket.usu_asig,
            tm_ticket.fech_asig,
            tm_usuario.usu_nom,
            tm_usuario.usu_ape,
            tm_usuario.usu_correo,
            tm_ticket.prio_id
            FROM 
            tm_ticket
            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
            WHERE
            tm_ticket.tick_estado = 'Cliente'
            AND tm_ticket.tick_titulo like IFNULL('%%',tm_ticket.tick_titulo)
            ORDER BY tm_ticket.tick_id DESC";
        $sql = $conectar->prepare($sql);

        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
