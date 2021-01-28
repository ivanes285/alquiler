<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>Solicitudes Pendientes de Carros </title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/pending_book_requests_style.css">
	</head>
	<body>
		<?php
			$query = $con->prepare("SELECT * FROM pending_book_requests;");
			$query->execute();
			$result = $query->get_result();;
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>Sin solicitudes pendientes</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='pending_book_requests.php'>";
				echo "<legend>Solicitudes de Carros Pendientes</legend>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							<th></th>
							<th>Usuario<hr></th>
							<th>Carro<hr></th>
							<th>Fecha<hr></th>
							<th>Estado<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					if ($row[4]=='Pendiente') {
						echo "<tr>";
						echo "<td>
								<label class='control control--checkbox'>
									<input type='checkbox' name='cb_".$i."' value='".$row[0]."' />
									<div class='control__indicator'></div>
								</label>
							</td>";
						for($j=1; $j<5; $j++)
							echo "<td>".$row[$j]."</td>";
						echo "</tr>";
					}
					
				}
				echo "</table>";
				echo "<br /><br /><div style='float: right;'>";
				echo "<input type='submit' value='Rechazar selección' name='l_reject' />&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='submit' value='Aceptar selección' name='l_grant'/>";
				echo "</div>";
				echo "</form>";
			}
			
			$header = 'From: <grupo4@gmail.com>' . "\r\n";
			
			if(isset($_POST['l_grant']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$request_id =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT member, book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();
						$resultRow = mysqli_fetch_array($query->get_result());
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						$aux="";
						$queryT = $con->prepare("SELECT * FROM book_issue_log WHERE book_isbn = ?;");
						$queryT->bind_param("s", $isbn);
						$queryT->execute();
						$numauto=mysqli_num_rows($queryT->get_result());
						if($numauto>0)
							die(error_without_field("ERROR: No se pudo emitir el carro debido a que ya está rentado"));
						$query = $con->prepare("INSERT INTO book_issue_log(member, book_isbn) VALUES(?, ?);");
						$query->bind_param("ss", $member, $isbn);
						if(!$query->execute())
							die(error_without_field("ERROR: No se pudo emitir el carro"));
						$requests++;
						
						$query = $con->prepare("SELECT email FROM member WHERE username = ?;");
						$query->bind_param("s", $member);
						$query->execute();
						$to = mysqli_fetch_array($query->get_result())[0];
						$subject = "Carro emitido con éxito";
						
						$query = $con->prepare("SELECT placa FROM autos WHERE placa = ?;");
						$query->bind_param("s", $isbn);
						$query->execute();
						$title = mysqli_fetch_array($query->get_result())[0];

						//update carro disponibilidad
						$query = $con->prepare("UPDATE autos SET disponibilidad=0 WHERE placa=?; ");
						$query->bind_param("s", $isbn);
						$query->execute();	

						
						$query = $con->prepare("SELECT due_date FROM book_issue_log WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $member, $isbn);
						$query->execute();
						$due_date = mysqli_fetch_array($query->get_result())[0];
						$message = "El carro con placa ".$isbn." ha sido emitido a su cuenta.";


						//update estado de solicitud
						$query = $con->prepare("UPDATE pending_book_requests SET estado='Aprobada' WHERE request_id=?; ");
						$query->bind_param("d", $request_id);
						$query->execute();

						
						//ESTE ES LA LINEA QUE EJECUTA EL MENSAJE
						@mail($to, $subject, $message, $header);
						
					}
				}
				if($requests > 0)
					echo success("Solicitud aceptada ".$requests." solicitud");
				else
					echo error_without_field("Ninguna solicitud seleccionada");
			}
			
			if(isset($_POST['l_reject']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$requests++;
						$request_id =  $_POST['cb_'.$i];
						
						$query = $con->prepare("SELECT member, book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();
						$resultRow = mysqli_fetch_array($query->get_result());
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						
						$query = $con->prepare("SELECT email FROM member WHERE username = ?;");
						$query->bind_param("s", $member);
						$query->execute();
						$to = mysqli_fetch_array($query->get_result())[0];
						$subject = "Problema de carro rechazado";

						$query = $con->prepare("UPDATE autos SET disponibilidad=1 WHERE placa=?; ");
						$query->bind_param("s", $isbn);
						$query->execute();	
						$query = $con->prepare("DELETE FROM pending_book_requests WHERE request_id = ?");
						$query->bind_param("d", $request_id);

						if(!$query->execute())
							die(error_without_field("ERROR: No se pudieron eliminar los valores"));
						$message = "Su solicitud para rentar el auto de placas: ".$isbn." ha sido rechazado, comuniquese con el administrador para mas detalles";
	
						@mail($to, $subject, $message, $header);
					}
				}
				if($requests > 0)
					echo success("Exitósame eliminado ".$requests." registro");
				else
					echo error_without_field("Ninguna solicitud seleccionada");
			}