<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];

	$enfrentamiento = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$res = $conn->query($enfrentamiento);
	$val = $res->fetch_row();

    if($val[19] == "2"){
        $enfjA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A'";
    	$resjA = $conn->query($enfjA);
    	$enfjB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B'";
    	$resjB = $conn->query($enfjB);
    }
    if($val[19] == "4"){
        $enfjA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A'";
    	$resjA = $conn->query($enfjA);
    	$enfjB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B'";
    	$resjB = $conn->query($enfjB);
    	$enfjC = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'C'";
    	$resjC = $conn->query($enfjC);
    	$enfjD = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'D'";
    	$resjD = $conn->query($enfjD);
    }
    if($val[19] == "8"){
        $enfjA = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'A'";
    	$resjA = $conn->query($enfjA);
    	$enfjB = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'B'";
    	$resjB = $conn->query($enfjB);
    	$enfjC = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'C'";
    	$resjC = $conn->query($enfjC);
    	$enfjD = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'D'";
    	$resjD = $conn->query($enfjD);
    	$enfjE = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'E'";
    	$resjE = $conn->query($enfjE);
    	$enfjF = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'F'";
    	$resjF = $conn->query($enfjF);
    	$enfjG = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'G'";
    	$resjG = $conn->query($enfjG);
    	$enfjH = "SELECT * FROM t_ligas WHERE id_torneo = '$id_torneo' AND grupo = 'H'";
    	$resjH = $conn->query($enfjH);
    }
    
    if($val[19] == "2"){
//-----------------------------------------------------------------------------------------
        function roundRobinTournamenta($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjA)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamenta($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','A','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','A','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentb($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjB)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentb($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','B','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','B','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
    }
    if($val[19] == "4"){
//-----------------------------------------------------------------------------------------
        function roundRobinTournamenta($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjA)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamenta($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','A','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','A','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentb($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjB)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentb($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','B','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','B','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentc($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjC)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentc($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','C','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','C','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentd($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjD)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentd($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','D','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','D','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
    }
    if($val[19] == "8"){
//-----------------------------------------------------------------------------------------
        function roundRobinTournamenta($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjA)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamenta($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','A','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','A','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentb($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjB)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentb($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','B','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','B','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentc($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjC)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentc($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','C','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','C','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentd($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjD)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentd($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','D','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','D','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
        function roundRobinTournamente($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjE)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamente($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','E','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','E','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentf($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjF)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentf($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','F','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','F','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamentg($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjG)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamentg($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','G','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','G','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
//-----------------------------------------------------------------------------------------
        function roundRobinTournamenth($teams) {
            // Si el número de equipos es impar, añadimos un equipo ficticio "Bye"
            if (count($teams) % 2 == 1) {
                $teams[] = "Bye";
            }
        
            $numTeams = count($teams);
            $numRounds = $numTeams - 1;
            $halfSize = $numTeams / 2;
        
            // Inicializamos las jornadas
            $schedule = [];
        
            for ($round = 0; $round <= $numRounds; $round++) {
                $roundMatches = [];
        
                for ($i = 0; $i < $halfSize; $i++) {
                    $home = $teams[$i];
                    $away = $teams[$numTeams - $i - 1];
        
                    // Alternamos la localía
                    if ($round % 2 == 0) {
                        $roundMatches[] = array($home,$away);
                    } else {
                        $roundMatches[] = array($away,$home);
                    }
                }
        
                $schedule[] = $roundMatches;
        
                // Rotamos los equipos
                $lastTeam = array_pop($teams);
                array_splice($teams, 1, 0, $lastTeam);
            }
        
            return $schedule;
        }
        
        // Ejemplo de uso
        $teams = array();
        $contj = 0;
    	while ($rowj = mysqli_fetch_row($resjH)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
        $schedule = roundRobinTournamenth($teams);
        
        $x = 0;
        $x2 = 1;
        $y = 0;
        
        if($contj % 2 == 0){
            $jor_m = $contj - 1;
            $enf_m = $contj / 2;
        }else{
            $jor_m = $contj;
            $enf_m = $contj / 2;
        }
    
        while($x < $jor_m){
            while($y < $enf_m){
                $local = $schedule[$x][$y][0];
                $visitante = $schedule[$x][$y][1];
                
                if(($local == "Bye") || ($visitante == "Bye")){
                }else{
                    $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo,tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','H','Ida')";
        	        $i_res = $conn->query($insert);
        	        
        	        if($val[15] == "Vuelta"){
        	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, grupo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','H','Vuelta')";
        	            $i_res2 = $conn->query($insert2);
    	            }
                }
                $y = $y + 1;
            }
            $y = 0;
            $x = $x + 1;
            $x2 = $x2 + 1;
        }
    }
	
	$btn = "UPDATE torneos SET comienzo = '1', btn = '2', l_jornada = '1' WHERE id = '$id_torneo'";
    $bsql = $conn->query($btn);
    
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>