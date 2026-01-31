<?php
    error_reporting(0);
    session_start();
    include_once 'bd/conexion.php';
    
    $id = $_SESSION['datos']['id']; $torneo = $_GET['t'];
    
    $sql = mysqli_query($conn, "SELECT comienzo,auditado FROM torneos WHERE id = '$torneo'");
    $sqlv = $sql->fetch_row();
    if(($sqlv[0] == '3') && ($sqlv[1] == $id)){
?>
    <html>
    <head>
        <title>Auditar - Csport</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/auditar.css">
        <link rel="icon" type="image/x-icon" href="/img/Logo.png">
    	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    </head>
    <body>
        <div id="pantalla">
    <?php
        $idt = mysqli_query($conn, "SELECT titulo,formato,tipo FROM torneos WHERE id = '$torneo'");
        $idtv = $idt->fetch_row();
        $enft1 = mysqli_query($conn, "SELECT id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Octavos'");
        $enftv1 = $enft1->fetch_row();
        $enft2 = mysqli_query($conn, "SELECT id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Cuartos'");
        $enftv2 = $enft2->fetch_row();
        $enft3 = mysqli_query($conn, "SELECT id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Semis'");
        $enftv3 = $enft3->fetch_row();
        $enft4 = mysqli_query($conn, "SELECT id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Final'");
        $enftv4 = $enft4->fetch_row();
        
        if($idtv[1] == "Liga"){
            $formato = "Sistema de Liga";
        }if($idtv[1] == "Liga E"){
            $formato = "Sistema de Liga + Eliminacion D.";
        }if($idtv[1] == "Grupos E"){
            $formato = "Sistema de Grupos + Eliminacion D.";
        }if($idtv[1] == "Eliminacion D"){
            $formato = "Sistema de Eliminacion Directa";
        }if($idtv[2] == "Ida"){
            $tipo = "Solo ida";
        }if($idtv[2] == "Vuelta"){
            $tipo = "Ida y vuelta";
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
    					<li><a href="/buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(255,255,255,1)"><path d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z"></path></svg><p>Buscar</p></a></li>
    				<?php
    					}
    				?>
    			</ul>
    		</header>
    <?php
        if($idtv[1] == "Liga"){
    ?>
        <div id="contenido">
            <header><h3><?php echo $idtv[0]; ?></h3></header>
            <header><span class="f-activa">Fase jornadas</span></header>
            <sidebar>
                <h3>Formato</h3>
                <p><?php echo $formato; ?></p>
                <h3>Tipo de partido</h3>
                <p><?php echo $tipo; ?></p>
                <button id="vtor">Verificar torneo</button>
            </sidebar>
            <div id="fase-j">
            <?php
                $enfj1c = mysqli_query($conn, "SELECT jornada FROM enfrentamientos WHERE id_torneo = '$torneo' AND jornada != '0' ORDER BY id_enfrentamiento DESC");
                $enfj1cv = $enfj1c->fetch_row();
                
                $jnro = 1;
                while($jnro <= $enfj1cv[0]){
            ?>
                <content>
                    <h4>Jornada <?php echo $jnro; ?></h4>
                <?php
                    $enfj1 = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND jornada = '$jnro'");
                    while($enfj1r = mysqli_fetch_row($enfj1)){

                    $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$enfj1r[4]'");
                    $enfftnv = $enfftn->fetch_row();
                    $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$enfj1r[4]'");
                    $enfftnv2 = $enfftn2->fetch_row();
            
                    $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$enfj1r[0]' AND id_torneo = '$torneo'");
                    $enfev = $enfe->fetch_row();
                    $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$enfj1r[1]' AND id_torneo = '$torneo'");
                    $enfev2 = $enfe2->fetch_row();
            
                    $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$enfj1r[0]'");
                    $enfpv = $enfp->fetch_row();
                    $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$enfj1r[1]'");
                    $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $enfj1r[2]; ?> - <?php echo $enfj1r[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                <?php
                    }
                ?>
                </content>
            <?php
                    $jnro = $jnro + 1;
                }
            ?>
                
            </div>
    	</div>
    <?php
        }
        if($idtv[1] == "Liga E"){
    ?>
        <div id="contenido">
            <header><h3><?php echo $idtv[0]; ?></h3></header>
            <header><span id="btn-j" class="f-activa">Fase jornadas</span><span id="btn-e">Fase eliminacion</span></header>
            <sidebar>
                <h3>Formato</h3>
                <p><?php echo $formato; ?></p>
                <h3>Tipo de partido</h3>
                <p><?php echo $tipo; ?></p>
                <button id="vtor">Verificar torneo</button>
            </sidebar>
            <div id="fase-j">
            <?php
                $enfj1c = mysqli_query($conn, "SELECT jornada FROM enfrentamientos WHERE id_torneo = '$torneo' AND jornada != '0' ORDER BY id_enfrentamiento DESC");
                $enfj1cv = $enfj1c->fetch_row();
                
                $jnro = 1;
                while($jnro <= $enfj1cv[0]){
            ?>
                <content>
                    <h4>Jornada <?php echo $jnro; ?></h4>
                <?php
                    $enfj1 = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND jornada = '$jnro'");
                    while($enfj1r = mysqli_fetch_row($enfj1)){

                    $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$enfj1r[4]'");
                    $enfftnv = $enfftn->fetch_row();
                    $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$enfj1r[4]'");
                    $enfftnv2 = $enfftn2->fetch_row();
            
                    $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$enfj1r[0]' AND id_torneo = '$torneo'");
                    $enfev = $enfe->fetch_row();
                    $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$enfj1r[1]' AND id_torneo = '$torneo'");
                    $enfev2 = $enfe2->fetch_row();
            
                    $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$enfj1r[0]'");
                    $enfpv = $enfp->fetch_row();
                    $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$enfj1r[1]'");
                    $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $enfj1r[2]; ?> - <?php echo $enfj1r[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                <?php
                    }
                ?>
                </content>
            <?php
                    $jnro = $jnro + 1;
                }
            ?>
                
            </div>
            <div id="fase-e">
    <?php
        if($enftv1){
    ?>
                <content>
                    <h4>Octavos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Octavos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv2){
    ?>
                <content>
                    <h4>Cuartos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Cuartos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv3){
    ?>
                <content>
                    <h4>Semifinal</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Semis'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv4){
    ?>
                <content>
                    <h4>Final</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Final'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
    ?>
            </div>
    	</div>
    <?php   
        }
        if($idtv[1] == "Grupos E"){
    ?>
        <div id="contenido">
            <header><h3><?php echo $idtv[0]; ?></h3></header>
            <header><span id="btn-j" class="f-activa">Fase jornadas</span><span id="btn-e">Fase eliminacion</span></header>
            <sidebar>
                <h3>Formato</h3>
                <p><?php echo $formato; ?></p>
                <h3>Tipo de partido</h3>
                <p><?php echo $tipo; ?></p>
                <button id="vtor">Verificar torneo</button>
            </sidebar>
            <div id="fase-j">
                <content>
                    <h4>Jornada 1</h4>
                    <div class="enf">
                        <img src="/img/equipos/barcelona.png">
                        <p class="name1">oghb1das_5</p>
                        <span>0 - 2</span>
                        <p class="name2">oghb1d</p>
                        <img src="/img/equipos/barcelona.png">
                        |
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                    <div class="enf">
                        <img src="/img/equipos/barcelona.png">
                        <p class="name1">oghb1das_5</p>
                        <span>0 - 2</span>
                        <p class="name2">oghb1d</p>
                        <img src="/img/equipos/barcelona.png">
                        |
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                    <div style="width: 100%; float: left; padding: .3rem;"></div>
                    <div class="enf">
                        <img src="/img/equipos/barcelona.png">
                        <p class="name1">oghb1das_5</p>
                        <span>0 - 2</span>
                        <p class="name2">oghb1d</p>
                        <img src="/img/equipos/barcelona.png">
                        |
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                    <div class="enf">
                        <img src="/img/equipos/barcelona.png">
                        <p class="name1">oghb1das_5</p>
                        <span>0 - 2</span>
                        <p class="name2">oghb1d</p>
                        <img src="/img/equipos/barcelona.png">
                        |
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/img/pruebas/2_5-120.png" target="blank" title="asd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
                </content>
            </div>
            <div id="fase-e">
    <?php
        if($enftv1){
    ?>
                <content>
                    <h4>Octavos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Octavos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv2){
    ?>
                <content>
                    <h4>Cuartos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Cuartos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv3){
    ?>
                <content>
                    <h4>Semifinal</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Semis'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv4){
    ?>
                <content>
                    <h4>Final</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Final'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
    ?>
            </div>
    	</div>
    <?php
        }
        if($idtv[1] == "Eliminacion D"){
    ?>
        <div id="contenido">
            <header><h3><?php echo $idtv[0]; ?></h3></header>
            <header><span class="f-activa">Fase eliminacion</span></header>
            <sidebar>
                <h3>Formato</h3>
                <p><?php echo $formato; ?></p>
                <h3>Tipo de partido</h3>
                <p><?php echo $tipo; ?></p>
                <button id="vtor">Verificar torneo</button>
            </sidebar>
            <div id="fase-e2">
    <?php
        if($enftv1){
    ?>
                <content>
                    <h4>Octavos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Octavos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv2){
    ?>
                <content>
                    <h4>Cuartos</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Cuartos'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv3){
    ?>
                <content>
                    <h4>Semifinal</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Semis'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
        if($enftv4){
    ?>
                <content>
                    <h4>Final</h4>
    <?php
        $enfft = mysqli_query($conn, "SELECT id_local,id_visitante,gol_local,gol_visitante,id_enfrentamiento FROM enfrentamientos WHERE id_torneo = '$torneo' AND tipo = 'Final'");
        while($final = mysqli_fetch_row($enfft)){
            $enfftn = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_local = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv = $enfftn->fetch_row();
            $enfftn2 = mysqli_query($conn, "SELECT c.nombre FROM enfrentamientos e JOIN cuentas c ON e.id_visitante = c.id_cuenta WHERE id_enfrentamiento = '$final[4]'");
            $enfftnv2 = $enfftn2->fetch_row();
            
            $enfe = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[0]' AND id_torneo = '$torneo'");
            $enfev = $enfe->fetch_row();
            $enfe2 = mysqli_query($conn, "SELECT e.img FROM r_torneos r JOIN equipos e ON r.equipo = e.id_equipo WHERE r.id_cuenta = '$final[1]' AND id_torneo = '$torneo'");
            $enfev2 = $enfe2->fetch_row();
            
            $enfp = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[0]'");
            $enfpv = $enfp->fetch_row();
            $enfp2 = mysqli_query($conn, "SELECT p.img FROM enfrentamientos e JOIN pruebas p ON e.id_enfrentamiento = p.id_enfrentamiento WHERE e.id_torneo = '$torneo' AND e.id_local = '$final[1]'");
            $enfpv2 = $enfp2->fetch_row();
    ?>
                    <div class="enf">
                        <img src="/<?php echo $enfev[0]; ?>">
                        <p class="name1"><?php echo $enfftnv[0]; ?></p>
                        <span><?php echo $final[2]; ?> - <?php echo $final[3]; ?></span>
                        <p class="name2"><?php echo $enfftnv2[0]; ?></p>
                        <img src="/<?php echo $enfev2[0]; ?>">
                        |
                        <a href="/<?php echo $enfpv[0]; ?>" target="blank" title="<?php echo $enfftnv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                        -
                        <a href="/<?php echo $enfpv2[0]; ?>" target="blank" title="<?php echo $enfftnv2[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8l0 464c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488L0 24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 144zM80 352c0 8.8 7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 336c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16l192 0c8.8 0 16-7.2 16-16s-7.2-16-16-16L96 240z"/></svg>Ver</a>
                    </div>
    <?php
        }
    ?>
                    
                </content>
    <?php
        }
    ?>
            </div>
    	</div>
    <?php
        }
    ?>
        </div>
    </body>
    </html>
    <script type="text/javascript">
        $('#btn-j').click(function(e) {
            var elemento = document.querySelectorAll("#fase-j");
            for (var i = 0; i < elemento.length; i++) {
              document.getElementById('fase-j').style.display = 'block';
              document.getElementById('btn-j').classList.add('f-activa');
              document.getElementById('fase-e').style.display = 'none';
              document.getElementById('btn-e').classList.remove('f-activa');
            }
        });
        $('#btn-e').click(function(e) {
            var elemento2 = document.querySelectorAll("#fase-e");
            for (var i = 0; i < elemento2.length; i++) {
              document.getElementById('fase-j').style.display = 'none';
              document.getElementById('btn-j').classList.remove('f-activa');
              document.getElementById('fase-e').style.display = 'block';
              document.getElementById('btn-e').classList.add('f-activa');
            }
        });
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
<?php
    }else{
        header('Location: https://csport.es');
    }
?>