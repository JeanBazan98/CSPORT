<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
	$d = $_GET['d'];
	
	$dsql = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$d'");
	$dsqlv = $dsql->fetch_row();
	
	if($dsqlv[9] == 5){
	    $wallet_c = 3;
	}if($dsqlv[9] == 10){
	    $wallet_c = 6;
	}if($dsqlv[9] == 20){
	    $wallet_c = 12;
	}if($dsqlv[9] == 30){
	    $wallet_c = 18;
	}if($dsqlv[9] == 50){
	    $wallet_c = 30;
	}if($dsqlv[9] == 80){
	    $wallet_c = 48;
	}if($dsqlv[9] == 100){
	    $wallet_c = 60;
	}if($dsqlv[9] == 200){
	    $wallet_c = 120;
	}

    $wslq = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$wallet_c' WHERE id_cuenta = '$dsqlv[1]'");
    $wslq2 = mysqli_query($conn, "DELETE FROM notificaciones WHERE id_cuenta = '$dsqlv[1]' AND id_cuentar = '$id_cuenta' AND tipo = 'Desafio'");
    $wslq3 = mysqli_query($conn, "DELETE FROM desafio WHERE id_desafio = '$d'");
    
    header('Location: https://csport.es/buscador');
?>