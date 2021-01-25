<?php
	require "../db_connect.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>Bienvenido Administrador</title>
		<link rel="stylesheet" type="text/css" href="css/home_style.css" />
	</head>
	<body>
		<div id="allTheThings">
			<a href="pending_registrations.php">
				<input type="hidden" value="Solicitudes de Alquiler" />
			</a><br />
			<a href="pending_book_requests.php">
				<input type="button" value="Solicitudes de Alquileres" />
			</a><br />
			<a href="insert_book.php">
				<input type="button" value="Agregar un Nuevo Vehiculo" />
			</a><br />
			<a href="carros.php">
				<input type="button" value="Lista de Vehiculos" />
			</a><br />
			<a href="alquileres.php">
				<input type="button" value="Lista de Alquileres" />
			</a><br />
			<a href="update_copies.php">
				<input type="hidden" value="Actualizar el número de unidades de un carro" />
			</a><br />
			<a href="update_balance.php">
				<input type="hidden" value="Actualiza el saldo de un cliente" />
			</a><br />
			<a href="due_handler.php">
				<input type="hidden" value="Recordatorios para hoy" />
			</a><br /><br />
		</div>
	</body>
</html>