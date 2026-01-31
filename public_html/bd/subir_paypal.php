<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_SESSION['datos']['id'];
	$paypal = $_POST['paypal'];
	
	if($paypal !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET paypal = '$paypal' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}
	$conn -> close();
?>