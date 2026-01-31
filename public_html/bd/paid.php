<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_SESSION['datos']['id'];
	$orderID = $_POST['orderID'];
	$emailID = $_POST['emailID'];
	$statusID = $_POST['statusID'];
	$fechaID = $_POST['fechaID'];
	$tipoID = $_POST['tipoID'];
	$metodoID = $_POST['metodoID'];
	$saldoID = $_POST['saldoID'];
	
	$s_wallet = number_format($saldoID, 2, '.', ',');
	
    $sql = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, email, status, fecha, orden) VALUES ('$id','$tipoID','$s_wallet','$metodoID','$emailID','$statusID','$fechaID','$orderID')");
    $sql2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$s_wallet' WHERE id_cuenta = '$id'");
    

    echo json_encode('aprobado');
?>