<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$grupo = $_GET['g'];
	$id_cuenta = $_SESSION['datos']['id'];

    if(isset($_SESSION['datos'])){
        $unirse = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
    	$res = $conn->query($unirse);
    
    	$unirse2 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
    	$res2 = $conn->query($unirse2);
    	$val2 = $res2->fetch_row();
    
    	$grupos = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = '$grupo'";
    	$res_g = $conn->query($grupos);
    	$cont = 0;
    	while ($val_g = mysqli_fetch_row($res_g)) {
    		$cont = $cont + 1;
    	}if ($cont >= ($val2[8]/$val2[19])) {
    		header('Location: https://csport.es/fixture?id='.$id_torneo.'&c='.$id_cuenta.'');
    	}else{
    		$grupos2 = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
    		$res_g2 = $conn->query($grupos2);
    		$val_g2 = $res_g2->fetch_assoc();
    		if (($val_g2) || ($val2[2] == $id_cuenta)) {
    			header('Location: https://csport.es/fixture?id='.$id_torneo.'&c='.$id_cuenta.'');
    		}else{
    			$registrar = "INSERT INTO t_ligas (id_torneo, id_cuenta, grupo) VALUES ('$id_torneo','$id_cuenta','$grupo')";
    			$sql = $conn->query($registrar);
    			header('Location: https://csport.es/fixture/'.$id_torneo.'');
    		}
    	}
    }
	$conn -> close();
?>