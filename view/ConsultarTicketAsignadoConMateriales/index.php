<?php
require_once("../../config/conexion.php");
$dir_proyecto = $settings['DIRECCION_PROYECTO'];
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<?php require_once("../MainHead/head.php"); ?>
	<title>HelpDesk CMC</>::Consultar Solicitudes Pendientes</title>
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
								<h3>Solicitudes Pendientes Con Materiales</h3>
								<input type="hidden" id="dir_proyecto" value="<?php echo $dir_proyecto; ?>">
								<ol class="breadcrumb breadcrumb-simple">
									<li><a href="../Home">Inicio</a></li>
									<li class="active">Solicitudes Pendientes Con Materiales</li>
								</ol>
							</div>
						</div>
					</div>
				</header>

				<div class="box-typical box-typical-padding">

					<div class="row" id="viewuser">
						<div class="col-lg-3" style="display: none;">
							<fieldset class="form-group">
								<label class="form-label" for="tick_titulo">Asunto</label>
								<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese Asunto" required>
							</fieldset>
						</div>

						<div class="col-lg-3" style="display: none;">
							<fieldset class="form-group">
								<label class="form-label" for="cat_id">Categoría</label>
								<select class="select2" id="cat_id" name="cat_id" data-placeholder="Seleccionar">
									<option label="Seleccionar"></option>

								</select>
							</fieldset>
						</div>

						<div class="col-lg-2" style="display: none;">
							<fieldset class="form-group">
								<label class="form-label" for="prio_id">Prioridad</label>
								<select class="select2" id="prio_id" name="prio_id" data-placeholder="Seleccionar">
									<option label="Seleccionar"></option>

								</select>
							</fieldset>
						</div>
					</div>
					
					<div class="box-typical box-typical-padding" id="table">
						<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
							<thead>
								<tr>
									<th style="width: 5%;">Nro.Ticket</th>
									<th class="d-none d-sm-table-cell" style="width: 30%;">Usuario</th>
									<th class="d-none d-sm-table-cell" style="width: 30%;">Asunto</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Creación</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Asignación</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Cierre</th>
									<th class="text-center" style="width: 5%;"></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>

				</div>

			</div>
		</div>
		<!-- Contenido -->
		<?php require_once("modalasignar.php"); ?>

		<?php require_once("../MainJs/js.php"); ?>

		<script type="text/javascript" src="../../public/js/helpers/helpers.js"></script>
		<script type="text/javascript" src="ConsultarTicketAsignadoConMateriales.js"></script>
		<script type="text/javascript" src="../MainNav/nav.js"></script>
		
		<script type="text/javascript" src="../notificacion.js"></script>

	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>