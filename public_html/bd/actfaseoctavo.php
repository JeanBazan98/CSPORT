<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];

    $ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();
    
	$enfrentamiento = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Octavos' AND torneo = 'Ida'";
	$res = $conn->query($enfrentamiento);
	
	$fasej = "UPDATE torneos SET l_jornada = '3', mjor = '0' WHERE id = '$id_torneo'";
	$fasejr = $conn->query($fasej);
	
    $Enf4to = array();
	while ($row = mysqli_fetch_row($res)) { array_push($Enf4to, $row[0]); }
	
	if($ti_row[15] == 'Vuelta'){
	    
	    $enfrentamiento2 = "SELECT * FROM enfrentamientos WHERE id_torneo = '$id_torneo' AND tipo = 'Octavos' AND torneo = 'Vuelta'";
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
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano4','$id_torneo','0','Ida','Cuartos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano4','$gano1','$id_torneo','0','Vuelta','Cuartos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano3','$id_torneo','0','Ida','Cuartos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano3','$gano2','$id_torneo','0','Vuelta','Cuartos')";
        $i_res2q = $conn->query($insert2q);
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano5','$gano8','$id_torneo','0','Ida','Cuartos')";
        $i_res = $conn->query($insert);
        $insertq = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano8','$gano5','$id_torneo','0','Vuelta','Cuartos')";
        $i_resq = $conn->query($insertq);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano7','$gano6','$id_torneo','0','Ida','Cuartos')";
        $i_res2 = $conn->query($insert2);
        $insert2q = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano6','$gano7','$id_torneo','0','Vuelta','Cuartos')";
        $i_res2q = $conn->query($insert2q);
        
        $sqltablasoc1 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablasoc2 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablasoc3 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablasoc4 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
    	$sqltablasoc5 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano5'");
    	$sqltablasoc6 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano6'");
    	$sqltablasoc7 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano7'");
    	$sqltablasoc8 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano8'");
        
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
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano1','$gano4','$id_torneo','0','Ida','Cuartos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano2','$gano3','$id_torneo','0','Ida','Cuartos')";
        $i_res2 = $conn->query($insert2);
        
        $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano5','$gano8','$id_torneo','0','Ida','Cuartos')";
        $i_res = $conn->query($insert);
        $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$gano7','$gano6','$id_torneo','0','Ida','Cuartos')";
        $i_res2 = $conn->query($insert2);
        
        $sqltablasoc1 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano1'");
    	$sqltablasoc2 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano2'");
    	$sqltablasoc3 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano3'");
    	$sqltablasoc4 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano4'");
    	$sqltablasoc5 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano5'");
    	$sqltablasoc6 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano6'");
    	$sqltablasoc7 = mysqli_query($conn, "UPDATE tablas SET 4to = '1' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano7'");
    	$sqltablasoc8 = mysqli_query($conn, "UPDATE tablas SET 4to = '2' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$gano8'");
        
	}
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>