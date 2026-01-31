<?php
	session_start();
	include_once 'conexion.php';
	
	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$sql= "UPDATE torneos SET comienzo = '2' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>