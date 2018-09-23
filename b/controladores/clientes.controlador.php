<?php

class ControladorClientes{

/*======================================================
=            LISTA LOS CLIENTES DISPONIBLES            =
======================================================*/
	public static function ctrListarClientes($atributo, $valor){

		$tabla = "CLIENTES";

		$respuesta = ModeloClientes::mdlListarClientes($tabla, $atributo);

		return $respuesta;
	}

/*==============================================
=            AÑADE UN NUEVO CLIENTE            =
==============================================*/
	public static function ctrAltaCliente($datos){

		if(isset($datos["dni"])){

			$tabla = "CLIENTES";
			$respuesta = ModeloClientes::mdlAltaCliente($tabla, $datos);

			return $respuesta;
		}
	}

/*==========================================
=            ELIMINA UN CLIENTE            =
==========================================*/
	public static function ctrEliminarCliente($idcliente){

		if(isset($idcliente)){

			$respuesta = ModeloClientes::mdlEliminarCliente("CLIENTES", $idcliente);

			return $respuesta;
		}
	}


}

?>