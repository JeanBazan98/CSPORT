<?php
    include_once 'conexion.php';
    session_start();
    $id_cuenta = $_SESSION['datos']['id'];
    $id_torneo = $_GET['id'];
    
    $cverif = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'");
    $cverifv = $cverif->fetch_row();
    
    function getClientIP() {
        $ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    
        return $ip;
    }
    $miip = getClientIP();
    
    if ($cverifv[4] > 1){
        if(isset($_GET['ADM'])){
            $sqli2 = mysqli_query($conn, "SELECT img FROM torneos WHERE id = '$id_torneo'");
            $sqliv2 = $sqli2->fetch_row();
            $imglink = explode("/", $sqliv2[0]);
            if($imglink[2] != "default.jpg"){
                unlink('../'.$sqliv2[0]);
            }
            
            $sqlit = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id_torneo'");
            $sqlitv = $sqlit->fetch_row();
            $datost = $sqlitv[0]."/".$sqlitv[1]."/".$sqlitv[2]."/".$sqlitv[3]."/".$sqlitv[4]."/".$sqlitv[5]."/".$sqlitv[6]."/".$sqlitv[7]."/".$sqlitv[8]."/".$sqlitv[9]."/".$sqlitv[11]."/".$sqlitv[12]."/".$sqlitv[13]."/".$sqlitv[14]."/".$sqlitv[15]."/".$sqlitv[16]."/".$sqlitv[17]."/".$sqlitv[18]."/".$sqlitv[19]."/".$sqlitv[20]."/".$sqlitv[21]."/"."/".$sqlitv[22]."/".$sqlitv[23];
            $regis = mysqli_query($conn, "INSERT INTO registro (id, tipo, id_cuenta, datos, ip) VALUES ('$id_torneo','Elimino/Torneo/Bases','$id_cuenta','$datost','$miip')");
            
            $sqle4 = "DELETE FROM torneos WHERE id = '$id_torneo'";
            $sqleres4 = $conn->query($sqle4);
            
        	header('Location: https://csport.es/buscador');
        }
    }else{
        header('Location: https://csport.es/torneo/'.$id_torneo.'');
    }
    if(!isset($_GET['ADM'])){
        $sqlct = mysqli_query($conn, "SELECT id_cuenta FROM torneos WHERE id = '$id_torneo'");
        $sqlctv = $sqlct->fetch_row();
        if($id_cuenta == $sqlctv[0]){
            $sqli2 = mysqli_query($conn, "SELECT img FROM torneos WHERE id = '$id_torneo'");
            $sqliv2 = $sqli2->fetch_row();
            $imglink = explode("/", $sqliv2[0]);
            if($imglink[2] != "default.jpg"){
                unlink('../'.$sqliv2[0]);
            }
            
            $sqlit = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$id_torneo'");
            $sqlitv = $sqlit->fetch_row();
            $datost = $sqlitv[0]."/".$sqlitv[1]."/".$sqlitv[2]."/".$sqlitv[3]."/".$sqlitv[4]."/".$sqlitv[5]."/".$sqlitv[6]."/".$sqlitv[7]."/".$sqlitv[8]."/".$sqlitv[9]."/".$sqlitv[11]."/".$sqlitv[12]."/".$sqlitv[13]."/".$sqlitv[14]."/".$sqlitv[15]."/".$sqlitv[16]."/".$sqlitv[17]."/".$sqlitv[18]."/".$sqlitv[19]."/".$sqlitv[20]."/".$sqlitv[21]."/"."/".$sqlitv[22]."/".$sqlitv[23];
            $regis = mysqli_query($conn, "INSERT INTO registro (id, tipo, id_cuenta, datos, ip) VALUES ('$id_torneo','Elimino/Torneo/Bases','$id_cuenta','$datost','$miip')");
            
            $sqle4 = "DELETE FROM torneos WHERE id = '$id_torneo'";
            $sqleres4 = $conn->query($sqle4);
            
        	header('Location: https://csport.es/perfil/'.$id_cuenta.'');
        }else{
            header('Location: https://csport.es/perfil/'.$id_cuenta.'');
        }
    }
    $conn -> close();
?>