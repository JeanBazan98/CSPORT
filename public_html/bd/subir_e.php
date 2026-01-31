<?php
	session_start();
	include_once 'conexion.php';

	$titulo = $_POST['tituloe'];
	$nombre = $_POST['nombree'];
	$id_cuenta = $_SESSION['datos']['id'];

	$juego = "SELECT nombre FROM equipos WHERE nombre = '$nombre'";
	$res = $conn->query($juego);
	$val = $res->fetch_assoc();
	if ($val) {
		header('Location: https://csport.es/buscador?error');
	}else{
		$carpeta = "../img/equipos/";
		$destino = $carpeta.$_FILES['imagene']['name'];
		copy($_FILES['imagene']['tmp_name'], $destino);
		$carpeta2 = "img/equipos/";
		$destino2 = $carpeta2.$_FILES['imagene']['name'];

		if (move_uploaded_file($_FILES['imagene']['tmp_name'], $destino)) {
		    $juego2 = "SELECT * FROM equipos WHERE titulo = '$titulo' ORDER BY id_equipo DESC LIMIT 1";
	        $res2 = $conn->query($juego2);
        	$val2 = $res2->fetch_assoc();
		    if ($val2){
		        $nro = $val2['nro'] + 1;
		        $subir = "INSERT INTO equipos (titulo, img, nombre, nro) VALUES ('$titulo','$destino2','$nombre','$nro')";
			    $sql = $conn->query($subir);
		    }else{
		        $nro = 1;
		        $subir = "INSERT INTO equipos (titulo, img, nombre, nro) VALUES ('$titulo','$destino2','$nombre','$nro')";
			    $sql = $conn->query($subir);
		    }
			header('Location: https://csport.es/administracion?l='.$titulo);
		}else{
			header('Location: https://csport.es/administracion?config');
		}			
	}
?>