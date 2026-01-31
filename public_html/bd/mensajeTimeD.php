<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id_torneo'];
	$id_cuenta = $_SESSION['datos']['id'];

	$sql_chat = "SELECT * FROM chat WHERE id_torneo = '$id_torneo' AND id_enfrentamiento = '0' ORDER BY id_chat DESC";
	$sql_chatres = $conn->query($sql_chat);

	while ($chat_r = mysqli_fetch_row($sql_chatres)) {
		$sql_chat3 = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$chat_r[2]'");
		$sql_chatval3 = $sql_chat3->fetch_row();
		$fecha= new DateTime($chat_r[6]);
	    $fechav = $fecha->format("M j, Y, g:i a");

		if ($chat_r[2] == $id_cuenta) {
			echo "<div class='chat_text active'>
			        <p>$chat_r[4]</p>
			    </div>";
		}else{
			if ($sql_chatval3[4] == 4) {
				echo "<div class='chat_text'>
				        <span>[ADMIN] $sql_chatval3[1]:</span>
				        <p>$chat_r[4]</p>
				        <label class='chat_fecha'>$fechav</label>
			        </div>";
			}else{
			    if ($chat_r[2] == 0) {
			        echo "<div class='chat_text'>
			                <span>[CSPORT]</span>
			                <p>$chat_r[4]</p>
			            </div>";
			    }else{
			        echo "<div class='chat_text'>
			                <span>$sql_chatval3[1]:</span>
			                <p>$chat_r[4]</p>
			                <label class='chat_fecha'>$fechav</label>
			            </div>";
			    }
			}
		}
	}
	$conn -> close();
?>