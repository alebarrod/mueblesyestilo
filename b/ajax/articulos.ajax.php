<?php

	require_once "../controladores/articulos.controlador.php";

	require_once "../modelos/articulos.modelo.php";

class AjaxArticulos{

	public function altaArticulo($nuevodato){

		$resultado = ControladorArticulos::ctrAltaArticulo($nuevodato);

		echo $resultado;
	}

	public function editarArticulo($nuevodato){
		$resultado = ControladorArticulos::ctrEditarArticulo($nuevodato);

		echo $resultado;
	}

	public function eliminarArticulo($idarticulo){

		$resultado = ControladorArticulos::ctrEliminarArticulo($idarticulo);

		echo $resultado;
	}

	
}
////////////////////////////////////////////////////////////////////////////

/* PERMITE AÑADIR UN ARTICULO*/
if(isset($_POST['insertararticulo'])){
	$val_nombre = validacionNombre($_POST['nombre']);
	$val_fechaalta = validacionNombre($_POST['fechaalta']);
	$val_cantidad = validacionCantidad($_POST['cantidad']);
	$val_peso = validacionPeso($_POST['peso']);
	$val_dimension = validacionDimension($_POST['dimension']);
	$val_material = validacionMaterial($_POST['material']);
	$val_preciocompra = validacionPrecioCompra($_POST['preciocompra']);
	$val_precioventa = validacionPrecioVenta($_POST['precioventa']);
	$val_compraventa = validacionCompraVenta($_POST['preciocompra'],$_POST['precioventa']);


	if($val_nombre && $val_cantidad && $val_peso && $val_dimension &&
	 $val_material && $val_preciocompra && $val_precioventa && $val_compraventa){
	$insertar = new AjaxArticulos();
	$datos = array(
					"nombre" => $_POST['nombre'],
					"fechaalta" => $_POST['fechaalta'],
					"cantidad" =>  $_POST['cantidad'],
					"peso" => $_POST['peso'],
					"dimensionn" => $_POST['dimension'],
					"material" => $_POST['material'],
					"preciocompra" => $_POST['preciocompra'],
					"precioventa" => $_POST['precioventa'],
					"fkidcategoria" => $_POST['categoria']
				  );

	$insertar -> altaArticulo($datos);
	}
}


/* PERMITE MODIFICAR UN ARTICULO*/
if(isset($_POST['editararticulo'])){

	$val_nombre = validacionNombre($_POST['nombre']);
	$val_fechaalta = validacionFechaAlta($_POST['fechaalta']);
	$val_cantidad = validacionCantidad($_POST['cantidad']);
	$val_peso = validacionPeso($_POST['peso']);
	$val_dimension = validacionDimension($_POST['dimension']);
	$val_material = validacionMaterial($_POST['material']);
	$val_preciocompra = validacionPrecioCompra($_POST['preciocompra']);
	$val_precioventa = validacionPrecioVenta($_POST['precioventa']);
	$val_compraventa = validacionCompraVenta($_POST['preciocompra'],$_POST['precioventa']);


	if($val_nombre && $val_fechaalta && $val_cantidad && $val_peso && $val_dimension &&
	 $val_material && $val_preciocompra && $val_precioventa && $val_compraventa){
	$editar = new AjaxArticulos();
	$datos = array(
					"idarticulo" => $_POST['idarticulo'],
					"nombre" => $_POST['nombre'],
					"fechaalta" => $_POST['fechaalta'],
					"cantidad" => $_POST['cantidad'],
					"peso" => $_POST['peso'],
					"dimension" => $_POST['dimension'],
					"material" => $_POST['material'],
					"preciocompra" => $_POST['preciocompra'],
					"precioventa" => $_POST['precioventa'],
					"idcategoria" => $_POST['idcategoria']
				  );

	$editar->editarArticulo($datos);
	}

}


/* PERMITE ELIMINAR ARTICULO*/
if(isset($_POST['eliminararticulo'])){

	$eliminar = new AjaxArticulos();

	$eliminar -> eliminarArticulo($_POST['id']);
}

function validacionNombre($nombreart){
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/";	//Solo admite de 2 a 15 de los caracteres entre corchetes
	$res = preg_match($pattern,$nombreart);
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

function validacionCantidad($cantidad) {
	$pattern = "/^[0-9]{0,5}$/";
	$res = preg_match($pattern,$cantidad);
	return $res;
}

function validacionPeso($peso) {
	$pattern = "/^[0-9]{0,5}$/";
	$res = preg_match($pattern,$peso);
	return 	$res;
}

function validacionDimension($dimension) {
	$pattern = "/^[0-9]{1,3}[x]{1}[0-9]{1,3}[x]{1}[0-9]{1,3}$/";
	$res = preg_match($pattern,$dimension);
	return $res;
}

function validacionMaterial($material) {
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]{2,30}/";
	$res = preg_match($pattern,$material);
	return $res;
}

function validacionPrecioCompra($precioCompra) {
	$pattern = "/^[0-9]{0,3}[.]{0,1}[0-9]{0,2}$/";
	$res = preg_match($pattern,$precioCompra);
	return $res;
}

function validacionPrecioVenta($precioVenta) {
	$pattern = "/^[0-9]{0,3}[.]{0,1}[0-9]{0,2}$/";
	$res = preg_match($pattern,$precioVenta);
	return $res;
}

function validacionNombreCategoria($nombreCategoria) {
	$pattern = "/^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,20}$/";	//Solo admite de 2 a 20 de los caracteres entre corchetes
	$res = preg_match($pattern,$nombreCategoria);
	return $res;
}

function validacionCompraVenta($compra,$venta){
	$res;
	if(validacionPrecioCompra($compra) && validacionPrecioVenta($venta)){
		if(intval($venta) >= intval($compra)){
			$res = true;
		}else{
			$res = false;
		}
	}else{
		$res = false;
	}

	return $res;

}


?>
