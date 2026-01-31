<?php
	session_start();
	include_once 'conexion.php';

    $id_cuenta = $_SESSION['datos']['id'];
	$njugador = $_POST['nombre'];
	$id_torneo = $_GET['id'];
	$jugadorA = $_GET['u'];
	
	$sqlct = mysqli_query($conn, "SELECT id_cuenta FROM torneos WHERE id = '$id_torneo'");
	$sqlctV = $sqlct->fetch_row();
	$sqlc = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email = '$njugador'");
	$sqlcV = $sqlc->fetch_row();
	$sql = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlcV[0]'");
	$sqlV = $sql->fetch_row();
	$sqlnt = mysqli_query($conn, "SELECT * FROM notificaciones WHERE tipo = 'TorneoR' AND id_cuentar = '$sqlcV[0]'");
	$sqlntV = $sqlnt->fetch_row();
	$sqlnt2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE tipo = 'TorneoRP' AND id_cuentar = '$sqlcV[0]'");
	$sqlntV2 = $sqlnt2->fetch_row();
	if(!$sqlcV){
    	echo json_encode('email');
	}else{
	    if($sqlV){
	        echo json_encode('registrado');
	    }else{
	        if(($sqlntV) || ($sqlntV2)){
	            echo json_encode('invitacion');
	        }else{
    	        $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('$jugadorA','$sqlcV[0]','TorneoR','$id_torneo')");
        	    echo json_encode('agregado');
	        }
	    }
	}
?>