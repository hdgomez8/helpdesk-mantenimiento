<?php
/* TODO:Cadena de Conexion */
require_once("../config/conexion.php");
/* TODO:Clases Necesarias */
require_once("../models/Ticket.php");
$ticket = new Ticket();

require_once("../models/Usuario.php");
$usuario = new Usuario();

require_once("../models/Documento.php");
$documento = new Documento();

/*TODO: opciones del controlador Ticket*/
switch ($_GET["op"]) {

        /* TODO: Insertar nuevo Ticket */
    case "insert":
        $datos = $ticket->insert_ticket($_POST["usu_id"], $_POST["emp_id"], $_POST["areas_id"], $_POST["ubicacion_id"], $_POST["tick_titulo"], $_POST["tick_descrip"]);
        /* TODO: Obtener el ID del ultimo registro insertado */
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["tick_id"] = $row["tick_id"];

                /* TODO: Validamos si vienen archivos desde la Vista */
                if (empty($_FILES['files']['name'])) {
                } else {
                    /* TODO:Contar Cantidad de Archivos desde la Vista */
                    $countfiles = count($_FILES['files']['name']);
                    /* TODO: Generamos ruta segun el ID del ultimo registro insertado */
                    $ruta = "../public/document/" . $output["tick_id"] . "/";
                    $files_arr = array();

                    /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }

                    /* TODO:Recorremos los archivos, y insertamos tantos detalles como documentos vinieron desde la vista */
                    for ($index = 0; $index < $countfiles; $index++) {
                        $doc1 = $_FILES['files']['tmp_name'][$index];
                        $destino = $ruta . $_FILES['files']['name'][$index];

                        /* TODO: Insertamos Documentos */
                        $documento->insert_documento($output["tick_id"], $_FILES['files']['name'][$index]);

                        /* TODO: Movemos los archivos hacia la carpeta creada */
                        move_uploaded_file($doc1, $destino);
                    }
                }
            }
        }
        echo json_encode($datos);
        break;

        /* TODO: Actualizamos el ticket a cerrado y adicionamos una linea adicional */
    case "update":
        $ticket->update_ticket($_POST["tick_id"]);
        $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"], $_POST["usu_id"]);
        break;
    case "update_x_tecnico":
        $ticket->update_ticket_x_tecnico($_POST["tick_id"], $_POST["tickd_descrip_diag_mant"], $_POST["tickd_descrip_act_rep_efec"]);
        break;
    case "update_x_tecnico_con_materiales":
        $ticket->update_ticket_x_tecnico_con_materiales($_POST["tick_id"], $_POST["tickd_descrip_diag_mant"], $_POST["tickd_descrip_act_rep_efec"]);
        break;
    case "update_x_tecnico_materiales":
        $tick_id = $_POST["tick_id"];
        $materiales_json = $_POST["materiales"];
        $materiales = json_decode($materiales_json, true); // Decodificar el JSON a un arreglo asociativo
        $tickd_descrip_diag_mant = $_POST["tickd_descrip_diag_mant"];


        // Ahora tienes el arreglo de materiales disponible en la variable $materiales
        // Puedes utilizarlo para realizar las operaciones que necesites

        $ticket->update_ticket_x_tecnico_materiales($tick_id, $materiales, $tickd_descrip_diag_mant);
        break;
    case "update_x_tecnico_proveedor":
        $ticket->update_ticket_x_tecnico_proveedor($_POST["tick_id"]);
        break;
    case "update_x_jefe_reasignar_con_materiales":
        $ticket->update_ticket_x_jefe_reasignar_con_materiales($_POST["tick_id"], $_POST["campoRequisicion"]);
        break;
    case "update_x_jefe_envio_a_compras":
        $ticket->update_ticket_x_jefe_enviado_a_compras($_POST["tick_id"], $_POST["campoOrdenCompra"]);
        break;
    case "update_x_jefe_cerrado":
        $ticket->update_ticket_x_jefe_cerrado($_POST["tick_id"]);
        break;
        /* TODO: Reabrimos el ticket y adicionamos una linea adicional */
    case "update_x_cliente":
        $ticket->update_ticket_x_cliente($_POST["tick_id"], $_POST["opcionSatisfaccion"]);
        break;
    case "reabrir":
        $ticket->reabrir_ticket($_POST["tick_id"]);
        $ticket->insert_ticketdetalle_reabrir($_POST["tick_id"], $_POST["usu_id"]);
        break;

        /* TODO: Asignamos el ticket  */
    case "asignar":
        $ticket->update_ticket_asignacion(
            $_POST["tick_id"],
            $_POST["usu_id_tecnico"],
            $_POST["tip_mant_id"],
            $_POST["sis_id"],
            $_POST["pri_id"],
            $_POST["tickd_descripusu"]
        );
        break;

        /* TODO: Listado de tickets segun usuario,formato json para Datatable JS */
    case "listar_x_usu":
        $datos = $ticket->listar_ticket_x_usu($_POST["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            if ($row["tick_estado"] == "Cliente") {
                $sub_array[] = '<span class="label label-pill label-default">Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado</span>';
            } else if ($row["tick_estado"] == "Pendiente Por Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente Por Materiales</span>';
            } else if ($row["tick_estado"] == "Cierre Técnico") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Técnico</span>';
            } else if ($row["tick_estado"] == "Pendiente Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Materiales</span>';
            } else if ($row["tick_estado"] == "En Compras") {
                $sub_array[] = '<span class="label label-pill label-success">En<br/>Compras</span>';
            } else if ($row["tick_estado"] == "Pendiente Proveedor") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Proveedor</span>';
            } else if ($row["tick_estado"] == "Cierre Cliente") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado Con Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado Con<br/>Materiales</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-warning">Cerrado</span>';
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_sol_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_mater"]));
            }

            if ($row["fech_env_compras"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_env_compras"]));
            }

            if ($row["fech_sol_proveedor"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_proveedor"]));
            }

            if ($row["fech_asig_con_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig_con_mater"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            if ($row["fech_cier_usu"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_usu"]));
            }

            if ($row["fech_cierre"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
            }

            if ($row["usu_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $datos1 = $usuario->get_usuario_x_id($row["usu_asig"]);
                foreach ($datos1 as $row1) {
                    $sub_array[] = '<span class="label label-pill label-warning">' . $row1["usu_nom"] . '</span>';
                }
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye" aria-hidden="true"></i></button>';
            if (isset($_SESSION["rol_id"]) == "4") {
                $sub_array[] = '';
            } else {
                $sub_array[] = '<button type="button" data-ticket-id="' . $row["tick_id"] . '" id="btnMostrarReporte" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#pdfModal"> <i class="fa fa-download" aria-hidden="true"></i></button>';
            }

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
        );
        echo json_encode($results);
        break;

        /* TODO: Listado de tickets,formato json para Datatable JS */
    case "listar_x_usu_est_pend_cierr_cliente":
        $datos = $ticket->listar_x_usu_est_pend_cierr_cliente($_POST["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-check" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "listar_x_est_pend_cierr_jefe_mant":
        $datos = $ticket->listar_x_est_pend_cierr_jefe_mant();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar_x_est_con_materiales":
        $datos = $ticket->listar_x_est_con_materiales();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar_x_est_con_materiales_tecnico":
        $datos = $ticket->listar_x_est_con_materiales_tecnico($_POST["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "listar_x_responsable":
        $datos = $ticket->listar_ticket_x_responsable($_POST["usu_asig"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            if ($row["tick_estado"] == "Cliente") {
                $sub_array[] = '<span class="label label-pill label-default">Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado</span>';
            } else if ($row["tick_estado"] == "Pendiente Por Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente Por Materiales</span>';
            } else if ($row["tick_estado"] == "Cierre Técnico") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Técnico</span>';
            } else if ($row["tick_estado"] == "Pendiente Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Materiales</span>';
            } else if ($row["tick_estado"] == "En Compras") {
                $sub_array[] = '<span class="label label-pill label-success">En<br/>Compras</span>';
            } else if ($row["tick_estado"] == "Pendiente Proveedor") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Proveedor</span>';
            } else if ($row["tick_estado"] == "Cierre Cliente") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado Con Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado Con<br/>Materiales</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-warning">Cerrado</span>';
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_sol_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_mater"]));
            }

            if ($row["fech_env_compras"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_env_compras"]));
            }

            if ($row["fech_sol_proveedor"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_proveedor"]));
            }

            if ($row["fech_asig_con_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig_con_mater"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            if ($row["fech_cier_usu"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_usu"]));
            }

            if ($row["fech_cierre"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
            }

            if ($row["usu_asig"] == null) {
                $sub_array[] = '<a onClick="asignar(' . $row["tick_id"] . ');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
            } else {
                $datos1 = $usuario->get_usuario_x_id($row["usu_asig"]);
                foreach ($datos1 as $row1) {
                    $sub_array[] = '<span class="label label-pill label-success">' . $row1["usu_nom"] . '</span>';
                }
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $sub_array[] = '<button type="button" data-ticket-id="' . $row["tick_id"] . '" id="btnMostrarReporte" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#pdfModal"> <i class="fa fa-download" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "listar_x_responsable_tecnico":
        $datos = $ticket->listar_ticket_x_responsable_tecnico($_POST["usu_asig"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cierre"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "listar_x_responsable_proveedores":
        $datos = $ticket->listar_ticket_x_responsable_proveedores($_POST["usu_asig"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_cierre"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "listar_x_compra_materiales":
        $datos = $ticket->listar_ticket_x_compra_materiales();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_mater"]));

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar_x_compra_materiales_en_compras":
        $datos = $ticket->listar_ticket_x_compra_materiales_en_compras();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_mater"]));

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "listar":
        $datos = $ticket->listar_ticket();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            if ($row["tick_estado"] == "Cliente") {
                $sub_array[] = '<span class="label label-pill label-default">Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado</span>';
            } else if ($row["tick_estado"] == "Pendiente Por Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente Por Materiales</span>';
            } else if ($row["tick_estado"] == "Cierre Técnico") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Técnico</span>';
            } else if ($row["tick_estado"] == "Pendiente Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Materiales</span>';
            } else if ($row["tick_estado"] == "En Compras") {
                $sub_array[] = '<span class="label label-pill label-success">En<br/>Compras</span>';
            } else if ($row["tick_estado"] == "Pendiente Proveedor") {
                $sub_array[] = '<span class="label label-pill label-success">Pendiente<br/>Proveedor</span>';
            } else if ($row["tick_estado"] == "Cierre Cliente") {
                $sub_array[] = '<span class="label label-pill label-warning">Cierre Cliente</span>';
            } else if ($row["tick_estado"] == "Asignado Con Materiales") {
                $sub_array[] = '<span class="label label-pill label-success">Asignado Con<br/>Materiales</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-warning">Cerrado</span>';
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            if ($row["fech_asig"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            if ($row["fech_sol_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_mater"]));
            }

            if ($row["fech_env_compras"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_env_compras"]));
            }

            if ($row["fech_sol_proveedor"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_sol_proveedor"]));
            }

            if ($row["fech_asig_con_mater"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig_con_mater"]));
            }

            if ($row["fech_cier_tecn"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_tecn"]));
            }

            if ($row["fech_cier_usu"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cier_usu"]));
            }

            if ($row["fech_cierre"] == null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
            } else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
            }

            if ($row["usu_asig"] == null) {
                $sub_array[] = '<a onClick="asignar(' . $row["tick_id"] . ');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
            } else {
                $datos1 = $usuario->get_usuario_x_id($row["usu_asig"]);
                foreach ($datos1 as $row1) {
                    $sub_array[] = '<span class="label label-pill label-success">' . $row1["usu_nom"] . '</span>';
                }
            }

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $sub_array[] = '<button type="button" data-ticket-id="' . $row["tick_id"] . '" id="btnMostrarReporte" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#pdfModal"> <i class="fa fa-download" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

        /* TODO: Listado de tickets,formato json para Datatable JS, filtro avanzado*/
    case "listar_filtro":
        $datos = $ticket->filtrar_ticket();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["usu_correo"];
            $sub_array[] = $row["tick_titulo"];

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

            $sub_array[] = '<button type="button" onClick="ver(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-wrench" aria-hidden="true"></i></button>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

        /* TODO: Formato HTML para mostrar detalle de ticket con comentarios */
    case "listardetalle":
        /* TODO: Listar todo el detalle segun tick_id */
        $datos = $ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
        break;
        /* TODO: Mostrar informacion de ticket en formato JSON para la vista */
    case "listar_materiales":
        $datos = $ticket->get_materiales($_POST["tick_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["unidad"];
            $sub_array[] = $row["cantidad"];
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;
    case "mostrar";
        $datos = $ticket->listar_ticket_x_id($_POST["tick_id"]);

        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["tick_id"] = $row["tick_id"];
                $output["usu_id"] = $row["usu_id"];
                $output["tick_titulo"] = $row["tick_titulo"];
                $output["tick_descrip"] = $row["tick_descrip"];
                $output["tick_diag_mant"] = $row["tick_diag_mant"];
                $output["tick_descrip_act_rep_efec"] = $row["tick_descrip_act_rep_efec"];
                $output["tick_estado"] = $row["tick_estado"];
                $output["usu_correo"] = $row["usu_correo"];
                $output["usu_nom"] = $row["usu_nom"];
                $output["emp_nom"] = $row["emp_nom"];
                $output["areas_nom"] = $row["areas_nom"];
                $output["ubicacion_nom"] = $row["ubicacion_nom"];
                $output["correo_soporte"] = $row["correo_soporte"];
                $output["tip_man_nom"] = $row["tip_man_nom"];
                $output["sis_nom"] = $row["sis_nom"];
                $output["prio_nom"] = $row["prio_nom"];
                $output["nombre_soporte"] = $row["nombre_soporte"];
            }
            echo json_encode($output);
        }
        break;
    case "mostrarGestionar";
        $datos = $ticket->listar_ticket_x_id_gestionar($_POST["tick_id"]);

        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["tick_id"] = $row["tick_id"];
                $output["tick_titulo"] = $row["tick_titulo"];
                $output["tick_descrip"] = $row["tick_descrip"];
                $output["tick_estado"] = $row["tick_estado"];
                $output["usu_correo"] = $row["usu_correo"];
                $output["emp_nom"] = $row["emp_nom"];
                $output["areas_nom"] = $row["areas_nom"];
                $output["ubicacion_nom"] = $row["ubicacion_nom"];
            }
            echo json_encode($output);
        }
        break;
    case "mostrarpendientes";
        $datos = $ticket->listar_ticket_x_id_x_responsable($_POST["tick_id"]);

        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["tick_id"] = $row["tick_id"];
                $output["usu_id"] = $row["usu_id"];
                $output["tick_titulo"] = $row["tick_titulo"];
                $output["tick_descrip"] = $row["tick_descrip"];
                $output["tick_diag_mant"] = $row["tick_diag_mant"];
                $output["tick_descrip_act_rep_efec"] = $row["tick_descrip_act_rep_efec"];
                $output["tick_estado"] = $row["tick_estado"];
                $output["tip_man_nom"] = $row["tip_man_nom"];
                $output["sis_nom"] = $row["sis_nom"];
                $output["prio_nom"] = $row["prio_nom"];
                $output["tick_num_requisicion"] = $row["tick_num_requisicion"];
                $output["usu_correo"] = $row["usu_correo"];
                $output["areas_nom"] = $row["areas_nom"];
                $output["ubicacion_nom"] = $row["ubicacion_nom"];
                $output["emp_nom"] = $row["emp_nom"];
                $output["nombre_soporte"] = $row["nombre_soporte"];
            }
            echo json_encode($output);
        }
        break;

    case "obtenerMateriales":
        $tick_id = $_GET['ID'];
        $datos = $ticket->listar_materiales_x_tick_id($tick_id);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["cantidad"];
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case "insertdetalle":
        $datos = $ticket->insert_ticketdetalle($_POST["tick_id"], $_POST["usu_id"], $_POST["tickd_descrip"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                /* TODO: Obtener tikd_id de $datos */
                $output["tickd_id"] = $row["tickd_id"];
                /* TODO: Consultamos si vienen archivos desde la vista */
                if (empty($_FILES['files']['name'])) {
                } else {
                    /* TODO:Contar registros */
                    $countfiles = count($_FILES['files']['name']);
                    /* TODO:Ruta de los documentos */
                    $ruta = "../public/document_detalle/" . $output["tickd_id"] . "/";
                    /* TODO: Array de archivos */
                    $files_arr = array();
                    /* TODO: Consultar si la ruta existe en caso no exista la creamos */
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }

                    /* TODO:recorrer todos los registros */
                    for ($index = 0; $index < $countfiles; $index++) {
                        $doc1 = $_FILES['files']['tmp_name'][$index];
                        $destino = $ruta . $_FILES['files']['name'][$index];

                        $documento->insert_documento_detalle($output["tickd_id"], $_FILES['files']['name'][$index]);

                        move_uploaded_file($doc1, $destino);
                    }
                }
            }
        }
        echo json_encode($datos);
        break;

        /* TODO: Total de ticket para vista de soporte */
    case "insertdetalleasignacion":
        $datos = $ticket->insert_ticketdetalle_asignacion($_POST["tick_id"], $_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                /* TODO: Obtener tikd_id de $datos */
                $output["tickd_id"] = $row["tickd_id"];
                /* TODO: Consultamos si vienen archivos desde la vista */
                if (empty($_FILES['files']['name'])) {
                } else {
                    /* TODO:Contar registros */
                    $countfiles = count($_FILES['files']['name']);
                    /* TODO:Ruta de los documentos */
                    $ruta = "../public/document_detalle/" . $output["tickd_id"] . "/";
                    /* TODO: Array de archivos */
                    $files_arr = array();
                    /* TODO: Consultar si la ruta existe en caso no exista la creamos */
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }

                    /* TODO:recorrer todos los registros */
                    for ($index = 0; $index < $countfiles; $index++) {
                        $doc1 = $_FILES['files']['tmp_name'][$index];
                        $destino = $ruta . $_FILES['files']['name'][$index];

                        $documento->insert_documento_detalle($output["tickd_id"], $_FILES['files']['name'][$index]);

                        move_uploaded_file($doc1, $destino);
                    }
                }
            }
        }
        echo json_encode($datos);
        break;

    case "totalxgestionar";
        $datos = $ticket->get_ticket_total_gestionar();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

    case "totalxRealizarTecnico":
        $datos = $ticket->get_ticket_total_x_realizar_x_tecnico($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
        } else {
            $output["TOTAL"] = 0;
        }
        echo json_encode($output);
        break;
    case "totalxRealizarTecnicoJefe":
        $datos = $ticket->get_ticket_total_x_realizar_x_tecnico_jefe($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
        } else {
            $output["TOTAL"] = 0;
        }
        echo json_encode($output);
        break;
    case "totalxrealizar":
        $datos = $ticket->get_ticket_total_x_realizar();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
        } else {
            $output["TOTAL"] = 0;
        }
        echo json_encode($output);
        break;
    case "totalxrealizarproveedores":
        $datos = $ticket->get_ticket_total_x_realizar_proveedores($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
        } else {
            $output["TOTAL"] = 0;
        }
        echo json_encode($output);
        break;
    case "totalxmateriales";
        $datos = $ticket->get_ticket_total_x_materiales();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

    case "totalconmateriales";
        $datos = $ticket->get_ticket_total_con_materiales();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;
    case "totalencompras";
        $datos = $ticket->get_ticket_total_en_compras();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;
    case "totalconmaterialesTecnico";
        $datos = $ticket->get_ticket_total_con_materiales_tecnico($_POST["usu_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;
    case "totalxvistobueno";
        $datos = $ticket->get_ticket_total_x_visto_bueno();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;
    case "totalxcerrar";
        $datos = $ticket->get_ticket_total_x_cerrar();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        /* TODO: Total de ticket Abierto para vista de soporte */
    case "total";

        $datos = $ticket->get_ticket_total();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        /* TODO: Total de ticket Abierto para vista de soporte */
    case "totalabierto";
        $datos = $ticket->get_ticket_totalabierto();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        /* TODO: Total de ticket Cerrados para vista de soporte */
    case "totalcerrado";
        $datos = $ticket->get_ticket_totalcerrado();
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        /* TODO: Formato Json para grafico de soporte */
    case "grafico";
        $datos = $ticket->get_ticket_grafico();
        echo json_encode($datos);
        break;

        /* TODO: Insertar valor de encuesta,estrellas y comentarios */
    case "encuesta":
        $ticket->insert_encuesta($_POST["tick_id"], $_POST["tick_estre"], $_POST["tick_coment"]);
        break;
}
