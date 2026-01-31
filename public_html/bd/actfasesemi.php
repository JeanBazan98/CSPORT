<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();

	$enfrentamiento = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Semis' AND torneo = 'Ida'";
	$res = $conn->query($enfrentamiento);
	$fasej = "UPDATE torneos SET l_jornada = '1', mjor = '0' WHERE id = '$id_torneo'";
	$fasejr = $conn->query($fasej);
	
    $Enf2do = array();
	while ($row = mysqli_fetch_row($res)) { array_push($Enf2do, $row[0]); }
	
	if($ti_row[15] == 'Vuelta'){
	    
	    $enfrentamiento2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Semis' AND torneo = 'Vuelta'";
    	$res2 = $conn->query($enfrentamiento2);
        $Enf2do2 = array();
    	while ($row2 = mysqli_fetch_row($res2)) { array_push($Enf2do2, $row2[0]); }
	    
	    $enfup = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do[0]'";
    	$enfupr = $conn->query($enfup);
    	$enfupv = $enfupr->fetch_row();
    	$enfupq = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do2[0]'";
    	$enfuprq = $conn->query($enfupq);
    	$enfupvq = $enfuprq->fetch_row();
    	
        if(($enfupv[3] + $enfupvq[4]) > ($enfupv[4] + $enfupvq[3])){
            $gano1 = $enfupv[1];
        }else{
            $gano1 = $enfupv[2];
        }
        $enfup2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do[1]'";
    	$enfupr2 = $conn->query($enfup2);
    	$enfupv2 = $enfupr2->fetch_row();
    	$enfup2q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do2[1]'";
    	$enfupr2q = $conn->query($enfup2q);
    	$enfupv2q = $enfupr2q->fetch_row();
    	
        if(($enfupv2[3] + $enfupv2q[4]) > ($enfupv2[4] + $enfupv2q[3])){
            $gano2 = $enfupv2[1];
        }else{
            $gano2 = $enfupv2[2];
        }
	    
	    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano2','$id_torneo','0','Ida','Final')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano1','$id_torneo','0','Vuelta','Final')";
        $i_resq = $conn->query($insertq);
        
        $sqltablasse1 = mysqli_query($conn, "UPDATE tablas SET final = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablasse2 = mysqli_query($conn, "UPDATE tablas SET final = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
	    
	}else{
	    
	    $enfup = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do[0]'";
    	$enfupr = $conn->query($enfup);
    	$enfupv = $enfupr->fetch_row();
    	
        if($enfupv[3] > $enfupv[4]){
            $gano1 = $enfupv[1];
        }else{
            $gano1 = $enfupv[2];
        }
        $enfup2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf2do[1]'";
    	$enfupr2 = $conn->query($enfup2);
    	$enfupv2 = $enfupr2->fetch_row();
    	
        if($enfupv2[3] > $enfupv2[4]){
            $gano2 = $enfupv2[1];
        }else{
            $gano2 = $enfupv2[2];
        }
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano2','$id_torneo','0','Ida','Final')";
        $i_res = $conn->query($insert);
        
        $sqltablasse1 = mysqli_query($conn, "UPDATE tablas SET final = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablasse2 = mysqli_query($conn, "UPDATE tablas SET final = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    
	}
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>