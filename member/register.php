<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../header.php";
?>

<html>
	<head>
		<title>Registro</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" href="css/register_style.css">
	</head>
	<body>
		<form class="cd-form" method="POST" action="#">
			<legend>Ingresa tu información</legend>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="m-user" type="text" name="m_user" id="m_user" placeholder="Usuario" required />
				</div>
				
				<div class="icon">
					<input class="m-pass" type="password" name="m_pass" placeholder="Contraseña" required />
				</div>
				
				<div class="icon">
					<input class="m-name" type="text" name="m_name" placeholder="Nombre Completo" required />
				</div>
				
				<div class="icon">
					<input class="m-email" type="email" name="m_email" id="m_email" placeholder="Correo" required />
				</div>
				
				<br />
				<input type="submit" name="m_register" value="Registrarse" />
		</form>
	</body>
	
	<?php
		if(isset($_POST['m_register']))
		{
				$query = $con->prepare("(SELECT username FROM member WHERE username = ?) UNION (SELECT username FROM pending_registrations WHERE username = ?);");
				$query->bind_param("ss", $_POST['m_user'], $_POST['m_user']);
				$query->execute();
				if(mysqli_num_rows($query->get_result()) != 0)
					echo error_with_field("El nombre de usuario que ingresó ya está en uso", "m_user");
				else
				{
					$query = $con->prepare("(SELECT email FROM member WHERE email = ?) UNION (SELECT email FROM pending_registrations WHERE email = ?);");
					$query->bind_param("ss", $_POST['m_email'], $_POST['m_email']);
					$query->execute();
					if(mysqli_num_rows($query->get_result()) != 0)
						echo error_with_field("Ya hay una cuenta registrada con ese correo electrónico", "m_email");
					else
					{
						$consult="'".$_POST['m_user']."' , '".($_POST['m_pass'])."' , '".$_POST['m_name']."' , '".$_POST['m_email']."'";
						$query = $con->prepare("INSERT INTO pending_registrations VALUES(".$consult.");");
						//$query->bind_param("ssssd", $_POST['m_user'],($_POST['m_pass']), $_POST['m_name'], $_POST['m_email']);
						//echo($consult);
						if($query->execute())
							echo success("Datos registrados. Se le notificará en la ID de correo electrónico proporcionada cuando se hayan verificado sus datos");
						else
							echo error_without_field("No se pudieron registrar los detalles. Por favor, inténtelo de nuevo más tarde");
					}
				}
			
		}
	?>
	
</html>