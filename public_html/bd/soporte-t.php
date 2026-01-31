<?php
	session_start();
	include_once 'conexion.php';

	$id_cuenta = $_POST['user'];
    $userid = "0/".$id_cuenta;
    
	$sqlt = mysqli_query($conn, "SELECT id_soporte,descripcion FROM soporte WHERE id_cuenta = '$userid' AND calificacion = '0'");
	while ($sqltv = mysqli_fetch_row($sqlt)) {
	    echo "
	        <a href='/ticket?id=$sqltv[0]' style='text-decoration: none; color: #262626;'><div class='list-soporte'>
                <span>Ticket #$sqltv[0]</span>
                <content>
                    $sqltv[1]
                </content>
            </div></a>
	    ";
	}
	$conn -> close();
?>