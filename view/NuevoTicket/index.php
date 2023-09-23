<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<?php require_once("../MainHead/head.php"); ?>
	<title>HelpDesk CMC::Nueva solicitud de servicio.</title>
	<style>
		.custom-alert {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: #fff;
			border: 2px solid #3498db;
			padding: 20px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
			display: none;
		}

		.custom-alert-content {
			text-align: center;
		}

		#custom-alert-message {
			font-weight: bold;
			font-size: 24px;
			color: #2ecc71;
			margin-bottom: 10px;
		}

		#custom-alert-close {
			background-color: #3498db;
			/* Color azul */
			color: #fff;
			border: none;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 50px;
			/* Hace que el botón sea ovalado */
		}

		.checkmark {
			width: 80px;
			height: 80px;
			border-radius: 50%;
			position: absolute;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #2ecc71;
			/* Color del chulo */
			animation: fadeInOut 1s ease-in-out infinite;
		}

		.checkmark-circle {
			width: 80px;
			height: 80px;
			border: 3px solid #2ecc71;
			/* Color del chulo */
			border-radius: 50%;
			position: absolute;
			animation: scaleInOut 1s ease-in-out infinite;
		}

		.checkmark-check {
			width: 30px;
			height: 60px;
			border: 6px solid transparent;
			border-top: 0;
			border-right: 0;
			border-bottom-color: white;
			border-radius: 50%;
			transform: rotate(40deg);
		}

		@keyframes fadeInOut {

			0%,
			100% {
				opacity: 1;
			}

			50% {
				opacity: 0;
			}
		}

		@keyframes scaleInOut {

			0%,
			100% {
				transform: scale(1);
			}

			50% {
				transform: scale(0.8);
			}
		}
	</style>
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
								<h3>Nueva solicitud de servicio</h3>
								<ol class="breadcrumb breadcrumb-simple">
									<li><a href="../Home">Inicio</a></li>
									<li class="active">Nueva solicitud de servicio</li>
								</ol>
							</div>
						</div>
					</div>
				</header>

				<div class="box-typical box-typical-padding">

					<h5 class="m-t-lg with-border">Ingresar Información</h5>

					<div class="row">
						<form method="post" id="ticket_form">

							<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"] ?>">

							<div class="col-lg-12">
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="tick_titulo">Asunto</label>
										<input type="text" class="form-control" id="tick_titulo" name="tick_titulo" placeholder="Ingrese Asunto" required>
									</fieldset>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="col-lg-4">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInput">Empresa</label>
										<select id="emp_id" name="emp_id" class="select2" required>

										</select>
									</fieldset>
								</div>

								<div class="col-lg-4">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInput">Área</label>
										<select id="areas_id" name="areas_id" class="select2" required>

										</select>
									</fieldset>
								</div>

								<div class="col-lg-4">
									<fieldset class="form-group">
										<label class="form-label semibold" for="exampleInput">Ubicación</label>
										<select id="ubicacion_id" name="ubicacion_id" class="select2" required>

										</select>
									</fieldset>
								</div>
							</div>

							<div class="col-lg-6">
								<fieldset class="form-group">
									<label class="form-label semibold" for="exampleInput">Adjuntos</label>
									<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
								</fieldset>
							</div>

							<div class="col-lg-12">
								<fieldset class="form-group">
									<label class="form-label semibold" for="tick_descrip">Descripción</label>
									<div class="summernote-theme-1">
										<textarea id="tick_descrip" name="tick_descrip" class="summernote" name="name"></textarea>
									</div>
								</fieldset>
							</div>
							<div class="col-lg-12">
								<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
							</div>
						</form>
					</div>

				</div>
			</div>

			<div class="custom-alert">
				<div class="custom-alert-content">
					<h2>Solicitud Enviada</h2>
					<h3>Se ha Radicado la solicitud Nro.</h3>
					<p id="custom-alert-message">Mensaje de la alerta</p>
					<button id="custom-alert-close">OK</button>
				</div>
			</div>
		</div>
		<!-- Contenido -->

		<?php require_once("../MainJs/js.php"); ?>

		<script type="text/javascript" src="nuevoticket.js"></script>
		<script type="text/javascript" src="../MainNav/nav.js"></script>

		<script type="text/javascript" src="../notificacion.js"></script>

	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>