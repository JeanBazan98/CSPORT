<?php
	session_start();
	include_once 'conexion.php';
	$id = $_SESSION['datos']['id'];
	$hoy = new DateTime();
    $hoys = $hoy->format('Y-m-d H:i:s');
            
    $code = $_POST['code'];
	$sqlcode = "SELECT * FROM cuentas WHERE id_cuenta = '$id'";
	$sqlcoder = $conn->query($sqlcode);
	$sqlcodev = $sqlcoder->fetch_array();

	if ($sqlcodev[6] == $code) {
		$sqlact= "UPDATE cuentas SET code = '', verificado = '1', fecha_c = '$hoys' WHERE id_cuenta = '$id'";
		$sqlactr = $conn->query($sqlact);
		echo json_encode('verificado');
	}else{
	    echo json_encode('error');
	}
	$conn -> close();
?>