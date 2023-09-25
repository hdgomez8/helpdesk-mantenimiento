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
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_titulo">Asunto</label>
                <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
              </fieldset>
            </div>

            <div class="col-lg-4">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_tipo_mantenimiento">Tipo De Mantenimniento</label>
                <input type="text" class="form-control" id="tick_tipo_mantenimiento" name="tick_tipo_mantenimiento" readonly>
              </fieldset>
            </div>

            <div class="col-lg-4">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_sistemas">Sistemas</label>
                <input type="text" class="form-control" id="tick_sistemas" name="tick_sistemas" readonly>
              </fieldset>
            </div>

            <div class="col-lg-4">
              <fieldset class="form-group">
                <label class="form-label semibold" for="tick_prioridad">Prioridad</label>
                <input type="text" class="form-control" id="tick_prioridad" name="tick_prioridad" readonly>
              </fieldset>
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
                  <textarea id="tickd_descrip_diag_mant" class="summernote" name="tickd_descrip_diag_mant" readonly></textarea>
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
                <div class="form-group">
                  <label class="form-label semibold">¿Orden de Compra o Requision?</label>
                  <div class="radio-group">
                    <label>
                      <input type="radio" name="req_orden" id="req_orden" value="ordenCompra" onclick="mostrarCampoOrdenCompra()"> Orden de Compra
                    </label>
                    <label>
                      <input type="radio" name="req_orden" id="req_orden" value="requisicion" onclick="mostrarCampoRequisicion()"> Requisicion
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-lg-4" id="numero_requisicion" style="display: none;">
                <label for="campoRequisicion">Numero de Requisicion</label>
                <input class="form-control" type="text" id="campoRequisicion" placeholder="Escribe aquí">
              </div>
              <div class="col-lg-4" id="numero_orden_compra" style="display: none;">
                <label for="campoOrdenCompra">Numero de Orden de Compra</label>
                <input class="form-control" type="text" id="campoOrdenCompra" placeholder="Escribe aquí">
              </div>
            </div>

            <div class="col-lg-12">
              <div>
                <div class="col-lg-12" id="reasignar_ticket">
                  <button type="button" id="btnreasignarticket" style="margin-top: 10px;" class="btn btn-rounded btn-inline btn-primary">Reasignar Ticket</button>
                </div>
                <div class="col-lg-12" id="enviar_compras">
                  <button type="button" id="btnenviarcompras" style="margin-top: 10px;" class="btn btn-rounded btn-inline btn-success">Enviar a Compras</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Contenido -->

      <?php require_once("../MainJs/js.php"); ?>

      <script type="text/javascript" src="DetalleTicket-Pendiente-Materiales.js"></script>
      <script type="text/javascript" src="../MainNav/nav.js"></script>
      
      <script type="text/javascript" src="../notificacion.js"></script>

  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>