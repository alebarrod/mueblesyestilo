<?php
  
  $administradores = ControladorAdministradores::ctrListarAdministradores(null, null);

?>
<div id="contenedor-principal">
  <div class="table-responsive">
<h1>Lista de Perfiles</h1>
<?php
  if(is_array($administradores)){
?>
    <table class="table">
      <thead>
        <tr>
          <th>##</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Dni</th>
          <th>Telefono</th>
          <th>Domicilio</th>
          <th>Email</th>
          <th>Password</th>
          <th>Fecha Nacimiento</th>
          <th>Foto</th>
          <th>Pefil</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
    <?php
      $cont = 0;
      foreach($administradores as $administrador){
    ?>
        <tr id="fila_<?= $administrador["IDADMINISTRADOR"] ?>">
          <td class="valor">
              <?= ++$cont ?>
          </td>
          <td id="nombre_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["NOMBRE"]; ?> 
          </td>
          <td id="apellido_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["APELLIDO"]; ?> 
          </td>
          <td id="dni_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["DNI"]; ?> 
          </td>
          <td id="telefono_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["TELEFONO"]; ?> 
          </td>
          <td id="domicilio_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["DOMICILIO"]; ?> 
          </td>
          <td id="email_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["EMAIL"]; ?> 
          </td>
          <td id="pass_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["PASS"]; ?> 
          </td>
          <td id="fechanacimiento_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["FECHANACIMIENTO"]; ?> 
          </td>
          <td id="foto_<?= $administrador["IDADMINISTRADOR"] ?>"> 
               
            <img src="b/<?= $administrador["FOTO"]; ?>">
          </td>
          <td id="perfil_<?= $administrador["IDADMINISTRADOR"] ?>"> 
              <?= $administrador["PERFIL"]; ?> 
          </td>
          <td>
              <input type="button" class="editar_button" id="editar_button<?= $administrador["IDADMINISTRADOR"] ?>" value="Editar" onclick="editarPerfil('<?= $administrador["IDADMINISTRADOR"] ?>');">

              <input style="display: none" type="button" class="guardar_button" id="guardar_button<?= $administrador["IDADMINISTRADOR"] ?>" value="Guardar" onclick="guardarPerfil('<?= $administrador["IDADMINISTRADOR"] ?>');">
              <input type="button" class="eliminar_button" id="eliminar_button<?= $administrador["IDADMINISTRADOR"] ?>" value="Eliminar" onclick="eliminarPerfil('<?= $administrador["IDADMINISTRADOR"] ?>');">
          </td>
        </tr>
    <?php
      }
    ?>
    <form enctype="multipart/form-data" id="formuploadajax" method="post">
        <tr id="nueva_fila">
          <td> &nbsp; </td>
          <td> <input type="text" id="nueva_nombre" name="nueva_nombre"> </td>
          <td><input type="text" id="nueva_apellido" name="nueva_apellido"></td>
          <td><input type="text" id="nueva_dni" name="nueva_dni"></td>
          <td><input type="number" id="nueva_telefono" name="nueva_telefono"></td>
          <td><input type="text" id="nueva_domicilio" name="nueva_domicilio"></td>
          <td><input type="email" id="nueva_email" name="nueva_email"></td>
          <td><input type="pass" id="nueva_pass" name="nueva_pass"></td>
          <td><input type="date" id="nueva_fechanacimiento" name="nueva_fechanacimiento"></td>
          <td><input type="file" id="nueva_foto" name="nueva_foto"></td>
          <td><select name="nueva_perfil" id="nueva_perfil">
              <option value="Empleado">Empleado</option>
              <option value="Admin">Admin</option>
          </select></td>
          <td> <input type="submit" value="Insertar"/> </td>
        </tr>
    </form>
      </tbody>
    </table>
  </div>
</div>
<?php
}
?>