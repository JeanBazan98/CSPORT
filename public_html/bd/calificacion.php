<?php
	session_start();
	include_once 'conexion.php';
	
    $id_cuenta = $_SESSION['datos']['id'];
	$id_t = $_GET['id'];
	
    if(isset($_GET['ticket'])){
        $ptsc = $_POST['ct'];
        $updtc = mysqli_query($conn, "UPDATE soporte SET calificacion = '$ptsc' WHERE id_soporte = '$id_t'");
        echo json_encode('calificado');
    }
	
	$conn -> close();
?>