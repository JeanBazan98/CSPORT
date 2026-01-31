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
	$con22 = 1;
	while($sqlw = mysqli_fetch_row($sqlrC23)){
	    $id_cuenta2 = $_POST['id_c'.$con22];
	    
	    $registrar = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_cuenta2')";
	    $sql3 = $conn->query($registrar);
	    
	    $con2 = $con2 + 1;
	    $con22 = $con22 + 1;
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
    
    $sql2= "UPDATE torneos SET btn = '1' WHERE id = '$id_torneo'";
	$res2 = $conn->query($sql2);
		
	$conn -> close();
    header('Location: https://csport.es/fixture/'.$id_torneo.'&e='.$id_equipo.'');
?>