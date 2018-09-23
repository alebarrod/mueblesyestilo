<?php

	session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, inicial-scale=1.0,
	maximun-scale=1.0, minimum-scale=1.0" />	
	<title>Muebles Y Estilo</title>
	<meta name="author" content="mueblesyestilo" />
	<link rel="icon" type="image/png" href="vistas/imagenes/logoPrincipal-35px.png" />

	<link rel="stylesheet" href="vistas/css/estiloCSSlogin.css" type="text/css">
	<?php
		 if(isset($_SESSION["validarsesionbackend"]) and $_SESSION["validarsesionbackend"] == "ok"){
	?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="vistas/css/estiloCSSOrdenadores.css" type="text/css">
		<link rel="stylesheet" href="vistas/css/estiloCSSMoviles.css" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
		
	<?php
		}
	?>

	<!-- Librerias JS -->
	<script src="vistas/plugins/jquery.min.js"></script>
	<script src="vistas/plugins/sweetalert2.all.js"></script>
</head>
<body>
	<div id="contenedor-general">
<?php

	if(isset($_SESSION["validarsesionbackend"]) and $_SESSION["validarsesionbackend"] == "ok"){


		/* CABECERA */
		include "modulos/cabecera.php";

		/* MENU LATERAL */
		include "modulos/lateral.php";

		/*=======================================================================
		=    ESTE CONTENIDO ES VARIABLE POR LO CARGAMOS LA PETICION POR GET     =
		=======================================================================*/
		if(isset($_GET["ruta"])){

			if($_GET["ruta"] == "inicio" or $_GET["ruta"] == "articulos" or $_GET["ruta"] == "categorias" or
			   $_GET["ruta"] == "ventas" or $_GET["ruta"] == "clientes" or $_GET["ruta"] == "perfiles" or
			   $_GET["ruta"] == "about" or $_GET["ruta"] == "salir" or  $_GET["ruta"] == "faq"  or  $_GET["ruta"] == "ayuda"
			   or  $_GET["ruta"] == "bano" or  $_GET["ruta"] == "cocina" or  $_GET["ruta"] == "jardin" or  $_GET["ruta"] == "salon") {

				include "modulos/".$_GET["ruta"].".php";
			}else{
				echo '<script> window.location = "http://localhost/b/vistas/404.html" </script>';
			}
		}else{

			include "modulos/inicio.php";
		}

		/* PIE DE PAGINA */
		include "modulos/footer.php";
	}else{

		/* Si no ha iniciado sesion cargamos el login para que se logee */
		
		include "modulos/login.php";
	}

?>

<!--======================================
=            JS            				 =
=======================================-->
<script src="vistas/js/gestionarCategorias.js"></script>
<script src="vistas/js/gestionarArticulos.js"></script>
<script src="vistas/js/gestionarClientes.js"></script>
<script src="vistas/js/gestionarPerfiles.js"></script>
	

</body>
</html>