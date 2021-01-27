<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../header.php";
?>

<html>
<script>
		function sololetras(e){
			key = e.keyCode||e.which;
			teclado= String.fromCharCode(key).toLowerCase();
			letras=" abcdefghijklmnopqrstuvwxyz";
			especiales="8-37-38-46-164";
			teclado_especial=false;
			for(var i in especiales){
				if(key==especiales[i]){
					teclado_especial=true;break;
				}
			}
			if(letras.indexOf(teclado)==-1 && !teclado_especial){
				return false;
			}

		}
	</script>
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
					<input class="m-pass" type="password" name="m_pass" minlength="8" maxlength="15" placeholder="Contraseña minimo 8 caracteres"  required />
				</div>
				
				<div class="icon">
					<input class="m-name" type="text" onpaste="return false" name="m_name"  onkeypress="return sololetras(event)" placeholder="Nombre Completo" required />
				</div>
				
				<div class="icon">
					<input class="m-email" type="email" name="m_email" id="m_email" placeholder="Correo" required />
				</div>
				<div class="icon">
					<input class="" type="number" name="b_edad" placeholder="Ingrese su edad" max=100 min=0 required />
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
						$consult="'".$_POST['m_user']."' , '".($_POST['m_pass'])."' , '".$_POST['m_name']."' , '".$_POST['m_email']."','".$_POST['b_edad']."'";
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