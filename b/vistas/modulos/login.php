
<h1>Muebles & Estilo</h1>
<form method="post">
		<div class="contenedor-muebles-y-estilo">  <!-- donde sale el nombre de mye -->
			<img id="logo-muebles-y-estilo" src="vistas/imagenes/mueblesYEstilo.png">
		</div>

		<div id="contenedor-principal-login">
			
			<div id="contenedor-login-user">
				<img id="imagen-login-user" src="vistas/imagenes/imagen-login-user.png">
				<input id="input-login-user" type="email" name="email" required >
			</div>
				
			<div id="contenedor-login-password">
				<img id="imagen-login-password" src="vistas/imagenes/imagen-login-password.png">
				<input id="input-login-password" type="password" name="pass" required autocomplete="off">
			</div>

			<div id="contenedor-enviar-login">
				<input id="enviar-login" type="submit" value="ENVIAR">
			</div>


		</div>

<?php
	$login = new ControladorAdministradores();
	$login -> ctrIngresoAdministrador();
?>
</form>