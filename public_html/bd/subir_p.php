<?php
	session_start();
	include_once 'conexion.php';
	
	$id_torneo = $_GET['id']; $id_enfrentamiento = $_GET['enf'];
	$id_cuenta = $_GET['c']; $gver = $_GET['g'];
	
    $tipo_archivo = $_FILES['imagen']['type'];
    $tamano_archivo = $_FILES['imagen']['size'];
    $ext = explode("/", $tipo_archivo);
    $nombrei = $id_cuenta."_".$id_torneo."-".$id_enfrentamiento.".".$ext[1];
    
    $tipo_archivo2 = $_FILES['imagen2']['type'];
    $tamano_archivo2 = $_FILES['imagen2']['size'];
    $ext2 = explode("/", $tipo_archivo2);
    $nombrei2 = $id_cuenta."_".$id_torneo."-".$id_enfrentamiento.".".$ext2[1];
    
    if ($_FILES['imagen']['tmp_name'] != ""){
        if (!((strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpg")) && ($tamano_archivo < 5000000))){
            header('Location: https://csport.es/fixture/'.$id_torneo.'&ver_g='.$gver.'&c='.$id_cuenta.'&enfretamiento='.$id_enfrentamiento.'error');
        }else{
    		$carpeta = "../img/pruebas/";
    		$destino = $carpeta.$nombrei;
    		copy($_FILES['imagen']['tmp_name'], $destino);
    		$carpeta2 = "img/pruebas/";
    		$destino2 = $carpeta2.$nombrei;
    		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
    			$registrar = "INSERT INTO pruebas (id_torneo, id_enfrentamiento, id_cuenta, img) VALUES ('$id_torneo','$id_enfrentamiento','$id_cuenta','$destino2')";
    			$sql = $conn->query($registrar);
    			header('Location: https://csport.es/fixture/'.$id_torneo.'&ver_g='.$gver.'&c='.$id_cuenta.'&enfretamiento='.$id_enfrentamiento.'');
    		}else{
    			header('Location: https://csport.es/fixture/'.$id_torneo.'&ver_g='.$gver.'&c='.$id_cuenta.'&enfretamiento='.$id_enfrentamiento.'error');
    		}
        }
	}
    if ($_FILES['imagen2']['tmp_name'] != ""){
        if (!((strpos($tipo_archivo2, "jpeg") || strpos($tipo_archivo2, "png") || strpos($tipo_archivo2, "jpg")) && ($tamano_archivo2 < 5000000))){
            header('Location: https://csport.es/fixture/'.$id_torneo.'&lver='.$gver.'&c='.$id_cuenta.'error');
        }else{
    		$carpeta = "../img/pruebas/";
    		$destino = $carpeta.$nombrei2;
    		copy($_FILES['imagen2']['tmp_name'], $destino);
    		$carpeta2 = "img/pruebas/";
    		$destino2 = $carpeta2.$nombrei2;
    		if (move_uploaded_file($_FILES['imagen2']['tmp_name'], $destino)) {
    
    			$registrar = "INSERT INTO pruebas (id_torneo, id_enfrentamiento, id_cuenta, img) VALUES ('$id_torneo','$id_enfrentamiento','$id_cuenta','$destino2')";
    			$sql = $conn->query($registrar);
    
    			header('Location: https://csport.es/fixture/'.$id_torneo.'&lver='.$gver.'&c='.$id_cuenta.'');
    		}else{
    			header('Location: https://csport.es/fixture/'.$id_torneo.'&lver='.$gver.'&c='.$id_cuenta.'error');
    		}
        }
	}
	$conn -> close();
?>