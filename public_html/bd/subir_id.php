<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_SESSION['datos']['id'];
	
	$eaid = $_POST['ea'];
	$psnid = $_POST['psn'];
	$xboxid = $_POST['xbox'];
	$actid = $_POST['act'];
	$nbaid = $_POST['nba'];
	
	if($eaid !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET ea_id = '$eaid' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}if($psnid !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET psn_id = '$psnid' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}if($xboxid !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET xbox_id = '$xboxid' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}if($actid !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET act_id = '$actid' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}if($nbaid !== ""){
	    $sql = mysqli_query($conn, "UPDATE cuentas SET nba_id = '$nbaid' WHERE id_cuenta = '$id'");
	    echo json_encode('cambiado');
	}
	$conn -> close();
?>