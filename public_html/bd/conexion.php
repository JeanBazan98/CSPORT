<?php
$servername = "localhost";  
$username = "u194993218_cop";
$password = "CC*AA5QUA#;IV#7*m";
$database = "u194993218_cop";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_errno) {
    error_log("❌ Fallo al conectar a MySQL: " . $conn->connect_error);
    exit(); // Detener la ejecución si hay un error
}
?>

