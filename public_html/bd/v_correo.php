<?php
    session_start();
	include_once 'conexion.php';
	$id = $_SESSION['datos']['id'];
	$email = $_SESSION['datos']['email'];
	
	$sqlcuenta = "SELECT * FROM cuentas WHERE id_cuenta = '$id'";
	$sqlcuentares = $conn->query($sqlcuenta);
	$sqlcuentaval = $sqlcuentares->fetch_row();
	
	if (empty($_SESSION['datos'])) {
		header('Location: https://csport.es/');
	}
	
	require '../PHPMailer/Exception.php';
	require '../PHPMailer/PHPMailer.php';
	require '../PHPMailer/SMTP.php';
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    if (($sqlcuentaval[6] !== "") || ($sqlcuentaval[4] > 0)){
	    header('Location: https://csport.es/perfil/'.$id.'&code_enviado');
	}else{
        $mail = new PHPMailer();
    	$code = rand(100000,999999);
    	$titulo = "Verificacion de CSport [ ".$code." ]";
    	$desc = "Codigo de verificacion de CSport.es <br>".$code;
        
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
        //$mail->send();
      
        if(!$mail->send()) {
            header('Location: https://csport.es/perfil/'.$id.'&no-enviado');
        }else{
            $sqlc = "UPDATE cuentas SET code = '$code' WHERE id_cuenta = '$id'";
    		$res = $conn->query($sqlc);
    		header('Location: https://csport.es/perfil/'.$id.'&enviado');
        }
	}
	$conn -> close();
?>