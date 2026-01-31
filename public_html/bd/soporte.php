<?php
	include_once 'conexion.php';

    if(isset($_GET['olvidaste'])){
        $text = $_POST['text']; $tipo = $_POST['tipo']; $user = $_POST['user'];
    	$hoy = new DateTime();
        $hoys = $hoy->format('Y-m-d H:i:s');
        $usert = "0/".$user;
        
        if((isset($user)) && (isset($text))){
            $upt = mysqli_query($conn, "INSERT INTO soporte (id_cuenta, tipo, descripcion, fecha, status, calificacion) VALUES ('$usert','$tipo','$text','$hoys','0','0')");
            echo json_encode('aprobado');
        }else{
            header('Location: https://csport.es/soporte');
        }
    }
    if(isset($_GET['conoces'])){
        $text = $_POST['text']; $tipo = $_POST['tipo']; $user = $_POST['user'];
    	$hoy = new DateTime();
        $hoys = $hoy->format('Y-m-d H:i:s');
        $usert = "0/".$user;
        
        if((isset($user)) && (isset($text))){
            $upt = mysqli_query($conn, "INSERT INTO soporte (id_cuenta, tipo, descripcion, fecha, status, calificacion) VALUES ('$usert','$tipo','$text','$hoys','0','0')");
            echo json_encode('aprobado');
        }else{
            header('Location: https://csport.es/soporte');
        }
    }
    if(isset($_GET['persona'])){
        $text = $_POST['text']; $tipo = $_POST['tipo']; $user = $_POST['user'];
    	$hoy = new DateTime();
        $hoys = $hoy->format('Y-m-d H:i:s');
        $usert = "0/".$user;
        
        if((isset($user)) && (isset($text))){
            $upt = mysqli_query($conn, "INSERT INTO soporte (id_cuenta, tipo, descripcion, fecha, status, calificacion) VALUES ('$usert','$tipo','$text','$hoys','0','0')");
            echo json_encode('aprobado');
        }else{
            header('Location: https://csport.es/soporte');
        }
    }
    
    if(isset($_GET['saldo'])){
        $text = $_POST['text']; $tipo = $_POST['tipo']; $user = $_POST['user'];
    	$hoy = new DateTime();
        $hoys = $hoy->format('Y-m-d H:i:s');
        $usert = "0/".$user;
        
        if((isset($user)) && (isset($text))){
            $upt = mysqli_query($conn, "INSERT INTO soporte (id_cuenta, tipo, descripcion, fecha, status, calificacion) VALUES ('$usert','$tipo','$text','$hoys','0','0')");
            echo json_encode('aprobado');
        }else{
            header('Location: https://csport.es/soporte');
        }
    }
    if(isset($_GET['deposite'])){
        $text = $_POST['text']; $tipo = $_POST['tipo']; $user = $_POST['user'];
    	$hoy = new DateTime();
        $hoys = $hoy->format('Y-m-d H:i:s');
        $usert = "0/".$user;
        
        if((isset($user)) && (isset($text))){
            $upt = mysqli_query($conn, "INSERT INTO soporte (id_cuenta, tipo, descripcion, fecha, status, calificacion) VALUES ('$usert','$tipo','$text','$hoys','0','0')");
            echo json_encode('aprobado');
        }else{
            header('Location: https://csport.es/soporte');
        }
    }
    $conn -> close();
?>