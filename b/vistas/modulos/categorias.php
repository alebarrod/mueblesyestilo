<?php
  
  $categorias = ControladorCategorias::ctrListarCategorias(null, null);

?>
<div id="contenedor-principal">
  <div class="table-responsive">
    <h1>Lista de Categorías</h1>
    <?php
      if(is_array($categorias)){
    ?>
    <table class="table table-hover" id="categoriastabla">
      <thead>
        <tr>
          <th>##</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        </tr>
      </thead>
      <tbody>
    <?php
      $cont = 0;
      foreach($categorias as $categoria){
    ?>
        <tr id="fila_<?= $categoria["IDCATEGORIA"] ?>">
          <td class="valor">
              <?= ++$cont ?>
          </td>
          <td id="nombre_<?= $categoria["IDCATEGORIA"] ?>"> 
              <?= $categoria["NOMBRE"]; ?> 
          </td>
          <td id="descripcion_<?= $categoria["IDCATEGORIA"]; ?>"> 
              <?= $categoria["DESCRIPCION"]; ?> 
          </td>
          <td>
              <input type="button" class="editar_button" id="editar_button<?= $categoria["IDCATEGORIA"] ?>" value="Editar" onclick="editarCategoria('<?= $categoria["IDCATEGORIA"] ?>');">
              <input style="display: none" type="button" class="guardar_button" id="guardar_button<?= $categoria["IDCATEGORIA"] ?>" value="Guardar" onclick="guardarCategoria('<?= $categoria["IDCATEGORIA"] ?>');">
              <input type="button" class="eliminar_button" id="eliminar_button<?= $categoria["IDCATEGORIA"] ?>" value="Eliminar" onclick="eliminarCategoria('<?= $categoria["IDCATEGORIA"] ?>');">
          </td>
        </tr>
    <?php
      }
    ?>
        <tr id="nueva_fila">
          <td> &nbsp; </td>
          <td> <input type="text" id="nueva_categoria"> </td>
          <td> <textarea id="nueva_descripcion" cols="55" rows="2" maxlength="150"></textarea> </td>
          <td> <input type="button" value="Insertar Fila" onclick="insertarCategoria();"> </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<?php
}
?>