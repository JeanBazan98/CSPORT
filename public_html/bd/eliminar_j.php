<?php
    include_once 'conexion.php';
    session_start();
    
    $id_torneo = $_GET['id'];
    $eliminado = $_GET['c'];
    $id_cuenta = $_SESSION['datos']['id'];
    
    $sqle = "DELETE FROM r_torneos WHERE id_cuenta = '$eliminado' AND id_torneo = '$id_torneo'";
    $sqleres = $conn->query($sqle);
    
    $sqle2 = "DELETE FROM t_grupos WHERE id_cuenta = '$eliminado' AND id_torneo = '$id_torneo'";
    $sqleres2 = $conn->query($sqle2);
    
    $sqle3 = "DELETE FROM t_ligas WHERE id_cuenta = '$eliminado' AND id_torneo = '$id_torneo'";
    $sqleres3 = $conn->query($sqle3);
    
    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>