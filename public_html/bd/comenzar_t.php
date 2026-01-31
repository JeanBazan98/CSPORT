<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];

	$sql = "UPDATE torneos SET comienzo = '1' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	$sql2 = "UPDATE torneos SET btn = '0' WHERE id = '$id_torneo'";
	$res2 = $conn->query($sql2);
    
    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>