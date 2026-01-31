<?php
	session_start();
	include_once 'conexion.php';
	
	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$limit = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$limitr = $conn->query($limit);
	$limitv = $limitr->fetch_row();
    
    if($limitv[16] == 2){
        
        $registrar = "DELETE FROM tablas WHERE id_torneo = '$id_torneo'";
	    $sql3 = $conn->query($registrar);
	    $registrar2 = "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final'";
	    $sql32 = $conn->query($registrar2);
        
    }if($limitv[16] == 4){
        
        $registrar = "DELETE FROM tablas WHERE id_torneo = '$id_torneo'";
	    $sql3 = $conn->query($registrar);
	    $registrar2 = "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Semis'";
	    $sql32 = $conn->query($registrar2);
    	
    }if($limitv[16] == 8){
        
        $registrar = "DELETE FROM tablas WHERE id_torneo = '$id_torneo'";
	    $sql3 = $conn->query($registrar);
	    $registrar2 = "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Cuartos'";
	    $sql32 = $conn->query($registrar2);
    	
    }if($limitv[16] == 16){
        
        $registrar = "DELETE FROM tablas WHERE id_torneo = '$id_torneo'";
	    $sql3 = $conn->query($registrar);
	    $registrar2 = "DELETE FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Octavos'";
	    $sql32 = $conn->query($registrar2);
    	
    }
	
	$sql= "UPDATE torneos SET comienzo = '1', l_jornada = '1' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>