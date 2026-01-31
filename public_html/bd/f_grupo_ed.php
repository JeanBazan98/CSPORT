<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();

	$id_cuenta = $_GET['c'];
	$asignar = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
	$res = $conn->query($asignar);
	$asignart1 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$rest1 = $conn->query($asignart1);
    $valt1 = $rest1->fetch_row();
    
	$j_cont = 0;
	$cont = -1;

    $id_ce = array();
	while ($val = mysqli_fetch_row($res)) { $j_cont = $j_cont + 1; array_push($id_ce, $val[1]); }
    if($valt1[8] == 4){
        $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$id_ce[0]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$id_ce[1]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$id_ce[2]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$id_ce[3]','1')";
	    $sql3q = $conn->query($registrarq);
	    
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[0]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[1]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[2]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[3]')";
	    $sql3qt = $conn->query($registrarqt);
	    
		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[0]','$id_ce[1]','$id_torneo','1','Ida','Semis')";
		$sqlenfA1B2 = $conn->query($enfA1B2);
		if($valt1[15] == 'Vuelta'){
	        $enfA1B2v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[1]','$id_ce[0]','$id_torneo','2','Vuelta','Semis')";
    		$sqlenfA1B2v = $conn->query($enfA1B2v);
	    }
		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[2]','$id_ce[3]','$id_torneo','1','Ida','Semis')";
		$sqlenfA2B1 = $conn->query($enfA2B1);
		if($valt1[15] == 'Vuelta'){
    		$enfA2B1v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[3]','$id_ce[2]','$id_torneo','2','Vuelta','Semis')";
    		$sqlenfA2B1v = $conn->query($enfA2B1v);
	    }
	    
		$fasej = "UPDATE torneos SET l_jornada = '2' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    if($valt1[8] == 8){
        $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[0]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[1]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[2]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[3]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[4]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[5]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[6]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$id_ce[7]','1')";
	    $sql3q = $conn->query($registrarq);
	    
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[0]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[1]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[2]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[3]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[4]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[5]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[6]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[7]')";
	    $sql3qt = $conn->query($registrarqt);
	    
	    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[0]','$id_ce[1]','$id_torneo','1','Ida','Cuartos')";
		$sqlenfA1B2 = $conn->query($enfA1B2);
		if($valt1[15] == 'Vuelta'){
		    $enfA1B2v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[1]','$id_ce[0]','$id_torneo','2','Vuelta','Cuartos')";
    		$sqlenfA1B2v = $conn->query($enfA1B2v);
	    }
		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[2]','$id_ce[3]','$id_torneo','1','Ida','Cuartos')";
		$sqlenfA2B1 = $conn->query($enfA2B1);
		if($valt1[15] == 'Vuelta'){
    		$enfA2B1v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[3]','$id_ce[2]','$id_torneo','2','Vuelta','Cuartos')";
    		$sqlenfA2B1v = $conn->query($enfA2B1v);
	    }
		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[4]','$id_ce[5]','$id_torneo','1','Ida','Cuartos')";
		$sqlenfC1D2 = $conn->query($enfD1C2);
		if($valt1[15] == 'Vuelta'){
    		$enfD1C2v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[5]','$id_ce[4]','$id_torneo','2','Vuelta','Cuartos')";
    		$sqlenfC1D2v = $conn->query($enfD1C2v);
	    }
		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[6]','$id_ce[7]','$id_torneo','1','Ida','Cuartos')";
		$sqlenfC2D1 = $conn->query($enfD2C1);
		if($valt1[15] == 'Vuelta'){
    		$enfD2C1v = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[7]','$id_ce[6]','$id_torneo','2','Vuelta','Cuartos')";
    		$sqlenfC2D1v = $conn->query($enfD2C1v);
	    }
		
	    
		$fasej = "UPDATE torneos SET l_jornada = '3' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    if($valt1[8] == 16){
        $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[0]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[1]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[2]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[3]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[4]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[5]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[6]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[7]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[8]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[9]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[10]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[11]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[12]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[13]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[14]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$id_ce[15]','1')";
	    $sql3q = $conn->query($registrarq);
	    
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[0]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[1]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[2]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[3]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[4]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[5]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[6]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[7]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[8]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[9]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[10]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[11]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[12]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[13]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[14]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[15]')";
	    $sql3qt = $conn->query($registrarqt);
	    
	    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[0]','$id_ce[1]','$id_torneo','1','Ida','Octavos')";
		$sqlenfA1B2 = $conn->query($enfA1B2);
		if($valt1[15] == 'Vuelta'){
		    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[1]','$id_ce[0]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
	    }
		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[2]','$id_ce[3]','$id_torneo','1','Ida','Octavos')";
		$sqlenfA2B1 = $conn->query($enfA2B1);
		if($valt1[15] == 'Vuelta'){
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[3]','$id_ce[2]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
	    }
		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[4]','$id_ce[5]','$id_torneo','1','Ida','Octavos')";
		$sqlenfC1D2 = $conn->query($enfD1C2);
		if($valt1[15] == 'Vuelta'){
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[5]','$id_ce[4]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
	    }
		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[6]','$id_ce[7]','$id_torneo','1','Ida','Octavos')";
		$sqlenfC2D1 = $conn->query($enfD2C1);
		if($valt1[15] == 'Vuelta'){
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[7]','$id_ce[6]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
	    }
		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[8]','$id_ce[9]','$id_torneo','1','Ida','Octavos')";
		$sqlenfE1F2 = $conn->query($enfE1F2);
		if($valt1[15] == 'Vuelta'){
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[9]','$id_ce[8]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
	    }
		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[10]','$id_ce[11]','$id_torneo','1','Ida','Octavos')";
		$sqlenfE2F1 = $conn->query($enfE2F1);
		if($valt1[15] == 'Vuelta'){
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[11]','$id_ce[10]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
	    }
		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[12]','$id_ce[13]','$id_torneo','1','Ida','Octavos')";
		$sqlenfG1H2 = $conn->query($enfG1H2);
		if($valt1[15] == 'Vuelta'){
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[13]','$id_ce[12]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
	    }
		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[14]','$id_ce[15]','$id_torneo','1','Ida','Octavos')";
		$sqlenfG2H1 = $conn->query($enfG2H1);
		if($valt1[15] == 'Vuelta'){
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[15]','$id_ce[14]','$id_torneo','2','Vuelta','Octavos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
	    }
	    
		$fasej = "UPDATE torneos SET l_jornada = '4' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    if($valt1[8] == 32){
        $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[0]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[1]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[2]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[3]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[4]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[5]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[6]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[7]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[8]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[9]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[10]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[11]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[12]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[13]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[14]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[15]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[16]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[17]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[18]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[19]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[20]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[21]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[22]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[23]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[24]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[25]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[26]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[27]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[28]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[29]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[30]','1')";
	    $sql3q = $conn->query($registrarq);
	    $registrarq = "INSERT INTO tablas (id_torneo, id_cuenta, 16vo) VALUES ('$id_torneo','$id_ce[31]','1')";
	    $sql3q = $conn->query($registrarq);
	    
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[0]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[1]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[2]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[3]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[4]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[5]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[6]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[7]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[8]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[9]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[10]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[11]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[12]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[13]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[14]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[15]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[16]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[17]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[18]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[19]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[20]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[21]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[22]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[23]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[24]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[25]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[26]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[27]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[28]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[29]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[30]')";
	    $sql3qt = $conn->query($registrarqt);
	    $registrarqt = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$id_torneo','$id_ce[31]')";
	    $sql3qt = $conn->query($registrarqt);
	    
	    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[0]','$id_ce[1]','$id_torneo','1','Ida','16avos')";
		$sqlenfA1B2 = $conn->query($enfA1B2);
		if($valt1[15] == 'Vuelta'){
		    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[1]','$id_ce[0]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
	    }
		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[2]','$id_ce[3]','$id_torneo','1','Ida','16avos')";
		$sqlenfA2B1 = $conn->query($enfA2B1);
		if($valt1[15] == 'Vuelta'){
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[3]','$id_ce[2]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
	    }
		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[4]','$id_ce[5]','$id_torneo','1','Ida','16avos')";
		$sqlenfC1D2 = $conn->query($enfD1C2);
		if($valt1[15] == 'Vuelta'){
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[5]','$id_ce[4]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
	    }
		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[6]','$id_ce[7]','$id_torneo','1','Ida','16avos')";
		$sqlenfC2D1 = $conn->query($enfD2C1);
		if($valt1[15] == 'Vuelta'){
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[7]','$id_ce[6]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
	    }
		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[8]','$id_ce[9]','$id_torneo','1','Ida','16avos')";
		$sqlenfE1F2 = $conn->query($enfE1F2);
		if($valt1[15] == 'Vuelta'){
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[9]','$id_ce[8]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
	    }
		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[10]','$id_ce[11]','$id_torneo','1','Ida','16avos')";
		$sqlenfE2F1 = $conn->query($enfE2F1);
		if($valt1[15] == 'Vuelta'){
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[11]','$id_ce[10]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
	    }
		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[12]','$id_ce[13]','$id_torneo','1','Ida','16avos')";
		$sqlenfG1H2 = $conn->query($enfG1H2);
		if($valt1[15] == 'Vuelta'){
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[13]','$id_ce[12]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
	    }
		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[14]','$id_ce[15]','$id_torneo','1','Ida','16avos')";
		$sqlenfG2H1 = $conn->query($enfG2H1);
		if($valt1[15] == 'Vuelta'){
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[15]','$id_ce[14]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
	    }
	    
	    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[16]','$id_ce[17]','$id_torneo','1','Ida','16avos')";
		$sqlenfA1B2 = $conn->query($enfA1B2);
		if($valt1[15] == 'Vuelta'){
		    $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[17]','$id_ce[16]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
	    }
		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[18]','$id_ce[19]','$id_torneo','1','Ida','16avos')";
		$sqlenfA2B1 = $conn->query($enfA2B1);
		if($valt1[15] == 'Vuelta'){
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[19]','$id_ce[18]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
	    }
		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[20]','$id_ce[21]','$id_torneo','1','Ida','16avos')";
		$sqlenfC1D2 = $conn->query($enfD1C2);
		if($valt1[15] == 'Vuelta'){
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[21]','$id_ce[20]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
	    }
		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[22]','$id_ce[23]','$id_torneo','1','Ida','16avos')";
		$sqlenfC2D1 = $conn->query($enfD2C1);
		if($valt1[15] == 'Vuelta'){
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[23]','$id_ce[22]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
	    }
		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[24]','$id_ce[25]','$id_torneo','1','Ida','16avos')";
		$sqlenfE1F2 = $conn->query($enfE1F2);
		if($valt1[15] == 'Vuelta'){
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[25]','$id_ce[24]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
	    }
		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[26]','$id_ce[27]','$id_torneo','1','Ida','16avos')";
		$sqlenfE2F1 = $conn->query($enfE2F1);
		if($valt1[15] == 'Vuelta'){
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[27]','$id_ce[26]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
	    }
		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[28]','$id_ce[29]','$id_torneo','1','Ida','16avos')";
		$sqlenfG1H2 = $conn->query($enfG1H2);
		if($valt1[15] == 'Vuelta'){
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[29]','$id_ce[28]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
	    }
		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[30]','$id_ce[31]','$id_torneo','1','Ida','16avos')";
		$sqlenfG2H1 = $conn->query($enfG2H1);
		if($valt1[15] == 'Vuelta'){
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$id_ce[31]','$id_ce[30]','$id_torneo','2','Vuelta','16avos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
	    }
	    
		$fasej = "UPDATE torneos SET l_jornada = '5' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    
	$fasej = "UPDATE torneos SET comienzo = '2' WHERE id = '$id_torneo'";
	$fasejr = $conn->query($fasej);

    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>