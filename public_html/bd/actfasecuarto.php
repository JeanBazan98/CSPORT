<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();

	$enfrentamiento = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Cuartos' AND torneo = 'Ida'";
	$res = $conn->query($enfrentamiento);
	$fasej = "UPDATE torneos SET l_jornada = '2', mjor = '0' WHERE id = '$id_torneo'";
	$fasejr = $conn->query($fasej);
	
    $Enf4to = array();
	while ($row = mysqli_fetch_row($res)) { array_push($Enf4to, $row[0]); }
	
	if($ti_row[15] == 'Vuelta'){
	    
	    $enfrentamiento2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Cuartos' AND torneo = 'Vuelta'";
    	$res2 = $conn->query($enfrentamiento2);
        $Enf4to2 = array();
    	while ($row2 = mysqli_fetch_row($res2)) { array_push($Enf4to2, $row2[0]); }
	    
	    $enfup = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[0]'";
    	$enfupr = $conn->query($enfup);
    	$enfupv = $enfupr->fetch_row();
    	$enfupq = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[0]'";
    	$enfuprq = $conn->query($enfupq);
    	$enfupvq = $enfuprq->fetch_row();
    	
        if(($enfupv[3] + $enfupvq[4]) > ($enfupv[4] + $enfupvq[3])){
            $gano1 = $enfupv[1];
        }else{
            $gano1 = $enfupv[2];
        }
        $enfup2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[1]'";
    	$enfupr2 = $conn->query($enfup2);
    	$enfupv2 = $enfupr2->fetch_row();
    	$enfup2q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[1]'";
    	$enfupr2q = $conn->query($enfup2q);
    	$enfupv2q = $enfupr2q->fetch_row();
    	
        if(($enfupv2[3] + $enfupv2q[4]) > ($enfupv2[4] + $enfupv2q[3])){
            $gano2 = $enfupv2[1];
        }else{
            $gano2 = $enfupv2[2];
        }
        $enfup3 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[2]'";
    	$enfupr3 = $conn->query($enfup3);
    	$enfupv3 = $enfupr3->fetch_row();
    	$enfup3q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[2]'";
    	$enfupr3q = $conn->query($enfup3q);
    	$enfupv3q = $enfupr3q->fetch_row();
    	
        if(($enfupv3[3] + $enfupv3q[4]) > ($enfupv3[4] + $enfupv3q[3])){
            $gano3 = $enfupv3[1];
        }else{
            $gano3 = $enfupv3[2];
        }
        $enfup4 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[3]'";
    	$enfupr4 = $conn->query($enfup4);
    	$enfupv4 = $enfupr4->fetch_row();
    	$enfup4q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[3]'";
    	$enfupr4q = $conn->query($enfup4q);
    	$enfupv4q = $enfupr4q->fetch_row();
    	
        if(($enfupv4[3] + $enfupv4q[4]) > ($enfupv4[4] + $enfupv4q[3])){
            $gano4 = $enfupv4[1];
        }else{
            $gano4 = $enfupv4[2];
        }
    
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano4','$id_torneo','0','Ida','Semis')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano4','$gano1','$id_torneo','0','Vuelta','Semis')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano3','$id_torneo','0','Ida','Semis')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano3','$gano2','$id_torneo','0','Vuelta','Semis')";
        $i_res2q = $conn->query($insert2q);
        
        $sqltablascu1 = mysqli_query($conn, "UPDATE tablas SET 2do = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablascu2 = mysqli_query($conn, "UPDATE tablas SET 2do = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablascu3 = mysqli_query($conn, "UPDATE tablas SET 2do = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablascu4 = mysqli_query($conn, "UPDATE tablas SET 2do = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
	    
	}else{
	    
	    $enfup = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[0]'";
    	$enfupr = $conn->query($enfup);
    	$enfupv = $enfupr->fetch_row();
    	
        if($enfupv[3] > $enfupv[4]){
            $gano1 = $enfupv[1];
        }else{
            $gano1 = $enfupv[2];
        }
        $enfup2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[1]'";
    	$enfupr2 = $conn->query($enfup2);
    	$enfupv2 = $enfupr2->fetch_row();
    	
        if($enfupv2[3] > $enfupv2[4]){
            $gano2 = $enfupv2[1];
        }else{
            $gano2 = $enfupv2[2];
        }
        $enfup3 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[2]'";
    	$enfupr3 = $conn->query($enfup3);
    	$enfupv3 = $enfupr3->fetch_row();
    	
        if($enfupv3[3] > $enfupv3[4]){
            $gano3 = $enfupv3[1];
        }else{
            $gano3 = $enfupv3[2];
        }
        $enfup4 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[3]'";
    	$enfupr4 = $conn->query($enfup4);
    	$enfupv4 = $enfupr4->fetch_row();
    	
        if($enfupv4[3] > $enfupv4[4]){
            $gano4 = $enfupv4[1];
        }else{
            $gano4 = $enfupv4[2];
        }
    
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano4','$id_torneo','0','Ida','Semis')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano3','$id_torneo','0','Ida','Semis')";
        $i_res2 = $conn->query($insert2);
        
        $sqltablascu1 = mysqli_query($conn, "UPDATE tablas SET 2do = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablascu2 = mysqli_query($conn, "UPDATE tablas SET 2do = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablascu3 = mysqli_query($conn, "UPDATE tablas SET 2do = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablascu4 = mysqli_query($conn, "UPDATE tablas SET 2do = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
    
	}
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>