<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id']; $id_cuenta = $_SESSION['datos']['id'];
	
	$sql = mysqli_query($conn, "SELECT id_cuenta FROM tablas WHERE (id_torneo = '$id_torneo' AND final = '1') OR (id_torneo = '$id_torneo' AND final = '2')");
	while($sqlv = mysqli_fetch_row($sql)){
	    $updatet = mysqli_query($conn, "UPDATE tablas SET ganador = '0' WHERE id_cuenta = '$sqlv[0]' AND id_torneo = '$id_torneo'");
	}

	$update = mysqli_query($conn, "UPDATE torneos SET l_jornada = '2' WHERE id = '$id_torneo'");
	$delete = mysqli_query($conn, "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final'");
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>