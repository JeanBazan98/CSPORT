<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$email = $_POST['email'];

	$unirse = mysqli_query($conn, "SELECT * FROM cuentas WHERE email = '$email'");
	$val = $unirse->fetch_assoc();

	$unirse2 = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id_torneo'");
	$val2 = $unirse2->fetch_row();
	
	$formato = $val2[7];
    
    $ins3 = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$val[id_cuenta]'");
	$i_val3 = $ins3->fetch_assoc();
	
	$ins3n = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id = '$id_torneo' AND id_cuentar = '$val[id_cuenta]'");
	$ins3nv = $ins3n->fetch_assoc();
	
	if($val2[2] == $_SESSION['datos']['id']){
    	if($email == null){
            echo json_encode('vacio');
        }else{
    	if (!$val) {
    		echo json_encode('email');
    	}else{
    	    if($i_val3){
    	        echo json_encode('j_registrado');
    	    }else{
        		$ins = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'";
        		$i_res = $conn->query($ins);
                $i_resv = mysqli_num_rows($i_res);
        		$cont2 = 0;
        		if ($i_resv >= $val2[8]) {
        			echo json_encode('lleno');
        		}else{
        		    if($ins3nv){
        		        echo json_encode('notificacion');
        		    }else{
        		        $sqlnt = mysqli_query($conn, "INSERT INTO notificaciones (id_cuenta, id_cuentar, tipo, id) VALUES ('$val2[2]','$val[id_cuenta]','TorneoI','$id_torneo')");
        			    echo json_encode('agregado');
        		    }
        		}
    	    }
    	}
        }
	}
	$conn -> close();
?>