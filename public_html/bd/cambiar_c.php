<?php
	session_start();
	include_once 'conexion.php';

	$acon = $_POST['acon'];
	$ncon = $_POST['ncon'];
	$id_cuenta = $_POST['id'];

	$cuentas = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
	$res2 = $conn->query($cuentas);
	$val2 = $res2->fetch_row();
	
	if (password_verify($acon, $val2[3])) {
		$pass = password_hash($ncon, PASSWORD_DEFAULT);
		
		$sql= "UPDATE cuentas SET contraseña = '$pass' WHERE id_cuenta = '$id_cuenta'";
	    $res = $conn->query($sql);
		echo json_encode('cambiado');
	}else{
		echo json_encode('contraseña');
	}
?>