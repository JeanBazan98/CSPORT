<?php
	session_start();
	include_once 'conexion.php';
	
	$id_torneo = $_GET['id']; $id_enf = $_GET['enf']; $id_cuenta = $_SESSION['datos']['id'];
	$local = $_POST['local']; $visitante = $_POST['visitante']; $tipop = $_GET['tp']; $tpn = $_GET['tpn']; 
	
	$enf = "SELECT * FROM enfrentamientos WHERE id_enfrentamiento = '$id_enf'";
	$enfres = $conn->query($enf);
	$enfval = $enfres->fetch_row();
	
	$jgrupo = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id_torneo'");
	$jgrupov = $jgrupo->fetch_row();

    if($enfval[3] > $enfval[4]){
        if ($local < $visitante){
            $update_local = mysqli_query($conn, "UPDATE t_ligas SET pg = pg + 1, pp = pp - 1, pts = pts + 3, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pg = pg - 1, pp = pp + 1, pts = pts - 3, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
        }
        if ($local == $visitante){
            $update_local = mysqli_query($conn, "UPDATE t_ligas SET pp = pp - 1, pe = pe + 1, pts = pts + 1, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pg = pg - 1, pe = pe + 1, pts = pts - 2, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
        }
    }
    if($enfval[3] < $enfval[4]){
        if ($local > $visitante){
           $update_local = mysqli_query($conn, "UPDATE t_ligas SET pg = pg + 1, pp = pp - 1, pts = pts + 3, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pg = pg - 1, pp = pp + 1, pts = pts - 3, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
        }
        if ($local == $visitante){
           $update_local = mysqli_query($conn, "UPDATE t_ligas SET pe = pe + 1, pp = pp - 1, pts = pts + 1, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pg = pg - 1, pe = pe + 1, pts = pts - 2, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
        }
    }
    if(($enfval[3] == $enfval[4]) || ($enfval[4] == $enfval[3])){
        if ($local > $visitante){
           $update_local = mysqli_query($conn, "UPDATE t_ligas SET pg = pg + 1, pe = pe -1, pts = pts + 2, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pp = pp + 1, pe = pe - 1, pts = pts - 1, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
        }
        if ($local < $visitante){
            $update_local = mysqli_query($conn, "UPDATE t_ligas SET pg = pg + 1, pe = pe - 1, pts = pts + 2, gf = gf - '$enfval[4]', gc = gc - '$enfval[3]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante = mysqli_query($conn, "UPDATE t_ligas SET pp = pp + 1, pe = pe - 1, pts = pts - 1, gf = gf - '$enfval[3]', gc = gc - '$enfval[4]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
            
            $update_local2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$visitante', gc = gc + '$local' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
            $update_visitante2 = mysqli_query($conn, "UPDATE t_ligas SET gf = gf + '$local', gc = gc + '$visitante' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
        }
    }
	
	$sql= "UPDATE enfrentamientos SET gol_local = '$local', gol_visitante = '$visitante' WHERE id_enfrentamiento = '$id_enf'";
	$res = $conn->query($sql);
	
	$update_pctj = mysqli_query($conn, "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
	$upd_pctjr = $update_pctj->fetch_row();
	$pctj_l = $upd_pctjr[6];
    $pctj_l2 = $upd_pctjr[2]*3;
    $pctjl = ($pctj_l/$pctj_l2)*100;
    $update_goles = mysqli_query($conn, "UPDATE t_ligas SET pctj = '$pctjl' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
    
	$update_pctj2 = mysqli_query($conn, "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
	$upd_pctjr2 = $update_pctj2->fetch_row();
	$pctj_v = $upd_pctjr2[6];
    $pctj_v2 = $upd_pctjr2[2]*3;
    $pctjv = ($pctj_v/$pctj_v2)*100;
    $update_goles2 = mysqli_query($conn, "UPDATE t_ligas SET pctj = '$pctjv' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
    
	$update_dg1 = mysqli_query($conn, "UPDATE t_ligas SET dg = gf - gc WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[1]'");
    $update_dg2 = mysqli_query($conn, "UPDATE t_ligas SET dg = gf - gc WHERE id_torneo = '$id_torneo' AND id_cuenta = '$enfval[2]'");
	
	if($tipop == "Ida"){
	    if($jgrupov[7] == "Grupos E"){
	        header('Location: https://csport.es/fixture/'.$id_torneo.'&Ida='.$tpn.'&'.$enfval[9].'=');
	    }else{
	        header('Location: https://csport.es/fixture/'.$id_torneo.'&Ida='.$tpn.'');
	    }
	}else{
	    if($jgrupov[7] == "Grupos E"){
	        header('Location: https://csport.es/fixture/'.$id_torneo.'&Vuelta='.$tpn.'&'.$enfval[9].'=');
	    }else{
	        header('Location: https://csport.es/fixture/'.$id_torneo.'&Vuelta='.$tpn.'');
	    }
	}
	$conn -> close();
?>