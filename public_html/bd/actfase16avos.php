<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];

    $ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();
    
	$enfrentamiento = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = '16avos' AND torneo = 'Ida'";
	$res = $conn->query($enfrentamiento);
	
	$fasej = "UPDATE torneos SET l_jornada = '4', mjor = '0' WHERE id = '$id_torneo'";
	$fasejr = $conn->query($fasej);
	
    $Enf4to = array();
	while ($row = mysqli_fetch_row($res)) { array_push($Enf4to, $row[0]); }
	
	if($ti_row[15] == 'Vuelta'){
	    
	    $enfrentamiento2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = '16avos' AND torneo = 'Vuelta'";
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
        
        $enfup5 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[4]'";
    	$enfupr5 = $conn->query($enfup5);
    	$enfupv5 = $enfupr5->fetch_row();
    	$enfup5q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[4]'";
    	$enfupr5q = $conn->query($enfup5q);
    	$enfupv5q = $enfupr5q->fetch_row();
    	
        if(($enfupv5[3] + $enfupv5q[4]) > ($enfupv5[4] + $enfupv5q[3])){
            $gano5 = $enfupv5[1];
        }else{
            $gano5 = $enfupv5[2];
        }
        $enfup6 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[5]'";
    	$enfupr6 = $conn->query($enfup6);
    	$enfupv6 = $enfupr6->fetch_row();
    	$enfup6q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[5]'";
    	$enfupr6q = $conn->query($enfup6q);
    	$enfupv6q = $enfupr6q->fetch_row();
    	
        if(($enfupv6[3] + $enfupv6q[4]) > ($enfupv6[4] + $enfupv6q[3])){
            $gano6 = $enfupv6[1];
        }else{
            $gano6 = $enfupv6[2];
        }
        $enfup7 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[6]'";
    	$enfupr7 = $conn->query($enfup7);
    	$enfupv7 = $enfupr7->fetch_row();
    	$enfup7q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[6]'";
    	$enfupr7q = $conn->query($enfup7q);
    	$enfupv7q = $enfupr7q->fetch_row();
    	
        if(($enfupv7[3] + $enfupv7q[4]) > ($enfupv7[4] + $enfupv7q[3])){
            $gano7 = $enfupv7[1];
        }else{
            $gano7 = $enfupv7[2];
        }
        $enfup8 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[7]'";
    	$enfupr8 = $conn->query($enfup8);
    	$enfupv8 = $enfupr8->fetch_row();
    	$enfup8q = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[7]'";
    	$enfupr8q = $conn->query($enfup8q);
    	$enfupv8q = $enfupr8q->fetch_row();
    	
        if(($enfupv8[3] + $enfupv8q[4]) > ($enfupv8[4] + $enfupv8q[3])){
            $gano8 = $enfupv8[1];
        }else{
            $gano8 = $enfupv8[2];
        }
        $enfup1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[8]'";
    	$enfupr1 = $conn->query($enfup1);
    	$enfupv1 = $enfupr1->fetch_row();
    	$enfupq1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[8]'";
    	$enfuprq1 = $conn->query($enfupq1);
    	$enfupvq1 = $enfuprq1->fetch_row();
    	
        if(($enfupv1[3] + $enfupvq1[4]) > ($enfupv1[4] + $enfupvq1[3])){
            $gano11 = $enfupv1[1];
        }else{
            $gano11 = $enfupv1[2];
        }
        $enfup21 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[9]'";
    	$enfupr21 = $conn->query($enfup21);
    	$enfupv21 = $enfupr21->fetch_row();
    	$enfup2q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[9]'";
    	$enfupr2q1 = $conn->query($enfup2q1);
    	$enfupv2q1 = $enfupr2q1->fetch_row();
    	
        if(($enfupv21[3] + $enfupv2q1[4]) > ($enfupv21[4] + $enfupv2q1[3])){
            $gano21 = $enfupv21[1];
        }else{
            $gano21 = $enfupv21[2];
        }
        $enfup31 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[10]'";
    	$enfupr31 = $conn->query($enfup31);
    	$enfupv31 = $enfupr31->fetch_row();
    	$enfup3q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[10]'";
    	$enfupr3q1 = $conn->query($enfup3q1);
    	$enfupv3q1 = $enfupr3q1->fetch_row();
    	
        if(($enfupv31[3] + $enfupv3q1[4]) > ($enfupv31[4] + $enfupv3q1[3])){
            $gano31 = $enfupv3[1];
        }else{
            $gano31 = $enfupv3[2];
        }
        $enfup41 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[11]'";
    	$enfupr41 = $conn->query($enfup41);
    	$enfupv41 = $enfupr41->fetch_row();
    	$enfup4q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[11]'";
    	$enfupr4q1 = $conn->query($enfup4q1);
    	$enfupv4q1 = $enfupr4q1->fetch_row();
    	
        if(($enfupv41[3] + $enfupv4q1[4]) > ($enfupv41[4] + $enfupv4q1[3])){
            $gano41 = $enfupv41[1];
        }else{
            $gano41 = $enfupv41[2];
        }
        
        $enfup51 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[12]'";
    	$enfupr51 = $conn->query($enfup51);
    	$enfupv51 = $enfupr51->fetch_row();
    	$enfup5q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[12]'";
    	$enfupr5q1 = $conn->query($enfup5q1);
    	$enfupv5q1 = $enfupr5q1->fetch_row();
    	
        if(($enfupv51[3] + $enfupv5q1[4]) > ($enfupv51[4] + $enfupv5q1[3])){
            $gano51 = $enfupv51[1];
        }else{
            $gano51 = $enfupv51[2];
        }
        $enfup61 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[13]'";
    	$enfupr61 = $conn->query($enfup61);
    	$enfupv61 = $enfupr61->fetch_row();
    	$enfup6q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[13]'";
    	$enfupr6q1 = $conn->query($enfup6q1);
    	$enfupv6q1 = $enfupr6q1->fetch_row();
    	
        if(($enfupv61[3] + $enfupv6q1[4]) > ($enfupv61[4] + $enfupv6q1[3])){
            $gano61 = $enfupv61[1];
        }else{
            $gano61 = $enfupv61[2];
        }
        $enfup71 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[14]'";
    	$enfupr71 = $conn->query($enfup71);
    	$enfupv71 = $enfupr71->fetch_row();
    	$enfup7q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[14]'";
    	$enfupr7q1 = $conn->query($enfup7q1);
    	$enfupv7q1 = $enfupr7q1->fetch_row();
    	
        if(($enfupv71[3] + $enfupv7q1[4]) > ($enfupv71[4] + $enfupv7q1[3])){
            $gano71 = $enfupv71[1];
        }else{
            $gano71 = $enfupv71[2];
        }
        $enfup81 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[15]'";
    	$enfupr81 = $conn->query($enfup81);
    	$enfupv81 = $enfupr81->fetch_row();
    	$enfup8q1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to2[15]'";
    	$enfupr8q1 = $conn->query($enfup8q1);
    	$enfupv8q1 = $enfupr8q1->fetch_row();
    	
        if(($enfupv81[3] + $enfupv8q1[4]) > ($enfupv81[4] + $enfupv8q1[3])){
            $gano81 = $enfupv81[1];
        }else{
            $gano81 = $enfupv81[2];
        }
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano11','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano11','$gano1','$id_torneo','0','Vuelta','Octavos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano21','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano21','$gano2','$id_torneo','0','Vuelta','Octavos')";
        $i_res2q = $conn->query($insert2q);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano3','$gano31','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano31','$gano3','$id_torneo','0','Vuelta','Octavos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano4','$gano41','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano41','$gano4','$id_torneo','0','Vuelta','Octavos')";
        $i_res2q = $conn->query($insert2q);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano5','$gano51','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano51','$gano5','$id_torneo','0','Vuelta','Octavos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano6','$gano61','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano61','$gano6','$id_torneo','0','Vuelta','Octavos')";
        $i_res2q = $conn->query($insert2q);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano7','$gano71','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano71','$gano7','$id_torneo','0','Vuelta','Octavos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano8','$gano81','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano81','$gano8','$id_torneo','0','Vuelta','Octavos')";
        $i_res2q = $conn->query($insert2q);
        
        $sqltablas16v1 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablas16v2 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablas16v3 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablas16v4 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
    	$sqltablas16v5 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano5'");
    	$sqltablas16v6 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano6'");
    	$sqltablas16v7 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano7'");
    	$sqltablas16v8 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano8'");
    	$sqltablas16v9 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano11'");
    	$sqltablas16v10 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano21'");
    	$sqltablas16v11 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano31'");
    	$sqltablas16v12 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano41'");
    	$sqltablas16v13 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano51'");
    	$sqltablas16v14 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano61'");
    	$sqltablas16v15 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano71'");
    	$sqltablas16v16 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano81'");
        
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
        
        $enfup5 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[4]'";
    	$enfupr5 = $conn->query($enfup5);
    	$enfupv5 = $enfupr5->fetch_row();
    	
        if($enfupv5[3] > $enfupv5[4]){
            $gano5 = $enfupv5[1];
        }else{
            $gano5 = $enfupv5[2];
        }
        $enfup6 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[5]'";
    	$enfupr6 = $conn->query($enfup6);
    	$enfupv6 = $enfupr6->fetch_row();
    	
        if($enfupv6[3] > $enfupv6[4]){
            $gano6 = $enfupv6[1];
        }else{
            $gano6 = $enfupv6[2];
        }
        $enfup7 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[6]'";
    	$enfupr7 = $conn->query($enfup7);
    	$enfupv7 = $enfupr7->fetch_row();
    	
        if($enfupv7[3] > $enfupv7[4]){
            $gano7 = $enfupv7[1];
        }else{
            $gano7 = $enfupv7[2];
        }
        $enfup8 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[7]'";
    	$enfupr8 = $conn->query($enfup8);
    	$enfupv8 = $enfupr8->fetch_row();
    	
        if($enfupv8[3] > $enfupv8[4]){
            $gano8 = $enfupv8[1];
        }else{
            $gano8 = $enfupv8[2];
        }
        $enfup1 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[8]'";
    	$enfupr1 = $conn->query($enfup1);
    	$enfupv1 = $enfupr1->fetch_row();
    	
        if($enfupv1[3] > $enfupv1[4]){
            $gano11 = $enfupv1[1];
        }else{
            $gano11 = $enfupv1[2];
        }
        $enfup21 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[9]'";
    	$enfupr21 = $conn->query($enfup21);
    	$enfupv21 = $enfupr21->fetch_row();
    	
        if($enfupv21[3] > $enfupv21[4]){
            $gano21 = $enfupv21[1];
        }else{
            $gano21 = $enfupv21[2];
        }
        $enfup31 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[10]'";
    	$enfupr31 = $conn->query($enfup31);
    	$enfupv31 = $enfupr31->fetch_row();
    	
        if($enfupv31[3] > $enfupv31[4]){
            $gano31 = $enfupv31[1];
        }else{
            $gano31 = $enfupv31[2];
        }
        $enfup41 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[11]'";
    	$enfupr41 = $conn->query($enfup41);
    	$enfupv41 = $enfupr41->fetch_row();
    	
        if($enfupv41[3] > $enfupv41[4]){
            $gano41 = $enfupv41[1];
        }else{
            $gano41 = $enfupv41[2];
        }
        
        $enfup51 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[12]'";
    	$enfupr51 = $conn->query($enfup51);
    	$enfupv51 = $enfupr51->fetch_row();
    	
        if($enfupv51[3] > $enfupv51[4]){
            $gano51 = $enfupv51[1];
        }else{
            $gano51 = $enfupv51[2];
        }
        $enfup61 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[13]'";
    	$enfupr61 = $conn->query($enfup61);
    	$enfupv61 = $enfupr61->fetch_row();
    	
        if($enfupv61[3] > $enfupv61[4]){
            $gano61 = $enfupv61[1];
        }else{
            $gano61 = $enfupv61[2];
        }
        $enfup71 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[14]'";
    	$enfupr71 = $conn->query($enfup71);
    	$enfupv71 = $enfupr71->fetch_row();
    	
        if($enfupv71[3] > $enfupv71[4]){
            $gano71 = $enfupv71[1];
        }else{
            $gano71 = $enfupv71[2];
        }
        $enfup81 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$Enf4to[15]'";
    	$enfupr81 = $conn->query($enfup81);
    	$enfupv81 = $enfupr81->fetch_row();
    	
        if($enfupv81[3] > $enfupv81[4]){
            $gano81 = $enfupv81[1];
        }else{
            $gano81 = $enfupv81[2];
        }
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano11','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano21','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano3','$gano31','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano4','$gano41','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano5','$gano51','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano6','$gano61','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano7','$gano71','$id_torneo','0','Ida','Octavos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano8','$gano81','$id_torneo','0','Ida','Octavos')";
        $i_res2 = $conn->query($insert2);
        
        $sqltablas16v1 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablas16v2 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablas16v3 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablas16v4 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
    	$sqltablas16v5 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano5'");
    	$sqltablas16v6 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano6'");
    	$sqltablas16v7 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano7'");
    	$sqltablas16v8 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano8'");
    	$sqltablas16v9 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano11'");
    	$sqltablas16v10 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano21'");
    	$sqltablas16v11 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano31'");
    	$sqltablas16v12 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano41'");
    	$sqltablas16v13 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano51'");
    	$sqltablas16v14 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano61'");
    	$sqltablas16v15 = mysqli_query($conn, "UPDATE tablas SET 8vo = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano71'");
    	$sqltablas16v16 = mysqli_query($conn, "UPDATE tablas SET 8vo = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano81'");
        
	}
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>