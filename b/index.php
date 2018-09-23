<?php

	require_once "controladores/plantilla.controlador.php";
	require_once "controladores/administradores.controlador.php";
	require_once "controladores/categorias.controlador.php";
	require_once "controladores/articulos.controlador.php";
	require_once "controladores/clientes.controlador.php";

	require_once "modelos/administradores.modelo.php";
	require_once "modelos/categorias.modelo.php";
	require_once "modelos/articulos.modelo.php";
	require_once "modelos/clientes.modelo.php";

$plantilla = new controladorPlantilla();
$plantilla -> ctrPlantila();

