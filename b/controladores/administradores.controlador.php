<?php

class ControladorAdministradores{

/*====================================================================================
=            CREA LA SESION DE USUARIO SI EL USUARIO Y PASS SON CORRECTOS            =
====================================================================================*/
	static public function ctrIngresoAdministrador(){
		if(isset($_POST["email"])){
			
			if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and preg_match('/^[a-zA-Z0-9]+$/', $_POST["pass"])){

				$tabla = 'ADMINISTRADORES';
				$atributo = 'EMAIL';
				$valor = $_POST['email'];

				$respuesta = ModeloAdministradores::mdlListarAdministradores($tabla, $atributo, $valor);

				if($respuesta["EMAIL"] == $_POST["email"] and $respuesta["PASS"] == $_POST["pass"]){

					$_SESSION["validarsesionbackend"] =  "ok";
					$_SESSION["idadministrador"] = $respuesta["IDADMINISTRADOR"];
					$_SESSION["nombreadministrador"] = $respuesta["NOMBRE"];
					$_SESSION["foto"] = $respuesta["FOTO"];
					$_SESSION["email"] = $respuesta["EMAIL"];
					$_SESSION["pass"] = $respuesta["PASS"];
					$_SESSION["perfil"] = $respuesta["PERFIL"];

					//echo '<script> window.location = "index.php?ruta=inicio" </script>';
					echo '<script> window.location = "inicio" </script>';
				}else{

					echo '<p style="color:red;text-align:center;font-size:30px;">Error al ingresar vuelva a intentarlo</p>';
				}
			}
		}
	}

/*=============================================
	LISTAR ADMINISTRADORES
=============================================*/

	static public function ctrListarAdministradores($atributo, $valor){

		$tabla = "ADMINISTRADORES";

		$respuesta = ModeloAdministradores::mdlListarAdministradores($tabla, $atributo, $valor);

		return $respuesta;
	}


/*=============================================
	ALTA DE PERFIL
=============================================*/
	static public function ctrAltaPerfil($datos){

		if(isset($datos["email"])){

			
			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			
				$ruta = "";

				if(isset($datos["foto"]["tmp_name"]) && !empty($datos["foto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($datos["foto"]["tmp_name"]);

					$nuevoAncho = 48;
					$nuevoAlto = 48;


					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($datos["foto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/perfiles/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES[$datos["foto"]]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($datos["foto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "../vistas/img/perfiles/".$aleatorio.".png";

						$origen = imagecreatefrompng($datos["foto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "ADMINISTRADORES";
				$datos2 = array(
					"nombre" => $_POST['nueva_nombre'],
					"apellido" => $_POST['nueva_apellido'],
					"dni" => $_POST['nueva_dni'],
					"telefono" => $_POST['nueva_telefono'],
					"domicilio" => $_POST['nueva_domicilio'],
					"email" => $_POST['nueva_email'],
					"pass" => $_POST['nueva_pass'],
					"fechanacimiento" => $_POST['nueva_fechanacimiento'],
					"foto" => $ruta,
					"perfil" => $_POST['nueva_perfil']
				);


				$respuesta = ModeloAdministradores::mdlAltaPerfil($tabla, $datos2);

				return $respuesta;
			
		}

	}
/*========================================================
=            ACTUALIZAR EL PERFIL DEL USUARIO            =
========================================================*/
	public static function ctrActualizarPerfil($nuevoperfil){

		$tabla = "ADMINISTRADORES";
		$respuesta =  ModeloAdministradores::mdlActualizarPerfil($tabla, $nuevoperfil);

		return $respuesta;

	}

/*=========================================
=            ELIMINA UN PERFIL            =
=========================================*/
	public static function ctrEliminarPerfil($idadministrador){

		$tabla = "ADMINISTRADORES";
		$respuesta = ModeloAdministradores::mdlEliminarPerfil($tabla, $idadministrador);

		return $respuesta;
	}





}

?>