<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../verify_logged_out.php";
	require "../header.php";
?>

<html>
	<head>
		<title>Ingreso de Miembro</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" type="text/css" href="css/index_style.css">
	</head>
	<body>
		<form class="cd-form" method="POST" action="#">
		
			<legend>Ingrese su nombre de usuario</legend>
			
			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
			
			<div class="icon">
				<input class="m-user" type="text" name="m_userR" placeholder="Usuario" required />
			</div>
			<input type="submit" value="Eviar" name="clave_R" />
			<br /><br /><br /><br />
		</form>
		<?php
			if(isset($_POST['clave_R']))
			{
				$usu=$_POST['m_userR'];
				$query = $con->prepare("SELECT email FROM member WHERE username = '".$usu."';");
				$query->execute();
				$result = $query->get_result();
				$email = mysqli_fetch_array($result)[0];
				$rows = mysqli_num_rows($result);
				if($rows == 0){
					echo error_without_field("ERROR: El usuario ingresado no existe");
				}else
				{
					$header = 'From: <grupo4@alquiler.com>' . "\r\n";
					$nueva=rand(100, 999);
					$nueva=$nueva."";
					echo($nueva);
					$consulta="'".$nueva."' WHERE username = '".$_POST['m_userR']."'";
					$query = $con->prepare("UPDATE member SET password = ".$consulta.";");
					if(!$query->execute())
						die(error_without_field("ERROR: No se pudo procesar su petición"));
					$to = $email."";
					$subject = "Recuperacion de clave";
					$message = "Estimado usuario, esta clave: ".$nueva." es temporal, debe cambiarla de inmediato.";
					mail($to, $subject, $message, $header);
					echo success("Se ha envido una nueva clave su correo electrónico, por favor cambiarla de inmediato");	
				}							
			}
		?>
	</body>
	
</html>