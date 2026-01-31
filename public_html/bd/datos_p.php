<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_GET['id'];
	
	$sqlc = mysqli_query($conn, "SELECT telefono FROM cuentas WHERE id_cuenta = '$id'");
	$sqlcv = $sqlc->fetch_row();
	
	$pais = $_POST['pais'];
	$ciudad = $_POST['ciudad'];
	$nac = $_POST['nac'];
	$tel = $_POST['tel'];
	$telc = $_POST['telc'];
	$nyp = $_POST['nyp'];
	$paisc = $pais."/".$ciudad;
	$telt = '+'.$telc.' '.$tel;
	
	if($telc !== ''){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET pais_ciudad = '$paisc', año = '$nac', telefono = '$telt', nyp = '$nyp' WHERE id_cuenta = '$id'");
        echo json_encode('cambiado');
	}else{
	    $sql = mysqli_query($conn, "UPDATE cuentas SET pais_ciudad = '$paisc', año = '$nac', nyp = '$nyp' WHERE id_cuenta = '$id'");
        echo json_encode('cambiado');
	}
    
?>