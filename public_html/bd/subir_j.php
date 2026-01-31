<?php
	session_start();
	include_once 'conexion.php';

	$titulo = $_POST['titulo2'];
	$id_cuenta = $_SESSION['datos']['id'];
	$plataforma = $_POST['plataforma'];

	$juego = "SELECT nombre FROM juegos WHERE nombre = '$titulo'";
	$res = $conn->query($juego);
	$val = $res->fetch_assoc();
	if ($val) {
		header('Location: https://csport.es/administracion?error');
	}else{
		$carpeta = "../img/";
		$destino = $carpeta.$_FILES['imagen2']['name'];
		copy($_FILES['imagen2']['tmp_name'], $destino);
		$carpeta2 = "img/";
		$destino2 = $carpeta2.$_FILES['imagen2']['name'];

		if (move_uploaded_file($_FILES['imagen2']['tmp_name'], $destino)) {
			$subir = "INSERT INTO juegos (nombre, img, tipo) VALUES ('$titulo','$destino2','$plataforma')";
			$sql = $conn->query($subir);
			header('Location: https://csport.es/administracion');
		}else{
			header('Location: https://csport.es/administracion?error');
		}			
	}
	$conn -> close();
?>