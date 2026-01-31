<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_SESSION['datos']['id'];
	$mensaje = $_POST['mensaje'];
	$tipo = $_POST['tipo'];
	
	$hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');

    if (!preg_match("/^([a-zA-Z0-9 ])+([._-¿?¡!])+[^<>]/", $mensaje)) {
	    echo json_encode('error');
    }else{
        $msj = "INSERT INTO chat (id_cuenta, mensaje, tipo, fecha) VALUES ('$id_cuenta','$mensaje','$tipo','$hoys')";
    	$sql = $conn->query($msj);

        echo json_encode('enviado');
    }

	$conn -> close();
?>