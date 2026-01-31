<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_GET['id_cuenta'];
    $id_d = $_GET['id']; $equipo = $_POST['equipo'];
    
    $sql = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_d'");
    $sqlv = $sql->fetch_row();

    if($sqlv[1] == $id_cuenta){
        $sqle = mysqli_query($conn, "UPDATE desafio SET equipo_l = '$equipo' WHERE id_desafio = '$id_d'");
        echo json_encode('subiendo');
    }if($sqlv[2] == $id_cuenta){
        $sqle2 = mysqli_query($conn, "UPDATE desafio SET equipo_v = '$equipo' WHERE id_desafio = '$id_d'");
        echo json_encode('subiendo');
    }
?>