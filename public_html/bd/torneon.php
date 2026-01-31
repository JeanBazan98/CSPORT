<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
    if(isset($_SESSION['datos'])){
        $id = $_GET['id'];
        $idn = $_GET['n'];
        
        $ntsql = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_notificacion = '$idn'");
        $ntsqlv = $ntsql->fetch_row();
        
        if($ntsqlv[3] == "TorneoI"){
            $sqlnt = mysqli_query($conn, "UPDATE notificaciones SET estado = '1', tipo = 'TorneoIP' WHERE id_notificacion = '$idn'");
            header('Location: https://csport.es/torneo/'.$id.'&u='.$ntsqlv[1].'');
        }if($ntsqlv[3] == "TorneoR"){
            $sqlnt = mysqli_query($conn, "UPDATE notificaciones SET estado = '1', tipo = 'TorneoRP' WHERE id_notificacion = '$idn'");
            header('Location: https://csport.es/torneo/'.$id.'&u='.$ntsqlv[1].'');
        }if($ntsqlv[3] == "DesafioA"){
            $sqlnt = mysqli_query($conn, "UPDATE notificaciones SET estado = '1', tipo = 'DesafioAP' WHERE id_notificacion = '$idn'");
            header('Location: https://csport.es/desafio/'.$id.'');
        }if($ntsqlv[3] == "RetiroA"){
            $sqlnt = mysqli_query($conn, "UPDATE notificaciones SET estado = '1', tipo = 'RetiroAP' WHERE id_notificacion = '$idn'");
            header('Location: https://csport.es/desafio/'.$id.'');
        }if($ntsqlv[3] == "TAuditado"){
            $sqlnt = mysqli_query($conn, "UPDATE notificaciones SET estado = '1', tipo = 'TPAuditado' WHERE id_notificacion = '$idn'");
            header('Location: https://csport.es/torneo/'.$id.'');
        }
    }
    $conn -> close();
?>