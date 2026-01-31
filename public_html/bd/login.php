<?php
	session_start();
	include_once 'conexion.php';

	$email = $_POST['email'];
	$contraseña = $_POST['contraseña'];	

	if (empty($email) || empty($contraseña)) {
		echo json_encode('vacio');
	}else{
		$cuentas = "SELECT email FROM cuentas WHERE email = '$email'";
		$res = $conn->query($cuentas);
		$val = $res->fetch_assoc();

		$cuentas2 = "SELECT * FROM cuentas WHERE email = '$email'";
		$res2 = $conn->query($cuentas2);
		$val2 = $res2->fetch_assoc();

		if ($val) {
			if (password_verify($contraseña, $val2['contraseña'])) {
				$datos = array('id' => $val2['id_cuenta'],'nombre' => $val2['nombre'],'email' => $email);
				$_SESSION['datos'] = $datos;
				
				$id_c = $val2['id_cuenta'];
				$hoy = new DateTime();
	            $hoys = $hoy->format('Y-m-d H:i:s');
	            $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
                $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
                $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
                $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
                $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
                $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
	            if($iphone || $android || $palmpre || $berry || $ipod || $ipad == true){
	                $tipo = "CELULAR";
	            }else{
	                $tipo = "PC";
	            }
	            function getClientIP() {
                    $ip = '';
                    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
                        $ip = $_SERVER['HTTP_X_FORWARDED'];
                    } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
                    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
                    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
                        $ip = $_SERVER['HTTP_FORWARDED'];
                    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }
                
                    return $ip;
                }
                $miip = getClientIP();
	            
	            $sqlcau = mysqli_query($conn, "SELECT inicio FROM actividad WHERE id_cuenta = '$id_c' ORDER BY inicio DESC LIMIT 1");
	            $sqlcauv = $sqlcau->fetch_row();
                
                $shoy = $sqlcauv[0];
                $fechaDes = new DateTime($shoy);
                $diferencia = $hoy->diff($fechaDes);
                if(($diferencia->h >= 8) || ($diferencia->d > 0)){
	                $act_u = mysqli_query($conn, "INSERT INTO actividad (id_cuenta, inicio, tipo, ip) VALUES ('$id_c','$hoys','$tipo','$miip')");
	            }
				echo json_encode('iniciando');
			}else{
				echo json_encode('contrasena');
			}
		}else{
			echo json_encode('email');
		}
	}
	$conn -> close();
?>