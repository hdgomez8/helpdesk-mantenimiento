<?php
require_once("../../config/conexion.php");
$dir_proyecto = $settings['DIRECCION_PROYECTO'];
if (isset($_SESSION["usu_id"])) {
  ?>
  <!DOCTYPE html>
  <html>
  <?php require_once("../MainHead/head.php"); ?>
  <title>HelpDesk CMC</>::Detalle Ticket</title>
  </head>
  <style>
    td {
      border: 1px solid black;
      padding: 8px;
    }
  </style>

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
                <input type="hidden" id="dir_proyecto" value="<?php echo $dir_proyecto; ?>">
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
                  <label class="form-label semibold" for="tick_tipo_mantenimiento">Tipo De Mantenimniento</label>
                  <input type="text" class="form-control" id="tick_tipo_mantenimiento" name="tick_tipo_mantenimiento"
                    readonly>
                </fieldset>
              </div>

              <div class="col-lg-4">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_sistemas">Sistemas</label>
                  <input type="text" class="form-control" id="tick_sistemas" name="tick_sistemas" readonly>
                </fieldset>
              </div>

              <div class="col-lg-2">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_prioridad">Prioridad</label>
                  <input type="text" class="form-control" id="tick_prioridad" name="tick_prioridad" readonly>
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
                <label class="form-label semibold" for="tickd_descripusu">Descripción</label>
                <div class="summernote-theme-1">
                  <textarea id="tickd_descripusu" name="tickd_descripusu" class="summernote"></textarea>
                </div>

              </fieldset>
            </div>

            <div class="col-lg-12" id="diagnostico_mantenimiento">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tickd_descrip_diag_mant">Diagnostico de mantenimiento</label>
                <div class="summernote-theme-1">
                  <textarea id="tickd_descrip_diag_mant" class="summernote" name="tickd_descrip_diag_mant"
                    readonly></textarea>
                </div>

              </fieldset>
            </div>

            <div id="repuestos_accesorios">
              <div class="col-lg-12">
                <label class="form-label semibold">Repuestos y/o Accesorios Solicitados</label>
                <div class="col-lg-12">
                  <table id="tablaDatos" class="display" style="width: 100%; border-collapse: collapse;">
                    <thead>
                      <tr>
                        <th style="border: 1px solid black; padding: 8px;">Descripción</th>
                        <th style="border: 1px solid black; padding: 8px;">Unidad</th>
                        <th style="border: 1px solid black; padding: 8px;">Cantidad</th>
                      </tr>
                    </thead>
                    <tbody id="tablaDatos-body">
                      <!-- Filas se llenarán dinámicamente -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div>
              <div class="col-lg-4">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="orden_compra">Solicitud De Compra</label>
                  <input type="text" class="form-control" id="orden_compra" name="orden_compra" readonly>
                </fieldset>
              </div>
            </div>

            <div class="col-lg-12" id="observacion_solicitud">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_obs_comp">Observación Solicitud</label>
                <div class="summernote-theme-1">
                  <textarea id="tick_obs_comp" name="tick_obs_comp" class="summernote" name="tick_obs_comp"></textarea>
                </div>
              </fieldset>
            </div>

            <div class="col-lg-12" id="observacion_gestion">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_obs_gestion">Observación Gestion</label>
                <div class="summernote-theme-1">
                  <textarea id="tick_obs_gestion" name="tick_obs_gestion" class="summernote"
                    name="tick_obs_gestion"></textarea>
                </div>
              </fieldset>
            </div>

            <div class="col-lg-12" id="estado_solicitud">
              <div class="justify-content-center">
                <div class="col-lg-2 text-center" id="cumple_solicitud">
                  <button type="button" id="btncumple" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-success">Cumple</button>
                </div>
                <div class="col-lg-2 text-center" id="no_cumple_solicitud">
                  <button type="button" id="btnnocumple" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-danger">No Cumple</button>
                </div>
                <div class="col-lg-2 text-center" id="cancelar">
                  <button type="button" id="btncancelar" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-secondary">Cancelar</button>
                </div>
              </div>
            </div>

            <div class="col-lg-12" id="gestion_solicitud">
              <div>
                <div class="col-lg-2" id="gestionando_solicitud">
                  <button type="button" id="btngestionandosolicitud" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-success">En Gestion</button>
                </div>
                <div class="col-lg-2" id="cerrado">
                  <button type="button" id="btncerrado" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-danger">Gestionado</button>
                </div>
                <div class="col-lg-1" id="cancelar">
                  <button type="button" id="btncancelar" style="margin-top: 10px;"
                    class="btn btn-rounded btn-inline btn-secondary">Cancelar</button>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
      <!-- Contenido -->

      <?php require_once("../MainJs/js.php"); ?>

      <script type="text/javascript" src="DetalleTicket-Pendiente-Materiales-en-compras.js"></script>
      <script type="text/javascript" src="../MainNav/nav.js"></script>

      <script type="text/javascript" src="../notificacion.js"></script>

  </body>

  </html>
  <?php
} else {
  header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>