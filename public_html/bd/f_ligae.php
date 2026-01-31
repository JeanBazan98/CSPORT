<?php
	session_start();
	include_once 'conexion.php';
	
	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$limit = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$limitr = $conn->query($limit);
	$limitv = $limitr->fetch_row();
	$limite = $limitv[16];
	
	$maxpt = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limite";
    $maxptr = $conn->query($maxpt);
    
    if($limitv[16] == 2){
        
  	    $finalld = array();
    	while ($xf = mysqli_fetch_row($maxptr)) {
    	    array_push($finalld, $xf[1]);
    	    
    	    $registrar = "INSERT INTO tablas (id_torneo, id_cuenta, final) VALUES ('$id_torneo','$xf[1]','1')";
		    $sql3 = $conn->query($registrar);
    	}
    	
        $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[0]','$finalld[1]','$id_torneo','Ida','Final')";
        $sqlfenf = $conn->query($subirfenf);
        
        if($limitv[15] == 'Vuelta'){
    	    $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[1]','$finalld[0]','$id_torneo','Vuelta','Final')";
            $sqlfenf = $conn->query($subirfenf);
    	}
    	
        $sqltablas = "UPDATE torneos SET l_jornada = '1' WHERE id = '$id_torneo'";
		$sqltablasres = $conn->query($sqltablas);
		
		$fasej = "UPDATE torneos SET l_jornada = '1' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
        
    }if($limitv[16] == 4){
        
        $finalld = array();
    	while ($xf = mysqli_fetch_row($maxptr)) {
    	    array_push($finalld, $xf[1]);
    	    
    	    $registrar = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$xf[1]','1')";
		    $sql3 = $conn->query($registrar);
    	}
    	
        $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[0]','$finalld[2]','$id_torneo','Ida','Semis')";
        $sqlfenf = $conn->query($subirfenf);
        if($limitv[15] == 'Vuelta'){
    	    $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[2]','$finalld[0]','$id_torneo','Vuelta','Semis')";
            $sqlfenf = $conn->query($subirfenf);
    	}
        $subirfenf2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[1]','$finalld[3]','$id_torneo','Ida','Semis')";
        $sqlfenf2 = $conn->query($subirfenf2);
        if($limitv[15] == 'Vuelta'){
            $subirfenf2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[3]','$finalld[1]','$id_torneo','Vuelta','Semis')";
            $sqlfenf2 = $conn->query($subirfenf2);
    	}
        
    	
        $sqltablas = "UPDATE torneos SET l_jornada = '1' WHERE id = '$id_torneo'";
		$sqltablasres = $conn->query($sqltablas);
		
		$fasej = "UPDATE torneos SET l_jornada = '2' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
        
    }if($limitv[16] == 8){
        
        $finalld = array();
    	while ($xf = mysqli_fetch_row($maxptr)) {
    	    array_push($finalld, $xf[1]);
    	    
    	    $registrar = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$xf[1]','1')";
		    $sql3 = $conn->query($registrar);
    	}
    	
        $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[0]','$finalld[4]','$id_torneo','Ida','Cuartos')";
        $sqlfenf = $conn->query($subirfenf);
        if($limitv[15] == 'Vuelta'){
    	    $subirfenf = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[4]','$finalld[0]','$id_torneo','Vuelta','Cuartos')";
            $sqlfenf = $conn->query($subirfenf);
    	}
        $subirfenf2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[1]','$finalld[5]','$id_torneo','Ida','Cuartos')";
        $sqlfenf2 = $conn->query($subirfenf2);
        if($limitv[15] == 'Vuelta'){
            $subirfenf2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[5]','$finalld[1]','$id_torneo','Vuelta','Cuartos')";
            $sqlfenf2 = $conn->query($subirfenf2);
    	}
        $subirfenf3 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[2]','$finalld[6]','$id_torneo','Ida','Cuartos')";
        $sqlfenf3 = $conn->query($subirfenf3);
        if($limitv[15] == 'Vuelta'){
            $subirfenf3 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[6]','$finalld[2]','$id_torneo','Vuelta','Cuartos')";
            $sqlfenf3 = $conn->query($subirfenf3);
    	}
        $subirfenf4 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[3]','$finalld[7]','$id_torneo','Ida','Cuartos')";
        $sqlfenf4 = $conn->query($subirfenf4);
    	if($limitv[15] == 'Vuelta'){
            $subirfenf4 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, torneo, tipo) VALUES ('$finalld[7]','$finalld[3]','$id_torneo','Vuelta','Cuartos')";
            $sqlfenf4 = $conn->query($subirfenf4);
    	}
    	
        $sqltablas = "UPDATE torneos SET l_jornada = '1' WHERE id = '$id_torneo'";
		$sqltablasres = $conn->query($sqltablas);
		
		$fasej = "UPDATE torneos SET l_jornada = '3' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
        
    }
	
	$sql= "UPDATE torneos SET comienzo = '2' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>