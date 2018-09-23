/*=================================================
=            AÑADE UN CLIENTE           		  =
=================================================*/
	function insertarCliente(){

		var dnicli = $("#nuevo_dni").val();
		var nombrecli = $("#nuevo_nombre").val();
		var apellidoscli = $("#nuevo_apellidos").val();
		var domiciliocli = $("#nuevo_domicilio").val();
		var telefonocli = $("#nuevo_telefono").val();
		var correocli = $("#nuevo_correoelectronico").val();
		var pass = $("#nuevo_pass").val();
		var fechacli = $("#nuevo_fechanacimiento").val();
		//console.log(fechacli);

		var val_dni = validacionDNI(dnicli);
		var val_nombre = validacionNombre(nombrecli);
		var val_apellidos = validacionApellidos(apellidoscli);
		var val_domicilio = validacionDomicilio(domiciliocli);
		var val_telefono = validacionTelefono(telefonocli);
		var val_pass = validacionContrasenya(pass);
		var val_correo = validacionCorreo(correocli);


		if(val_dni && val_nombre && val_apellidos && val_domicilio && val_telefono && val_pass && val_correo){
			$.ajax({
				type:'post',
				url:'ajax/clientes.ajax.php',
				data: {
						insertarcliente:'insertarcliente',
						dni: dnicli,
						nombre: nombrecli,
						apellidos: apellidoscli,
						domicilio: domiciliocli,
						telefono: telefonocli,
						correoelectronico: correocli,
						fechanacimiento:fechacli
					  },
				success:function(respuesta){

					if(respuesta!="" && respuesta!="error"){

						// imprimimos el nuevo dato en el html
						var id = respuesta;
						var nuevafila = "<tr id='fila_"+id+"'> <td></td>";
						nuevafila += "<td id='dni_"+id+"'>"+dnicli+"</td>";
						nuevafila += "<td id='nombre_"+id+"'>"+nombrecli+"</td>";
						nuevafila += "<td id='apellidos_"+id+"'>"+apellidoscli+"</td>";
						nuevafila += "<td id='domicilio_"+id+"'>"+domiciliocli+"</td>";
						nuevafila += "<td id='telefono_"+id+"'>"+telefonocli+"</td>";
						nuevafila += "<td id='correo_"+id+"'>"+correocli+"</td>";
						nuevafila += "<td id='fechanacimiento_"+id+"'>"+fechacli+"</td>";

						nuevafila += "<td><input type='button' class='eliminar_button' id='eliminar_button"+id+"' value='Eliminar' onclick='eliminarCliente("+id+");'></td></tr>";
			
						$("#clientestabla tr:last").before(nuevafila);

						// Limpiamos los inputs el que añade una nueva categoria
						$("#nuevo_dni").val("");
						$("#nuevo_nombre").val("");
						$("#nuevo_apellidos").val("");
						$("#nuevo_domicilio").val("");
						$("#nuevo_telefono").val("");
						$("#nuevo_correoelectronico").val("");
						$("#nuevo_fechanacimiento").val("");
					}
				}
			});
		}else{
			var error = "";
			if(!val_dni){
				error = error.concat("Error en el dni<br>");
			}
			if(!val_nombre){
				error = error.concat("Error en el nombre<br>");
			}
			if(!val_apellidos){
				error = error.concat("Error en los apellidos<br>");
			}
			if(!val_domicilio){
				error = error.concat("Error en el domicilio<br>");
			}
			if(!val_telefono){
				error = error.concat("Error en el numero de telefono<br>");
			}
			if(!val_pass){
				error = error.concat("Error en la contraseña<br>");
			}
			if(!val_correo){
				error = error.concat("Error en el correo<br>");
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
=            ELIMINAR CLIENTE            =
==========================================*/
	function eliminarCliente(idcliente){

		$.ajax({
			type:'post',
			url:'ajax/clientes.ajax.php',
			data: {
					eliminarcliente: 'eliminarcliente',
					id: idcliente
				  },
			success: function(respuesta){

				if(respuesta == "success"){

					$("#fila_"+idcliente).remove();
				}
			}
		});
	}


/*============================================
=            FUNCIONES DE VALIDACION         =
============================================*/

function validacionDNI(dni){
	var res;
	var numero;
  	var letr;
  	var letra;
  	var expresion_regular_dni;
	
	expresion_regular_dni = /^\d{8}[a-zA-Z]$/;	//8 digitos seguidos de una letra mayúscula o minúscula (sin caracteres especiales)
	
	if(expresion_regular_dni.test(dni) == true){
	     numero = dni.substr(0,dni.length-1);
	     letr = dni.substr(dni.length-1,1);
	     numero = numero % 23;
	     letra='TRWAGMYFPDXBNJZSQVHLCKET';
	     letra=letra.substring(numero,numero+1);
	    if (letra!=letr.toUpperCase()) {
	    	res = false;
	    }else{
			res = true;
	    }
	}else{
		res = false;
	}
	return res;
}

function validacionNombre(nombre){
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,15}$/;	//Solo admite de 2 a 15 de los caracteres entre corchetes
	var res = pattern.test(nombre);
	return res;
}

function validacionApellidos(apellidos){
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ]{2,19}$/;	//Solo admite de 2 a 19 de los caracteres entre corchetes
	var res = pattern.test(apellidos);
	return res;
}

function validacionDomicilio(domicilio){
	var pattern = /^[A-Za-z0-9ÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùûÑñÇç ºª]{2,30}$/;	//Solo admite de 2 a 20 de los caracteres entre corchetes
	var res = pattern.test(domicilio);
	return res;
}

function validacionTelefono(telefono){
	var pattern = /^[0-9]{9}$/;	//Solo admite 9 dígitos
	var res = pattern.test(telefono);
	return res;
}

function validacionCorreo(correo){
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
	if(user_domain.length != 2){
		check_user = false;
	}else{
		check_user = pattern_user.test(user_domain[0]);	//Comprueba que solo haya letras, numeros o barras bajas
		check_dom1 = pattern_domain.test(user_domain[1]);	//Comprueba que solo haya minusculas y puntos
		check_dom2 = !user_domain.includes("..");	//Comprueba que no haya un subdominio vacio o sea ".."
		check_dom3 = !(user_domain[1][0].includes(".") | user_domain[1].slice(-1).includes("."));	//Comprobamos que no empiece ni acabe en "."
	}

	if(check_length && check_user && check_dom1 && check_dom2 && check_dom3){
		res = true;
	}


	return res;
}

function validacionContrasenya(pass) {
	var pattern = /^[A-Za-zÄÁÂÀËÉÊÈÍÏÎÌÓÖÒÔÚÜÙÛáäàâéëèêíïìîóöòôúüùû_0-9 ]{2,15}$/;	//Solo admite de 2 a 15 de los caracteres entre corchetes
	var res = pattern.test(pass);
	return res;
}
