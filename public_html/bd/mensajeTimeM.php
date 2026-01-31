<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_SESSION['datos']['id'];
	$id2 = $_GET['id'];

	$sql_chat = "SELECT * FROM chat WHERE (id_cuenta = '$id_cuenta' AND id_enfrentamiento = '$id2' AND tipo = 'Msj') OR (id_cuenta = '$id2' AND id_enfrentamiento = '$id_cuenta' AND tipo = 'Msj') ORDER BY id_chat DESC LIMIT 100";
	$sql_chatres = $conn->query($sql_chat);

	while ($chat_r = mysqli_fetch_row($sql_chatres)) {
		$sql_chat3 = "SELECT * FROM cuentas WHERE id_cuenta = '$chat_r[2]'";
		$sql_chatres3 = $conn->query($sql_chat3);
		$sql_chatval3 = $sql_chatres3->fetch_row();

		if (($chat_r[2] == $id_cuenta) || ($chat_r[3] == $id2)) {
		    
			echo "<div class='chat_text active'><p>$chat_r[4]</p></div>";
		}else{
	        echo "<div class='chat_text'><span>$sql_chatval3[1]:</span><p>$chat_r[4]</p></div>";
		}
	}
	$conn -> close();
?>