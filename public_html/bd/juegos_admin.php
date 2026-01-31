<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_POST['id'];
	
	if(isset($_GET['titulo'])){
	    $titulo = $_POST['ti'];
	    $slqst = mysqli_query($conn, "UPDATE juegos SET nombre = '$titulo' WHERE id_juego = '$id'");
	    echo json_encode('aprobado');
	}
	if(isset($_GET['tipo'])){
	    $tipo = $_POST['tipo'];
	    $slqsti = mysqli_query($conn, "UPDATE juegos SET tipo = '$tipo' WHERE id_juego = '$id'");
	    echo json_encode('aprobado');
	}
	if(isset($_GET['img'])){
	    //$slqsi = mysqli_query($conn, "UPDATE cuentas SET verificado = '$rol' WHERE id_cuenta = '$id'");
	    //echo json_encode('aprobado');
	}
	if(isset($_GET['eliminar'])){
	    $delete = $_POST['eliminar'];
	    $slqse = mysqli_query($conn, "DELETE FROM juegos WHERE id_juego = '$delete'");
	    echo json_encode('aprobado');
	}
?>