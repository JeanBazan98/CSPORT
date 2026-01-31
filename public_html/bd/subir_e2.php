<?php
	session_start();
	include_once 'conexion.php';

	$nombre = $_POST['nombree'];

	$subir = "INSERT INTO equipos_t (titulo) VALUES ('$nombre')";
	$sql = $conn->query($subir);
			
	header('Location: https://csport.es/administracion?adm');
?>