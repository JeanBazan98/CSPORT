<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_POST['id'];
	
	if(isset($_GET['link'])){
	    $link = $_POST['link'];
	    $slqsti = mysqli_query($conn, "UPDATE publicidad SET link = '$link' WHERE id_pub = '$id'");
	    echo json_encode('aprobado');
	}
	if(isset($_GET['img'])){
	    //$slqsi = mysqli_query($conn, "UPDATE cuentas SET verificado = '$rol' WHERE id_cuenta = '$id'");
	    //echo json_encode('aprobado');
	}
	if(isset($_GET['eliminar'])){
	    $delete = $_POST['eliminar'];
	    $slqse = mysqli_query($conn, "DELETE FROM publicidad WHERE id_pub = '$delete'");
	    echo json_encode('aprobado');
	}
	$conn -> close();
?>