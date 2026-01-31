<?php
	session_start();
	session_destroy();
	header('Location: https://csport.es/');
	$conn -> close();
?>