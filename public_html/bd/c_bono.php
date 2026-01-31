<?php
	session_start();
	include_once 'conexion.php';
	$id_cuenta = $_SESSION['datos']['id'];
	
	$adm = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id_cuenta'");
	$admv = $adm->fetch_row();
	
	$hoy = new DateTime();
    $hoys = $hoy->format('Y-m-d H:i:s');
	
	$evento = $_POST['evento']; $titulo = $_POST['titulo'];
	$tipob = $_POST['tipob']; $nro = $_POST['nro'];
	$tipop = $_POST['tipop']; $tiempo = $_POST['tiempo']; $fecha = $_POST['fecha'];
    
    $sqlc = mysqli_query($conn, "SELECT id_bono FROM bonos WHERE titulo = '$titulo'");
    $sqlcv = $sqlc->fetch_row();
    
    if($admv[0] == 4){
        if(isset($sqlcv[0])){
            echo json_encode('existe');
        }else{
            if($tiempo == 0){
                $insertB = mysqli_query($conn, "INSERT INTO bonos (evento, titulo, tipo, cantidad, aplican, tiempo, fecha, expira, status) VALUES ('$evento','$titulo','$tipob','$nro','$tipop','$tiempo','$hoys','$fecha','0')");
            }else{
                $insertB = mysqli_query($conn, "INSERT INTO bonos (evento, titulo, tipo, cantidad, aplican, tiempo, fecha, expira, status) VALUES ('$evento','$titulo','$tipob','$nro','$tipop','$tiempo','0000-00-00 00:00:00','$fecha','0')");
            }
        }
    }
?>