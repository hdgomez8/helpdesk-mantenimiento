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
            <form method="post" id="ticket_form">
              <div class="col-lg-12">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tick_titulo">Asunto</label>
                  <input type="text" class="form-control" id="tick_titulo" name="tick_titulo" readonly>
                </fieldset>
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

              <div class="col-lg-3">
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
                    <textarea id="tickd_descrip_diag_mant" class="summernote" name="tickd_descrip_diag_mant"></textarea>
                  </div>

                </fieldset>
              </div>


              <?php
              if ($_SESSION["rol_id"] != "2") {
                echo '
              <div class="col-lg-12">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-label">¿Requiere Materiales?</label>
                    <div class="radio-group">
                      <label>
                        <input type="radio" name="opcionMateriales" id="opcionMaterialesSi" value="si" onclick="ocultarCamposRequiereMateriales()"> Sí
                      </label>
                      <label>
                        <input type="radio" name="opcionMateriales" id="opcionMaterialesNo" value="no" onclick="mostrarCamposRequiereMateriales()"> No
                      </label>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4" id="Proveedor" style="display: none;">
                  <div class="form-group">
                    <label class="form-label">¿Requiere Proveedor?</label>
                    <div class="radio-group">
                      <label>
                        <input type="radio" name="opcionProveedor" id="opcionProveedorSi" value="si" onclick="ocultarCamposRequiereProveedor()"> Sí
                      </label>
                      <label>
                        <input type="radio" name="opcionProveedor" id="opcionProveedorNo" value="no" onclick="mostrarCamposRequiereProveedor()"> No
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div id="repuestos_accesorios">
                <div class="col-lg-12">
                  <label class="form-label semibold">Repuestos y/o Accesorios Instalados</label>
                  <div class="col-lg-12">
                    <table id="table1" class="display" style="width: 100%;border-collapse: collapse;">
                      <thead>
                        <tr>
                          <th style="border: 1px solid black; padding: 8px;">Descripción</th>
                          <th style="border: 1px solid black; padding: 8px;">Unidad</th>
                          <th style="border: 1px solid black; padding: 8px;">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Filas -->
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-lg-12">
                  <button type="button" class="btn btn-rounded btn-inline btn-success" data-toggle="modal" data-target="#agregarModal">Agregar Repuesto o Accesorio</button>
                </div>
              </div>';
              }
              ?>


              <div class="col-lg-12" id="descripcion_actividades">
                <fieldset class="form-group">
                  <label class="form-label semibold" for="tickd_descrip_act_rep_efec">Descripción de Actividades o Reparaciones Efectuadas</label>
                  <div class="summernote-theme-1">
                    <textarea id="tickd_descrip_act_rep_efec" name="tickd_descrip_act_rep_efec" class="summernote"></textarea>
                  </div>

                </fieldset>
              </div>

              <!-- Modal para agregar repuestos o accesorios -->
              <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="agregarModalLabel">Agregar Repuesto o Accesorio</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="agregarForm">
                        <div class="form-group">
                          <label class="form-label" for="descripcion">Descripción</label>
                          <select class="select2" id="descripcion" name="descripcion" data-placeholder="Seleccionar" required>
                          </select>
                        </div>

                        <div class="form-group">
                          <label class="form-label" for="unidad">Unidad</label>
                          <select class="select2" id="unidad" name="unidad" data-placeholder="Seleccionar">
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="cantidad">Cantidad</label>
                          <input type="number" class="form-control" name="cantidad" id="cantidad" value="0">
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-primary" id="agregarBtn">Agregar</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-12" id="cerrar_ticket">
                <button type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-primary">Cerrar Ticket</button>
              </div>
              <div class="col-lg-12" id="solicitar_materiales" style="display: none;">
                <button type="button" id="btnsolicitarmateriales" class="btn btn-rounded btn-inline btn-primary">Solicitar Materiales</button>
              </div>
              <div class="col-lg-12" id="solicitar_proveedor" style="display: none;">
                <button type="button" id="btnsolicitarproveedor" class="btn btn-rounded btn-inline btn-primary">Solicitar Proveedor</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Contenido -->

    <?php require_once("../MainJs/js.php"); ?>

    <script type="text/javascript" src="detalleticket-pendientes.js"></script>
    <script type="text/javascript" src="../MainNav/nav.js"></script>

    <script type="text/javascript" src="../notificacion.js"></script>

  </body>

  </html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>