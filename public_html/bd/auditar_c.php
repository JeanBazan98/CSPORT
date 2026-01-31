<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_SESSION['datos']['id'];
	$id_torneo = $_GET['t'];

	$goles = mysqli_query($conn, "UPDATE torneos SET auditado = '$id_cuenta', comienzo = '3' WHERE id = '$id_torneo'");
	
	$conn -> close();
	header('Location: https://csport.es/auditar?t='.$id_torneo.'');
?>