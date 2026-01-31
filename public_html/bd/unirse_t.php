<?php
	session_start();
	include_once 'conexion.php';

    if(isset($_SESSION['datos'])){
        $id_torneo = $_GET['id'];
    	$id_cuenta = $_SESSION['datos']['id'];
    	
    	$sqltt = mysqli_query($conn, "SELECT inscripcion FROM torneos WHERE id = '$id_torneo'");
    	$sqlttv = $sqltt->fetch_row();
    	
        $sqltp = mysqli_query($conn, "SELECT id_notificacion FROM notificaciones WHERE (id_cuentar = '$id_cuenta' AND id = '$id_torneo' AND tipo = 'TorneoI') OR (id_cuentar = '$id_cuenta' AND id = '$id_torneo' AND tipo = 'TorneoIP')");
        $sqltpv = $sqltp->fetch_row();
        
        if((($sqlttv[0] == 2) || ($sqlttv[0] == 4)) && (isset($sqltpv))){
            $unirse = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
        	$res = $conn->query($unirse);
        	$val = $res->fetch_assoc();
        
        	$unirse2 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
        	$res2 = $conn->query($unirse2);
        	$val2 = $res2->fetch_row();
        	$formato = $val2[7];
        
        	if ($val) {
        		header('Location: https://csport.es/torneo?id='.$id_torneo.'');
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
        			header('Location: https://csport.es/torneo?id='.$id_torneo.'');
        		}else{
        			echo "reg";
        			$registrar = "INSERT INTO r_torneos (id_torneo, id_cuenta, formato, nro) VALUES ('$id_torneo','$id_cuenta','$formato','$cont2')";
        			$sql = $conn->query($registrar);
        
        			$upd= "UPDATE torneos SET activo = '1' WHERE id = '$id_torneo'";
        			$u_res = $conn->query($upd);
        
        			header('Location: https://csport.es/fixture/'.$id_torneo.'');
        		}
        	}
        }else{
            header('Location: https://csport.es/torneo/'.$id_torneo.'');
        }
        if(($sqlttv[0] == 0) || ($sqlttv[0] == 3)){
            $unirse = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$id_cuenta'";
        	$res = $conn->query($unirse);
        	$val = $res->fetch_assoc();
        
        	$unirse2 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
        	$res2 = $conn->query($unirse2);
        	$val2 = $res2->fetch_row();
        	$formato = $val2[7];
        
        	if ($val) {
        		header('Location: https://csport.es/torneo?id='.$id_torneo.'');
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
        			header('Location: https://csport.es/torneo?id='.$id_torneo.'');
        		}else{
        			echo "reg";
        			$registrar = "INSERT INTO r_torneos (id_torneo, id_cuenta, formato, nro) VALUES ('$id_torneo','$id_cuenta','$formato','$cont2')";
        			$sql = $conn->query($registrar);
        
        			$upd= "UPDATE torneos SET activo = '1' WHERE id = '$id_torneo'";
        			$u_res = $conn->query($upd);
        
        			header('Location: https://csport.es/fixture/'.$id_torneo.'');
        		}
        	}
        }else{
            header('Location: https://csport.es/torneo/'.$id_torneo.'');
        }
    }else{
        header('Location: https://csport.es/torneo/'.$id_torneo.'');
    }
	$conn -> close();
?>