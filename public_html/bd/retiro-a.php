<?php
	session_start();
	include_once 'conexion.php';

    $id_cuenta = $_SESSION['datos']['id'];
	$id = $_GET['id'];
	
	$hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');
	
	$sqlwt = mysqli_query($conn, "SELECT id_cuenta FROM wallet_t WHERE id_transaccion = '$id'");
    $sqlwt = $sqlwt->fetch_row();
    $upt = mysqli_query($conn, "UPDATE wallet_t SET status = 'COMPLETED', adm = '$id_cuenta', fecha_d = '$hoys' WHERE id_transaccion = '$id'");
    
    $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('0','$sqlwt[0]','RetiroA','$id')");
    echo json_encode('aprobado');
?>