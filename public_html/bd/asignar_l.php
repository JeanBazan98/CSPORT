<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$id_cuenta = $_GET['c'];
	$titulo = $_POST['titulo'];

	$asignar = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
	$res = $conn->query($asignar);

    if($titulo == '0'){
        $a_titulo = "SELECT * FROM equipos";
	    $res2 = $conn->query($a_titulo);
    }else{
        $a_titulo = "SELECT * FROM equipos WHERE titulo = '$titulo'";
	    $res2 = $conn->query($a_titulo);
    }
    
	$j_cont = 0;
	$e_cont = 0;
	$cont = -1;

	while ($val = mysqli_fetch_row($res)) { $j_cont = $j_cont + 1; }
	while ($val2 = mysqli_fetch_row($res2)) { $e_cont = $e_cont + 1; }	
	
	$valoresRandom = array();
	$valorRandomPrimero = mt_rand(1,$e_cont);
	array_push($valoresRandom, $valorRandomPrimero);
	 
	$x = 1;
	while ($x < $j_cont) {
	    $siguienteValorRadom = mt_rand(1,$e_cont);
	    if(in_array($siguienteValorRadom, $valoresRandom)){
	    	continue;
	    }else{
			array_push($valoresRandom, $siguienteValorRadom);
	   		$x++;
	    }
	}
	
	$r_torneo = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
	$r_res = $conn->query($r_torneo);
	while ($f_cont = mysqli_fetch_row($r_res)) {
		$cont = $cont + 1;
		
		if($titulo == 0){
		    $a_titulo2 = "SELECT * FROM equipos WHERE id_equipo = '$valoresRandom[$cont]'";
    		$res2_1 = $conn->query($a_titulo2);
    		$a_val_t = $res2_1->fetch_row();
		}else{
		    $a_titulo2 = "SELECT * FROM equipos WHERE titulo = '$titulo' AND nro = '$valoresRandom[$cont]'";
    		$res2_1 = $conn->query($a_titulo2);
    		$a_val_t = $res2_1->fetch_row();
		}
		
		$sql4 = "UPDATE r_torneos SET equipo = '$a_val_t[0]' WHERE id_torneo = '$id_torneo' AND id_cuenta = '$f_cont[1]'";
		$res4 = $conn->query($sql4);
		
		$sql2= "UPDATE torneos SET comienzo = '1' WHERE id = '$id_torneo'";
		$res2 = $conn->query($sql2);

		$registrar = "INSERT INTO t_ligas (id_torneo, id_cuenta) VALUES ('$f_cont[0]','$f_cont[1]')";
		$sql3 = $conn->query($registrar);		
	}

    $conn -> close();
	header('Location: https://csport.es/fixture/'.$id_torneo.'');
?>