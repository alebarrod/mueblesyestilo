<?php
	
	$articulos = ControladorArticulos::ctrListarArticulos(null, null);
	$categorias = ControladorCategorias::ctrListarCategorias(null, null);
	//var_dump($categorias);
?>
<div id="contenedor-principal">
	<div class="table-responsive">
		<h1>Lista de Artículos</h1>

		<?php

			if(is_array($articulos)){
		?>
		<table class="table table-hover" id="articulostabla">
		  <thead>
		    <tr>
		      <th>##</th>
		      <th>Nombre</th>
		      <th>Fecha Alta</th>
		      <th>Cantidad</th>
		      <th>Peso</th>
		      <th>Dimension</th>
		      <th>Material</th>
		      <th>Precio Compra</th>
		      <th>Precio Venta</th>
		      <th>Categoria</th>
		      <th>Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		    </tr>
		  </thead>
		  <tbody>

		<?php
				$cont = 0;
				foreach($articulos as $articulo){
		?>
			<tr id="fila_<?= $articulo["IDARTICULO"] ?>">
				<td class="valor"><?= ++$cont ?></td>
				<td id="nombre_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['NOMBRE'] ?> </td>
				<td id="fechaalta_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['FECHAALTA'] ?> </td>
				<td id="cantidad_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['CANTIDAD'] ?> </td>
				<td id="peso_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['PESO'] ?> </td>
				<td id="dimension_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['DIMENSIONN'] ?> </td>
				<td id="material_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['MATERIAL'] ?> </td>
				<td id="preciocompra_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['PRECIOCOMPRA'] ?> </td>
				<td id="precioventa_<?= $articulo["IDARTICULO"] ?>"> <?= $articulo['PRECIOVENTA'] ?> </td>
				<td> 
					<span id="idcategoria_<?= $articulo["IDARTICULO"] ?>"><?= $articulo['NOMCAT'] ?></span> 
					<select name="" id="listacategoria_<?= $articulo["IDARTICULO"]?>" style="display: none">
						<?php foreach($categorias as $categoria){ ?>
							<option <?php if($categoria['IDCATEGORIA'] == $articulo['IDCAT']){ echo 'selected';} ?> value="<?=  $categoria['IDCATEGORIA'] ?>"> <?=  $categoria['NOMBRE'] ?>
							</option>
						<?php } ?>
					</select>
				
				</td>
				<td>
					<input type="button" class="editar_button" id="editar_button<?= $articulo["IDARTICULO"] ?>" value="Editar" onclick="editarArticulo('<?= $articulo["IDARTICULO"] ?>');">
					<input style="display: none" type="button" class="guardar_button" id="guardar_button<?= $articulo["IDARTICULO"] ?>" value="Guardar" onclick="guardarArticulo('<?= $articulo["IDARTICULO"] ?>');">
					<input type="button" class="eliminar_button" id="eliminar_button<?= $articulo["IDARTICULO"] ?>" value="Eliminar" onclick="eliminarArticulo('<?= $articulo["IDARTICULO"] ?>');">
				</td>
			</tr>

		<?php
				}
		?>
			<tr id="nueva_fila">
				<td></td>
				<td><input type="text" size="12" id="nuevo_nombre"></td>
				<td></td>
				<td><input style="width: 50px" type="number" id="nuevo_cantidad"></td>
				<td><input style="width: 50px" type="number" id="nuevo_peso"></td>
				<td><input style="width: 50px" type="text" id="nuevo_dimension"></td>
				<td><input style="width: 50px" type="text" id="nuevo_material"></td>
				<td><input style="width: 50px" type="number" id="nuevo_preciocompra"></td>
				<td><input style="width: 50px" type="number" id="nuevo_precioventa"></td>
				<td>
					<select name="" id="nuevo_lista">
						<?php foreach($categorias as $categoria){ ?>
						<option <?php if($categoria['IDCATEGORIA'] == 0){ echo 'selected';} ?> value="<?=  $categoria['IDCATEGORIA'] ?>"> <?=  $categoria['NOMBRE'] ?>
						</option>
						<?php } ?>
					</select>
					
				</td>
				<td><input type="button" value="Añadir Articulo" onclick=" insertarArticulo();"></td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
	}
?>
