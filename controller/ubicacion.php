<?php
/* TODO:Cadena de Conexion */
require_once("../config/conexion.php");
/* TODO:Modelo Categoria */
require_once("../models/Ubicacion.php");
$ubicacion = new Ubicacion();

/*TODO: opciones del controlador Categoria*/
switch ($_GET["op"]) {
        /* TODO: Guardar y editar, guardar si el campo cat_id esta vacio */
        /* TODO: Formato para llenar combo en formato HTML */
    case "combo":
        $datos = $ubicacion->get_ubicacion($_POST["areas_id"]);
        $html = "";
        $html .= "<option label='Seleccionar'></option>";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['ubicacion_id'] . "'>" . $row['ubicacion_nom'] . "</option>";
            }
            echo $html;
        }
        break;
}
