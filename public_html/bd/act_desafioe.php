<?php
	session_start();
	include_once 'conexion.php';

	$gol_local = $_POST['local']; $gol_visitante = $_POST['visitante'];
	$id_torneo = $_GET['id']; $id_enf = $_GET['enf'];

    $desafio = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_torneo'");
    $desafiov = $desafio->fetch_row();

    $enf = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$id_torneo' AND tipo = 'Desafio' AND torneo = 'Vuelta'");
    $enfv = $enf->fetch_row();
    $enf2 = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$id_torneo' AND tipo = 'Desafio' AND torneo = 'Ida'");
    $enfv2 = $enf2->fetch_row();
    $enf3 = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$id_torneo' AND tipo = 'Desafio' AND torneo = 'Oro'");
    $enfv3 = $enf3->fetch_row();
    
    $hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');
	            
    if ($desafiov[9] == '5') {
		$montodec = "3";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '10') {
		$montodec = "6";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '20') {
		$montodec = "12";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '30') {
		$montodec = "18";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '50') {
		$montodec = "30";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '80') {
		$montodec = "48";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '100') {
		$montodec = "60";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
	if ($desafiov[9] == '200') {
		$montodec = "120";
		$gncp = ($montodec + $montodec) - $desafiov[9];
	}
        		
	if($desafiov[8] == 'Vuelta'){
	    if($enfv3[0] == $id_enf){
	        if ($gol_local > $gol_visitante) {
    	    	$sqld3 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv3[1]' WHERE id_desafio = '$id_torneo'");
    	    	$walletd = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $desafiov[9] WHERE id_cuenta = '$enfv3[1]'");
    	    	
    	    	$ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, status) VALUES ('$enfv3[1]','Desafio','$desafiov[9]','$id_torneo','$hoys','COMPLETED')");
                $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden, status) VALUES ('0','Plataforma','$gncp','$id_torneo','$hoys','Desafio','COMPLETED')");
    	    }
    	    if ($gol_local < $gol_visitante) {
    		    $sqld4 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv3[2]' WHERE id_desafio = '$id_torneo'");
    		    $walletd = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $desafiov[9] WHERE id_cuenta = '$enfv3[2]'");
    		    
    		    $ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, status) VALUES ('$enfv3[2]','Desafio','$desafiov[9]','$id_torneo','$hoys','COMPLETED')");
                $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden, status) VALUES ('0','Plataforma','$gncp','$id_torneo','$hoys','Desafio','COMPLETED')");
    	    }
	    }else{
	        if($enfv[0] == $id_enf){
        	    if (($enfv[3] + $enfv2[4]) > ($enfv[4] + $enfv2[3])) {
            		if(($enfv[10] == 1) || ($enfv2[10] == 1)){
            		    if($gol_local > $gol_visitante){}else{
            		        $sqld1 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv[2]' WHERE id_desafio = '$id_torneo'");
            		        $walletd2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$desafiov[9]' WHERE id_cuenta = '$enfv[2]'");
            		        $walletd3 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - '$desafiov[9]' WHERE id_cuenta = '$enfv[1]'");
            		        
            		        $ganano = mysqli_query($conn, "UPDATE wallet_t SET id_cuenta = '$enfv[2]' WHERE tipo = 'Desafio' AND metodo = '$id_torneo'");
            		    }
            		}
            	}
            	if (($enfv[3] + $enfv2[4]) < ($enfv[4] + $enfv2[3])) {
                    if(($enfv[10] == 1) || ($enfv2[10] == 1)){
                        if($gol_local < $gol_visitante){}else{
            		        $sqld1 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv[1]' WHERE id_desafio = '$id_torneo'");
            		        $walletd2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$desafiov[9]' WHERE id_cuenta = '$enfv[1]'");
            		        $walletd3 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - '$desafiov[9]' WHERE id_cuenta = '$enfv[2]'");
            		        
            		        $ganano = mysqli_query($conn, "UPDATE wallet_t SET id_cuenta = '$enfv[1]' WHERE tipo = 'Desafio' AND metodo = '$id_torneo'");
            		    }
            		}
            	}
            	if(($enfv[3] + $enfv2[4]) == ($enfv[4] + $enfv2[3])) {
            	    $sql2dc1 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_torneo','0','RESULTADO GLOBAL QUEDO EN EMPATE - SE DEFINE POR UN 3ER PARTIDO | POR GOL DE ORO')");
            	    $rnd = rand(1,2);
            	    if($rnd == 1){ $sorteo = $enfv2[1]; $sorteo2 = $enfv2[2];
            	    }else{ $sorteo = $enfv2[2]; $sorteo2 = $enfv2[1]; }
            	    $sqlcs = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sorteo'");
            	    $sqlcsv = $sqlcs->fetch_row();
            	    $sql2dc2 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_torneo','0','3ER PARTIDO LO CREA: $sqlcsv[0]')");
            	    $sql2c = mysqli_query($conn, "INSERT INTO enfrentamientos (id_local, id_visitante, torneo, grupo, tipo) VALUES ('$sorteo','$sorteo2','Oro','$id_torneo','Desafio')");
            	}
    	    }
	    }
	}
	if($desafiov[8] == 'Ida'){
	    if($enfv3[0] == $id_enf){
	        if ($gol_local > $gol_visitante) {
    	    	$sqld3 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv3[1]' WHERE id_desafio = '$id_torneo'");
    	    	$walletd = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $desafiov[9] WHERE id_cuenta = '$enfv3[1]'");
    	    	
    	    	$ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, status) VALUES ('$enfv3[1]','Desafio','$desafiov[9]','$id_torneo','$hoys','COMPLETED')");
                $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden, status) VALUES ('0','Plataforma','$gncp','$id_torneo','$hoys','Desafio','COMPLETED')");
    	    }
    	    if ($gol_local < $gol_visitante) {
    		    $sqld4 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv3[2]' WHERE id_desafio = '$id_torneo'");
    		    $walletd = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + $desafiov[9] WHERE id_cuenta = '$enfv3[2]'");
    		    
    		    $ganano = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, status) VALUES ('$enfv3[2]','Desafio','$desafiov[9]','$id_torneo','$hoys','COMPLETED')");
                $ganacp = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, fecha, orden, status) VALUES ('0','Plataforma','$gncp','$id_torneo','$hoys','Desafio','','COMPLETED')");
    	    }
	    }else{
	        if($enfv2[0] == $id_enf){
        	    if ($enfv2[3] > $enfv2[4]) {
        	        if($gol_local > $gol_visitante){}else{
        		        $sqld1 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv2[1]' WHERE id_desafio = '$id_torneo'");
        		        $walletd2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$desafiov[9]' WHERE id_cuenta = '$enfv2[1]'");
        		        $walletd3 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - '$desafiov[9]' WHERE id_cuenta = '$enfv2[2]'");
        		        
        		        $ganano = mysqli_query($conn, "UPDATE wallet_t SET id_cuenta = '$enfv2[1]' WHERE tipo = 'Desafio' AND metodo = '$id_torneo'");
        		    }
            	}
            	if ($enfv2[3] < $enfv2[4]) {
            	    if($gol_local > $gol_visitante){}else{
        		        $sqld1 = mysqli_query($conn, "UPDATE desafio SET ganador = '$enfv2[2]' WHERE id_desafio = '$id_torneo'");
        		        $walletd2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$desafiov[9]' WHERE id_cuenta = '$enfv2[2]'");
        		        $walletd3 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - '$desafiov[9]' WHERE id_cuenta = '$enfv2[1]'");
        		        
        		        $ganano = mysqli_query($conn, "UPDATE wallet_t SET id_cuenta = '$enfv2[2]' WHERE tipo = 'Desafio' AND metodo = '$id_torneo'");
        		    }
            	}
            	if($enfv2[3] == $enfv2[4]) {
            	    $sql2dc1 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_torneo','0','RESULTADO GLOBAL QUEDO EN EMPATE - SE DEFINE POR UN 3ER PARTIDO | POR GOL DE ORO')");
            	    $rnd = rand(1,2);
            	    if($rnd == 1){ $sorteo = $enfv2[1]; $sorteo2 = $enfv2[2];
            	    }else{ $sorteo = $enfv2[2]; $sorteo2 = $enfv2[1]; }
            	    $sqlcs = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sorteo'");
            	    $sqlcsv = $sqlcs->fetch_row();
            	    $sql2dc2 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_torneo','0','3ER PARTIDO LO CREA: $sqlcsv[0]')");
            	    $sql2c = mysqli_query($conn, "INSERT INTO enfrentamientos (id_local, id_visitante, torneo, grupo, tipo) VALUES ('$sorteo','$sorteo2','Oro','$id_torneo','Desafio')");
            	}
    	    }
	    }
	}

	$goles = mysqli_query($conn, "UPDATE enfrentamientos SET gol_local = '$gol_local', gol_visitante = '$gol_visitante', tabla = '1' WHERE tipo = 'Desafio' AND id_enfrentamiento = '$id_enf'");
	
	$conn -> close();
	header('Location: https://csport.es/desafio/'.$id_torneo.'');
?>