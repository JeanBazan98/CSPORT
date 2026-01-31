<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_GET['id_cuenta'];
    
	$juego = $_POST['juego'];
	$premio = $_POST['monto']; $incognito = $_POST['incognito'];
	$tiempos = $_POST['tiempos'];
	$plantilla = $_POST['plantilla']; $encuentro = $_POST['encuentro'];
	$equipos = "Desafio";
	$hoy = new DateTime();
	$hoys = $hoy->format('Y-m-d H:i:s');
	            
	$wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id_cuenta'");
	$walletv = $wallet->fetch_row();
	
	$juegoc = $juego;
	
	if($premio == 5){
	    $wallet_c = 3;
	}if($premio == 10){
	    $wallet_c = 6;
	}if($premio == 20){
	    $wallet_c = 12;
	}if($premio == 30){
	    $wallet_c = 18;
	}if($premio == 50){
	    $wallet_c = 30;
	}if($premio == 80){
	    $wallet_c = 48;
	}if($premio == 100){
	    $wallet_c = 60;
	}if($premio == 200){
	    $wallet_c = 120;
	}
    
    if($walletv[1] >= $wallet_c){
        if($incognito == "true"){
            $sql = mysqli_query($conn, "INSERT INTO desafio (id_cuenta, juego, tiempos, controles, vjuego, plantilla, encuentro, premio, oculto, fecha) VALUES ('$id_cuenta','$juegoc','$tiempos','Cualquiera','Normal','$plantilla','$encuentro','$premio','1','$hoys')");
            $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - $wallet_c WHERE id_cuenta = '$id_cuenta'");
            echo json_encode('subiendo');
        }else{
            $sql = mysqli_query($conn, "INSERT INTO desafio (id_cuenta, juego, tiempos, controles, vjuego, plantilla, encuentro, premio, oculto, fecha) VALUES ('$id_cuenta','$juegoc','$tiempos','Cualquiera','Normal','$plantilla','$encuentro','$premio','0','$hoys')");
            $sqlb = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - $wallet_c WHERE id_cuenta = '$id_cuenta'");
            echo json_encode('subiendo');
        }
    }else{
        echo json_encode('balance');
    }
    $conn -> close();
?>