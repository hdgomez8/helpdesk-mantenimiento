<?php
require_once("../../config/conexion.php");
$dir_proyecto = $settings['DIRECCION_PROYECTO'];
if (isset($_SESSION["usu_id"])) {
	echo "<script>console.log('" . $dir_proyecto . "');</script>";
?>
	<!DOCTYPE html>
	<html>
	<?php require_once("../MainHead/head.php"); ?>
	<title>HelpDesk CMC</>::Consultar Solicitud</title>
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
								<h3>Consultar Solicitud</h3>
								<input type="hidden" id="dir_proyecto" value="<?php echo $dir_proyecto; ?>">
								<ol class="breadcrumb breadcrumb-simple">
									<li><a href="../Home">Inicio</a></li>
									<li class="active">Consultar Solicitud</li>
								</ol>
							</div>
						</div>
					</div>
				</header>

				<div class="box-typical box-typical-padding">
					<div class="box-typical box-typical-padding" id="table">
						<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
							<thead>
								<tr>
									<th style="width: 5%;">Nro.<br>Ticket</th>
									<th class="d-none d-sm-table-cell" style="width: 30%;">Usuario</th>
									<th class="d-none d-sm-table-cell" style="width: 30%;">Título</th>
									<th class="d-none d-sm-table-cell" style="width: 5%;">Estado</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Creación</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Asignación</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Solicitud<br>Materiales</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Envio<br>Compras</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Solicitud<br>Proveedor</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Reasignación</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Cierre<br>Técnico</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Cierre<br>Usuario</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha<br>Cierre</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Responsable</th>
									<th class="text-center" style="width: 5%;"></th>
									<th class="text-center" style="width: 5%;"></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>

				</div>

			</div>

			<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<iframe id="pdfIframe" src="" width="100%" height="500"></iframe>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>


		</div>

		<!-- Contenido -->
		<?php require_once("modalasignar.php"); ?>

		<?php require_once("../MainJs/js.php"); ?>

		<script type="text/javascript" src="../../public/js/helpers/helpers.js"></script>
		<script type="text/javascript" src="consultarticket.js"></script>
		<script type="text/javascript" src="../MainNav/nav.js"></script>

		<script type="text/javascript" src="../notificacion.js"></script>

		<script>
			$(document).on("click", "#btnMostrarReporte", function() {
				var ticketId = $(this).data("ticket-id");
				var iframeSrc = "../ConsultarTicket/reporte.php?tick_id=" + ticketId;
				$("#pdfIframe").attr("src", iframeSrc);
				$("#pdfModalLabel").text("PDF Preview - Ticket ID: " + ticketId);
			});

		</script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>