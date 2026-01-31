<?php
	session_start();
	include_once 'conexion.php';
	$id = $_SESSION['datos']['id'];
	$nombre = $_SESSION['datos']['nombre'];
	
	$sqlcode = "SELECT * FROM cuentas WHERE id_cuenta = '$id'";
	$sqlcoder = $conn->query($sqlcode);
	$sqlcodev = $sqlcoder->fetch_array();
    
    $tipo_archivo = $_FILES['imagen']['type'];
    $tamano_archivo = $_FILES['imagen']['size'];
    $ext = explode("/", $tipo_archivo);
    $imgname = $id."_".$nombre.".".$ext[1];
    
    if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 2000000))){
        header('Location: https://csport.es/perfil/'.$id.'&error_ext');
    }else{
        if (isset($_POST['cfoto'])) {
    		$carpeta = "../img/cuenta/";
    		$destino = $carpeta.$imgname;
    		copy($_FILES['imagen']['tmp_name'], $destino);
    		$carpeta2 = "img/cuenta/";
    		$destino2 = $carpeta2.$imgname;
    
    		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
    			$subir = "UPDATE cuentas SET img = '$destino2' WHERE id_cuenta = '$id'";
    			$sql = $conn->query($subir);
    			header('Location: https://csport.es//perfil/'.$id.'');
    		}else{
    			header('Location: https://csport.es/perfil/'.$id.'&error_img');
    		}
    	}
    }
	$conn -> close();
?>