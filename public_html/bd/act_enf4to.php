<?php
	session_start();
	include_once 'conexion.php';

	$gol_local = $_POST['local'];
	$gol_visitante = $_POST['visitante'];
	$id_torneo = $_GET['id'];
	$id_enf = $_GET['enf'];
	$id_cuenta = $_SESSION['datos']['id'];

	$goles = "UPDATE enfrentamientos SET gol_local = '$gol_local', gol_visitante = '$gol_visitante', tabla = '1' WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$id_enf'";
	$sql = $conn->query($goles);

	$enf_sql = "SELECT * FROM enfrentamientos WHERE id_enfrentamiento = '$id_enf'";
	$enf_sqlres = $conn->query($enf_sql);
	$sqlval = $enf_sqlres->fetch_row();

	$tablas = "SELECT * FROM tablas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'";
	$tablasres = $conn->query($tablas);
	$tablasval = $tablasres->fetch_row();
	
	$ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();
	
	if($ti_row[15] == 'Vuelta'){
    	if ($gol_local >= $gol_visitante) {
    		if ($tablasval[5] == 1) {
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			}
    		}else{
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			}
    		}	
    	}else{
    		if ($tablasval[5] == 1) {
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			}
    		}else{
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			}
    		}
    	}
	}else{
	    if ($gol_local >= $gol_visitante) {
    		if ($tablasval[5] == 1) {
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			}
    		}else{
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			}
    		}	
    	}else{
    		if ($tablasval[5] == 1) {
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			}
    		}else{
    			if($ti_row[7] == "Eliminacion D"){
    			    $updategol = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_visitante', gc = gc + '$gol_local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[2]'");
    			    $updategol2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$gol_local', gc = gc + '$gol_visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlval[1]'");
    			}
    		}
    	}
	}

    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>