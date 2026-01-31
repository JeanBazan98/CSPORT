<?php
	session_start();
	include_once 'conexion.php';

	$mensaje = $_POST['mensaje']; $id = $_GET['id'];
	$id_cuenta = $_POST['id_c'];
	
	$hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');

    if (!preg_match("/^([a-zA-Z0-9 ])+([._-¿?¡!])+[^<>]/", $mensaje)) {
	    echo json_encode('error');
    }else{
        $msj = "INSERT INTO chat (id_torneo, id_cuenta, id_enfrentamiento, mensaje, tipo, fecha) VALUES ('$id','$id_cuenta','1','$mensaje','Ticket','$hoys')";
	    $sql = $conn->query($msj);

        echo json_encode('enviado');
    }
	
	$conn -> close();
?>