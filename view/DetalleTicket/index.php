<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
  <!DOCTYPE html>
  <html>
  <?php require_once("../MainHead/head.php"); ?>
  <title>HelpDesk CMC</>::Detalle Ticket</title>
  </head>

  <body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php"); ?>

    <!-- Contenido -->
    <div class="page-content">
      <div class="container-fluid">

        <header class="section-header">
          <div class="tbl">
            <div class="tbl-row">
              <div class="tbl-cell">
                <h3 id="lblnomidticket">Detalle Ticket - 1</h3>
                <div id="lblestado"></div>
                <span class="label label-pill label-primary" id="lblnomusuario"></span>
                <span class="label label-pill label-default" id="lblfechcrea"></span>
                <ol class="breadcrumb breadcrumb-simple">
                  <li><a href="../Home">Inicio</a></li>
                  <li class="active">Detalle Ticket</li>
                </ol>
              </div>
            </div>
          </div>
        </header>

        <div class="box-typical box-typical-padding">
          <div class="row">

            <div class="col-lg-12">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Asunto</label>
                  <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                </fieldset>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="col-lg-4">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="usuario">Usuario</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" readonly>
                </fieldset>
              </div>
              <div class="col-lg-2">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="empresa">Empresa</label>
                  <input type="text" class="form-control" id="empresa" name="empresa" readonly>
                </fieldset>
              </div>
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="area">Área</label>
                  <input type="text" class="form-control" id="area" name="area" readonly>
                </fieldset>
              </div>
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="ubicacion">Ubicación</label>
                  <input type="text" class="form-control" id="ubicacion" name="ubicacion" readonly>
                </fieldset>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tipoMantenimiento">Tipo Mantenimiento</label>
                  <input type="text" class="form-control" id="tipoMantenimiento" name="tipoMantenimiento" readonly>
                </fieldset>
              </div>
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="sistema">Sistema</label>
                  <input type="text" class="form-control" id="sistema" name="sistema" readonly>
                </fieldset>
              </div>
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="prioridad">Prioridad</label>
                  <input type="text" class="form-control" id="prioridad" name="prioridad" readonly>
                </fieldset>
              </div>
              <div class="col-lg-3">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tecnico">Técnico</label>
                  <input type="text" class="form-control" id="tecnico" name="tecnico" readonly>
                </fieldset>
              </div>
            </div>

            <div class="col-lg-12">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_titulo">Adjuntos</label>
                <table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                  <thead>
                    <tr>
                      <th style="width: 90%;">Nombre</th>
                      <th class="text-center" style="width: 10%;"></th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </fieldset>
            </div>


            <div class="col-lg-12">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tickd_descripusu">Descripción de la Solicitud</label>
                <div class="summernote-theme-1">
                  <textarea id="tickd_descripusu" name="tickd_descripusu" class="summernote" name="name"></textarea>
                </div>

              </fieldset>
            </div>

            <div class="col-lg-12">
              <fieldset class="form-group">
                <label class="form-label semibold" for="diag_mant">Diagnóstico de Mantenimiento</label>
                <div class="summernote-theme-1">
                  <textarea id="diag_mant" name="diag_mant" class="summernote" name="diag_mant"></textarea>
                </div>

              </fieldset>
            </div>

            <div class="col-lg-12">
              <fieldset class="form-group">
                <label class="form-label semibold" for="act_rep_efec">Descripción de Actividades o Reparaciones Efectuadas</label>
                <div class="summernote-theme-1">
                  <textarea id="act_rep_efec" name="act_rep_efec" class="summernote" name="act_rep_efec"></textarea>
                </div>

              </fieldset>
            </div>

          </div>
        </div>

      </div>
    </div>
    <!-- Contenido -->

    <?php require_once("../MainJs/js.php"); ?>

    <script type="text/javascript" src="detalleticket.js"></script>
    <script type="text/javascript" src="../MainNav/nav.js"></script>
    
    <script type="text/javascript" src="../notificacion.js"></script>

  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>