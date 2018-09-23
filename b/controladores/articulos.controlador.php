<?php

class ControladorArticulos{

/*=======================================================
=            LISTA LOS ARTICULOS DISPONIBLES            =
=======================================================*/
	public static function ctrListarArticulos($atributo, $valor){

		$tabla = "ARTICULOS";

		$respuesta = ModeloArticulos::mldListarArticulos($tabla, $atributo, $valor);

		return $respuesta;
	}

/*=========================================
=            AÑADE UN ARTICULO            =
=========================================*/
	public static function ctrAltaArticulo($datos){

		if(isset($datos["nombre"]) && isset($datos["cantidad"]) && isset($datos["cantidad"]) && isset($datos["precioventa"])){

			$tabla = "ARTICULOS";

			$respuesta = ModeloArticulos::mdlAltaArticulo($tabla, $datos);

			return $respuesta;
		}
	}

/*============================================
=            MODIFICA UN ARTICULO            =
============================================*/
	public static function ctrEditarArticulo($datos){

		if(isset($datos["nombre"]) && isset($datos["cantidad"]) && isset($datos["cantidad"]) && isset($datos["precioventa"])){

			$tabla = "ARTICULOS";

			$respuesta = ModeloArticulos::mldEditarArticulo($tabla, $datos);

			return $respuesta;
		}

	}

/*===========================================
=            ELIMINA UN ARTICULO            =
===========================================*/
	public static function ctrEliminarArticulo($idart){

		if(isset($idart)){

			$tabla = "ARTICULOS";

			$respuesta = ModeloArticulos::mdlEliminarArticulo($tabla, $idart);

			return $respuesta;

		}

	}


}

?>