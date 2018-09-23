<?php

	require_once "../controladores/administradores.controlador.php";

	require_once "../modelos/administradores.modelo.php";

class AjaxPerfiles{

	public function editarPerfil($nuevoperfil){
	
		$resultado = ControladorAdministradores::ctrActualizarPerfil($nuevoperfil);

		echo $resultado;
	}


	public function eliminarperfil($idadministrador){

		$resultado = ControladorAdministradores::ctrEliminarPerfil($idadministrador);

		echo $resultado;
	}

	public function altaPerfil($datos){

		$resultado = ControladorAdministradores::ctrAltaPerfil($datos);

		echo json_encode($resultado);
	}


}

//////////////////////////////////////////////////////////

if(isset($_POST['editarperfil'])){

	$val_perfil = validacionPerfil($_POST['tipoperfil']);

	if($val_perfil){

		$editar = new AjaxPerfiles();

		$datos = array(
					"idadministrador" => $_POST['idadministrador'],
					"perfil" => $_POST['tipoperfil']
				   );
	
		$editar->editarPerfil($datos);
	}
}

if(isset($_POST['eliminarperfil'])){

	$eliminar = new AjaxPerfiles();

	$eliminar-> eliminarperfil($_POST['id']);

}

if(isset($_POST['altaperfil'])){

	$val_nombre = validacionNombre($_POST['nueva_nombre']);
	$val_apellido = validacionApellidos($_POST['nueva_apellido']);
	$val_dni = validacionDni($_POST['nueva_dni']);
	$val_telefono = validacionTelefono($_POST['nueva_telefono']);
	$val_domicilio = validacionDomicilio($_POST['nueva_domicilio']);
	$val_email = validacionCorreoElectronico($_POST['nueva_email']);
	$val_pass = validacionContrasenya($_POST['nueva_pass']);
	$val_fechaalta = validacionFechaAlta($_POST['nueva_fechanacimiento']);
	$val_perfil = validacionPerfil($_POST['nueva_perfil']);
	

	if($val_nombre && $val_apellido && $val_dni && $val_telefono && $val_domicilio &&
		$val_email && $val_pass /*&& $val_fechaalta*/ && $val_perfil){

		$alta = new AjaxPerfiles();

		$datos = array(
					"nombre" => $_POST['nueva_nombre'],
					"apellido" => $_POST['nueva_apellido'],
					"dni" => $_POST['nueva_dni'],
					"telefono" => $_POST['nueva_telefono'],
					"domicilio" => $_POST['nueva_domicilio'],
					"email" => $_POST['nueva_email'],
					"pass" => $_POST['nueva_pass'],
					"fechanacimiento" => $_POST['nueva_fechanacimiento'],
					"foto" => $_FILES['nueva_foto'],
					"perfil" => $_POST['nueva_perfil']
				);

		$alta-> altaPerfil($datos);
	}
}


function validacionNombre($nombre){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$nombre);
	return $res;
}

function validacionApellidos($apellidos){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$apellidos);
	return $res;
}

function validacionDni($dni){
    $res = false;
	$pattern = "/^\d{8}[a-zA-Z]$/";
	$check1 = preg_match($pattern,$dni);

    if($check1){
	    $letra = substr($dni, -1);
    	$numeros = substr($dni, 0, -1);
    	if ( substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
       		$check2 = true;
    	}else{
	    	$check2 = false;;
	    }

    	if($check1 && $check2){
	    	$res = true;
	    }else{
	    	$res = false;
	    }   
    }   
    return $res;
}

function validacionTelefono($telefono){
	$pattern = "/^[0-9]{9}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$telefono);
	return $res;
}

function validacionDomicilio($domicilio){
	$pattern = "/^[A-Za-z0-9ÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ºª]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$domicilio);
	return $res;
}

function validacionCorreoElectronico($correo){
	
	$pattern = "/[@]/";
	$pattern_user = "/[A-Za-z0-9_]+/";
	$pattern_domain = "/[a-z.]+/";
	$usuario_dominio = preg_split($pattern,$correo);
	$check1 = false;
	$check2 = 30 > strlen($correo);
	$check_user = false;
	$check_dom1 = false;
	$check_dom2 = false;
	$check_dom3 = false;
	$check_dom4 = false;
	
	if(sizeof($usuario_dominio) == 2){
		$check1 = true;
		$check_user = preg_match($pattern_user,$usuario_dominio[0]);	//Comprueba que solo haya letras, numeros o barras bajas
		$check_dom1 = preg_match($pattern_domain,$usuario_dominio[1]);	//Comprueba que solo haya minusculas y puntos
		$check_dom2 = !preg_match("/[.]{2,}/",$usuario_dominio[1]);	//Comprueba que no haya un subdominio vacio o sea ".."
		$check_dom3 = !(preg_match("/[.]/",$usuario_dominio[1][0]));	//TODO:Comprobamos que no empiece ni acabe en "."
		$check_dom4 = !("." == substr($usuario_dominio[1],-1));//TODO:
	
	}
    
    if($check1 && $check2 && $check_user && $check_dom1 && $check_dom2 && $check_dom3 && $check_dom4){
        $res = true;
    }else{
        $res = false;
    }
	
	return $res;
}

function validacionFechaAlta($fecha_alta) {	//formato: dd/mm/yyyy
	$pattern = "/^[0-9]{1,2}[\/]{1}[0-9]{1,2}[\/]{1}[0-9]{2,4}$/";
	$check1 = preg_match($pattern,$fecha_alta);
	$check2;
	$res = false;
    if($check1){
	    $date = date("d/m/y");
	    $date2 = preg_split("/[\/]/",$date);
    	$day = $date2[0];
    	$month = $date2[1];
    	$year = $date2[2];

		$fecha = preg_split("/[\/]/",$fecha_alta);
		
		$day2 = $fecha[0];
		$month2 = $fecha[1];
		$year2 = substr($fecha[2],-2);
	
	
	    /*echo ($year2);
		
		echo ($year)."<".($year2)."=".intval(intval($year) > intval($year2) || intval($year2) > 60);

		if(intval($year) < intval($year2) || intval($year2) > 60){
			$check2 = false;
		}else if(intval($year) == intval($year2)){
			if(intval($month) < intval($month2)){
				$check2 = false;
			}else if(intval($month) == intval($month2)){
				if(intval($day) < intval($day2)){
					$check2 = false;
				}else{
					$check2 = true;
				}
			}else{
				$check2 = true;
			}
		}else{
			$check2 = true;
		}*/

	}

	if($check1 /*&& $check2*/){
		$res = true;
	}

	return $res;
}

function validacionContrasenya($pass){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$pass);
	return $res;
}

function validacionPerfil($perfil){
	$res = ($perfil == "Empleado" || $perfil == "Admin");
	return $res;
}

?>