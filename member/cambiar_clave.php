<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";
	require "header_member.php";
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
		
			<legend>Ingrese su nueva clave</legend>
			
			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
            '<script>
					document.getElementById("error").innerHTML = "Se cerrará sesión cuando se haya cambiado su clave";
					document.getElementById("error-message").className = "success-message";
			</script>; 
			<div class="icon">
				<input class="m-pass" type="password" name="m_passC" minlength="8" maxlength="15" placeholder="Contraseña minimo 8 caracteres" placeholder="Contraseña" required />
			</div>
			<input type="submit" value="Eviar" name="clave_C" />
			<br /><br /><br /><br />
		</form>
		<?php
			if(isset($_POST['clave_C']))
			{
              
                $usuar=$_SESSION['username'];
                $nueva=$_POST['m_passC'];
                $consulta="'".$nueva."' WHERE username = '".$usuar."'";
                $query = $con->prepare("UPDATE member SET password = ".$consulta.";");
                if(!$query->execute())
                    die(error_without_field("ERROR: No se pudo cambiar su clave"));
  
                sleep(4);
                header("Location: ../logout.php");
                    
                                                  
            }

            
		?>
        
	</body>
	
</html>