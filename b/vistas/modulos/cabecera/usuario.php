<header> <!-- inicio -->
				<!-- logo principal de la pagina  -->
				<h1>Muebles & Estilo</h1>
				<div id="contenedor-muebles-y-estilo">  <!-- donde sale el nombre de mye -->
					<img id="logo-muebles-y-estilo" src="vistas/imagenes/mueblesYEstilo.png">
				</div>


				<div id="contenedor-logo-pagina-principal" class="elemento-header">
					<a href="inicio"><img id="logo-pagina-principal" src="vistas/imagenes/logoPrincipal.png" /></a>
				</div>
				
				<!-- barra de busqueda de la cabecera -->
				<div id="contenedor-barra-busqueda">
					<form id="formulario-busqueda-productos" action="" class="elemento-header">  <!-- el atributo que procesara este formulario son articulos -->
						<div id="div-input-de-busqueda">
							<input id="input-de-busqueda" type="text" autocomplete="off" placeholder="Buscar producto"/>
							<label for="input-de-busqueda">
								<img id="id-imagen-lupa" src="vistas/imagenes/lupa.png" />
							</label>
						</div>	
					</form>	
				</div>
				
				<!-- iconos para usuario y cesta -->
				<div id="mi-cuenta-y-carrito">
					<div id="mi-cuenta" class="elemento-header">
						<label for="imagen-mi-cuenta">
							<img src="vistas/imagenes/user.png" />
							<span>Hola, <?= $_SESSION["nombreadministrador"] ?></span>
						</label>
						
					</div>
					
					<div id="salir" class="elemento-header">
						<label>
							<a href="salir"><img src="vistas/imagenes/salir.png" /></a>
							<span>Salir</span>
						</label>
					</div>
					
					
				</div>
			</header>