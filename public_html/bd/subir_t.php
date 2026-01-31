<?php
	session_start();
	include_once 'conexion.php';
	$id_creador = $_SESSION['datos']['id'];
	
	$sqlcreador = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id_creador'");
    $sqlcreadorv = $sqlcreador->fetch_row();
    
	$titulo = $_POST['titulo'];
	$desc = $_POST['descripcion'];
	$inscripcion = $_POST['inscripcion'];
	$formato = $_POST['formato'];
	$id_cuenta = $_SESSION['datos']['id'];
	$tipo = $_POST['tipo'];
	$plataforma = $_POST['plataforma'];
	$juego = $_POST['juego'];
	$equiposc = $_POST['equiposc'];
	$price = $_POST['premio'];
	$cganador = $_POST['ganadores'];
	
	$hoyF = (date("Y")."-".date("n")."-".(date("j")));

	if (($formato == 'Liga') || ($formato == 'Liga E')) {
	    $equipos = $_POST['equipos2'];
	}if($formato == 'Eliminacion D'){
	    $equipos = $_POST['equipos3'];
	}if ($formato == 'Grupos E'){
	    $equipos = $_POST['cporg'];
	    $cporg = $_POST['equipos'];
	    $equipos = $equipos * $cporg;
	}

    if((empty($equipos)) || ($equipos == 0)){
        echo json_encode('vacio');
    }else{
        if (empty($titulo) || empty($desc)) {
		echo json_encode('vacio');
	    }else{
		if(($formato == 'Liga') && ($tipo == null)){
		    echo json_encode('vacio');
		}else{
		    if(($formato == 'Liga E') && ($tipo == null)){
		        echo json_encode('vacio');
		    }else{
		        if(($formato == 'Liga E') && ($equiposc == 0)){
    		        echo json_encode('vacio');
    		    }else{
    		        $b_torneo = "SELECT id_torneo FROM torneos WHERE id_cuenta = '$id_cuenta'";
    		        $res = $conn->query($b_torneo);
    	        	$val = $res->fetch_assoc();
    		        if ($val) {
            			$b_torneo2 = "SELECT id_torneo FROM torneos WHERE id_cuenta = '$id_cuenta' ORDER BY id_torneo DESC";
            			$res2 = $conn->query($b_torneo2);
            			$val2 = $res2->fetch_row();
            			$val3 = $val2[0] + 1;
                        
                        if(($inscripcion == "1") && ($sqlcreadorv[0] == 4)){
                            if($cganador == 1){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.40;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 2){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.35;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 3){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.30;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }
                    	}if(($inscripcion == "1") && ($sqlcreadorv[0] !== 4)){
                    	    if($cganador == 1){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.40;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 2){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.35;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 3){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.30;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }
                    	}
                        
            			$subir = "INSERT INTO torneos (id_torneo, id_cuenta, titulo, descripcion, inscripcion, formato, equipos, juego, img, plataforma, tipo, clasificados, price, cant_g, fecha, cant_ganadores) VALUES ('$val3','$id_cuenta','$titulo','$desc','$inscripcion','$formato','$equipos','$juego','img/torneos/default.jpg','$plataforma','$tipo','$equiposc','$premio','$cporg','$hoyF','$cganador')";
            			$sql = $conn->query($subir);
            			
            			echo json_encode('subiendo');
            		}else{
            			$id_torneo = "1";
            			if(($inscripcion == "1") && ($sqlcreadorv[0] == 4)){
                            if($cganador == 1){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.40;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 2){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.35;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 3){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.30;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }
                    	}if(($inscripcion == "1") && ($sqlcreadorv[0] !== 4)){
                    	    if($cganador == 1){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.10;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 2){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.10;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }if($cganador == 3){
                                $premiop = $price*$equipos;
                        	    $premiop2 = $premiop*0.10;
                        	    $premiox = $premiop-$premiop2;
                        	    $premio = $price."/".$premiox;
                            }
                    	}
            			$subir = "INSERT INTO torneos (id_torneo, id_cuenta, titulo, descripcion, inscripcion, formato, equipos, juego, img, plataforma, tipo, clasificados, price, cant_g, fecha, cant_ganadores) VALUES ('$id_torneo','$id_cuenta','$titulo','$desc','$inscripcion','$formato','$equipos','$juego','img/torneos/default.jpg','$plataforma','$tipo','$equiposc','$premio','$cporg','$hoyF','$cganador')";
            			$sql = $conn->query($subir);
            			
            			echo json_encode('subiendo');
            		}
		        }
		    }
		}
	}
    }
	$conn -> close();
?>