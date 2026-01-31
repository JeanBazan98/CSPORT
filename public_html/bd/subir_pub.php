<?php
	session_start();
	include_once 'conexion.php';
	$id = $_SESSION['datos']['id'];
	$link = $_POST['link'];
    
    $carpeta = "../img/";
	$destino = $carpeta.$_FILES['imagen']['name'];
	copy($_FILES['imagen']['tmp_name'], $destino);
	$carpeta2 = "img/";
	$destino2 = $carpeta2.$_FILES['imagen']['name'];

	if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
	    $update = mysqli_query($conn, "INSERT INTO publicidad (img, link) VALUES ('$destino2','$link')");
		header('Location: https://csport.es/administracion');
	}else{
		header('Location: https://csport.es/administracion?pub');
	}
	$conn -> close();
?>