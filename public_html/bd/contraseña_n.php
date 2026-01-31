<?php
	session_start();
	include_once 'conexion.php';

	$ncontra = $_POST['ncontra'];
	$rcontra = $_POST['rcontra'];
	
	$id_c = $_GET['id'];
	
	if (empty($ncontra) || empty($rcontra)) {
		echo json_encode('vacio');
	}else{
		$cuentas = "SELECT email FROM cuentas WHERE id_cuenta = '$id_c'";
		$res = $conn->query($cuentas);
		$val = $res->fetch_assoc();

		if ($ncontra == $rcontra) {
			if ($val) {
				$pass = password_hash($ncontra, PASSWORD_DEFAULT);
				$ncontraseña = "UPDATE cuentas SET contraseña = '$pass', code = '' WHERE id_cuenta = '$id_c'";
		        $sqlnc = $conn->query($ncontraseña);
		        
				echo json_encode('cambiado');
			}
		}else{
			echo json_encode('contraseña');
		}
	}

?>