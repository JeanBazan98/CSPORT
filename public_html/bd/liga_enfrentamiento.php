<?php
	session_start();
	include_once 'conexion.php';
	date_default_timezone_set('UTC');

	$id_torneo = $_GET['id'];
	$id_cuenta = $_SESSION['datos']['id'];
	
	$enf = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$res = $conn->query($enf);
	$val = $res->fetch_row();
	
	$enfj = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
	$resj = $conn->query($enfj);
	
//-----------------------------------------------------------------------------------------
    function roundRobinTournament($teams) {
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
	while ($rowj = mysqli_fetch_row($resj)) { array_push($teams, $rowj[1]); $contj = $contj + 1; }
    $schedule = roundRobinTournament($teams);
    
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
                $insert = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$local','$visitante','$id_torneo','$x2','$val[7]','Ida')";
    	        $i_res = $conn->query($insert);
    	        
    	        if($val[15] == "Vuelta"){
    	            $insert2 = "INSERT INTO enfrentamientos (id_local, id_visitante, id_torneo, jornada, torneo, tipo) VALUES ('$visitante','$local','$id_torneo','$x2','$val[7]','Vuelta')";
    	            $i_res2 = $conn->query($insert2);
	            }
            }
            $y = $y + 1;
        }
        $y = 0;
        $x = $x + 1;
        $x2 = $x2 + 1;
    }

    
	$sql= "UPDATE torneos SET l_jornada = '1' WHERE id = '$id_torneo'";
	$res = $conn->query($sql);
	
	$conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>