<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>Bienvenido</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="css/home_style.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_radio_button_style.css">
		<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
		<script src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>	
		<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap/3/css/bootstrap.com"/>
		<link href="../daterangepicker-master/daterangepicker.css" rel="stylesheet"/>
		<script src="../daterangepicker-master/daterangepicker.js"></script>
	</head>
	<body>
		<?php
			$query = $con->prepare("SELECT *FROM imagenphp ORDER BY id");
			$query->execute();
			$fotos = $query->get_result();

			$query = $con->prepare("SELECT * FROM autos ORDER BY idauto");
			$query->execute();
			$result = $query->get_result();
			if(!$result)
				die("ERROR: No se puedieron encontrar los carros");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>Carros no Disponibles</h2>";
			else
			{
				
				echo "<form class='cd-form' method='POST' action='#'>";
				//echo "<legend>Carros Disponibles</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
						<th>Nro<hr></th>
						<th>Placa<hr></th>
						<th>Marca<hr></th>
						<th>Modelo<hr></th>
						<th>Categoría<hr></th>
						<th>Precio/Día<hr></th>
						<th>Disponibilidad<hr></th>
					</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					$phot=mysqli_fetch_array($fotos);
					
					/*echo "<tr>
							<td>
								<label class='control control--radio'>
									<input type='radio' name='rd_book' value=".$row[0]." />
								<div class='control__indicator'></div>
							</td>";
					for($j=0; $j<6; $j++)
						if($j == 4)
							echo "<td>$".$row[$j]."</td>";
						else
							echo "<td>".$row[$j]."</td>";
							echo "<td>"?>
							<img src="<?php print('../librarian/'.$phot['urlPhoto']); ?>" width="500">
								<?php	
							"</td>";*/


							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td>".$row[3]."</td>";
							echo "<td>".$row[4]."</td>";
							echo "<td>".$row[5]."</td>";
							if ($row[6]==1) {
								echo "<td>Disponible</td>";
							}else {
								echo "<td>Ocupado</td>";
							}
							//echo "<td>".$row[6]."</td>";
							echo "<td>"?>
									<img src="<?php print('../librarian/'.$phot['urlPhoto']); ?>" width="500">
										<?php	
									"</td>";
		






					echo "</tr>";
					
				}
				echo "</table>";
				//echo "<legend>Seleccione un rango de fechas</legend>";
				?>
					<!--<input id="Fechas" type="text" name="rd_fecha" readonly="readonly" require/>-->
				<?php
				//echo "<br /><br /><input type='submit' name='m_request' value='Solicitar Carro' />";
				echo "</form>";
				?>
				<script>
				$('#Fechas').daterangepicker({
					"autoApply": true,
					"minDate":new Date()
				});
				</script>
				<?php
			}
			
			if(isset($_POST['m_request']))
			{
				if(empty($_POST['rd_book']))
					echo error_without_field("Seleccione un carro para emitir");
				else
				{
					/*$query = $con->prepare("SELECT copies FROM book WHERE isbn = ?;");
					$query->bind_param("s", $_POST['rd_book']);
					$query->execute();
					$copies = mysqli_fetch_array($query->get_result())[0];
					if($copies == 0)
						echo error_without_field("No hay unidades disponibles del carro seleccionado.");
					else
					{*/
						$query = $con->prepare("SELECT request_id FROM pending_book_requests WHERE member = ?;");
						$query->bind_param("s", $_SESSION['username']);
						$query->execute();
						if(mysqli_num_rows($query->get_result()) == 1)
							echo error_without_field("Solo puedes solicitar un carro a la vez");
						else
						{
							$query = $con->prepare("SELECT book_isbn FROM book_issue_log WHERE member = ?;");
							$query->bind_param("s", $_SESSION['username']);
							$query->execute();
							$result = $query->get_result();
							if(mysqli_num_rows($result) >= 3)
								echo error_without_field("No puedes emitir más de 3 carros a la vez");
							else
							{
								$rows = mysqli_num_rows($result);
								for($i=0; $i<$rows; $i++)
									if(strcmp(mysqli_fetch_array($result)[0], $_POST['rd_book']) == 0)
										break;
								if($i < $rows)
									echo error_without_field("Ya ha solicitado una unidad de este carro.");
								else
								{/*
									$query = $con->prepare("SELECT balance FROM member WHERE username = ?;");
									$query->bind_param("s", $_SESSION['username']);
									$query->execute();
									$memberBalance = mysqli_fetch_array($query->get_result())[0];
									
									$query = $con->prepare("SELECT price FROM book WHERE isbn = ?;");
									$query->bind_param("s", $_POST['rd_book']);
									$query->execute();
									$bookPrice = mysqli_fetch_array($query->get_result())[0];
									if($memberBalance < $bookPrice)
										echo error_without_field("No tiene el saldo suficiente para emitir este carro.");
									else
									{*/
										$query = $con->prepare("SELECT * FROM pending_book_requests ;");
										$query->execute();
										$dispo="si";
										$aux=mysqli_num_rows($query->get_result())+1;
										$ins=$aux.", '".$_SESSION['username']."', '".$_POST['rd_book']."', '".$_POST['rd_fecha']."'";
										$query = $con->prepare("INSERT INTO pending_book_requests VALUES (".$ins.");");
										//$query->bind_param("ss", $_SESSION['username'], $_POST['rd_book'], $_POST['rd_fecha']);
										if(!$query->execute())
											echo error_without_field("ERROR: No se pudo solicitar el carro");
										else
											echo success("Carro solicitado con éxito. Se le notificará por correo electrónico cuando el carro se emita a su cuenta");
									}
								}
							}
						}
					
				}
			
		?>
	</body>
</html>