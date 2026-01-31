<?php
	session_start();
	include_once 'conexion.php';
	$email = $_POST['email'];
	$rol = $_POST['rol'];
    
    $sqlc = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email = '$email'");
    $sqlcv = $sqlc->fetch_row();
    $sqlc2 = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email = '$email' AND verificado > '1'");
    $sqlcv2 = $sqlc2->fetch_row();
    
    if($sqlcv){
        if($sqlcv2){
            echo json_encode('email');
        }else{
            $slqs = mysqli_query($conn, "UPDATE cuentas SET verificado = '$rol' WHERE email = '$email'");
            echo json_encode('aprobado');
        }
    }else{
        echo json_encode('nexiste');
    }
?>