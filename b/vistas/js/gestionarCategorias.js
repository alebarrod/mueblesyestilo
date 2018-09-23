// este metodo es equivalente a $(document).ready(function(){})
$(function () {

	/*=============================================
	=            VALIDAR CATEGORIA                =
	=============================================*/
	$(".validarcategoria").change(function () {
		$(".alerta").remove();

		var form = new FormData();


		form.append("nombrecategoria", nombrecategoria);


		$.ajax({
			url: "ajax/categorias.ajax.php",
			type: "POST",
			data: form,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function (res) {
				if (res) {

					$(".validarcategoria").parent().after('<p class="alerta" style="color:red"> Ya existe la categoria</p>');
					$(".validarcategoria").val("");
				}
			}
		});

	});
}); // FIN DE DOCUMENT READY

/*=================================================
=            AÑADE UNA NUEVA CATEGORIA            =
=================================================*/
function insertarCategoria() {

	var nombrecat = $("#nueva_categoria").val();
	var descripcioncat = $("#nueva_descripcion").val();
	//console.log(nombrecat);

	var val_categoria = validacionCategoria(nombrecat);
	var val_descategoria = validacionDescripcionCategoria(descripcioncat);
	console.log(val_categoria, val_descategoria);
	if (val_categoria && val_descategoria) {
		$.ajax({
			type: 'post',
			url: 'ajax/categorias.ajax.php',
			data: {
				insertarcategoria: 'insertarcategoria',
				nombre: nombrecat,
				descripcion: descripcioncat
			},
			success: function (respuesta) {

				if (respuesta != "" && respuesta != "error") {

					// imprimimos el nuevo dato en el html
					var id = respuesta;
					var nuevafila = "<tr id='fila_" + id + "'> <td></td><td id='nombre_" + id + "'>" + nombrecat + "</td>";
					nuevafila += "<td id='descripcion_" + id + "'>" + descripcioncat + "</td>";
					nuevafila += "<td><input type='button' class='editar_button' id='editar_button" + id + "' value='Editar' onclick='editarCategoria(" + id + ");'>";
					nuevafila += "<input style='display: none' type='button' class='guardar_button' id='guardar_button" + id + "' value='Guardar' onclick='guardarCategoria(" + id + ");'>";
					nuevafila += "<input type='button' class='eliminar_button' id='eliminar_button" + id + "' value='Eliminar' onclick='eliminarCategoria(" + id + ");'></td></tr>";

					$("#categoriastabla tr:last").before(nuevafila);

					// Limpiamos los inputs el que añade una nueva categoria
					$("#nueva_categoria").val("");
					$("#nueva_descripcion").val("");
				}
			}
		});
	} else {
		var error = '';

		if (!val_categoria) {
			error = error.concat("Error en el nombre de la categoria<br>");
		}
		console.log(error);
		if (!val_descategoria) {
			error = error.concat("Error en la descripcion<br>");
		}

		swal({
			type: 'error',
			title: 'Oops...',
			html: error,
		})
		//alert(error);
	}
}

/*========================================
=            EDITAR CATEGORIA            =
========================================*/
function editarCategoria(idcategoria) {

	// guardamos la informacion que tenga el id nombre_$numeroid en una variable
	var nombrecat = $.trim($("#nombre_" + idcategoria).text());
	var descripcioncat = $.trim($("#descripcion_" + idcategoria).text());

	// Sustituimos la informacion que tenga el id nombre_$numeroid por un input
	$("#nombre_" + idcategoria).html("<input type='text' id='nombre_text" + idcategoria + "' value='" + nombrecat + "'>");
	$("#descripcion_" + idcategoria).html("<input type='text' id='descripcion_text" + idcategoria + "' value='" + descripcioncat + "'>");

	// deshabilitamos el boton de editar y habilitamos el boton de guardar
	$("#editar_button" + idcategoria).css("display", "none");
	$("#guardar_button" + idcategoria).css("display", "block");
}

/*=================================================
=       GUARDA LA CATEGORIA MODIFICADA            =
=================================================*/
function guardarCategoria(idcategoria) {

	// guardamos el contenido del input en una variable
	var nombrecat = $.trim($("#nombre_text" + idcategoria).val());
	var descripcioncat = $.trim($("#descripcion_text" + idcategoria).val());

	var val_categoria = validacionCategoria(nombrecat);
	var val_descategoria = validacionDescripcionCategoria(descripcioncat);

	if (val_categoria && val_descategoria) {
		// utilizamos ajax 
		$.ajax({
			type: 'post',
			url: 'ajax/categorias.ajax.php',
			data: {
				editarcategoria: 'editarcategoria',
				id: idcategoria,
				nombre: nombrecat,
				descripcion: descripcioncat
			},
			success: function (respuesta) {
				//console.log("AKI", respuesta);
				if (respuesta == "success") {
					//console.log("AKI", respuesta);
					// imprimimos el nuevo valor en el html
					$("#nombre_" + idcategoria).text(nombrecat);
					$("#descripcion_" + idcategoria).text(descripcioncat);

					// habilitamos el boton editar categoria y deshabilitamos el boton guardar categoria
					$("#editar_button" + idcategoria).css("display", "block")
					$("#guardar_button" + idcategoria).css("display", "none")
				}
			}
		});
	} else {
		var error = '';

		if (!val_categoria) {
			error = error.concat("Error en el nombre de la categoria<br>");
		}
		console.log(error);
		if (!val_descategoria) {
			error = error.concat("Error en la descripcion<br>");
		}

		swal({
			type: 'error',
			title: 'Oops...',
			html: error,
		})
		//alert(error);
		
	}

}

/*==========================================
=            ELIMINAR CATEGORIA            =
==========================================*/
function eliminarCategoria(idcategoria) {

	$.ajax({
		type: 'post',
		url: 'ajax/categorias.ajax.php',
		data: {
			eliminarcategoria: 'eliminarcategoria',
			id: idcategoria
		},
		success: function (respuesta) {

			if (respuesta == "success") {

				$("#fila_" + idcategoria).remove();
			}
		}
	});
}


/*============================================
=            FUNCIONES DE VALIDACION         =
============================================*/


function validacionCategoria(categoria) {
	var res;
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,20}$/;
	var res = pattern.test(categoria);
	return res;
}

function validacionDescripcionCategoria(descripcion) {
	var res;
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ,.]{2,30}$/;
	var res = pattern.test(descripcion);
	return res;
}