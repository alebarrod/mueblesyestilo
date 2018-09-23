<?php

	require_once "../controladores/clientes.controlador.php";

	require_once "../modelos/clientes.modelo.php";

class AjaxClientes{


	public function altaCliente($datos){

		$resultado = ControladorClientes::ctrAltaCliente($datos);

		echo $resultado;
	}

	public function eliminarCliente($idcliente){

		$resultado = ControladorClientes::ctrEliminarCliente($idcliente);

		echo $resultado;
	}
	
}
///////////////////////////////////

if(isset($_POST['insertarcliente'])){
	$val_dni = validacionDni($_POST['dni']);
	$val_nombre = validacionNombre($_POST['nombre']);
	$val_apellidos = validacionApellidos($_POST['apellidos']);
	$val_domicilio = validacionDomicilio($_POST['domicilio']);
	$val_telefono = validacionTelefono($_POST['telefono']);
	$val_correo = validacionCorreoElectronico($_POST['correoelectronico']);

	
	if($val_dni && $val_nombre && $val_apellidos && $val_domicilio && $val_telefono && $val_correo){
	$insertar = new AjaxClientes();

	$ffecha= date("d/m/Y", strtotime($_POST['fechanacimiento']));
	$datos = array(
					"dni" => $_POST['dni'],
					"nombre" => $_POST['nombre'],
					"apellidos" => $_POST['apellidos'],
					"domicilio" => $_POST['domicilio'],
					"telefono" => $_POST['telefono'],
					"correoelectronico" => $_POST['correoelectronico'],
					"fechanacimiento" => $ffecha
				   );

	$insertar -> altaCliente($datos);
	}
}


if(isset($_POST['eliminarcliente'])){

	$eliminar = new AjaxClientes();

	$eliminar -> eliminarCliente($_POST['id']);
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

function validacionDomicilio($domicilio){
	$pattern = "/^[A-Za-z0-9ÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ºª]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$domicilio);
	return $res;
}

function validacionTelefono($telefono){
	$pattern = "/^[0-9]{9}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$telefono);
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

function validacionContrasenya($pass) {
    $pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû_0-9 ]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
    $res = preg_match($pattern,$pass);
	return $res;
}


?>