<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<?php require_once("../MainHead/head.php"); ?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<title>HelpDesk CMC::Home</title>
	<style>
		.custom-gray {
			background-color: gray;
		}

		.custom-green {
			background-color: green;
		}

		.custom-orange {
			background-color:orange;
		}

		.custom-blue {
			background-color:#0096ff;
		}

		.custom-purple {
			background-color:#572364;
		}
	</style>	
	</head>

	<body class="with-side-menu">

		<?php require_once("../MainHeader/header.php"); ?>

		<div class="mobile-menu-left-overlay"></div>

		<?php require_once("../MainNav/nav.php"); ?>

		<!-- Contenido -->
		<div class="page-content">

			<?php if ($_SESSION["rol_id"] == "1") {
				require_once("./inicio/SuperAdmin.php");
			} elseif ($_SESSION["rol_id"] == "2") {
				require_once("./inicio/Admin.php");
			} elseif ($_SESSION["rol_id"] == "3") {
				require_once("./inicio/Tecnico.php");
			} else {
				require_once("./inicio/Usuario.php");
			} ?>
		</div>
		<!-- Contenido -->

		<?php require_once("../MainJs/js.php"); ?>

		<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

		<script type="text/javascript" src="home.js"></script>
		<script type="text/javascript" src="../MainNav/nav.js"></script>

		<script type="text/javascript" src="../notificacion.js"></script>

	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "indexLoginMant.php");
}
?>