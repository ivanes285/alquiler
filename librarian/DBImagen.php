<?php
include "../db_connect.php";

class DBImagen
{

	private $DBConexion;


	function __construct($Conexion)
	{
		$this->DBConexion = $Conexion;
				
	}

	/**********************************
	Función para guardar la ruta de la
	   Imagen en la base de datos
	**********************************/
	public function uploadImage()
	{
		/*$query = $this->DBConexion->prepare("SELECT count(*) FROM imagenphp ;");
		$query->execute();
		$dispo="si";
		$idauto=$query+1;
		echo($idauto);
		$ruta = 'imagenes/'.$Imagen['imagen']['name'];
		move_uploaded_file($Imagen['imagen']['tmp_name'],$ruta);
		$SQLStatement = $this->DBConexion->prepare("INSERT INTO imagenphp VALUES (31,'$ruta')");
		//$SQLStatement->bindParam(":url",$ruta);
		$SQLStatement->execute();*/
	}
	public function viewImages()
	{
		
	}

}

?>