<?php
	session_start();
	include_once 'conexion.php';
	
    require '../PHPMailer/Exception.php';
    require '../PHPMailer/PHPMailer.php';
	require '../PHPMailer/SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
	$email = $_POST['email'];
	
	$sqlcuenta = "SELECT * FROM cuentas WHERE email = '$email'";
	$sqlcuentares = $conn->query($sqlcuenta);
	$sqlcuentaval = $sqlcuentares->fetch_row();
    
	if (empty($email)){
		echo json_encode('vacio');
	}else{
		$cuentas = "SELECT email FROM cuentas WHERE email = '$email'";
		$res = $conn->query($cuentas);
		$val = $res->fetch_row();
		if ($val){
            $mail = new PHPMailer();
        	$code = rand(100000,999999);
        	$titulo = "Recuperacion tu clave de CSport";
        	$desc = "Copia y pega este link en tu navegador: https://csport.es/login.php?id=".$sqlcuentaval[0]."&code=".$code."";
            
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no.reply.csport@gmail.com';
            $mail->Password = 'qibftmkwqhmhktad';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
        
            //Recipients
            $mail->setFrom('no.reply.csport@gmail.com', 'CSport');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $titulo;
            $mail->Body = $desc;
          
            if (!$mail->send()){
                echo json_encode('error');
            }else{
                $sqlc = "UPDATE cuentas SET code = '$code' WHERE email = '$email'";
        		$res = $conn->query($sqlc);

        		echo json_encode('exitoso');
            }
		}else{
			echo json_encode('email');
		}
	}
?>