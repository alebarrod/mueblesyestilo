<?php
	
	require_once "../controladores/categorias.controlador.php";

	require_once "../modelos/categorias.modelo.php";

class AjaxCategorias{

	// Evita que se creen categorias con nombre repetidos
	public $validarnombrecategoria;

	public function validarNombreCategoria(){

		$atributo = "NOMBRE";
		/*
		* ucwords la primela letra de una palabra o palabras lo transforma en mayuscula
		* strtolower la palabra o palabras lo transforma en minuscula
		*/
		$valor = ucwords(strtolower($this->validarnombrecategoria));

		$resultado = ControladorCategorias::ctrListarCategorias($atributo, $valor);

		echo json_encode($resultado);
	}


	// Modifica un categoria existente
	public function editarCategoria($nuevodatoscat){
	
		$resultado = ControladorCategorias::ctrEditarCategoria($nuevodatoscat);

		echo $resultado;
	}

	// Eliminar Categoria
	public function eliminarCategoria($idcat){

		$resultado = ControladorCategorias::ctrEliminarCategoria($idcat);

		echo $resultado;
	}

	// Añade una  nueva categoria
	public function altaCategoria($datos){

		$resultado = ControladorCategorias::ctrAltaCategoria($datos);

		echo $resultado;
	}


}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST["nombrecategoria"])){
	$validacat = new AjaxCategorias();
	$validacat -> validarnombrecategoria = $_POST["nombrecategoria"];

	$validacat-> validarNombreCategoria();
}

// INVOCA LA METODO QUE REALIZA LA MODIFICACION
if(isset($_POST['editarcategoria'])){
	$val_nombrecategoria = validacionNombreCategoria($_POST['nombre']);
	$val_descripcion = validacionDescripcion($_POST['descripcion']);
	
	if($val_nombrecategoria && $val_descripcion){
	$editar = new AjaxCategorias();
	$datos = array(
					"idcat" => $_POST["id"],
					"nuevonombrecat" => $_POST["nombre"],
					"nuevodescripcat" => $_POST["descripcion"]
				  );

	
	//$editar -> nuevodatoscat = "kaka";
	$editar -> editarCategoria($datos);
	}
}

// INVOCA AL METODO QUE REALIZA LA ELIMINACION DE UNA CATEGORIA
if(isset($_POST['eliminarcategoria'])){
	$eliminar = new AjaxCategorias();
	//$eliminar -> idcat = $_POST['id'];
	$eliminar -> eliminarCategoria($_POST['id']);

}

// INVOCA AL METODO QUE AÑADE UNA CATEGORIA
if(isset($_POST['insertarcategoria'])){

	$val_nombrecategoria = validacionNombreCategoria($_POST['nombre']);
	$val_descripcion = validacionDescripcion($_POST['descripcion']);
	
	if($val_nombrecategoria && $val_descripcion){
		$insertar = new AjaxCategorias();

		$datos = array(
						"nombre" => $_POST["nombre"],
						"descripcion" => $_POST["descripcion"]
					  );
		$insertar -> altaCategoria($datos);	
	}
}


function validacionNombreCategoria($nombrecategoria){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,20}/";
	$res = preg_match($pattern,$nombrecategoria);
	return $res;
}

function validacionDescripcion($descripcion){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç .,]{2,30}/";
	$res = preg_match($pattern,$descripcion);
	return $res;
}
?>