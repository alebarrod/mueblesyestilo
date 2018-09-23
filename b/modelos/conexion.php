<?php
class Conexion{

	public function conectar(){

		try{

			$link = new PDO('oci:dbname=XE;charset=UTF8', 'IISSI', 'iissi');
			return $link;
		}catch(Exception $e){

			header('Location: vistas\error.php');
		}
	}

}

?>