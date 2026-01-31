<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_SESSION['datos']['id'];
	$id_t = $_GET['id']; $mensaje = "Tu ticket se cerro con exito! Califica la atencion para archivar este ticket.";
	
    $updt = mysqli_query($conn, "UPDATE soporte SET status = '1', chat = '1' WHERE id_soporte = '$id_t'");
    $msj = "INSERT INTO chat (id_torneo, id_cuenta, id_enfrentamiento, mensaje, tipo, fecha) VALUES ('$id_t','-1','1','$mensaje','Ticket','$hoys')";
	    $sql = $conn->query($msj);
	    
    echo json_encode('cerrado');
	$conn -> close();
?>