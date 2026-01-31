<?php
	session_start();
	include_once 'conexion.php';
	
	if(isset($_SESSION['datos']['id'])){
    	$hoy = new DateTime();
    	$hoys = $hoy->format('Y-m-d H:i:s');
    	$id = $_SESSION['datos']['id'];
        if($status == 0){
            $slqs = mysqli_query($conn, "UPDATE cuentas SET status = '$hoys' WHERE id_cuenta = '$id'");
            echo json_encode('online');
        }
	}
	$conn -> close();
?>