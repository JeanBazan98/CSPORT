<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id_torneo'];
	$id_cuenta = $_SESSION['datos']['id'];
	$id_enf = $_GET['enf'];

	$sql_chat = "SELECT * FROM chat WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$id_enf'";
	$sql_chatres = $conn->query($sql_chat);

	$sql_chat2 = "SELECT * FROM torneos WHERE id = '$id_torneo'";
	$sql_chatres2 = $conn->query($sql_chat2);
	$sql_chatval2 = $sql_chatres2->fetch_row();

	while ($chat_r = mysqli_fetch_row($sql_chatres)) {
		$sql_chat3 = "SELECT * FROM cuentas WHERE id_cuenta = '$chat_r[2]'";
		$sql_chatres3 = $conn->query($sql_chat3);
		$sql_chatval3 = $sql_chatres3->fetch_row();

		if ($chat_r[2] == $id_cuenta) {
			echo "<p class='cgt_local'>$chat_r[4]</p>";
		}else{
			echo "<p class='cgt_visit'><span>$sql_chatval3[1]: </span>$chat_r[4]</p>";
		}
		
	}
	$conn -> close();
?>