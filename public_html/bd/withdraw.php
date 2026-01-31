<?php
	session_start();
	include_once 'conexion.php';
	
	$id = $_SESSION['datos']['id'];
	$email = $_POST['email']; $metodo = $_POST['metodo'];
	$s_wallet = $_POST['saldo'];
	$saldo  = number_format($s_wallet, 2, '.', ',');
	
	$sqlws = mysqli_query($conn, "SELECT saldo FROM wallet WHERE id_cuenta = '$id'");
	$sqlwsv = $sqlws->fetch_row();
    if($sqlwsv[0] >= $saldo){
        $hoy = new DateTime();
    	$hoys = $hoy->format('Y-m-d H:i:s');
    	
    	function orderID($leng = 10){
    	    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
    	    $ordercID = "";
    	    for($i=0; $i<$leng; $i++){
    	        $ordercID .= $cadena[rand(0,35)];
    	    }
    	    return $ordercID;
    	}
    	
    	$orderID = orderID(17);
    	
        $sql = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, email, status, fecha, orden) VALUES ('$id','Retiro','$saldo','$metodo','$email','WAIT','$hoys','$orderID')");
        $sql2 = mysqli_query($conn, "UPDATE wallet SET saldo = saldo - '$saldo' WHERE id_cuenta = '$id'");
	    echo json_encode('aprobado');
	}else{
	    echo json_encode('balance');
	}
	$conn -> close();
?>