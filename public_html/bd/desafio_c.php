<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
    $id_enf = $_GET['id_enf'];
    
	$wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id_cuenta'");
	$walletv = $wallet->fetch_row();
	$desafio = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_enf'");
	$desafiov = $desafio->fetch_row();

	if($desafiov[9] == 5){
	    $wallet_c = 3;
	}if($desafiov[9] == 10){
	    $wallet_c = 6;
	}if($desafiov[9] == 20){
	    $wallet_c = 12;
	}if($desafiov[9] == 30){
	    $wallet_c = 18;
	}if($desafiov[9] == 50){
	    $wallet_c = 30;
	}if($desafiov[9] == 80){
	    $wallet_c = 48;
	}if($desafiov[9] == 100){
	    $wallet_c = 60;
	}if($desafiov[9] == 200){
	    $wallet_c = 120;
	}
    
    if($walletv[1] >= $wallet_c){
        $sql = mysqli_query($conn, "UPDATE desafio SET id_visitante = '$id_cuenta', status = '1' WHERE id_desafio = '$id_enf'");
        if($desafiov[8] == "Vuelta"){
            $sql2c = mysqli_query($conn, "INSERT INTO enfrentamientos (id_local, id_visitante, torneo, grupo, tipo) VALUES ('$desafiov[1]','$id_cuenta','Ida','$desafiov[0]','Desafio')");
            $sql2d = mysqli_query($conn, "INSERT INTO enfrentamientos (id_local, id_visitante, torneo, grupo, tipo) VALUES ('$id_cuenta','$desafiov[1]','Vuelta','$desafiov[0]','Desafio')");

            $sql2dc = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_enf','0','REGLAS POR IDA Y VUELTA')");
            $sql2dc1 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_enf','0','EL CREADOR DEL DESAFIO ENVIA INVITACION DE PARTIDO IDA')");
            $sql2dc2 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_enf','0','EL RETADOR ENVIA INVITACION DE PARTIDO VUELTA')");
            
            $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('$id_cuenta','$desafiov[1]','DesafioA','$desafiov[0]')");
            
            $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - $wallet_c WHERE id_cuenta = '$id_cuenta'");
            echo json_encode('subiendo');
        }else{
            $sql2 = mysqli_query($conn, "INSERT INTO enfrentamientos (id_local, id_visitante, torneo, grupo, tipo) VALUES ('$desafiov[1]','$id_cuenta','$desafiov[8]','$desafiov[0]','Desafio')");
            
            $sql2dc2 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_enf','0','REGLAS POR IDA')");
            $sql2dc1 = mysqli_query($conn, "INSERT INTO chat (id_torneo, id_cuenta, mensaje) VALUES ('$id_enf','0','EL CREADOR DEL DESAFIO ENVIA INVITACION DE PARTIDO IDA')");
            
            $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('$id_cuenta','$desafiov[1]','DesafioA','$desafiov[0]')");
            
            $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - $wallet_c WHERE id_cuenta = '$id_cuenta'");
            echo json_encode('subiendo');
        }
    }else{
        echo json_encode('balance');
    }
?>