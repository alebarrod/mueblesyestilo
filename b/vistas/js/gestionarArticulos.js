$(function () { });
/*=========================================
=            AÑADE UN ARTICULO            =
=========================================*/
function insertarArticulo() {
	var hoy = new Date();

	var nombreart = $.trim($("#nuevo_nombre").val());
	var fechaaltaart = hoy.getDate().toString() + "/" + (hoy.getMonth() + 1).toString() + "/" + (hoy.getFullYear()).toString().substring(2, 4);
	var cantidadart = $.trim($("#nuevo_cantidad").val());
	var pesoart = $.trim($("#nuevo_peso").val());
	var dimension = $.trim($("#nuevo_dimension").val());
	var materialart = $.trim($("#nuevo_material").val());
	var preciocompraart = $.trim($("#nuevo_preciocompra").val());
	var precioventaart = $.trim($("#nuevo_precioventa").val());
	var nombrecatraw = $("#nuevo_lista" + " option:selected").text();
	var categoriaart = $.trim($("#nuevo_lista").val());

	var val_nombreart = validacionNombre(nombreart);
	var val_fechaaltaart = validacionFechaAlta(fechaaltaart);
	var val_cantidadart = validacionCantidad(cantidadart);
	var val_pesoart = validacionPeso(pesoart);
	var val_dimension = validacionDimension(dimension);
	var val_materialart = validacionMaterial(materialart);
	var val_preciocompraart = validacionPrecioCompra(preciocompraart);
	var val_precioventaart = validacionPrecioVenta(precioventaart);
	
	var nombrecat = nombrecatraw; 

	while(nombrecat.search(" ")!=-1){
		nombrecat = nombrecat.replace(/[^A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]/, "");	//Elimina caracteres que no sean letras
	}
	nombrecat = nombrecat.match(/[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]+/);	//Obtenemos solo los caracteres deseados como filtro
		
	var val_nombrecat = validacionNombreCategoria(nombrecat);


	if (val_nombreart && val_fechaaltaart && val_cantidadart && val_pesoart && val_dimension
		&& val_materialart && val_preciocompraart && val_precioventaart && val_nombrecat) {
		$.ajax({
			type: 'post',
			url: 'ajax/articulos.ajax.php',
			data: {
				insertararticulo: 'insertararticulo',
				nombre: nombreart,
				fechaalta: fechaaltaart,
				cantidad: cantidadart,
				peso: pesoart,
				dimension: dimension,
				material: materialart,
				preciocompra: preciocompraart,
				precioventa: precioventaart,
				categoria: categoriaart
			},
			success: function (respuesta) {

				if (respuesta != "" && respuesta != "error") {
					var id = respuesta;
					var nuevafila = "<tr id='fila_" + id + "'> <td></td><td id='nombre_" + id + "'>" + nombreart + "</td>";
					nuevafila += "<td id='fechaalta_" + id + "'>" + fechaaltaart + "</td>";
					nuevafila += "<td id='cantidad_" + id + "'>" + cantidadart + "</td>";
					nuevafila += "<td id='peso_" + id + "'>" + pesoart + "</td>";
					nuevafila += "<td id='dimension_" + id + "'>" + dimension + "</td>";
					nuevafila += "<td id='material_" + id + "'>" + materialart + "</td>";
					nuevafila += "<td id='preciocompra_" + id + "'>" + preciocompraart + "</td>";
					nuevafila += "<td id='precioventa_" + id + "'>" + precioventaart + "</td>";//aki modificar
					nuevafila += "<td id='cp'><span id='idcategoria_" + id + "'>" + nombrecat + "</span></td>";
					nuevafila += "<td><input type='button' class='editar_button' id='editar_button" + id + "' value='Editar' onclick='editarArticulo(" + id + ");'>";
					nuevafila += "<input style='display: none' type='button' class='guardar_button' id='guardar_button" + id + "' value='Guardar' onclick='guardarArticulo(" + id + ");'>";
					nuevafila += "<input type='button' class='eliminar_button' id='eliminar_button" + id + "' value='Eliminar' onclick='eliminarArticulo(" + id + ");'></td></tr>";

					$("#articulostabla tr:last").before(nuevafila);
					$("#nuevo_lista").clone().prependTo("#cp").attr({ 'id': 'listacategoria_' + id, 'style': 'display:none' })

					$("#nuevo_nombre").val("");
					$("#nuevo_cantidad").val("");
					$("#nuevo_peso").val("");
					$("#nuevo_dimension").val("");
					$("#nuevo_material").val("");
					$("#nuevo_preciocompra").val("");
					$("#nuevo_precioventa").val("");
				}
			}
		});
	} else {
		var error = "";

		if (!val_nombreart) {
			error = error.concat("Error en el nombre del articulo<br>");
		}
		if (!val_fechaaltaart) {
			error = error.concat("Error en la fecha de alta<br>");
		}
		if (!val_cantidadart) {
			error = error.concat("Error en la cantidad<br>");
		}
		if (!val_pesoart) {
			error = error.concat("Error en el peso<br>");
		}
		if (!val_dimension) {
			error = error.concat("Error en el formato de la dimension 00x00x00<br>");
		}
		if (!val_materialart) {
			error = error.concat("Error en el material<br>");
		}
		if (!val_preciocompraart) {
			error = error.concat("Error en el precio de compra<br>");
		}
		if (!val_precioventaart) {
			error = error.concat("Error en el precio de venta<br>");
		}
		if (!val_nombrecat) {
			error = error.concat("Error en el nombre de la categoria<br>");
		}

		swal({
			type: 'error',
			title: 'Oops...',
			html: error,
		})
		//alert(error);
	}


}

/*=================================================
=            EDITAR UN ARTICULO                    =
=================================================*/
function editarArticulo(idarticulo) {

	// leendo datos del formulario
	var nombreart = $.trim($("#nombre_" + idarticulo).text());
	var fechaaltaart = $.trim($("#fechaalta_" + idarticulo).text());
	var cantidadart = $.trim($("#cantidad_" + idarticulo).text());
	var pesoart = $.trim($("#peso_" + idarticulo).text());
	var dimensionart = $.trim($("#dimension_" + idarticulo).text());
	var materialart = $.trim($("#material_" + idarticulo).text());
	var preciocompraart = $.trim($("#preciocompra_" + idarticulo).text());
	var precioventaart = $.trim($("#precioventa_" + idarticulo).text());
	$("#idcategoria_" + idarticulo).empty();

	$("#nombre_" + idarticulo).html("<input style='width:98%' type='text' id='nombre_text" + idarticulo + "' value='" + nombreart + "'>");
	$("#fechaalta_" + idarticulo).html("<input style='width:98%' type='text' id='fechaalta_text" + idarticulo + "' value='" + fechaaltaart + "' readonly>");
	$("#cantidad_" + idarticulo).html("<input style='width:98%' type='number' id='cantidad_text" + idarticulo + "' value='" + cantidadart + "'>");
	$("#peso_" + idarticulo).html("<input style='width:98%' type='number' id='peso_text" + idarticulo + "' value='" + pesoart + "'>");
	$("#dimension_" + idarticulo).html("<input style='width:98%' type='text' id='dimension_text" + idarticulo + "' value='" + dimensionart + "'>");
	$("#material_" + idarticulo).html("<input style='width:98%' type='text' id='material_text" + idarticulo + "' value='" + materialart + "'>");
	$("#preciocompra_" + idarticulo).html("<input style='width:98%' type='number' id='preciocompra_text" + idarticulo + "' value='" + preciocompraart + "'>");
	$("#precioventa_" + idarticulo).html("<input style='width:98%'type='number' id='precioventa_text" + idarticulo + "' value='" + precioventaart + "'>");
	$("#listacategoria_" + idarticulo).css("display", "block");

	$("#editar_button" + idarticulo).css("display", "none");
	$("#guardar_button" + idarticulo).css("display", "block");

}

/*===============================================================
=            GUARDAR EL ARTICULO MODIFICADO EN LA BD            =
===============================================================*/
function guardarArticulo(idarticulo) {
	var nombreart = $.trim($("#nombre_text" + idarticulo).val());
	var fechaaltaart = $.trim($("#fechaalta_text" + idarticulo).val());
	var cantidadart = $.trim($("#cantidad_text" + idarticulo).val());
	var pesoart = $.trim($("#peso_text" + idarticulo).val());
	var dimensionart = $.trim($("#dimension_text" + idarticulo).val());
	var materialart = $.trim($("#material_text" + idarticulo).val());
	var preciocompraart = $.trim($("#preciocompra_text" + idarticulo).val());
	var precioventaart = $.trim($("#precioventa_text" + idarticulo).val());
	var nombrecatraw = $("#listacategoria_" + idarticulo + " option:selected").text();
	var idcat = $("#listacategoria_" + idarticulo).val()

	var val_nombreart = validacionNombre(nombreart);
	var val_fechaaltaart = validacionFechaAlta(fechaaltaart);
	var val_cantidadart = validacionCantidad(cantidadart);
	var val_pesoart = validacionPeso(pesoart);
	var val_dimension = validacionDimension(dimensionart);
	var val_materialart = validacionMaterial(materialart);
	var val_preciocompraart = validacionPrecioCompra(preciocompraart);
	var val_precioventaart = validacionPrecioVenta(precioventaart);
	var val_compraventa = validacionCompraVenta(preciocompraart,precioventaart);

	var nombrecat = nombrecatraw; 

	while(nombrecat.search(" ")!=-1){
		nombrecat = nombrecat.replace(/[^A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]/, "");	//Elimina caracteres que no sean letras
	}
	nombrecat = nombrecat.match(/[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]+/);	//Obtenemos solo los caracteres deseados como filtro
		
	var val_nombrecat = validacionNombreCategoria(nombrecat);

	if (val_nombreart && val_fechaaltaart && val_cantidadart && val_pesoart && val_dimension
		&& val_materialart && val_preciocompraart && val_precioventaart && val_nombrecat && val_compraventa) {

		$.ajax({
			type: 'post',
			url: 'ajax/articulos.ajax.php',
			data: {
				editararticulo: 'editararticulo',
				idarticulo: idarticulo,
				nombre: nombreart,
				fechaalta: fechaaltaart,
				cantidad: cantidadart,
				peso: pesoart,
				dimension: dimensionart,
				material: materialart,
				preciocompra: preciocompraart,
				precioventa: precioventaart,
				idcategoria: idcat
			},
			success: function (respuesta) {
				if (respuesta == "success") {

					$("#nombre_" + idarticulo).text(nombreart);
					$("#fechaalta_" + idarticulo).text(fechaaltaart);
					$("#cantidad_" + idarticulo).text(cantidadart);
					$("#peso_" + idarticulo).text(pesoart);
					$("#dimension_" + idarticulo).text(dimensionart);
					$("#material_" + idarticulo).text(materialart);
					$("#preciocompra_" + idarticulo).text(preciocompraart);
					$("#precioventa_" + idarticulo).text(precioventaart);
					$("#idcategoria_" + idarticulo).text(nombrecat);

					$("#listacategoria_" + idarticulo).css("display", "none");
					$("#editar_button" + idarticulo).css("display", "block");
					$("#guardar_button" + idarticulo).css("display", "none");
				}
			}
		});
	} else {
		var error = "";

		if (!val_nombreart) {
			error = error.concat("Error en el nombre del articulo<br>");
		}
		if (!val_fechaaltaart) {
			error = error.concat("Error en la fecha de alta<br>");
		}
		if (!val_cantidadart) {
			error = error.concat("Error en la cantidad<br>");
		}
		if (!val_pesoart) {
			error = error.concat("Error en el peso<br>");
		}
		if (!val_dimension) {
			error = error.concat("Error en el formato de la dimension 00x00x00<br>");
		}
		if (!val_materialart) {
			error = error.concat("Error en el material<br>");
		}
		if (!val_preciocompraart) {
			error = error.concat("Error en el precio de compra<br>");
		}
		if (!val_precioventaart) {
			error = error.concat("Error en el precio de venta<br>");
		}
		if (!val_compraventa) {
			error = error.concat("Error, el precio de venta no puede ser mayor que el de compra<br>");
		}
		if (!val_nombrecat) {
			error = error.concat("Error en el nombre de la categoria<br>");
		}

		swal({
			type: 'error',
			title: 'Oops...',
			html: error,
		})
		//alert(error);
	}

}

/*============================================
=            ELIMINAR UN ARTICULO            =
============================================*/
function eliminarArticulo(idarticulo) {

	$.ajax({
		type: 'post',
		url: 'ajax/articulos.ajax.php',
		data: {
			eliminararticulo: 'eliminararticulo',
			id: idarticulo
		},
		success: function (respuesta) {

			if (respuesta == "success") {

				$("#fila_" + idarticulo).remove();
			}
		}
	});
}

/*============================================
=            FUNCIONES DE VALIDACION         =
============================================*/


function validacionNombre(nombreart){
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/;	//Solo admite de 2 a 15 de los caracteres entre corchetes
	var res = pattern.test(nombreart);
	return res;
}

function validacionFechaAlta(fecha_alta) {	//formato: dd/mm/yyyy
	var pattern = /^[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{2,4}$/;
	var check1 = pattern.test(fecha_alta);
	var check2;
	var res = false;

	var date = new Date();
	var day = date.getDate().toString();
	var month = (date.getMonth()+1).toString();
	var year = date.getFullYear().toString().substring(2, 4);

	if(check1){

		var fecha = fecha_alta.split("/");

		if(parseInt(year) < parseInt(fecha[2])){
			console.log("Año incorrecto",year,fecha[2]);
			check2 = false;
		}else if(parseInt(year) == parseInt(fecha[2])){
			if(parseInt(month) < parseInt(fecha[1])){
				console.log("Mes incorrecto",'"',month,'"',fecha[1],'"');
				check2 = false;
			}else if(parseInt(month) == parseInt(fecha[1])){
				if(parseInt(day) < parseInt(fecha[0])){
					console.log("Dia incorrecto23 -",parseInt(day),"-",parseInt(fecha[0]));
					check2 = false;
				}else{
					check2 = true;
				}
			}else{
				check2 = true;
			}
		}else{
			check2 = true;
		}

	}

	if(check1 && check2){
		res = true;
	}


	return res;
}

function validacionCantidad(cantidad) {
	var pattern = /^[0-9]{0,5}$/;
	var res = pattern.test(cantidad);
	return res;
}

function validacionPeso(peso) {
	var pattern = /^[0-9]{0,5}$/;
	var res = pattern.test(peso);
	return res;
}

function validacionDimension(dimension) {
	var pattern = /^[0-9]{1,3}[x]{1}[0-9]{1,3}[x]{1}[0-9]{1,3}$/;
	var res = pattern.test(dimension);
	return res;
}

function validacionMaterial(material) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû]{2,30}/;
	var res = pattern.test(material);
	return res;
}

function validacionPrecioCompra(precioCompra) {
	var pattern = /^[0-9]{0,3}[.]{0,1}[0-9]{0,2}$/;
	var res = pattern.test(precioCompra);
	return res;
}

function validacionPrecioVenta(precioVenta) {
	var pattern = /^[0-9]{0,3}[.]{0,1}[0-9]{0,2}$/;
	var res = pattern.test(precioVenta);
	return res;
}

function validacionNombreCategoria(nombreCategoria) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,20}$/;	//Solo admite de 2 a 20 de los caracteres entre corchetes
	var res = pattern.test(nombreCategoria);
	return res;
}

function validacionCompraVenta(compra,venta){
	var res;
	if(validacionPrecioCompra(compra) && validacionPrecioVenta(venta)){
		if(parseInt(venta) >= parseInt(compra)){
			res = true;
		}else{
			res = false;
		}
	}else{
		res = false;
	}

	return res;
}