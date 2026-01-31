<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id']; $idu = $_GET['u'];
	$id_cuenta = $_SESSION['datos']['id'];

    $sqltc = mysqli_query($conn, "SELECT id_cuenta FROM torneos WHERE id = '$id_torneo'");
    $sqltc = $sqltc->fetch_row();
    $sql2 = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
    $sqlV2 = $sql2->fetch_row();
    $sql3 = mysqli_query($conn, "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
    $sqlV3 = $sql3->fetch_row();
    $sql5 = mysqli_query($conn, "SELECT * FROM tablas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
    $sqlV5 = $sql5->fetch_row();
    
    if($sqltc[0] == $id_cuenta){
        if($sqlV2){
            $sql1c = mysqli_query($conn, "UPDATE r_torneos SET id_cuenta = '$id_cuenta' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
        }if($sqlV3){
            $sql2c = mysqli_query($conn, "UPDATE t_ligas SET id_cuenta = '$id_cuenta' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
        }if($sqlV5){
            $sql3c = mysqli_query($conn, "UPDATE tablas SET id_cuenta = '$id_cuenta' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$idu'");
        }
    }
    
    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>