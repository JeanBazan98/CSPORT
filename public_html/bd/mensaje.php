<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id_torneo'];
	$id_cuenta = $_SESSION['datos']['id'];
	$lver = $_GET['enf'];
	$id_cuenta = $_GET['id_cuenta'];
	$mensaje = $_POST['mensaje'];
	
	$hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');

    if (!preg_match("/^([a-zA-Z0-9 ])+([._-¿?¡!])+[^<>]/", $mensaje)) {
	    echo json_encode('error');
    }else{
        $msj = "INSERT INTO chat (id_torneo, id_cuenta, id_enfrentamiento, mensaje, fecha) VALUES ('$id_torneo','$id_cuenta','$lver','$mensaje','$hoys')";
    	$sql = $conn->query($msj);

        echo json_encode('enviado');
    }

	$conn -> close();
?>