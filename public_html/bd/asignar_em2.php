<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_equipo = $_GET['e'];
	
	
	$sqleC2 = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' ORDER BY id_rtorneos ASC";
	$sqlrC2 = $conn->query($sqleC2);
	$sqlw = mysqli_fetch_row($sqlrC2);
	
	$sqleC23 = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' ORDER BY id_rtorneos ASC";
	$sqlrC23 = $conn->query($sqleC23);
	$con2 = 0;
	while($sqlw = mysqli_fetch_row($sqlrC23)){
	    $con2 = $con2 + 1;
	}
	
	
	$x = 0;
	
    while($x <= $con2){
        $equipo = $_POST['titulo_a'.$x];
        $id_cuenta = $_POST['id_c'.$x];
        
        $sqlec = "SELECT * FROM cuentas WHERE id_cuenta = '$sqlw[1]'";
	    $sqlrc = $conn->query($sqlec);
	    $sqlvc = $sqlrc->fetch_row();

	    $sql= "UPDATE r_torneos SET equipo = '$equipo' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
	    $res = $conn->query($sql);
		
	    $x = $x + 1;
    }
    
    $conn -> close();
    header('Location: https://csport.es/bd/grupo_enfrentamiento.php?id='.$id_torneo.'&c='.$id_cuenta.'');
?>