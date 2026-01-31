<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	$hoy = new DateTime();
    $hoys = $hoy->format('Y-m-d H:i:s');
    	

    $upt = mysqli_query($conn, "UPDATE torneos SET comienzo = '4' WHERE id = '$id_torneo'");
    $sqlc = mysqli_query($conn, "SELECT id_cuenta,cant_ganadores,tipo,price,inscripcion,equipos FROM torneos WHERE id = '$id_torneo'");
    $sqlcv = $sqlc->fetch_row();
    
    $pricep = explode("/", $sqlcv[3]);
    
    $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('0','$sqlcv[0]','TAuditado','$id_torneo')");
    
    if(($sqlcv[1] == '3') && ($sqlcv[4] == '1')){
        $pmero = $pricep[1] * 0.50;
		$sgdo = $pricep[1] * 0.30;
		$tcro = $pricep[1] * 0.20;
    }
    if(($sqlcv[1] == '2') && ($sqlcv[4] == '1')){
        if($sqlcv[2] == 'Vuelta'){
            $enf_sql2 = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Vuelta'");
        	$sqlval2 = $enf_sql2->fetch_row();
            $enf_sql = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Ida'");
        	$sqlval = $enf_sql->fetch_row();
        	$id_gl = $sqlval2[0]; $id_gv = $sqlval2[1];
        	
        	$goles_l = $sqlval2['2'] + $sqlval['3'];
        	$goles_v = $sqlval2['3'] + $sqlval['2'];
        	
		    $pmero = $pricep[1] * 0.575; $sgdo = $pricep[1] * 0.425;
        	
        	if($goles_l >= $goles_v){
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$id_gl'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gl','Torneo','$pmero','$id_torneo','$hoys')");
        	    
        	    $sqlb2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $sgdo WHERE id_cuenta = '$id_gv'");
        	    $sqlntn2 = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gv','Torneo','$sgdo','$id_torneo','$hoys')");
        	}else{
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$id_gv'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gv','Torneo','$pmero','$id_torneo','$hoys')");
        	    
        	    $sqlb2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $sgdo WHERE id_cuenta = '$id_gl'");
        	    $sqlntn2 = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gl','Torneo','$sgdo','$id_torneo','$hoys')");
        	}
        }else{
            $enf_sql = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Ida'");
        	$sqlval = $enf_sql->fetch_row();
        	
        	if($sqlval[2] >= $sqlval[3]){
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$sqlval[0]'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[0]','Torneo','$pmero','$id_torneo','$hoys')");
        	    
        	    $sqlb2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $sgdo WHERE id_cuenta = '$sqlval[1]'");
        	    $sqlntn2 = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[1]','Torneo','$sgdo','$id_torneo','$hoys')");
        	}else{
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$sqlval[1]'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[0]','Torneo','$pmero','$id_torneo','$hoys')");
        	    
        	    $sqlb2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $sgdo WHERE id_cuenta = '$sqlval[0]'");
        	    $sqlntn2 = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[1]','Torneo','$sgdo','$id_torneo','$hoys')");
        	}
        }
        
        $sqlcp = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$sqlcv[0]'");
        $sqlcpv = $sqlcp->fetch_row();
        if($sqlcpv[0] == 2){
            $gnco = $pricep[0] * $sqlcv[5];
            $gncoT = $gnco * 0.35;
            $gncoT1 = $gncoT * 0.25;
            $gncoT2 = $gncoT * 0.75;
            $ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('0','Ganancias','$gncoT2','$id_torneo','$hoys')");
            $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden) VALUES ('0','Plataforma','$gncoT1','$id_torneo','$hoys','Torneo')");
        }else{
            $gnco = $pricep[0] * $sqlcv[5];
            $gncoT = $gnco * 0.35;
            $ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden) VALUES ('0','Plataforma','$gncoT','$id_torneo','$hoys','Torneo')");
        }
        
    }
    if(($sqlcv[1] == '1') && ($sqlcv[4] == '1')){
        if($sqlcv[2] == 'Vuelta'){
            $enf_sql2 = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Vuelta'");
        	$sqlval2 = $enf_sql2->fetch_row();
            $enf_sql = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Ida'");
        	$sqlval = $enf_sql->fetch_row();
        	$id_gl = $sqlval2[0]; $id_gv = $sqlval2[1];
        	
        	$goles_l = $sqlval2['2'] + $sqlval['3'];
        	$goles_v = $sqlval2['3'] + $sqlval['2'];
        	
		    $pmero = $pricep[1];
        	
        	if($goles_l >= $goles_v){
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$id_gl'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gl','Torneo','$pmero','$id_torneo','$hoys')");
        	}else{
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$id_gv'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$id_gv','Torneo','$pmero','$id_torneo','$hoys')");
        	}
        }else{
            $enf_sql = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Final' AND torneo = 'Ida'");
        	$sqlval = $enf_sql->fetch_row();
        	
        	if($sqlval[2] >= $sqlval[3]){
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$sqlval[0]'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[0]','Torneo','$pmero','$id_torneo','$hoys')");
        	}else{
        	    $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $pmero WHERE id_cuenta = '$sqlval[1]'");
        	    $sqlntn = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('$sqlval[0]','Torneo','$pmero','$id_torneo','$hoys')");
        	}
        }
        
        $sqlcp = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$sqlcv[0]'");
        $sqlcpv = $sqlcp->fetch_row();
        if($sqlcpv[0] == 2){
            $gnco = $pricep[0] * $sqlcv[5];
            $gncoT = $gnco * 0.40;
            $gncoT1 = $gncoT * 0.25;
            $gncoT2 = $gncoT * 0.75;
            $ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha) VALUES ('0','Ganancias','$gncoT2','$id_torneo','$hoys')");
            $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden) VALUES ('0','Plataforma','$gncoT1','$id_torneo','$hoys','Torneo')");
        }else{
            $gncoP = $pricep[0] * $sqlcv[5];
            $gncoTP = $gncoP * 0.40;
            $gananoP = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden) VALUES ('0','Plataforma','$gncoTP','$id_torneo','$hoys','Torneo')");
        }
    }
    echo json_encode('aprobado');
?>