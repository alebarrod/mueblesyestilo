<?php
	
	$clientes = ControladorClientes::ctrListarClientes(null, null);

	//var_dump($clientes);

?>
<div id="contenedor-principal">
	<div class="table-responsive">
		<h1>Lista de Clientes</h1>
		<?php
		  if(is_array($clientes)){
		?>
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>##</th>
		      <th>DNI</th>
		      <th>Nombre</th>
		      <th>Apellidos</th>
		      <th>Domicilio</th>
		      <th>telefono</th>
		      <th>Correo Electronico</th>
		      <th>Contraseña</th>
		      <th>Fecha Nacimiento</th>
		      <th>Acciones</th>
		    </tr>
		  </thead>
		  <tbody>
		<?php
		  $cont = 0;
		  foreach($clientes as $cliente){
		?>
			<tr id="fila_<?= $cliente['IDCLIENTE'] ?>">
				<td class="valor"><?= $cont++ ?></td>
				<td id="dni_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['DNI'] ?> </td>
				<td id="nombre_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['NOMBRE'] ?> </td>
				<td id="apellidos_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['APELLIDOS'] ?> </td>
				<td id="domicilio_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['DOMICILIO'] ?> </td>
				<td id="telefono_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['TELEFONO'] ?> </td>
				<td id="correo_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['CORREOELECTRONICO'] ?> </td>
				<td id="pass_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['PASS'] ?> </td>
				<td id="fechanacimiento_<?= $cliente['IDCLIENTE'] ?>"> <?= $cliente['FECHANACIMIENTO'] ?> </td>
				<td>
		          <input type="button" class="eliminar_button" id="eliminar_button<?= $cliente['IDCLIENTE'] ?>" value="Eliminar" onclick="eliminarCliente('<?= $cliente['IDCLIENTE'] ?>');">
				</td>
			</tr>
		<?php
		  }
		?>
		<tr id="nueva_fila">
			<td></td>
			<td><input type="text" id="nuevo_dni"></td>
			<td><input type="text" id="nuevo_nombre"></td>
			<td><input type="text" id="nuevo_apellidos"></td>
			<td><input type="text" id="nuevo_domicilio"></td>
			<td><input type="number" id="nuevo_telefono"></td>
			<td><input type="text" id="nuevo_correoelectronico"></td>
			<td><input type="text" id="nuevo_pass"></td>
			<td><input type="date" id="nuevo_fechanacimiento"></td>
			<td><input type="button" value="Insertar Cliente" onclick="insertarCliente();"></td>
		  </tbody>
		</table>
	</div>	
</div>
<?php
}
?>