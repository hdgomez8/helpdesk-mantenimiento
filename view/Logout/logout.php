<?php
    require_once("../../config/conexion.php");
$dir_proyecto = $settings['DIRECCION_PROYECTO'];
    /* TODO: Destruir Session */
    session_destroy();
    /* TODO: Luego de cerrar session enviar a la pantalla de login */
    header("Location:".Conectar::ruta()."indexLoginMant.php");
    exit();
