<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>
<?php
	//Incluyendo la conexion y enviando el Arreglo Files a la funcion
	include 'coneccion.php';
	$d="df";
	if(isset($_POST['save']))
	{
		$DBImagen->uploadImage();
	}
	
	
?>
<html>
	<head>
		<title>Agregar Automóvil</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css" />
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css" />
		<link rel="stylesheet" href="css/insert_book_style.css">
	</head>
	<body>
		<center>
		<table aling:'center'>
			<tr>
			<td>
				<div >
						<form method="post" enctype="multipart/form-data" class="cd-form">
							<div class="b-isbn">
								<input type="file" name="imagen" class="b-isbn">	
							</div>
							<input type="submit" name="save" class="b-isbn">
							<?php 
							/*Llamando a la funciĂłn para visualizar las imagenes
							$DBImagen->viewImages();*/
							?>
						</form>
						<br>
						<?php
							/*Incluyendo la conexion y enviando el Arreglo Files a la funcion*/
							/*include 'coneccion.php';*/
							if(isset($_POST['save']))
							
							{$ruta = 'imagenes/'.$_FILES['imagen']['name'];
								move_uploaded_file($_FILES['imagen']['tmp_name'],$ruta);
								$query = $con->prepare("SELECT * FROM imagenphp ;");
								$query->execute();
								$dispo="si";
								$cantidad=mysqli_num_rows($query->get_result())+1;								
								$idphoto=$cantidad.",'".$ruta."'";
								$query = $con->prepare("INSERT INTO imagenphp VALUES ($idphoto);");
								if(!$query->execute())
									die(error_without_field("ERROR: No se puede agregar el carro"));
								echo success("Carro Agregado Satisfactoriamente");
								?>
								<img src="<?php print('imagenes/'.$_FILES['imagen']['name']); ?>" width="500">
								<?php							
							}
						?>
						
							
				</div>
			</td>
			<td>
				<form class="cd-form" method="POST" action="#">
					<legend>Ingresa toda la información del carro</legend>
					
						<div class="error-message" id="error-message">
							<p id="error"></p>
						</div>
						
						<div class="icon">
							<input class="b-isbn" id="b_placa" type="text" name="b_placa" placeholder="Placa" required />
						</div>
						
						<div class="icon">
							<input class="b-title" type="text" name="b_marca" placeholder="Marca" required />
						</div>
						
						<div class="icon">
							<input class="b-author" type="text" name="b_modelo" placeholder="Modelo" required />
						</div>
						
						<div>
						<h4>Categoría</h4>

							<p class="cd-select icon">
								<select class="b-category" name="b_categoria">
									<option>Auto</option>
									<option>Camioneta</option>
								</select>
							</p>
						</div>
						
						<div class="icon">
							<input class="b-price" type="number" name="b_precio" placeholder="Precio por Día" required />
						</div>
						
						
						
						<br />
						<input class="b-isbn" type="submit" name="b_add" value="Agregar" />
				</form>
			</td>

			</tr>
		</table>
		</center>
	<body>

	<?php
		if(isset($_POST['b_add']))
		{
			$query = $con->prepare("SELECT placa FROM autos WHERE placa = ?;");
			$query->bind_param("s", $_POST['b_placa']);
			$query->execute();
			
			if(mysqli_num_rows($query->get_result()) != 0)
				echo error_with_field("Ya existe un carro con esa placa", "b_placa");
			else
			{
				//$placa="x";
				$query = $con->prepare("SELECT * FROM autos ;");
				$query->execute();
				$dispo="si";
				$idauto=mysqli_num_rows($query->get_result())+1;
				$consulta=", '".$_POST['b_placa']."', '".$_POST['b_marca']."', '".$_POST['b_modelo']."', '".$_POST['b_categoria']."', ".$_POST['b_precio']."";
				$cons=$idauto.$consulta;
				$query = $con->prepare("INSERT INTO autos VALUES ($cons);");
				if(!$query->execute())
					die(error_without_field("ERROR: No se puede agregar el carro"));
				echo success("Carro Agregado Satisfactoriamente");
			}
		}
	?>
</html>