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
				<input type="button" value="Solicitudes de Registro de Clientes Pendientes" />
			</a><br />
			<a href="pending_book_requests.php">
				<input type="button" value="Solicitudes de Carros Pendientes" />
			</a><br />
			<a href="insert_book.php">
				<input type="button" value="Agregar un Nuevo Carro" />
			</a><br />
			<a href="update_copies.php">
				<input type="button" value="Actualizar el número de unidades de un carro" />
			</a><br />
			<a href="update_balance.php">
				<input type="button" value="Actualiza el saldo de un cliente" />
			</a><br />
			<a href="due_handler.php">
				<input type="button" value="Recordatorios para hoy" />
			</a><br /><br />
		</div>
	</body>
</html>