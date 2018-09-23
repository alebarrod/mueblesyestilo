<?php
	
	require_once "conexion.php";

class ModeloCategorias{

/*=================================================================================
=   LISTA LAS CATEGORIAS DE LA QUE DISPONEMOS,  LISTA UNA CATEGORIA ESPECIFICA    =
=================================================================================*/
	public static function mdlListarCategorias($tabla, $atributo, $valor){

		if(is_null($atributo)){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY IDCATEGORIA DESC");
			$stmt -> execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $atributo = :$atributo");
			$stmt -> bindParam(":".$atributo, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

	}

/*===============================================
=            DA DE ALTA UNA CATEGORIA           =
===============================================*/
	public static function mdlAltaCategoria($tabla, $datos){
		$sh = Conexion::conectar()->prepare("SELECT SEC_CATEGORIAS.NEXTVAL FROM DUAL");
		$sh -> execute();
		$id = $sh -> fetchColumn(0);
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (IDCATEGORIA, NOMBRE, DESCRIPCION) VALUES ($id, :nombre, :descripcion)");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return $id;
		}else{

			return "";
		}
	}

/*========================================
=            EDITAR CATEGORIA            =
========================================*/
	public static function mdlEditarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE = :nombre, DESCRIPCION = :descripcion WHERE IDCATEGORIA =:idcategoria");

		$stmt->bindParam(":nombre", $datos["nuevonombrecat"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["nuevodescripcat"], PDO::PARAM_STR);
		$stmt->bindParam(":idcategoria", $datos["idcat"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";
		}else{

			return "error";
		}
	}

/*==========================================
=            ELIMINAR CATEGORIA            =
==========================================*/
	public static function mdlEliminarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE IDCATEGORIA = :idcategoria");
		$stmt->bindParam(":idcategoria", $datos, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";
		}else{

			return "error";
		}
	}


}
?>