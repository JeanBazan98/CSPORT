<?php
	session_start();
	include_once 'conexion.php';
	$id_cuenta = $_SESSION['datos']['id'];
	$id = $_GET['id'];

    $sql = mysqli_query($conn, "SELECT id_desafio FROM desafio WHERE id_cuenta = '$id_cuenta' AND dp = 'P/$id' ORDER BY id_desafio DESC");
    $sqlv = $sql->fetch_row();
    
    $sqlnot = mysqli_query($conn, "UPDATE notificaciones SET id = '$sqlv[0]', tipo = 'DesafioP' WHERE id_cuenta = '$id_cuenta' AND id_cuentar = '$id' AND tipo = 'Desafio'");
    
    $conn -> close();
	header('Location: https://csport.es/desafio/'.$sqlv[0].'');
?>