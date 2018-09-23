<?php

	require_once "conexion.php";

class ModeloArticulos{

/*==================================================================
=             LISTA LOS ARTICULOS DE LA QUE DISPONEMOS             =
==================================================================*/

	public static function mldListarArticulos($tabla, $atributo, $valor){

		if(is_null($atributo)){

			$stmt = Conexion::conectar()->prepare("SELECT A.IDARTICULO, A.NOMBRE, A.FECHAALTA, A.CANTIDAD, A.PESO, A.DIMENSIONN, A.MATERIAL, A.PRECIOCOMPRA, A.PRECIOVENTA, A.FKIDCATEGORIA as IDCAT, C.NOMBRE as nomcat FROM $tabla A, CATEGORIAS C where A.FKIDCATEGORIA=C.IDCATEGORIA ORDER BY IDARTICULO DESC");
			$stmt -> execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

	}

/*==============================================
=            DA DE ALTA UN ARTICULO            =
==============================================*/
	public static function mdlAltaArticulo($tabla, $datos){

		$sh = Conexion::conectar()->prepare("SELECT SEC_ARTICULOS.NEXTVAL FROM DUAL");
		$sh -> execute();
		$id = $sh -> fetchColumn(0);

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (IDARTICULO, NOMBRE, FECHAALTA, CANTIDAD, PESO, DIMENSIONN, MATERIAL, PRECIOCOMPRA, PRECIOVENTA, FKIDCATEGORIA) VALUES ($id,:nombre, :fechaalta, :cantidad, :peso, :dimensionn, :material, :preciocompra, :precioventa, :fkidcategoria)");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechaalta", $datos["fechaalta"]);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
		$stmt -> bindParam(":dimensionn", $datos["dimensionn"], PDO::PARAM_STR);
		$stmt -> bindParam(":material", $datos["material"], PDO::PARAM_STR);
		$stmt -> bindParam(":preciocompra", $datos["preciocompra"], PDO::PARAM_INT);
		$stmt -> bindParam(":precioventa", $datos["precioventa"], PDO::PARAM_INT);
		$stmt -> bindParam(":fkidcategoria", $datos["fkidcategoria"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return $id;
		}else{

			return "error";
		}


	}

/*============================================
=            MODIFICA UN ARTICULO            =
============================================*/
	public static function mldEditarArticulo($tabla, $datos){

		$idarticulo = $datos['idarticulo'];
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET NOMBRE=:nombre, FECHAALTA=:fechaalta, CANTIDAD=:cantidad, PESO=:peso, DIMENSIONN=:dimensionn, MATERIAL=:material, PRECIOCOMPRA=:preciocompra, PRECIOVENTA=:precioventa, FKIDCATEGORIA=:fkidcategoria WHERE IDARTICULO= $idarticulo");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaalta", $datos["fechaalta"]);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":peso", $datos["peso"], PDO::PARAM_INT);
		$stmt->bindParam(":dimensionn", $datos["dimension"], PDO::PARAM_STR);
		$stmt->bindParam(":material", $datos["material"], PDO::PARAM_STR);
		$stmt->bindParam(":preciocompra", $datos["preciocompra"], PDO::PARAM_INT);
		$stmt->bindParam(":precioventa", $datos["precioventa"], PDO::PARAM_INT);
		$stmt->bindParam(":fkidcategoria", $datos["idcategoria"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";
		}else{

			return "error";
		}
	}

/*=============================================
=            ELIMINA UN ARTICULO           	 =
=============================================*/
	public static function mdlEliminarArticulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE IDARTICULO = :idarticulo");
		$stmt->bindParam(":idarticulo", $datos, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";
		}else{

			return "error";
		}
	}

} // CIERRE



?>