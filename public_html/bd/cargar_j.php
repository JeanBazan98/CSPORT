<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_SESSION['datos']['id']; $juego = $_POST['juego'];
	$sqlc = mysqli_query($conn, "SELECT juegos FROM cuentas WHERE id_cuenta = '$id'");
	$sqlcv = $sqlc->fetch_row();
	
	if($sqlcv[0]){
	    $juegoS = $sqlcv[0];
	    $array = explode("/", $juegoS);
        $conteo = count($array);
        $contJ = 0; $arrayJ = array();
        
        while($contJ < $conteo){
            if(array_push($arrayJ, $array[$contJ])){} $contJ = $contJ + 1;
        }
        
        $existe = false;
        foreach ($arrayJ as $valor) { if ($valor === $juego) { $existe = true; } }
        if($existe) {
            echo json_encode('existe');
        }else{
            $juegoSF = $juego."/".$sqlcv[0];
            $sql = mysqli_query($conn, "UPDATE cuentas SET juegos = '$juegoSF' WHERE id_cuenta = '$id'");
	        echo json_encode('cambiado');
        }
	}else{
    	if($juego !== ""){
    	    $juegoF = $juego;
    	    $sql = mysqli_query($conn, "UPDATE cuentas SET juegos = '$juegoF' WHERE id_cuenta = '$id'");
    	    echo json_encode('cambiado');
    	} 
	}
	$conn -> close();
?>