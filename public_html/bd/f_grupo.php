<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$ti_torneo = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$ti_res = $conn->query($ti_torneo);
	$ti_row = $ti_res->fetch_row();
	
    $valoresA = array();
	$valoresB = array();
	$valoresC = array();
	$valoresD = array();
	$valoresE = array();
	$valoresF = array();
	$valoresG = array();
	$valoresH = array();
	
	$limitg = $ti_row[16];
	
    if(($ti_row[16] * $ti_row[19]) == 4){
        $t_grupoA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
		$t_grupoAres = $conn->query($t_grupoA);
		while ($t_grupoArow = mysqli_fetch_row($t_grupoAres)) {
			if(array_push($valoresA, $t_grupoArow[1])){}
		}
		$t_grupoB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $ti_row[16]";
		$t_grupoBres = $conn->query($t_grupoB);
		while ($t_grupoBrow = mysqli_fetch_row($t_grupoBres)) {
			if(array_push($valoresB, $t_grupoBrow[1])){}
		}

		$tgrupoA1 = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$valoresA[0]','1')";
		$sqlA1 = $conn->query($tgrupoA1);
		$tgrupoA2 = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$valoresA[1]','2')";
		$sqlA2 = $conn->query($tgrupoA2);
		$tgrupoB1 = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$valoresB[0]','1')";
		$sqlB1 = $conn->query($tgrupoB1);
		$tgrupoB2 = "INSERT INTO tablas (id_torneo, id_cuenta, 2do) VALUES ('$id_torneo','$valoresB[1]','2')";
		$sqlB2 = $conn->query($tgrupoB2);

        if($ti_row[15] == 'Vuelta'){
            $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Semis')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[1]','$valoresA[0]','$id_torneo','','Vuelta','Semis')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Semis')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[0]','$valoresA[1]','$id_torneo','','Vuelta','Semis')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
        }else{
            $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Semis')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Semis')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
        }

		$fasej = "UPDATE torneos SET l_jornada = '2', comienzo = '2', mjor = '0' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    if(($ti_row[16] * $ti_row[19]) == 8){
        if($ti_row[19] == 4){
            $t_grupoA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoAres = $conn->query($t_grupoA);
    		while ($t_grupoArow = mysqli_fetch_row($t_grupoAres)) {
    			if(array_push($valoresA, $t_grupoArow[1])){}
    		}
    		$t_grupoB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoBres = $conn->query($t_grupoB);
    		while ($t_grupoBrow = mysqli_fetch_row($t_grupoBres)) {
    			if(array_push($valoresB, $t_grupoBrow[1])){}
    		}
    		$t_grupoC = "SELECT * FROM t_grupos WHERE id_torneo = '$id_torneo' AND grupo = 'C' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoCres = $conn->query($t_grupoC);
    		while ($t_grupoCrow = mysqli_fetch_row($t_grupoCres)) {
    			if(array_push($valoresC, $t_grupoCrow[1])){}
    		}
    		$t_grupoD = "SELECT * FROM t_grupos WHERE id_torneo = '$id_torneo' AND grupo = 'D' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoDres = $conn->query($t_grupoD);
    		while ($t_grupoDrow = mysqli_fetch_row($t_grupoDres)) {
    			if(array_push($valoresD, $t_grupoDrow[1])){}
    		}
    
    		$tgrupoA1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[0]','1')";
    		$sqlA1 = $conn->query($tgrupoA1);
    		$tgrupoA2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[1]','2')";
    		$sqlA2 = $conn->query($tgrupoA2);
    		$tgrupoB1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[0]','1')";
    		$sqlB1 = $conn->query($tgrupoB1);
    		$tgrupoB2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[1]','2')";
    		$sqlB2 = $conn->query($tgrupoB2);
    		$tgrupoC1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresC[0]','1')";
    		$sqlC1 = $conn->query($tgrupoC1);
    		$tgrupoC2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresC[1]','2')";
    		$sqlC2 = $conn->query($tgrupoC2);
    		$tgrupoD1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresD[0]','1')";
    		$sqlD1 = $conn->query($tgrupoD1);
    		$tgrupoD2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresD[1]','2')";
    		$sqlD2 = $conn->query($tgrupoD2);
    
            if($ti_row[15] == 'Vuelta'){
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
        		
        		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
            }else{
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
            }
        }
        if($ti_row[19] == 2){
            $t_grupoA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoAres = $conn->query($t_grupoA);
    		while ($t_grupoArow = mysqli_fetch_row($t_grupoAres)) {
    			if(array_push($valoresA, $t_grupoArow[1])){}
    		}
    		$t_grupoB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoBres = $conn->query($t_grupoB);
    		while ($t_grupoBrow = mysqli_fetch_row($t_grupoBres)) {
    			if(array_push($valoresB, $t_grupoBrow[1])){}
    		}
    
    		$tgrupoA1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[0]','1')";
    		$sqlA1 = $conn->query($tgrupoA1);
    		$tgrupoA2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[1]','2')";
    		$sqlA2 = $conn->query($tgrupoA2);
    		$tgrupoB1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[2]','1')";
    		$sqlB1 = $conn->query($tgrupoB1);
    		$tgrupoB2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresA[3]','2')";
    		$sqlB2 = $conn->query($tgrupoB2);
    		$tgrupoC1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[0]','1')";
    		$sqlC1 = $conn->query($tgrupoC1);
    		$tgrupoC2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[1]','2')";
    		$sqlC2 = $conn->query($tgrupoC2);
    		$tgrupoD1 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[2]','1')";
    		$sqlD1 = $conn->query($tgrupoD1);
    		$tgrupoD2 = "INSERT INTO tablas (id_torneo, id_cuenta, 4to) VALUES ('$id_torneo','$valoresB[3]','2')";
    		$sqlD2 = $conn->query($tgrupoD2);
    
            if($ti_row[15] == 'Vuelta'){
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[2]','$valoresA[3]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[3]','$valoresA[2]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
        		
        		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[1]','$valoresA[0]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[0]','$valoresA[1]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[3]','$valoresB[2]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[2]','$valoresB[3]','$id_torneo','','Vuelta','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
            }else{
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[2]','$valoresA[3]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[3]','$valoresA[2]','$id_torneo','','Ida','Cuartos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
            }
        }

		$fasej = "UPDATE torneos SET l_jornada = '3', comienzo = '2', mjor = '0' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }
    if(($ti_row[16] * $ti_row[19]) == 16){
        if($ti_row[19] == 4){
            $t_grupoA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoAres = $conn->query($t_grupoA);
    		while ($t_grupoArow = mysqli_fetch_row($t_grupoAres)) {
    			if(array_push($valoresA, $t_grupoArow[1])){}
    		}
    		$t_grupoB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoBres = $conn->query($t_grupoB);
    		while ($t_grupoBrow = mysqli_fetch_row($t_grupoBres)) {
    			if(array_push($valoresB, $t_grupoBrow[1])){}
    		}
    		$t_grupoC = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'C' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoCres = $conn->query($t_grupoC);
    		while ($t_grupoCrow = mysqli_fetch_row($t_grupoCres)) {
    			if(array_push($valoresC, $t_grupoCrow[1])){}
    		}
    		$t_grupoD = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'D' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoDres = $conn->query($t_grupoD);
    		while ($t_grupoDrow = mysqli_fetch_row($t_grupoDres)) {
    			if(array_push($valoresD, $t_grupoDrow[1])){}
    		}
    		
    		$tgrupoA1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[0]','1')";
    		$sqlA1 = $conn->query($tgrupoA1);
    		$tgrupoA2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[1]','2')";
    		$sqlA2 = $conn->query($tgrupoA2);
    		$tgrupoA3 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[3]','1')";
    		$sqlA3 = $conn->query($tgrupoA3);
    		$tgrupoA4 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[4]','2')";
    		$sqlA4 = $conn->query($tgrupoA4);
    		$tgrupoB1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[0]','1')";
    		$sqlC1 = $conn->query($tgrupoB1);
    		$tgrupoB2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[1]','2')";
    		$sqlB2 = $conn->query($tgrupoB1);
    		$tgrupoB3 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[3]','1')";
    		$sqlD3 = $conn->query($tgrupoB2);
    		$tgrupoB4 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[4]','2')";
    		$sqlD4 = $conn->query($tgrupoB4);
    		
    		$tgrupoC1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[0]','1')";
    		$sqlC1 = $conn->query($tgrupoC1);
    		$tgrupoC2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[1]','2')";
    		$sqlC2 = $conn->query($tgrupoC2);
    		$tgrupoC3 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[3]','1')";
    		$sqlC3 = $conn->query($tgrupoC3);
    		$tgrupoC4 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[4]','2')";
    		$sqlC4 = $conn->query($tgrupoC4);
    		$tgrupoD1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[0]','1')";
    		$sqlD1 = $conn->query($tgrupoD1);
    		$tgrupoD2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[1]','2')";
    		$sqlD2 = $conn->query($tgrupoD2);
    		$tgrupoD3 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[3]','1')";
    		$sqlD3 = $conn->query($tgrupoD3);
    		$tgrupoD4 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[4]','2')";
    		$sqlD4 = $conn->query($tgrupoD4);
    		
    		if($ti_row[15] == 'Vuelta'){
            $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Octavos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Octavos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[3]','$valoresA[2]','$id_torneo','','Ida','Octavos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[2]','$valoresA[3]','$id_torneo','','Ida','Octavos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Octavos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Octavos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[2]','$valoresC[3]','$id_torneo','','Ida','Octavos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[3]','$valoresC[2]','$id_torneo','','Ida','Octavos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
    		
    		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[0]','$valoresA[1]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[1]','$valoresA[0]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[3]','$valoresB[2]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[2]','$valoresB[3]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[0]','$valoresC[1]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[1]','$valoresC[0]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[2]','$valoresD[3]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[3]','$valoresD[2]','$id_torneo','','Vuelta','Octavos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
            }else{
            $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Octavos')";
    		$sqlenfA1B2 = $conn->query($enfA1B2);
    		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Octavos')";
    		$sqlenfA2B1 = $conn->query($enfA2B1);
    		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[3]','$valoresA[2]','$id_torneo','','Ida','Octavos')";
    		$sqlenfC1D2 = $conn->query($enfD1C2);
    		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresB[2]','$valoresA[3]','$id_torneo','','Ida','Octavos')";
    		$sqlenfC2D1 = $conn->query($enfD2C1);
    		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Octavos')";
    		$sqlenfE1F2 = $conn->query($enfE1F2);
    		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Octavos')";
    		$sqlenfE2F1 = $conn->query($enfE2F1);
    		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[2]','$valoresC[3]','$id_torneo','','Ida','Octavos')";
    		$sqlenfG1H2 = $conn->query($enfG1H2);
    		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresD[3]','$valoresC[2]','$id_torneo','','Ida','Octavos')";
    		$sqlenfG2H1 = $conn->query($enfG2H1);
        }
        }
		if($ti_row[19] == 8){
            $t_grupoA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoAres = $conn->query($t_grupoA);
    		while ($t_grupoArow = mysqli_fetch_row($t_grupoAres)) {
    			if(array_push($valoresA, $t_grupoArow[1])){}
    		}
    		$t_grupoB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoBres = $conn->query($t_grupoB);
    		while ($t_grupoBrow = mysqli_fetch_row($t_grupoBres)) {
    			if(array_push($valoresB, $t_grupoBrow[1])){}
    		}
    		$t_grupoC = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'C' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoCres = $conn->query($t_grupoC);
    		while ($t_grupoCrow = mysqli_fetch_row($t_grupoCres)) {
    			if(array_push($valoresC, $t_grupoCrow[1])){}
    		}
    		$t_grupoD = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'D' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoDres = $conn->query($t_grupoD);
    		while ($t_grupoDrow = mysqli_fetch_row($t_grupoDres)) {
    			if(array_push($valoresD, $t_grupoDrow[1])){}
    		}
    		$t_grupoE = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'E' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoEres = $conn->query($t_grupoE);
    		while ($t_grupoErow = mysqli_fetch_row($t_grupoEres)) {
    			if(array_push($valoresE, $t_grupoErow[1])){}
    		}
    		$t_grupoF = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'F' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoFres = $conn->query($t_grupoF);
    		while ($t_grupoFrow = mysqli_fetch_row($t_grupoFres)) {
    			if(array_push($valoresF, $t_grupoFrow[1])){}
    		}
    		$t_grupoG = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'G' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoGres = $conn->query($t_grupoG);
    		while ($t_grupoGrow = mysqli_fetch_row($t_grupoGres)) {
    			if(array_push($valoresG, $t_grupoGrow[1])){}
    		}
    		$t_grupoH = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'H' ORDER BY pts DESC, pg DESC, dg DESC LIMIT $limitg";
    		$t_grupoHres = $conn->query($t_grupoH);
    		while ($t_grupoHrow = mysqli_fetch_row($t_grupoHres)) {
    			if(array_push($valoresH, $t_grupoHrow[1])){}
    		}
    		
    		$tgrupoA1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[0]','1')";
    		$sqlA1 = $conn->query($tgrupoA1);
    		$tgrupoA2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresA[1]','2')";
    		$sqlA2 = $conn->query($tgrupoA2);
    		$tgrupoB1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[0]','1')";
    		$sqlB1 = $conn->query($tgrupoB1);
    		$tgrupoB2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresB[1]','2')";
    		$sqlB2 = $conn->query($tgrupoB2);
    		$tgrupoC1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[0]','1')";
    		$sqlC1 = $conn->query($tgrupoC1);
    		$tgrupoC2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresC[1]','2')";
    		$sqlC2 = $conn->query($tgrupoC2);
    		$tgrupoD1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[0]','1')";
    		$sqlD1 = $conn->query($tgrupoD1);
    		$tgrupoD2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresD[1]','2')";
    		$sqlD2 = $conn->query($tgrupoD2);
    		$tgrupoE1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresE[0]','1')";
    		$sqlE1 = $conn->query($tgrupoE1);
    		$tgrupoE2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresE[1]','2')";
    		$sqlE2 = $conn->query($tgrupoE2);
    		$tgrupoF1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresF[0]','1')";
    		$sqlF1 = $conn->query($tgrupoF1);
    		$tgrupoF2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresF[1]','2')";
    		$sqlF2 = $conn->query($tgrupoF2);
    		$tgrupoG1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresG[0]','1')";
    		$sqlG1 = $conn->query($tgrupoG1);
    		$tgrupoG2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresG[1]','2')";
    		$sqlG2 = $conn->query($tgrupoG2);
    		$tgrupoH1 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresH[0]','1')";
    		$sqlH1 = $conn->query($tgrupoH1);
    		$tgrupoH2 = "INSERT INTO tablas (id_torneo, id_cuenta, 8vo) VALUES ('$id_torneo','$valoresH[1]','2')";
    		$sqlH2 = $conn->query($tgrupoH2);
    		
    		if($ti_row[15] == 'Vuelta'){
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
        		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[0]','$valoresF[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfE1F2 = $conn->query($enfE1F2);
        		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[1]','$valoresF[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfE2F1 = $conn->query($enfE2F1);
        		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[0]','$valoresH[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfG1H2 = $conn->query($enfG1H2);
        		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[1]','$valoresH[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfG2H1 = $conn->query($enfG2H1);
        		
        		$enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
        		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[1]','$valoresF[0]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfE1F2 = $conn->query($enfE1F2);
        		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[0]','$valoresF[1]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfE2F1 = $conn->query($enfE2F1);
        		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[1]','$valoresH[0]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfG1H2 = $conn->query($enfG1H2);
        		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[0]','$valoresH[1]','$id_torneo','','Vuelta','Octavos')";
        		$sqlenfG2H1 = $conn->query($enfG2H1);
            }else{
                $enfA1B2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[0]','$valoresB[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfA1B2 = $conn->query($enfA1B2);
        		$enfA2B1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresA[1]','$valoresB[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfA2B1 = $conn->query($enfA2B1);
        		$enfD1C2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[0]','$valoresD[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfC1D2 = $conn->query($enfD1C2);
        		$enfD2C1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresC[1]','$valoresD[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfC2D1 = $conn->query($enfD2C1);
        		$enfE1F2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[0]','$valoresF[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfE1F2 = $conn->query($enfE1F2);
        		$enfE2F1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresE[1]','$valoresF[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfE2F1 = $conn->query($enfE2F1);
        		$enfG1H2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[0]','$valoresH[1]','$id_torneo','','Ida','Octavos')";
        		$sqlenfG1H2 = $conn->query($enfG1H2);
        		$enfG2H1 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$valoresG[1]','$valoresH[0]','$id_torneo','','Ida','Octavos')";
        		$sqlenfG2H1 = $conn->query($enfG2H1);
            }
        }

		$fasej = "UPDATE torneos SET l_jornada = '4', comienzo = '2', mjor = '0' WHERE id = '$id_torneo'";
	    $fasejr = $conn->query($fasej);
    }

    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>