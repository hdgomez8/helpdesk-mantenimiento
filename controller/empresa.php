<?php
/* TODO:Cadena de Conexion */
require_once("../config/conexion.php");
/* TODO:Modelo Categoria */
require_once("../models/Empresa.php");
$empresa = new Empresa();

/*TODO: opciones del controlador Categoria*/
switch ($_GET["op"]) {
        /* TODO: Guardar y editar, guardar si el campo cat_id esta vacio */
        /* TODO: Formato para llenar combo en formato HTML */
    case "combo":
        $datos = $empresa->get_empresa();
        $html = "";
        $html .= "<option label='Seleccionar'></option>";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['emp_id'] . "'>" . $row['emp_nom'] . "</option>";
            }
            echo $html;
        }
        break;
}
