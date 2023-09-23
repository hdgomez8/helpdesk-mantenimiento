<?php
/*TODO: librerias necesarias para que el proyecto pueda enviar emails */
require('class.phpmailer.php');
include("class.smtp.php");

/*TODO: llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../Models/Ticket.php");

class Email extends PHPMailer
{

    //TODO: variable que contiene el correo del destinatario
    // protected $gCorreo = 'mantenimiento@clinicamarcaribe.com';
    // protected $gContrasena = 'Aroc@2022';
    protected $gCorreo = 'sistemas@clinicamarcaribe.com';
    protected $gContrasena = 'Arduin02023*';
    //TODO: variable que contiene la contraseña del destinatario

    /* TODO:Alertar al momento de generar un ticket */
    public function ticket_abierto($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $correo = $row["usu_correo"];
        }

        //TODO: IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Abierto 1 " . $id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto 1" . $id;
        //Igual//
        $cuerpo = file_get_contents('../public/NuevoTicket.html'); /*TODO:  Ruta del template en formato HTML */
        /*TODO: parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Abierto");
        return $this->Send();
    }

    /* TODO:Alertar al momento de generar un ticket a sistemas*/
    public function ticket_abierto_correo($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id_correo($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $correo = $row["usu_correo"];
        }

        //TODO: IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Abierto " . $id;
        $this->CharSet = 'UTF8';
        $this->addAddress("mantenimiento@clinicamarcaribe.com");
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto " . $id;
        //Igual//
        $cuerpo = file_get_contents('../public/NuevoTicket.html'); /*TODO:  Ruta del template en formato HTML */
        /*TODO: parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Abierto");
        return $this->Send();
    }

    /* TODO:Alertar al momento de Cerrar un ticket */
    public function ticket_cerrado($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $correo = $row["usu_correo"];
            $nombre_soporte = $row["nombre_soporte"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Cerrado " . $id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Cerrado " . $id;
        //Igual//
        $cuerpo = file_get_contents('../public/CerradoTicket.html'); /*TODO:  Ruta del template en formato HTML */
        /*TODO:  parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblUsuAsig", $nombre_soporte, $cuerpo);


        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");
        return $this->Send();
    }

    /* TODO:Alertar al momento de Cerrar un ticket */
    public function ticket_cierre_tecnico($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $correo = $row["usu_correo"];
            $nombre_soporte = $row["nombre_soporte"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Cerrado " . $id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Cerrado "  . $id;
        //Igual//
        $cuerpo = file_get_contents('../public/CerradoTicket.html'); /*TODO:  Ruta del template en formato HTML */
        /*TODO:  parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblUsuAsig", $nombre_soporte, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");
        return $this->Send();
    }

    /* TODO:Alertar al momento de Asignar un ticket */
    public function ticket_asignado($tick_id)
    {
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row) {
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $correo = $row["usu_correo"];
            $correo_soporte = $row["correo_soporte"];
            $nombre_soporte = $row["nombre_soporte"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com'; //Aqui el server
        $this->Port = 587; //Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Asignado " . $id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->addAddress($correo_soporte);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Asignado " . $id;
        //Igual//
        $cuerpo = file_get_contents('../public/AsignarTicket.html'); /*TODO:  Ruta del template en formato HTML */
        /*TODO:  parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblUsuAsig", $nombre_soporte, $cuerpo);
        

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Asignado");
        return $this->Send();
    }
}

