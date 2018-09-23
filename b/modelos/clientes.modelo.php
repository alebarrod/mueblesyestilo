<?php

	require_once "conexion.php";

class ModeloClientes{

/*======================================================
=            LISTA LOS CLIENTES DISPONIBLES            =
======================================================*/
	public static function mdlListarClientes($tabla, $atributo){

		if(is_null($atributo)){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY IDCLIENTE");
			$stmt -> execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

/*=============================================
=            DA DE ALTA UN CLIENTE            =
=============================================*/
	public static function mdlAltaCliente($tabla, $datos){
		$sh = Conexion::conectar()->prepare("SELECT SEC_CLIENTES.NEXTVAL FROM DUAL");
		$sh -> execute();
		$id = $sh -> fetchColumn(0);

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (IDCLIENTE, DNI, NOMBRE, APELLIDOS, DOMICILIO, TELEFONO, CORREOELECTRONICO, PASS, FECHANACIMIENTO) VALUES ($id, :dni, :nombre, :apellidos, :domicilio, :telefono, :correoelectronico, :pass, :fechanacimiento)");

		$stmt -> bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
		$stmt -> bindParam(":domicilio", $datos["domicilio"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_INT, 9);
		$stmt -> bindParam(":correoelectronico", $datos["correoelectronico"], PDO::PARAM_STR);
		$stmt -> bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechanacimiento", $datos["fechanacimiento"]);

		if($stmt -> execute()){

			return $id;
		}else{

			return "error";
		}
	}

/*==========================================
=            ELIMINA UN CLIENTE            =
==========================================*/
	public static function mdlEliminarCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE IDCLIENTE = :idcliente");
		$stmt -> bindParam(":idcliente", $datos, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";
		}else{

			return "error";
		}
	}

}

?>