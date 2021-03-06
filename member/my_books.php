<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";
	require "header_member.php";
?>

<html>
	<head>
		<title>Mis Arrendamientos</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/my_books_style.css">
	</head>
	<body>
	
		<?php
			$query = $con->prepare("SELECT * FROM pending_book_requests WHERE member = ?;");
			$query->bind_param("s", $_SESSION['username']);
			$query->execute();
			$result = $query->get_result();
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No hay carros solicitados actualmente</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<legend>Mis Alquileres</legend>";
				echo "<div class='success-message' id='success-message'>
						<p id='success'></p>
					</div>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo"<table width='100%' cellpadding='10' cellspacing='10'>
						<tr>
							<th>Placa<hr></th>
							<th>Marca<hr></th>
							<th>Modelo<hr></th>
							<th>Categoría<hr></th>
							<th>Fecha<hr></th>
							<th>Estado<hr></th>
						</tr>";

				$num=0;

				for($i=0; $i<$rows; $i++)
				{
					$isbn = mysqli_fetch_array($result)[2];
					if($isbn != NULL)
					{
						$query = $con->prepare("SELECT * FROM autos WHERE placa = ?;");
						$query->bind_param("s", $isbn);
						$query->execute();
						$innerRow = mysqli_fetch_array($query->get_result());
						$num=$innerRow[0];
						echo "<tr>";
						/*echo "<td>
									<label class='control control--checkbox'>
										<input type='checkbox' name='cb_book".$i."' value='".$isbn."'>
										<div class='control__indicator'></div>
									</label>
								</td>";*/
						echo "<td>".$isbn."</td>";
						for($j=1; $j<4; $j++)
							echo "<td>".$innerRow[$j]."</td>";

						/*$query = $con->prepare("SELECT due_date FROM book_issue_log WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $_SESSION['username'], $isbn);
						$query->execute();*/

						$query = $con->prepare("SELECT time, estado FROM pending_book_requests WHERE member = ? ;");
						$query->bind_param("s", $_SESSION['username']);
						$query->execute();
						$time_estado=mysqli_fetch_array($query->get_result());

						echo "<td>".$time_estado[0]."</td>";
						echo "<td>".$time_estado[1]."</td>";
						echo "</tr>";
					}
				}
				echo "</table><br />";
				//echo "<input type='submit' name='b_return' value='Devolver el/los carros seleccionados' />";

				

				$query = $con->prepare("SELECT * FROM imagenphp WHERE id=? ;");
				$query->bind_param("i", $num);
				$query->execute();
				$fotos = $query->get_result();
				$phot = mysqli_fetch_array($fotos);
				echo "<img src='../librarian/".$phot['urlPhoto']."' width='500'>";





				echo "</form>";
			}
			
			if(isset($_POST['b_return']))
			{
				$books = 0;
				for($i=0; $i<$rows; $i++)
					if(isset($_POST['cb_book'.$i]))
					{
						$query = $con->prepare("SELECT due_date FROM book_issue_log WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $_SESSION['username'], $_POST['cb_book'.$i]);
						$query->execute();
						$due_date = mysqli_fetch_array($query->get_result())[0];
						
						$query = $con->prepare("SELECT DATEDIFF(CURRENT_DATE, ?);");
						$query->bind_param("s", $due_date);
						$query->execute();
						$days = (int)mysqli_fetch_array($query->get_result())[0];
						
						$query = $con->prepare("DELETE FROM book_issue_log WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $_SESSION['username'], $_POST['cb_book'.$i]);
						if(!$query->execute())
							die(error_without_field("ERROR: No pude devolver el/los carros "));
						
						if($days > 0)
						{
							$penalty = 3*$days;
							$query = $con->prepare("SELECT price FROM book WHERE isbn = ?;");
							$query->bind_param("s", $_POST['cb_book'.$i]);
							$query->execute();
							$price = mysqli_fetch_array($query->get_result())[0];
							if($price < $penalty)
								$penalty = $price;
							$query = $con->prepare("UPDATE member SET balance = balance - ? WHERE username = ?;");
							$query->bind_param("ds", $penalty, $_SESSION['username']);
							$query->execute();
							echo '<script>
									document.getElementById("error").innerHTML += "Un sancion de $ '.$penalty.' fue impuesto por retener tu libro '.$_POST['cb_book'.$i].' por '.$days.' días después del tiempo convenido de entrega.<br />";
									document.getElementById("error-message").style.display = "block";
								</script>';
						}
						$books++;
					}
				if($books > 0)
				{
					echo '<script>
							document.getElementById("success").innerHTML = "Proceso de devolución exitoso '.$books.' carros";
							document.getElementById("success-message").style.display = "block";
						</script>';
					$query = $con->prepare("SELECT balance FROM member WHERE username = ?;");
					$query->bind_param("s", $_SESSION['username']);
					$query->execute();
					
					$balance = (int)mysqli_fetch_array($query->get_result())[0];
					if($balance < 0)
						header("Location: ../logout.php");
				}
				else
					echo error_without_field("Por favor seleccione el carro a devolver");
			}
		?>
		
	</body>
</html>