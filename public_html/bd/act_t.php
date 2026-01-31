<?php
	session_start();
	include_once 'conexion.php';
	
	if(isset($_GET['ADM'])){
	    $id = $_GET['e'];
    	$titulo = $_POST['titulo'];
    	$desc = $_POST['descripcion'];
    	$juego = $_POST['juego'];
    	$plataforma = $_POST['plataforma'];
    	$id_cuenta = $_SESSION['datos']['id'];
    	$formato = $_POST['formato'];
    	$tipo = $_POST['tipo'];
    	
    	$ac_t = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id'");
    	$resv = $ac_t->fetch_row();
    	
    	$code = rand(100000,999999);
    	$tipo_archivo = $_FILES['imagen']['type'];
        $tamano_archivo = $_FILES['imagen']['size'];
        $ext = explode("/", $tipo_archivo);
        $imgname = $id."_".$code.".".$ext[1];
    
    	if ($_FILES['imagen']['tmp_name']!=""){
    	    if (!((strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 5000000))){
                header('Location: https://csport.es/perfil/'.$id.'&error_ext');
            }else{
        		$carpeta = "../img/torneos/";
        		$destino = $carpeta.$imgname;
        		copy($_FILES['imagen']['tmp_name'], $destino);
        		$carpeta2 = "img/torneos/";
        		$destino2 = $carpeta2.$imgname;
        		
        		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        			$sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', img = '$destino2', plataforma = '$plataforma', tipo = '$tipo' WHERE id = '$id'";
        			$res = $conn->query($sql);
        			header('Location: https://csport.es/torneo/'.$id.'');
        		}else{
        			header('Location: https://csport.es/torneo/'.$id.'&error');
        		}
            }
    	}else{
    		$sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', plataforma = '$plataforma', inscripcion = '$inscripcion', tipo = '$tipo', inscripcion = '$resv[6]' WHERE id = '$id'";
    		$res = $conn->query($sql);
    		header('Location: https://csport.es/torneo/'.$id.'');
    	}
	}
	if(isset($_GET['USER'])){
	    $id = $_GET['e'];
    	$cuenta = $_GET['c'];
    	$titulo = $_POST['titulo'];
    	$desc = $_POST['descripcion'];
    	$juego = $_POST['juego'];
    	$plataforma = $_POST['plataforma'];
    	$id_cuenta = $_SESSION['datos']['id'];
    	$formato = $_POST['formato'];
    	$equipos_clasificados = $_POST['equipos_clasificados'];
    	$tipo = $_POST['tipo'];
    	
    	if ($formato == 'Liga'){
    	    $equipos = $_POST['equipos2'];
    	}
    	if ($formato == 'Liga E') {
    	    $equipos = $_POST['equipos2'];
    	}
    	if($formato == 'Eliminacion D'){
    	    $equipos = $_POST['equipos3'];
    	}
    	if ($formato == 'Grupos E'){
    	    $equipos = $_POST['equipos_e'];
    	    $cporg = $_POST['equipos'];
    	    $equipos = $equipos * $cporg;
    	}
    	
    	$ac_t2 = mysqli_query($conn, "SELECT * FROM torneos WHERE id_torneo = '$id' AND id_cuenta = '$id_cuenta'");
    	$resv = $ac_t2->fetch_row();
    	
    	$code = rand(100000,999999);
    	$tipo_archivo = $_FILES['imagen']['type'];
        $tamano_archivo = $_FILES['imagen']['size'];
        $ext = explode("/", $tipo_archivo);
        $imgname = $id."_".$code.".".$ext[1];
    	
    	if ($_FILES['imagen']['tmp_name']!=""){
    	    if (!((strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 5000000))){
                header('Location: https://csport.es/perfil/'.$id.'&error_ext');
            }else{
                $carpeta = "../img/torneos/";
        		$destino = $carpeta.$imgname;
        		copy($_FILES['imagen']['tmp_name'], $destino);
        		$carpeta2 = "img/torneos/";
        		$destino2 = $carpeta2.$imgname;
        		
        		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
        		    if($resv[6] == '1'){
        		        $pcw = explode("/", $resv[17]);
        		        $pcwd = $pcw[0]*$equipos;
        		        $pcwd2 = $pcwd*0.40;
        		        $pcwd3 = $pcwd-$pcwd2;
        		        $premio = $pcw[0]."/".$pcwd3;
        		        
        		        $sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', img = '$destino2', plataforma = '$plataforma', formato = '$formato', clasificados = '$equipos_clasificados', tipo = '$tipo', equipos = '$equipos', cant_g = '$cporg', price = '$premio' WHERE id_torneo = '$id' AND id_cuenta = '$id_cuenta'";
        			    $res = $conn->query($sql);
        			    header('Location: https://csport.es/perfil/'.$cuenta.'&e='.$id.'');
        		    }else{
        		        $sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', img = '$destino2', plataforma = '$plataforma', formato = '$formato', clasificados = '$equipos_clasificados', tipo = '$tipo', equipos = '$equipos', cant_g = '$cporg' WHERE id_torneo = '$id' AND id_cuenta = '$id_cuenta'";
        			    $res = $conn->query($sql);
        			    header('Location: https://csport.es/perfil/'.$cuenta.'&e='.$id.'');
        		    }
        		}else{
        			header('Location: https://csport.es/perfil/'.$cuenta.'&e='.$id.'&error_img');
        		}
            }
    	}else{
    	    if($resv[6] == '1'){
		        $pcw = explode("/", $resv[17]);
		        $pcwd = $pcw[0]*$equipos;
		        $pcwd2 = $pcwd*0.40;
		        $pcwd3 = $pcwd-$pcwd2;
		        $premio = $pcw[0]."/".$pcwd3;
		        
		        $sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', plataforma = '$plataforma', formato = '$formato', clasificados = '$equipos_clasificados', tipo = '$tipo', equipos = '$equipos', cant_g = '$cporg', price = '$premio' WHERE id_torneo = '$id' AND id_cuenta = '$id_cuenta'";
    		    $res = $conn->query($sql);
    		    header('Location: https://csport.es/perfil/'.$cuenta.'&e='.$id.'');
		    }else{
		        $sql= "UPDATE torneos SET titulo = '$titulo', descripcion = '$desc', juego = '$juego', plataforma = '$plataforma', formato = '$formato', clasificados = '$equipos_clasificados', tipo = '$tipo', equipos = '$equipos', cant_g = '$cporg' WHERE id_torneo = '$id' AND id_cuenta = '$id_cuenta'";
    		    $res = $conn->query($sql);
    		    header('Location: https://csport.es/perfil/'.$cuenta.'&e='.$id.'');
		    }
    	}
	}
	$conn -> close();
?>