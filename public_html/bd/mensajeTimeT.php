<?php
	session_start();
	include_once 'conexion.php';

	$id_torneo = $_GET['id'];
	if(isset($_SESSION['datos']['id'])){
	    $id_cuenta = $_SESSION['datos']['id'];
	}else{
	    $id_cuenta = 0;
	}

	$sql_chat = mysqli_query($conn, "SELECT * FROM chat WHERE id_torneo = '$id_torneo' AND tipo = 'Ticket' ORDER BY id_chat DESC");
	
    $sql_chat2 = mysqli_query($conn, "SELECT * FROM chat WHERE id_chat = '1' AND tipo = 'Ticket'");
    $sql_chat2v = $sql_chat2->fetch_row();
    	    
	while ($chat_r = mysqli_fetch_row($sql_chat)) {
		$sql_chat3 = mysqli_query($conn, "SELECT id_cuenta, nombre, verificado FROM cuentas WHERE id_cuenta = '$chat_r[2]'");
		$sql_chatval3 = $sql_chat3->fetch_row();
		$fecha= new DateTime($chat_r[6]);
	    $fechav = $fecha->format("M j, Y, g:i a");
        
		if (($chat_r[2] == $id_cuenta) || ($chat_r[2] == $id_cuenta)) {
			echo "<div class='chat_text active'>
			        <p>$chat_r[4]</p>
			    </div>";
		}else{
		    if($sql_chatval3[2] == 4){
		        echo "<div class='chat_text'>
			        <span>[ADMIN] $sql_chatval3[1]:</span>
			        <p>$chat_r[4]</p>
			        <label class='chat_fecha'>$fechav</label>
		        </div>";
		    }else{
		        if($chat_r[2] == -1){
		            echo "<div class='chat_text'>
		                    <span>[!]</span>
        			        <p>$chat_r[4]</p>
        		        </div>";
		        }else{
		            echo "<div class='chat_text'>
        			        <span>Usuario:</span>
        			        <p>$chat_r[4]</p>
        			        <label class='chat_fecha'>$fechav</label>
        		        </div>";
		        }
		        
		    }
			
		}
	}
	echo "<div class='chat_text'>
    	        <span>[!]</span>
    	        <p>$sql_chat2v[4]</p>
            </div>";
            
	$conn -> close();
?>