<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_SESSION['datos']['id'];
	$id_torneo = $_GET['d'];

	$goles = mysqli_query($conn, "UPDATE desafio SET auditado = '$id_cuenta' WHERE id_desafio = '$id_torneo'");
	
	$conn -> close();
	header('Location: https://csport.es/desafio/'.$id_torneo.'');
?>