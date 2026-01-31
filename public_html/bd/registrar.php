<?php
	session_start();
	include_once 'conexion.php';

	$nombre = $_POST['nombre'];
	$email = $_POST['email'];
	$contraseña = $_POST['contraseña'];
	$contraseña2 = $_POST['contraseña2'];	

	if (empty($nombre) || empty($email) || empty($contraseña) || empty($contraseña2)) {
		echo json_encode('vacio');
	}else{
		$cuentas = "SELECT email FROM cuentas WHERE email = '$email'";
		$res = $conn->query($cuentas);
		$val = $res->fetch_assoc();
		
		$cuentasn = "SELECT email FROM cuentas WHERE nombre = '$nombre'";
		$resn = $conn->query($cuentasn);
		$valn = $resn->fetch_assoc();

		if ($contraseña == $contraseña2) {
			if ($val) {
				echo json_encode('email');
			}else{
			    if ($valn) {
    				echo json_encode('nombre');
    			}else{
    				$pass = password_hash($contraseña, PASSWORD_DEFAULT);
    				$registrar = "INSERT INTO cuentas (nombre, email, contraseña, verificado, img) VALUES ('$nombre','$email','$pass','0','img/cuenta/default.jpg')";
    				$sql = $conn->query($registrar);
    
    				$cuentas2 = "SELECT id_cuenta FROM cuentas WHERE email = '$email'";
    				$res2 = $conn->query($cuentas2);
    				$val2 = $res2->fetch_array();
    				
    				$wallet = "INSERT INTO wallet (id_cuenta) VALUES ('$val2[0]')";
    				$sql_w = $conn->query($wallet);
    
    				$datos = array('id' => $val2[0],'nombre' => $nombre,'email' => $email);
    				$_SESSION['datos'] = $datos;
    				echo json_encode('iniciando');
    			}
			}
		}else{
			echo json_encode('contraseña');
		}
	}
?>