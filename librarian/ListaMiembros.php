<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>Solicitudes de Registro Pendientes</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/pending_registrations_style.css">
	</head>
	<body>
		<?php
			$query = $con->prepare("SELECT username, name, email, edad  FROM member");
			$query->execute();
			$result = $query->get_result();
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>Miembros</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>Miembros</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							<th>Usuario<hr></th>
							<th>Nombre<hr></th>
							<th>Correo<hr></th>
							<th>Edad<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>";
					/*echo "<td>
							<label class='control control--checkbox'>
								<input type='checkbox' name='cb_".$i."' value='".$row[0]."' />
								<div class='control__indicator'></div>
							</label>
						</td>";*/
					$j;
					for($j=0; $j<3; $j++)
						echo "<td>".$row[$j]."</td>";
					echo "<td>".$row[$j]."</td>";
					echo "</tr>";
				}
				echo "</table><br /><br />";
				echo "<div style='float: right;'>";
				echo "<input type='hidden' value='Eliminar Selección' name='l_delete' />&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='hidden' value='Confirmar Selección' name='l_confirm' />";
				echo "</div>";
				echo "</form>";

			}
			
			$header = 'From: <grupo4@alquiler.com>' . "\r\n";
			if(isset($_POST['contrasenia']))
			{
					//echo rand();
				echo rand(100, 1000);
			}


			if(isset($_POST['l_confirm']))
			{
				$members = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$username =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT * FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						$query->execute();
						$row = mysqli_fetch_array($query->get_result());
						
						$parametro=$username."','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4];
						$quer = $con->prepare("SELECT * FROM member ;");
						$quer->execute();
						$cantidad=mysqli_num_rows($quer->get_result())+1;								
						$idparam=$cantidad.",'".$parametro."'";

						$query = $con->prepare("INSERT INTO member VALUES(".$idparam.");");
						
						//$query->bind_param("ssssd", $username, $row[1], $row[2], $row[3]);
						if(!$query->execute())
							die(error_without_field("ERROR: No se pudieron insertar valores"));
						$members++;
						
						$to = $row[3];
						$subject = "Membresía del concecionario aceptada";
						$message = "Su membresia ha sido aceptada por el concecionario. Ahora puede solicitar carros con su cuenta.";
						mail($to, $subject, $message, $header);
					}
				}
				if($members > 0)
					echo success("Exitosamente agregado ".$members."cliente");

					
				else
					echo error_without_field("Ningún registro seleccionado");
			}
			
			if(isset($_POST['l_delete']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$username =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT email FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						$query->execute();
						$email = mysqli_fetch_array($query->get_result())[0];
						
						$query = $con->prepare("DELETE FROM pending_registrations WHERE username = ?;");
						$query->bind_param("s", $username);
						if(!$query->execute())
							die(error_without_field("ERROR: No se pudieron eliminar los valores"));
						$requests++;
						
						$to = $email;
						$subject = "Solicitud de membresía rechazada";
						$message = "Su membresia ha sido rechazada por el concecionario. Póngase en contacto con un administrador para más información.";
						mail($to, $subject, $message, $header);
					}
				}
				if($requests > 0)
					echo success("Eliminado Exitosamente ".$requests." Registro");
				else
					echo error_without_field("No se seleccionó ningún registro");
			}
		?>
	</body>
</html>