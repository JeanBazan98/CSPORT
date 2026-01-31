<?php
	session_start();
	include_once 'conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
	$email = $_POST['email'];
	
	$adm = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id_cuenta'");
	$admv = $adm->fetch_row();
	$emailsl = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email = '$email'");
	$emailslv = $emailsl->fetch_row();
	$idc = $emailslv[0];
	
	if($admv[0] == 4){
	    if(isset($_GET['dp'])){
	        $hoy = new DateTime();
            $hoys = $hoy->format('Y-m-d H:i:s');
    	
	        $saldo = $_POST['saldo']; $orden = $_POST['orden']; $transs = $_POST['transs']; $id = $_POST['id'];
	        $tipod = explode("/", $transs);
	        $sqlcdt = mysqli_query($conn, "SELECT email FROM cuentas WHERE id_cuenta = '$id'");
	        $sqlcdtv = $sqlcdt->fetch_row();
	        
	        if($tipod[0] == "d"){
	            $tipodt = "Deposito";
	        }if($tipod[0] == "r"){
	            $tipodt = "Retiro";
	        }
	        $wallet = mysqli_query($conn, "UPDATE wallet SET saldo = saldo + '$saldo' WHERE id_cuenta = '$id'");
	        $transsacion = mysqli_query($conn, "INSERT INTO wallet_t (id_cuenta, tipo, saldo, metodo, orden, email, status, fecha) VALUES ('$id','$tipodt','$saldo','$tipod[1]','$orden','$sqlcdtv[0]','COMPLETED','$hoys')");
	        
	        $arr = array('agregado');
	        echo json_encode($arr);
	    }else{
    	    if($emailslv){
    	        $arr = array('aprobado',$idc,$email);
                echo json_encode($arr);
    	    }else{
    	        $arr = array('email');
    	        echo json_encode($arr);
    	    }
	    }
	}else{
	    echo json_encode('adm');
	}
?>