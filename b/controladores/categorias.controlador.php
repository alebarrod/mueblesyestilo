<?php
	
class ControladorCategorias{

/*======================================================
=    LISTA LAS CATEGORIAS O UNA CATEGORIA CONCRETA     =
======================================================*/

	public static function ctrListarCategorias($atributo, $valor){

		$tabla = "CATEGORIAS";

		$respuesta = ModeloCategorias::mdlListarCategorias($tabla, $atributo, $valor);
	

		return $respuesta;		
	}

/*=============================================
=            AÑADE UNA NUEVA CATEGORIA        =
=============================================*/

	public static function ctrAltaCategoria($datos){

		if(isset($datos["nombre"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["nombre"]) and preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])){

				$tabla  = "CATEGORIAS";
				$respuesta = ModeloCategorias::mdlAltaCategoria($tabla, $datos);

				return $respuesta;

			}else {

				return 'error';
			}
		}
	}

/*========================================
=            EDITAR CATEGORIA            =
========================================*/
	public static function ctrEditarCategoria($nuevodatoscat){
		
		if(isset($nuevodatoscat['nuevonombrecat'])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nuevodatoscat['nuevonombrecat']) and preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nuevodatoscat['nuevodescripcat'])){
				/*
				$datos = array(
								"idcategoria" => $nuevodatoscat['idcat'], 
								"nombre" => ucwords(strtolower($nuevodatoscat['nuevodescripcat'])),
								"descripcion" => $nuevodatoscat['nuevonombrecat']
							  );
				*/
				$tabla = "CATEGORIAS";

				$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $nuevodatoscat);

				return $respuesta;

			}else{

				return 'Error al modificar la categoria en el controlador';
			}

		}
	}

/*====================================
=         ELIMINAR CATEGORIA         =
====================================*/
	public static function ctrEliminarCategoria($idcat){
		if(isset($idcat)){

			// si hay aritulos que tiene asignada la categoria a eleminiar, lo que haremos es cambiar a la categoria por defecto
			//$numerodearticulos = ModeloArticulos::mdlContarArticulos("ARTICULOS", "FKIDCATEGORIA", $idcat);
			/*
			if($numerodearticulos > 0){

				// nombre tabla, atributo a modificar, nuevo valor, antiguo valor
				ModeloProductos::mdlEditarArticulos("ARTICULOS", "FKIDCATEGORIA", 0, $idcat);
			}*/

			// NOMBRE DE LA TABLA, VALOR
			$respuesta = ModeloCategorias::mdlEliminarCategoria("CATEGORIAS", $idcat);

			return $respuesta;
		}
	}
}
//Cierrra la clase

?>