/*===================================================
=            DA ALTA UN ADMIN O EMPLEADO            =
===================================================*/
$(function () {
	$("#formuploadajax").on("submit", function (e) {
		e.preventDefault();
		var f = $(this);
		var formData = new FormData(document.getElementById("formuploadajax"));
		formData.append('altaperfil', 'altaperfil');
		var nombre = formData.get("nueva_nombre");
		var apellidos = formData.get("nueva_apellido");
		var dni = formData.get("nueva_dni");
		var telefono = formData.get("nueva_telefono");
		var domicilio = formData.get("nueva_domicilio");
		var email = formData.get("nueva_email");
		var pass = formData.get("nueva_pass");
		var fnacimiento = formData.get("nueva_fechanacimiento");
		var perfil = formData.get("nueva_perfil");

		var fnacimiento2 = new Date(fnacimiento);
		var fnacimiento3 = fnacimiento2.getDate().toString() + "/" +
		 (fnacimiento2.getMonth() + 1).toString() + "/" +
		  (fnacimiento2.getFullYear()).toString().substring(2, 4);


		var val_nombre = validacionNombre(nombre);
		var val_apellidos = validacionApellidos(apellidos);
		var val_dni = validacionDNI(dni);
		var val_telefono = validacionTelefono(telefono);
		var val_domicilio = validacionDomicilio(domicilio);
		var val_correo = validacionCorreo(email);
		var val_pass = validacionContrasenya(pass);
		var val_fnacimiento = validacionFechaAlta(fnacimiento3);
		var val_perfil = validacionPerfil(perfil);


		if(val_nombre && val_apellidos && val_dni &&
			 val_telefono && val_domicilio && val_correo
			  && val_pass && val_fnacimiento && val_perfil){
		$.ajax({
			url: "ajax/perfiles.ajax.php",
			type: "post",
			dataType: "html",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (respuesta) {
				var valores = JSON.parse(respuesta);
				if (valores.id != "" && valores.id != "error") {
					var id = valores.id;
					var fotito = valores.ruta;

					var nuevafila = "<tr id='fila_" + id + "'> <td></td><td id='nombre_" + id + "'>" + formData.get('nueva_nombre') + "</td>";
					nuevafila += "<td id='apellido_" + id + "'>" + formData.get('nueva_apellido') + "</td>";
					nuevafila += "<td id='dni_" + id + "'>" + formData.get('nueva_dni') + "</td>";
					nuevafila += "<td id='telefono_" + id + "'>" + formData.get('nueva_telefono') + "</td>";
					nuevafila += "<td id='domicilio_" + id + "'>" + formData.get('nueva_domicilio') + "</td>";
					nuevafila += "<td id='email_" + id + "'>" + formData.get('nueva_email') + "</td>";
					nuevafila += "<td id='pass_" + id + "'>" + formData.get('nueva_pass') + "</td>";
					nuevafila += "<td id='fechanacimiento_" + id + "'>" + formData.get('nueva_fechanacimiento') + "</td>";//aki modificar
					nuevafila += "<td id='foto_" + id + "'><img src='b/" + fotito + "'></td>";
					nuevafila += "<td id='perfil_" + id + "'>" + formData.get('nueva_perfil') + "</td>";
					nuevafila += "<td><input type='button' class='editar_button' id='editar_button" + id + "' value='Editar' onclick='editarPerfil(" + id + ");'>";
					nuevafila += "<input style='display: none' type='button' class='guardar_button' id='guardar_button" + id + "' value='Guardar' onclick='guardarPerfil(" + id + ");'>";
					nuevafila += "<input type='button' class='eliminar_button' id='eliminar_button" + id + "' value='Eliminar' onclick='eliminarPerfil(" + id + ");'></td></tr>";

					$("#perfilestabla tr:last").before(nuevafila);
					$("#nueva_nombre").val("");
					$("#nueva_apellido").val("");
					$("#nueva_dni").val("");
					$("#nueva_telefono").val("");
					$("#nueva_email").val("");
					$("#nueva_pass").val("");
					$("#nueva_fechanacimiento").val("");
					$("#nueva_foto").val("");
					$("#nueva_perfil").val("");
				}
			}
		});
	} else {
		var error = "";

		if (!val_nombre) {
			error = error.concat("Error en el nombre<br>");
		}
		if (!val_apellidos) {
			error = error.concat("Error en los apellidos<br>");
		}
		if (!val_dni) {
			error = error.concat("Error en el dni<br>");
		}
		if (!val_telefono) {
			error = error.concat("Error en el telefono<br>");
		}
		if (!val_domicilio) {
			error = error.concat("Error en el domicilio<br>");
		}
		if (!val_correo) {
			error = error.concat("Error en el correo<br>");
		}
		if (!val_pass) {
			error = error.concat("Error en el precio de contraseña<br>");
		}
		if (!val_fnacimiento) {
			error = error.concat("Error en la fecha de nacimiento<br>");
		}
		if (!val_perfil) {
			error = error.concat("Error en el perfil<br>");
		}

		swal({
			type: 'error',
			title: 'Oops...',
			html: error,
		})
		//alert(error);
	}

	});

});

/*=================================================
=            EDITA EL PERFIL DEL USUARIO          =
=================================================*/
function editarPerfil(idadministrador) {

	// leendo datos del formulario
	var perfiladm = $.trim($("#perfil_" + idadministrador).text());
	if (perfiladm == 'Admin') {
		$("#perfil_" + idadministrador).html("<select id='lista" + idadministrador + "'><option value='Admin' selected>Admin</option><option value='Empleado'>Empleado</option></select>");
	} else {
		$("#perfil_" + idadministrador).html("<select id='lista" + idadministrador + "'><option value='Admin'>Admin</option><option value='Empleado' selected>Empleado</option></select>");
	}

	$("#editar_button" + idadministrador).css("display", "none");
	$("#guardar_button" + idadministrador).css("display", "block");

}

/*===============================================================
=            GUARDAR EL ARTICULO MODIFICADO EN LA BD            =
===============================================================*/
function guardarPerfil(idadministrador) {

	var tipoperfil = $("#lista" + idadministrador).val();
	//console.log(idcat);
	var val_perfil = validacionPerfil(tipoperfil);
	console.log(tipoperfil);
	if(val_perfil){
		$.ajax({
			type: 'post',
			url: 'ajax/perfiles.ajax.php',
			data: {
				editarperfil: 'editarperfil',
				tipoperfil: tipoperfil,
				idadministrador: idadministrador
			},
			success: function (respuesta) {
				if (respuesta == "success") {

					$("#perfil_" + idadministrador).text(tipoperfil);

					$("#editar_button" + idadministrador).css("display", "block");
					$("#guardar_button" + idadministrador).css("display", "none");
				}
			}
		});
	} else {
		var error = "";

		if (!val_perfil) {
			error = error.concat("Error en el perfil<br>");
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
function eliminarPerfil(idadministrador) {

	$.ajax({
		type: 'post',
		url: 'ajax/perfiles.ajax.php',
		data: {
			eliminarperfil: 'eliminarperfil',
			id: idadministrador
		},
		success: function (respuesta) {

			if (respuesta == "success") {

				$("#fila_" + idadministrador).remove();
			}
		}
	});
}

function validacionNombre(nombre) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/;	//Solo admite de 2 a 15 de los caracteres entre corchetes
	var res = pattern.test(nombre);
	return res;
}

function validacionApellidos(apellidos) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,30}$/;	//Solo admite de 2 a 19 de los caracteres entre corchetes
	var res = pattern.test(apellidos);
	return res;
}

function validacionDNI(dni) {
	var res;
	var numero;
	var letr;
	var letra;
	var expresion_regular_dni;

	expresion_regular_dni = /^\d{8}[a-zA-Z]$/;	//8 digitos seguidos de una letra mayúscula o minúscula (sin caracteres especiales)

	if (expresion_regular_dni.test(dni) == true) {
		numero = dni.substr(0, dni.length - 1);
		letr = dni.substr(dni.length - 1, 1);
		numero = numero % 23;
		letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
		letra = letra.substring(numero, numero + 1);
		if (letra != letr.toUpperCase()) {
			res = false;
		} else {
			res = true;
		}
	} else {
		res = false;
	}
	return res;
}

function validacionDomicilio(domicilio) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ºª]{2,30}$/;	//Solo admite de 2 a 20 de los caracteres entre corchetes
	var res = pattern.test(domicilio);
	return res;
}

function validacionTelefono(telefono) {
	var pattern = /^[0-9]{9}$/;	//Solo admite 9 dígitos
	var res = pattern.test(telefono);
	return res;
}

function validacionCorreo(correo) {
	var res = false;
	var check_length;
	var check_user;
	var check_dom1;
	var check_dom2;
	var check_dom3;
	var user_domain;

	pattern_user = /^[A-Za-z0-9_]+$/;	// '+' es de 0 a infinito
	pattern_domain = /^[a-z.]+$/;

	check_length = correo.length < 25;

	user_domain = correo.split("@");	//Comprobamos que solo haya una "@"
	if (user_domain.length != 2) {
		check_user = false;
	} else {
		check_user = pattern_user.test(user_domain[0]);	//Comprueba que solo haya letras, numeros o barras bajas
		check_dom1 = pattern_domain.test(user_domain[1]);	//Comprueba que solo haya minusculas y puntos
		check_dom2 = !user_domain.includes("..");	//Comprueba que no haya un subdominio vacio o sea ".."
		check_dom3 = !(user_domain[1][0].includes(".") | user_domain[1].slice(-1).includes("."));	//Comprobamos que no empiece ni acabe en "."
	}

	if (check_length && check_user && check_dom1 && check_dom2 && check_dom3) {
		res = true;
	}


	return res;
}

function validacionContrasenya(pass) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû_0-9 ]{2,30}$/;	//Solo admite de 2 a 15 de los caracteres entre corchetes
	var res = pattern.test(pass);
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

		if(parseInt(year) < parseInt(fecha[2])&& parseInt(fecha[2]) < 60){
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

function validacionPerfil(perfil) {
	var res = (perfil == "Empleado" || perfil == "Admin");
	return res;
}