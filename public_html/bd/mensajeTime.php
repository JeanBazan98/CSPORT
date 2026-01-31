<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id_torneo'];
	$id_cuenta = $_SESSION['datos']['id'];
	$id_enf = $_GET['enf'];

	$sql_chat = "SELECT * FROM chat WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '$id_enf'";
	$sql_chatres = $conn->query($sql_chat);

	$sql_chat2 = mysqli_query($conn, "SELECT id_cuenta FROM torneos WHERE id = '$id_torneo'");
	$sql_chatval2 = $sql_chat2->fetch_row();

	while ($chat_r = mysqli_fetch_row($sql_chatres)) {
		$sql_chat3 = mysqli_query($conn, "SELECT id_cuenta,nombre FROM cuentas WHERE id_cuenta = '$chat_r[2]'");
		$sql_chatval3 = $sql_chat3->fetch_row();
		$fecha= new DateTime($chat_r[6]);
	    $fechav = $fecha->format("M j, Y, g:i a");

		if ($chat_r[2] == $id_cuenta) {
			echo "<div class='chat_text active'>
			        <p>$chat_r[4]</p>
			    </div>";
		}else{
			if ($chat_r[2] == $sql_chatval2[0]) {
				echo "<div class='chat_text'>
				        <a href='/perfil/ $sql_chatval3[0]'><span>[Org] $sql_chatval3[1]:</span></a>
				        <p>$chat_r[4]</p>
				        <label class='chat_fecha'>$fechav</label>
				    </div>";
			}else{
				echo "<div class='chat_text'>
				        <a href='/perfil/ $sql_chatval3[0]'><span>$sql_chatval3[1]:</span></a>
				        <p>$chat_r[4]</p>
				        <label class='chat_fecha'>$fechav</label>
				    </div>";
			}
		}
	}
	$conn -> close();
?>