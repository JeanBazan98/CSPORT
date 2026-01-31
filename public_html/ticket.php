<?php
    error_reporting(0);
    session_start();
    include_once 'bd/conexion.php';
    
    $id = $_SESSION['datos']['id']; $id_s = $_GET['id'];
    
    $idtt = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id'");
    $idttv = $idtt->fetch_row();
    $idt = mysqli_query($conn, "SELECT * FROM soporte WHERE id_soporte = '$id_s'");
    $idtv = $idt->fetch_row();
?>
<html>
<head>
    <title>Ticket - Csport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/ticket.css">
    <link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
</head>
<body>
    <script src="../status.js"></script>
    <script type="text/javascript">
        var userTN = "0/"+localStorage.getItem('sc_oUser');
        var userSql = "<?php echo $idtv[1]; ?>";
<?php
        if(isset($_GET['r'])){
            if($idttv[0] == 4){
                $updt = mysqli_query($conn, "UPDATE soporte SET adm = '$id' WHERE id_soporte = '$id_s'");
            }
        }else{
?>
        if(userSql == userTN){
        }else{
            window.location = "/soporte?tickets";
        }
<?php
        }
?>
        
    </script>
    <div id="pantalla">
<?php
    $usersp = explode("/", $idtv[1]);
    if($idtv[2] == "Olvidaste"){
        $formato = "Dirección de correo electrónico";
    }if($idtv[2] == "Conoces"){
        $formato = "No puedo entrar a mi cuenta";
    }if($idtv[2] == "Persona"){
        $formato = "Otra persona usa mi cuenta";
    }if($idtv[2] == "Saldo"){
        $formato = "No sabe como recargar saldo";
    }if($idtv[2] == "Deposite"){
        $formato = "Deposito y no se le reflejo";
    }
    
    
?>
    	<header id="hbar">
			<ul>
				<?php
					if (empty(($_SESSION['datos']))) {
				?>
					<li><a href="/">CSPORT</a></li>
					<li><a href="/login">Iniciar sesion</a></li>
				<?php
					}else{
				?>
				    <li id="btn-desp" style="float: left; display: none;"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M16 18V20H5V18H16ZM21 11V13H3V11H21ZM19 4V6H8V4H19Z"></path></svg></a></li>
					<li style="margin-left: 2rem; float: left;"><a href="/">CSPORT</a></li>
					<li><a href="/bd/cerrar" style="margin-right: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z"></path></svg></a></li>
					<li><a href="/perfil/<?php echo $_SESSION['datos']['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg></a></li>
				<?php
        	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id' AND estado = '0'");
        	        $notsql2v = mysqli_num_rows($notsql2);
        	    ?>
					<li><a href="/buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(255,255,255,1)"><path d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z"></path></svg></a></li>
				<?php
					}
				?>
			</ul>
		</header>
        <div id="contenido">
            <header><h3>Ticket #<?php echo $idtv[0]; ?></h3></header>
            <header><span><?php echo $formato; ?></span></header>
<?php
        if($idtv[5] == $id){
?>
            <sidebar>
                <h3>Usuario</h3>
                <p><?php echo $usersp[1]; ?></p>
<?php
            if($idtv[6] == 0){
?>
                <button id="f-ticket">Finalizar ticket</button>
<?php
            }
?>
            </sidebar>
<?php
        }else{
            if(($idtv[5] !== $id) && ($idtv[6] == 1)){
?>
                <sidebar>
                    <h3>Ticket cerrado</h3>
                    <p>Califica la atencion</p>
                    <div id="stars">
<?php
                    if($idtv[8] == 0){
    ?>
                        <ul>
                            <li id="ct1" style="cursor: pointer;"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li id="ct2" style="cursor: pointer;"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li id="ct3" style="cursor: pointer;"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li id="ct4" style="cursor: pointer;"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li id="ct5" style="cursor: pointer;"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                        </ul>
    <?php
                    }else{
                        if($idtv[8] == 1){
                            echo "<ul>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                        </ul>";
                        }
                        if($idtv[8] == 2){
                            echo "<ul>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                        </ul>";
                        }
                        if($idtv[8] == 3){
                            echo "<ul>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                        </ul>";
                        }
                        if($idtv[8] == 4){
                            echo "<ul>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(217,169,47,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26ZM12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502L9.96214 9.69434L5.12921 10.2674L8.70231 13.5717L7.75383 18.3451L12.0006 15.968Z'></path></svg></li>
                        </ul>";
                        }
                        if($idtv[8] == 5){
                            echo "<ul>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                            <li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></li>
                        </ul>";
                        }
                    }
?>
                    </div>
                </sidebar>
<?php
            }
        }
?>
            <div id="fase-j">
                <content>
                    <h4>" <?php echo $idtv[3]; ?> "</h4>
                    <div id="enf"></div>
<?php
                if($idtv[7] == 0){
?>
                    <form id="form-t">
                        <input type="text" id="mensajemsj" placeholder="Escribe aqui...">
                        <button id="msj-p"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558ZM5 4.38249V10.9999H10V12.9999H5V19.6174L18.8499 11.9999L5 4.38249Z"></path></svg></button>
                    </form>
<?php
                }
?>
                </content>
            </div>
    	</div>
    </div>
</body>
</html>
<script type="text/javascript">
    $('#ct1').click(function(e) {
		e.preventDefault();
		
        document.getElementById('ct1').disabled = true;
		var php = "ct=1";

		$.ajax({
			url: '/bd/calificacion.php?id=<?php echo $id_s; ?>&ticket',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "calificado") {
			    $("#stars").load(location.href + " #stars");
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	$('#ct2').click(function(e) {
		e.preventDefault();
		
        document.getElementById('ct2').disabled = true;
		var php = "ct=2";

		$.ajax({
			url: '/bd/calificacion.php?id=<?php echo $id_s; ?>&ticket',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "calificado") {
			    $("#stars").load(location.href + " #stars");
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	$('#ct3').click(function(e) {
		e.preventDefault();
		
        document.getElementById('ct3').disabled = true;
		var php = "ct=3";

		$.ajax({
			url: '/bd/calificacion.php?id=<?php echo $id_s; ?>&ticket',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "calificado") {
                $("#stars").load(location.href + " #stars");
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	$('#ct4').click(function(e) {
		e.preventDefault();
		
        document.getElementById('ct4').disabled = true;
		var php = "ct=4";

		$.ajax({
			url: '/bd/calificacion.php?id=<?php echo $id_s; ?>&ticket',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "calificado") {
                $("#stars").load(location.href + " #stars");
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	$('#ct5').click(function(e) {
		e.preventDefault();
		
        document.getElementById('ct5').disabled = true;
		var php = "ct=5";

		$.ajax({
			url: '/bd/calificacion.php?id=<?php echo $id_s; ?>&ticket',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "calificado") {
                $("#stars").load(location.href + " #stars");
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	
    $('#f-ticket').click(function(e) {
		e.preventDefault();
		
        document.getElementById('f-ticket').disabled = true;
		var php = "chat=1";

		$.ajax({
			url: '/bd/soporte-f.php?id=<?php echo $id_s; ?>',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "cerrado") {
			    document.getElementById('f-ticket').style.display = "none";
			    document.getElementById('form-t').style.display = "none";
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
    $('#msj-p').click(function(e) {
		e.preventDefault();
		
        document.getElementById('msj-p').disabled = false;
		var mensaje = document.getElementById('mensajemsj').value;
		var php = "mensaje="+mensaje+"&id_c=<?php echo $id; ?>";

		$.ajax({
			url: '/bd/mensajeT.php?id=<?php echo $id_s; ?>',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "enviado") {
			    document.getElementById('msj-p').disabled = false;
				document.getElementById('mensajemsj').value = "";
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
	setInterval(function(){
		$.ajax({
			url: '/bd/mensajeTimeT.php?id=<?php echo $id_s; ?>',
			type: 'POST',
			dataType: 'text',
			success:function(data){
				$("#enf").html(data);
			}
		});
	}, 1000);
    $('#vtor').click(function(e) {
	e.preventDefault();
    document.getElementById('vtor').disabled = true;

	$.ajax({
		url: '/bd/auditar_t.php?id=<?php echo $torneo; ?>',
		type: 'POST',
		dataType: 'json',
	})
	.done(function(res) {
		if (res == "aprobado") {
			setTimeout(() => {
				window.location = "/administracion";
			}, 1000);
		}
	})
	.fail(function() {
	})
	.always(function() {
	});
});
    
	pantalla = window.innerHeight
	document.getElementById('pantalla').style.height = pantalla+'px';
</script>