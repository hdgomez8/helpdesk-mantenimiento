<?php
require_once("../../config/conexion.php");
header('Content-Type: text/html; charset=UTF-8');
$dir_proyecto = $settings['DIRECCION_PROYECTO'];
$ticket_id = $_GET['tick_id'];

$conectar = new PDO("mysql:local=localhost;dbname=ticket", "root", "Orion1225");

$query = "SELECT tick_id,
tm_ticket.fech_crea,
tick_descrip,
tick_diag_mant,
tick_descrip_act_rep_efec,
emp_id,
fech_cierre,
fech_cier_usu,
fech_asig,
u1.usu_nom AS usu_nom,
u2.usu_correo AS correo_creador,
tip_mant_id,
sis_id,
tip_mant_id,
areas_nom,
satisfaccion,
u1.Firma,
u2.Firma AS Firma_solicitante,
tick_num_requisicion,
u1.usu_ape As usu_ape
from tm_ticket 
inner join tm_usuario u1 on u1.usu_id = tm_ticket.usu_asig 
inner join tm_usuario u2 on u2.usu_id = tm_ticket.usu_id 
inner join tm_areas on tm_areas.areas_id = tm_ticket.area_id
WHERE tick_id=:ticket_id";
$statement = $conectar->prepare($query);
$statement->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
// Ejecuta la consulta
$statement->execute();
// Recupera los resultados
$result = $statement->fetch(PDO::FETCH_ASSOC);
// Ahora $result contendrá la información del ticket, específicamente el valor de tick_id
$tick_id = $result['tick_id'];
$fech_asig = $result['fech_asig'];
$usu_nom = $result['usu_nom'];
$usu_ape = $result['usu_ape'];
$satisfaccion = $result['satisfaccion'];
$fech_cierre = $result['fech_cierre'];
$fech_crea = $result['fech_crea'];
$fech_cier_usu = $result['fech_cier_usu'];
$emp_id = $result['emp_id'];
$sis_id = $result['sis_id'];
$tick_num_requisicion = $result['tick_num_requisicion'];
$tick_descrip = $result['tick_descrip'];
$tick_diag_mant = $result['tick_diag_mant'];
$tick_descrip_act_rep_efec = $result['tick_descrip_act_rep_efec'];
$tip_mant_id = $result['tip_mant_id'];
$firma_tecnico = $result['Firma'];
$firma_solicitante = $result['Firma_solicitante'];
$correo_creador = $result['correo_creador'];
$areas_nom = $result['areas_nom'];

$query2 = "SELECT 
tm_material.nombre,
tm_unidades.unidad_nombre,
tm_materialsolicitado.cantidad
from tm_ticket 
inner join tm_usuario u1 on u1.usu_id = tm_ticket.usu_asig 
inner join tm_usuario u2 on u2.usu_id = tm_ticket.usu_id 
inner join tm_areas on tm_areas.areas_id = tm_ticket.area_id
inner join tm_solicitudmateriales on tm_solicitudmateriales.tick_id = tm_ticket.tick_id
inner join tm_materialsolicitado on tm_materialsolicitado.solicitud_id = tm_solicitudmateriales.solicitud_id
inner join tm_material on tm_material.material_id = tm_materialsolicitado.material_id
inner join tm_unidades on tm_unidades.unidad_id = tm_materialsolicitado.unidad_id
WHERE tm_ticket.tick_id = :ticket_id";
$statement2 = $conectar->prepare($query2);
$statement2->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
// Ejecuta la consulta
$statement2->execute();


// Inicializa un arreglo para almacenar los resultados
$resultados = array();

// Utiliza un bucle para recorrer todos los resultados
while ($row = $statement2->fetch(PDO::FETCH_ASSOC)) {
    $resultados[] = $row;
}


// Ahora $resultados contendrá todos los conjuntos de resultados
// Puedes acceder a cada conjunto utilizando un índice en $resultados

$nombre_material1 = isset($resultados[0]['nombre']) ? $resultados[0]['nombre'] : "";
$unidad_material1 = isset($resultados[0]['unidad_nombre']) ? $resultados[0]['unidad_nombre'] : "";
$cantidad_material1 = isset($resultados[0]['cantidad']) ? $resultados[0]['cantidad'] : "";

$nombre_material2 = isset($resultados[1]['nombre']) ? $resultados[1]['nombre'] : "";
$unidad_material2 = isset($resultados[1]['unidad_nombre']) ? $resultados[1]['unidad_nombre'] : "";
$cantidad_material2 = isset($resultados[1]['cantidad']) ? $resultados[1]['cantidad'] : "";

// $nombre_material3 = $resultados[2]['nombre'];
// $unidad_material3 = $resultados[2]['unidad_nombre'];
// $cantidad_material3 = $resultados[2]['cantidad'];

// $nombre_material4 = $resultados[3]['nombre'];
// $unidad_material4 = $resultados[3]['unidad_nombre'];
// $cantidad_material4 = $resultados[3]['cantidad'];
$fechaFirma = new DateTime('2023-11-30');
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilo personalizado para la tabla */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-cell {
            padding: 8px;
            text-align: center;
            border: 2px solid #333;
            /* Borde oscuro */
        }

        .width-20 {
            width: 20%;
        }

        .width-60 {
            width: 60%;
        }
    </style>
</head>

<body>

    <table style="height: 30px; width: 600px;">
        <tbody>
            <tr style="height: 60px;">
                <td style="width: 80px; height: 70px; border: 1px solid black;"><img
                        src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/helpdesk/public/img/logo-colsalud.png" alt=""
                        style="width: 80px; height: auto;"></td>
                <td style="width: 500px; height: 70px; border: 1px solid black;text-align: center;"><strong>SOLICITUD DE
                        MANTENIMIENTO Y REPORTE DE SERVICIO</strong></td>
                <td style="width: 20px; height: 70px; border: 1px solid black;">
                    <table style="height: 51px;" width="100">
                        <tbody>
                            <tr style="height: 20px;">
                                <td
                                    style="width: 130px; height: 22px; border: 1px solid black;font-size: 8px;text-align: center;">
                                    <strong>CODIGO:<strong><br />CMC-GI-FR-001-01
                                </td>
                            </tr>
                            <tr style="height: 20px;">
                                <td
                                    style="width: 130px; height: 22px; border: 1px solid black;font-size: 8px;text-align: center;">
                                    <strong>FECHA DE EMISIÓN:<strong><br />31.01.17
                                </td>
                            </tr>
                            <tr style="height: 20px;">
                                <td
                                    style="width: 130px; height: 22px; border: 1px solid black;font-size: 8px;text-align: center;">
                                    <strong>FECHA DE ACTUALIZACIÓN:<strong><br />13.10.23
                                </td>
                            </tr>
                            <tr style="height: 20px;">
                                <td
                                    style="width: 130px; height: 22px; border: 1px solid black;font-size: 8px;text-align: center;">
                                    <strong>VERSION: 007<strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 6px;" width="600px">
        <tbody>
            <tr style="height: 6px;">
                <td
                    style="width: 720px; height: 6px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>SOLICITUD</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 13px; width: 714px;">
        <tbody>
            <tr>
                <td style="width: 114px;border: 1px solid black;font-size: 10px;">FECHA: <span style="font-size: 12px;">
                        <?php
                        $fech_crea_formateada = date("Y-m-d", strtotime($fech_crea));
                        echo $fech_crea_formateada;
                        ?>
                    </span>
                <td style="width: 350px;border: 1px solid black;font-size: 10px;">SOLICITANTE: <span
                        style="font-size: 12px;">
                        <?php echo $correo_creador; ?>
                    </span></td>
                <td style="width: 250px;border: 1px solid black;font-size: 10px;">SERVICIO: <span
                        style="font-size: 12px;">
                        <?php echo $areas_nom; ?>
                    </span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 18px; width: 724px;">
        <tbody>
            <tr style="height: 113.875px;">
                <td style="width: 200px; height: 113.875px; border: 1px solid black;">
                    <div style="display: inline-block;">
                        <table style="width: 240px;">
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                EMPRESA:</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                COLSALUD</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left; <?php echo $emp_id == '1' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">CENTRO
                                                DE IMÁGENES</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $emp_id == '3' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                CUIDADO CRITICO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $emp_id == '2' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                CARDIOSALUD</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $emp_id == '4' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width: 400px; height: 113.875px; border: 1px solid black;">
                    <table style="width: 100%;">
                        <tr>
                            <td
                                style="font-size: 10px; text-align: left; vertical-align: top;height: 113.875px;line-height: 1;">
                                <strong>DESCRIPCION DE LA SOLICITUD:</strong><span style="font-size: 12px;">
                                    <?php echo $tick_descrip ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 10px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>PLANIFICACION DE LA SOLICITUD(Espacio reservado personal de mantenimiento)</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 80px;" width="724px">
        <tbody>
            <tr style="height: 80px;">
                <td style="width: 600px;height: 80px;border: 1px solid black;">
                    <div style="display: inline-block;">
                        <table style="width: 724px">
                            <tr>
                                <td>
                                    <table style="width: 60%;">
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">TIPO
                                                DE<br />MANTENIMIENTO</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                CORRECTIVO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $tip_mant_id == '1' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                PREVENTIVO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $tip_mant_id == '2' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                PREDICTIVO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $tip_mant_id == '3' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                TRASLADO Y<br />MOVIMINETO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $tip_mant_id == '4' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table style="width: 60%;">
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">
                                                SISTEMAS:</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 45%; font-size: 8px; text-align: left;">
                                                ELECTRICO</td>
                                            <td
                                                style="height:20px;width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '1' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">AIRES
                                                ACONDICIONADOS</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '2' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">
                                                ELECTRO MECANICO</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '3' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">
                                                HIDROSANITARIO</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '4' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">
                                                INFRAESTRUCTURA</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '5' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">
                                                MUEBLES Y ENCERES</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '6' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px; width: 45%; font-size: 8px; text-align: left;">GASES
                                                MEDICINALES</td>
                                            <td
                                                style="height:20px; width: 5%;border: 1px solid black; font-size: 8px; text-align: left;<?php echo $sis_id == '7' ? 'background-color: black;' : 'background-color: white;'; ?>">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table style="width: 99%;">
                                        <tr>
                                            <td style="height:19px;width: 10%; font-size: 8px; text-align: left;"></td>
                                            <td style="height:19px;width: 20%; font-size: 8px; text-align: left;">&nbsp;
                                            </td>
                                            <td style="height:19px;width: 20%; font-size: 8px; text-align: left;">NO. DE
                                                SOLICITUD</td>
                                            <td style="height:19px;width: 35%;border: 1px solid black; font-size: 12px; text-align: center;"
                                                colspan="3">
                                                <?php echo $tick_id; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 10%; font-size: 8px; text-align: left;">FECHA
                                                ASIGNACION:</td>
                                            <td
                                                style="height:20px;width: 20%;border: 1px solid black; font-size: 12px; text-align: center;">
                                                <?php $fecha_asig_formateada = date("Y-m-d", strtotime($fech_asig));
                                                echo $fecha_asig_formateada; ?>
                                            </td>
                                            <td style="height:20px;width: 20%; font-size: 8px; text-align: left;">
                                                TECNICO/EMPRESA</td>
                                            <td style="height:20px;width: 35%;border: 1px solid black; font-size: 12px; text-align: center;"
                                                colspan="3">
                                                <?php $nombre_completo_tecnico = $usu_nom . ' ' . $usu_ape;
                                                echo $nombre_completo_tecnico; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 5%; font-size: 8px; text-align: left;">FECHA
                                                INICIO:</td>
                                            <td
                                                style="height:20px;width: 25%;border: 1px solid black; font-size: 12px; text-align: center;">
                                                <?php $fecha_asig_formateada = date("Y-m-d", strtotime($fech_asig));
                                                echo $fecha_asig_formateada; ?>
                                            </td>
                                            <td style="height:20px; width: 20%; font-size: 8px; text-align: left;">FECHA
                                                FINAL:</td>
                                            <td
                                                style="height:20px; width: 20%;border: 1px solid black; font-size: 12px; text-align: center;">
                                                <?php $fech_cierre_formateada = date("Y-m-d", strtotime($fech_cierre));
                                                echo $fech_cierre_formateada; ?>
                                            </td>
                                            <td style="height:20px; width: 5%; font-size: 8px; text-align: left;">H/H
                                            </td>
                                            <td
                                                style="height:20px; width: 10%;border: 1px solid black; font-size: 12px; text-align: center;">
                                                <?php echo "10"; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 20%; font-size: 8px; text-align: left;">
                                                CONTACTO SERVICIO:</td>
                                            <td style="height:20px;width: 70%;border: 1px solid black; font-size: 14px; text-align: left;"
                                                colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php echo $correo_creador; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:20px;width: 15%; font-size: 8px; text-align: left;">NO.
                                                SOLICITUD COMPRAS:</td>
                                            <td
                                                style="height:20px;width: 20%;border: 1px solid black; font-size: 8px; text-align: left;">
                                                &nbsp;</td>
                                            <td style="height:20px; width:20%; font-size: 8px; text-align: left;">NO.
                                                REQUISICION:</td>
                                            <td style="height:20px; width: 30%;border: 1px solid black; font-size: 14px; text-align: left;"
                                                colspan="3">&nbsp;&nbsp;
                                                <?php echo $tick_num_requisicion; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 10px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>DIAGNOSTICO DE MANTENIMIENTO(Espacio reservado personal de mantenimiento)</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 65px;" width="724px">
        <tbody>
            <tr>
                <td style="width: 690px;height: 65px;border: 1px solid black;line-height: 1;"><span
                        style="font-size: 12px;">
                        <?php echo $tick_diag_mant ?>
                    </span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 10px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>REPUESTOS Y/O ACCESORIOS INSTALADOS</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 90px; width: 724px;">
        <tbody>
            <tr>
                <td style="width: 270px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;DESCRIPCION
                </td>
                <td style="width: 30px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;UNIDAD</td>
                <td style="width: 30px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;CANT</td>
                <td style="width: 270px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;DESCRIPCION
                </td>
                <td style="width: 30px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;UNIDAD</td>
                <td style="width: 30px; text-align: center;border: 1px solid black;font-size: 10px;">&nbsp;CANT</td>
            </tr>
            <tr>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;
                    <?php echo isset($nombre_material1) ? $nombre_material1 : '&nbsp;'; ?>
                </td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;
                    <?php echo isset($unidad_material1) ? $unidad_material1 : '&nbsp;'; ?>
                </td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;&nbsp;&nbsp;
                    <?php echo isset($cantidad_material1) ? $cantidad_material1 : '&nbsp;'; ?>
                </td>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;
                    <?php echo isset($nombre_material2) ? $nombre_material2 : '&nbsp;'; ?>
                </td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;
                    <?php echo isset($unidad_material2) ? $unidad_material2 : '&nbsp;'; ?>
                </td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;&nbsp;&nbsp;
                    <?php echo isset($cantidad_material2) ? $cantidad_material2 : '&nbsp;'; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 270px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
                <td style="width: 30px;border: 1px solid black;font-size: 10px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 9px; text-align: center; vertical-align: middle;line-height: 1; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>DESCRIPCION DE ACTIVIDADES O REPARACIONES EFECTUADAS</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 55px;" width="720px">
        <tbody>
            <tr>
                <td style="width: 720px;height: 55px;border: 1px solid black;line-height: 1;"><span
                        style="font-size: 12px;">
                        <?php echo $tick_descrip_act_rep_efec ?>
                    </span></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 10px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>EVALUACI&Oacute;N DEL SERVICIO</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="710px">
        <tbody>
            <tr style="height: 10px;">
                <td style="width: 720px;height: 10px;border: 1px solid black;">
                    <table style="height: 10px; width: 710px;">
                        <tbody>
                            <tr>
                                <td style="width: 475px;font-size: 12px;">&nbsp;Recibio trabajo a satisfaccion: SI
                                    &nbsp;<span
                                        style="border: 1px solid black;<?php echo $satisfaccion == '1' ? 'background-color: black;' : 'background-color: white;'; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;
                                    NO &nbsp;<span
                                        style="border: 1px solid black;<?php echo $satisfaccion == '0' ? 'background-color: black;' : 'background-color: white;'; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </td>
                                <td style="width: 235px;font-size: 12px;">&nbsp;Fecha de Recibido:&nbsp;&nbsp;&nbsp;
                                    <?php $fecha_cier_usu_formateada = date("Y-m-d", strtotime($fech_cier_usu));
                                    echo $fecha_cier_usu_formateada; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 10px;" width="600px">
        <tbody>
            <tr style="height: 10px;">
                <td
                    style="width: 720px; height: 10px; text-align: center; vertical-align: middle; border: 1px solid black;font-size: 10px;background-color: #dcdcdc;">
                    <strong>OBSERVACIONES</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="height: 30px;" width="720px">
        <tbody>
            <tr>
                <td style="width: 720px;height: 30px;border: 1px solid black;line-height: 1;"><span
                        style="font-size: 12px;"></span></td>
            </tr>
        </tbody>
    </table>
    <table width="710px">
        <tbody>
            <tr style="height: 50;">
                <td style="width: 234px; height: 50px;border: 1px solid black;text-align: center;"><img
                        src="http://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo $firma_solicitante; ?>" alt=""
                        style="width: 120px; height: auto;"></td>

                <td style="width: 240px; height: 50px;border: 1px solid black;text-align: center;">
                    <img src="http://<?php echo $_SERVER['HTTP_HOST'] . '/helpdesk/public/img/firmas/' . ($fech_cierre <= $fechaFirma ? 'Jefe-Milton.jpg' : 'Jefe-Edinson-Mantenimiento.jpg'); ?>"
                        alt="" style="width: 120px; height: auto;">
                </td>

                <td style="width: 240px; height: 50px;border: 1px solid black;text-align: center;"><img
                        src="http://<?php echo $_SERVER['HTTP_HOST']; ?><?php echo $firma_tecnico; ?>" alt=""
                        style="width: 120px; height: auto;"></td>
            </tr>
        </tbody>
    </table>
    <table style="height: 8px;" width="720px">
        <tbody>
            <tr>
                <td style="width: 234px; text-align: center;border: 1px solid black; font-size: 8px;">&nbsp;FIRMA
                    SOLICITANTE</td>
                <td style="width: 240px; text-align: center;border: 1px solid black; font-size: 8px;">&nbsp;FIRMA SUP.
                    MANTENIMIENTO<?php echo ($fech_cierre <= $fechaFirma ? 'Jefe-Milton.jpg' : 'Jefe-Edinson-Mantenimiento.jpg'); ?></td>
                <td style="width: 240px; text-align: center;border: 1px solid black; font-size: 8px;">FIRMA
                    T&Eacute;CNICO DE MANTENIMIENTO&nbsp;</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
<?php
$html = ob_get_clean();
//echo $html;

require_once '../../vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper("letter");

// cambio
$dompdf->render();

$dompdf->stream("archivo_.pdf", array("Attachment" => false));
?>