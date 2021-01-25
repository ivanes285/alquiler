<?php 
	/****************************************
	Conexion a Base de Datos con PDO
	Si tienes dudas acerca de la conexion te 
	recomiendo el curso que subi acerca de PDO
	*****************************************/
	try
	 {
		$handler = new PDO('mysql:host=127.0.0.1;dbname=alquilerv2','root','');
		$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 }
	catch(PDOException $e)
	 {
		echo $e->getMessage();
	 }

	/*Crear el objeto para accesar a la clase*/
	include_once 'DBImagen.php';
	$DBImagen = new DBImagen($handler);
?>