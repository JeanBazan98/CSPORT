<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	$nombre = $_POST['nombre'];

    $sql = mysqli_query($conn, "SELECT * FROM cuentas WHERE nombre = '$nombre'");
    $sqlv = $sql->fetch_row();
    
    $sqlt = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id_torneo'");
    $sqltv = $sqlt->fetch_row();
    
    if($sqltv[2] == $_SESSION['datos']['id']){
        if($sqlv){
            if($sqlv[2] == "#ID"){
                $sql2 = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' AND id_cuenta = '$sqlv[0]'");
                $sqlv2 = $sql2->fetch_row();
                if($sqlv2){
                    echo json_encode('inscripto');
                }else{
                    $sql3 = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo'");
                    $sqlv3 = mysqli_num_rows($sql3);
                    if($sqlv3 >= $sqltv[8]){
                        echo json_encode('lleno');
                    }else{
                        $ins = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' ORDER BY id_rtorneos DESC LIMIT 1");
            		    $insv = $ins->fetch_row();
            		    $nro = $insv[4] + 1;
            		    
            			$registrar = mysqli_query($conn, "INSERT INTO r_torneos (id_torneo, id_cuenta, formato, nro) VALUES ('$id_torneo','$sqlv[0]','$sqltv[7]','$nro')");
            
            			$upd = mysqli_query($conn, "UPDATE torneos SET activo = '1' WHERE id = '$id_torneo'");
                        echo json_encode('agregado');
                    }
                }
            }else{
                echo json_encode('nombrer');
            }
        }else{
            $registrar2 = "INSERT INTO cuentas (nombre, email, img) VALUES ('$nombre','#ID','img/cuenta/bot.jpg')";
            $sql2 = $conn->query($registrar2);
        }
    }
    $conn -> close();
?>