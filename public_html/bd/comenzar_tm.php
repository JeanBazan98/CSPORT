<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];

	$sql = "UPDATE torneos SET comienzo = '1', l_jornada = '1' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	
	$r_torneo = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
	$r_res = $conn->query($r_torneo);
	
	while ($f_cont = mysqli_fetch_row($r_res)) {
		$registrar = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$f_cont[0]','$f_cont[1]')";
		$sql3 = $conn->query($registrar);		
	}
    
    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>