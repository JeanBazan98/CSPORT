<?php
	session_start();
	include_once 'conexion.php';

    if(isset($_SESSION['datos'])){
        $id_torneo = $_GET['id'];
    	$grupo = $_POST['grupo'];
    	$jgdr = $_POST['jgdr'];
    
        $ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
    	$ti_res = $conn->query($ti_torneo);
    	$ti_row = $ti_res->fetch_row();
    
    	$grupos = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = '$grupo'";
    	$res_g = $conn->query($grupos);
    	$cont = 0;
    	
    	while ($val_g = mysqli_fetch_row($res_g)) {
    		$cont = $cont + 1;
    	}if ($cont >= ($ti_row[8]/$ti_row[19])) {
    		echo json_encode('lleno');
    	}else{
    		$grupos2 = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$jgdr'";
    		$res_g2 = $conn->query($grupos2);
    		$val_g2 = $res_g2->fetch_assoc();
    		if (($val_g2) || ($val2[2] == $jgdr)) {
    		    echo json_encode('grupo');
    		}else{
    			$registrar = "INSERT INTO t_ligas (id_torneo, id_cuenta, grupo) VALUES ('$id_torneo','$jgdr','$grupo')";
    			$sql = $conn->query($registrar);
    			echo json_encode('agregado');
    		}
    	}
    }
    $conn -> close();
?>