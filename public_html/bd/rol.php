<?php
	session_start();
	include_once 'conexion.php';
	$id = $_POST['id'];
	$rol = $_POST['rol'];

    $slqs = mysqli_query($conn, "UPDATE cuentas SET verificado = '$rol' WHERE id_cuenta = '$id'");
    echo json_encode('aprobado');
?>