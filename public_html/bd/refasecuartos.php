<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id']; $id_cuenta = $_SESSION['datos']['id'];
	
	$delete = mysqli_query($conn, "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Semis'");
	$update = mysqli_query($conn, "UPDATE torneos SET l_jornada = '3' WHERE id = '$id_torneo'");
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>