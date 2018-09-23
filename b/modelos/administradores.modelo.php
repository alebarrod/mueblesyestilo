<?php
	require_once "conexion.php";

class ModeloAdministradores{

/*======================================================================
=            LISTA EL ADMIN MAS LOS EMPLEADOS DADOS DE ALTA            =
======================================================================*/
	static public function mdlListarAdministradores($tabla, $atributo, $valor){

		if($atributo != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $atributo = :$atributo");
			$stmt->bindParam(":".$atributo, $valor, PDO::PARAM_STR);
			$stmt->execute();

			//fetch devuelve una solo linea
			return $stmt->fetch();
		}else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();

			return $stmt -> fetchAll();
		}
	}
/*=============================================
			ACTUALIZAR PERFIL ESTO ES PARA EL ADMIN
=============================================*/
	static public function mdlActualizarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET PERFIL = :pef WHERE IDADMINISTRADOR = :id");

		$stmt -> bindParam(":pef", $datos['perfil'], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos['idadministrador'], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "success";
		
		}else{

			return "error";	

		}
	}

/*=============================================
		REGISTRO DE UN ADMIN O EMPLEADO
=============================================*/
	static public function mdlAltaPerfil($tabla, $datos){

		$sh = Conexion::conectar()->prepare("SELECT SEC_ADMINISTRADORES.NEXTVAL FROM DUAL");
		$sh -> execute();
		$id = $sh -> fetchColumn(0);

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(IDADMINISTRADOR, NOMBRE, APELLIDO, DNI, TELEFONO, DOMICILIO, EMAIL, PASS, FECHANACIMIENTO, FOTO, PERFIL) VALUES ($id, :nombre, :apellido, :dni, :telefono, :domicilio, :email, :pass, :fechanacimiento, :foto, :perfil)");
		$ff = date("d/m/Y", strtotime($datos["fechanacimiento"]));

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_INT);
		$stmt->bindParam(":domicilio", $datos["domicilio"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt->bindParam(":fechanacimiento", $ff);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);

		$valor = array(
						"id" => $id,
						"ruta" => $datos["foto"]
					   );

		if($stmt->execute()){

			return $valor;	

		}else{

			return "error";
		
		}

	}

/*=============================================
		EDITAR LOS DATOS DE LOS EMPLEADOS PERO NO SU PERFIL
=============================================*/

	static public function mdlEditarPerfil($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, dni = :dni, telefono = :telefono, domicilio =:domicilio, email = :email, pass = :pass, fechanacimiento, foto = :foto WHERE IDADMINISTRADOR = :id");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_INT);
		$stmt -> bindParam(":domicilio", $datos["domicilio"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":pass", $datos["pass"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechanacimiento", $datos["fechanacimiento"]);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

/*=============================================
		ELIMINAR PERFIL
=============================================*/

	static public function mdlEliminarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE IDADMINISTRADOR = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "success";
		
		}else{

			return "error";	

		}
	}

}

?>