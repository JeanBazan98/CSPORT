<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
    $id_torneo = $_GET['id'];
    $pago = $_GET['p'];
    
	$wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id_cuenta'");
	$walletv = $wallet->fetch_row();

    if($walletv[1] >= $pago){
        $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - $pago WHERE id_cuenta = '$id_cuenta'");
        
        $unirse = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
    	$res = $conn->query($unirse);
    	$val = $res->fetch_assoc();
    
    	$unirse2 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
    	$res2 = $conn->query($unirse2);
    	$val2 = $res2->fetch_row();
    	$formato = $val2[7];
    
    	if ($val) {
    		echo json_encode('existe');
    	}else{
    		$ins = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
    		$i_res = $conn->query($ins);
    
    		$cont = 0;
    		$cont2 = 1;
    		while ($i_rows = mysqli_fetch_row($i_res)){
    			$cont = $cont + 1;
    			$cont2 = $cont2 + 1;
    		}
    
    		if ($cont >= $val2[8]) {
    			echo json_encode('lleno');
    		}else{
    			$registrar = "INSERT INTO r_torneos (id_torneo, id_cuenta, formato, nro) VALUES ('$id_torneo','$id_cuenta','$formato','$cont2')";
    			$sql = $conn->query($registrar);
    
    			$upd= "UPDATE torneos SET activo = '1' WHERE id = '$id_torneo'";
    			$u_res = $conn->query($upd);
    
    			echo json_encode('pagado');
    		}
    	}
    }else{
        echo json_encode('balance');
    }
    $conn -> close();
?>