<?php
    error_reporting(0);
	session_start();
	include_once 'bd/conexion.php';
	$id = $_SESSION['datos']['id'];
	$nomb = $_SESSION['datos']['nombre'];
	
	if (empty(($_SESSION['datos']))) {
		header('Location: https://csport.es/login');
	}
	
	$ci_torneo = "SELECT * FROM cuentas WHERE id_cuenta = '$id'";
	$ci_res = $conn->query($ci_torneo);
	$ci_row = $ci_res->fetch_row();

    $wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id'");
    $w_saldo = $wallet->fetch_row();
    $s_wallet = number_format($w_saldo[1], 2, '.', ',');
    
    $sqlctr = mysqli_query($conn, "SELECT t.fecha FROM r_torneos r JOIN torneos t ON r.id_torneo = t.id WHERE r.id_cuenta = '$id' AND t.inscripcion = '1'");
    $confd2 = 0; $fechaActd2 = new DateTime();
    while ($sqlctrv = mysqli_fetch_row($sqlctr)) {
        $cond2 = $sqlctrv[0];
        $fechacd2 = new DateTime($cond2);
        $difcd2 = $fechaActd2->diff($fechacd2);
        if($difcd2->m <= 2){
            $confd2 = $confd2 + 1;
        }
    }
    $sqldec = mysqli_query($conn, "SELECT COUNT(id_desafio) FROM desafio WHERE id_cuenta = '$id' OR id_visitante = '$id'");
    $sqldecv = $sqldec->fetch_row();
    
    $sqlia = mysqli_query($conn, "SELECT inicio,tipo FROM actividad WHERE id_cuenta = '$id'");
    $condc = 0; $condp = 0; $confd = 0;
    $fechaActd = new DateTime();
    while ($sqliav = mysqli_fetch_row($sqlia)) {
        $cond = $sqliav[0];
        $fechacd = new DateTime($cond);
        $difcd = $fechaActd->diff($fechacd);
        if($difcd->m <= 2){
            $confd = $confd + 1;
            if($sqliav[1] == "PC"){
                $condp = $condp + 1;
            }else{
                $condc = $condc + 1;
            }
        }
    }
    $conT2m = ($condp + $condc)/60;
    
    $conttdc = $sqldecv[0] + $confd2;
    if(($conttdc <= 3) && ($conT2m < 7)){
        $nvlC = 0;
        $nvlCP = 0;
    }if((($conttdc >= 3) && ($conttdc <= 6)) && ($conT2m >= 0.25)){
        $nvlC = 1;
        $nvlCP = 0.25;
    }if((($conttdc >= 6) && ($conttdc <= 9)) && ($conT2m >= 0.5)){
        $nvlC = 2;
        $nvlCP = 0.5;
    }if((($conttdc >= 9) && ($conttdc <= 12)) && ($conT2m >= 0.75)){
        $nvlC = 3;
        $nvlCP = 0.75;
    }if(($conttdc > 12) && ($conT2m >= 1)){
        $nvlC = 4;
        $nvlCP = 1;
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="img/Logo.png">
	<link rel="stylesheet" type="text/css" href="css/buscador.css">
	<link rel="stylesheet" type="text/css" href="fonts/fonts.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AeDeI1X9V4DEgIqCVnw0uOQ8hz__yt0yNHCtAS6jcMx4TEut4QlA0jdzSqDy4lN7em1CMaW_mZrFXjhD"></script>
	<title>Buscador | Csport</title>
</head>
<body>
    <script src="../status.js"></script>
	<div id="pantalla"><span id="errorwd1"></span>
    <?php
    	if ($ci_row[4] >= 2) {
    	?>
            <label title="Crear un torneo" id="crear_t" for="btn-modal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg></label>
    <?php
    	}
        if(isset($_GET['msj'])){
    ?>
        <input type="checkbox" id="btn-modal-msj">
		<div class="container-modal-msj">
	        <div class="content-modal-msj">
	        <?php
	            $idmsj = $_GET['msj'];
	            $sqlmp = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$id' AND id_enfrentamiento = '$idmsj') OR (id_cuenta = '$idmsj' AND id_enfrentamiento = '$id')");
	            $sqlmpv = $sqlmp->fetch_row();
	            if($sqlmpv){
    	            if($sqlmpv[2] == $id){
    	                $idmsj2 = $sqlmpv[3];
    	            }else{
    	                $idmsj2 = $sqlmpv[2];
    	            }
    	            $sqlmpc = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$idmsj2'");
    	            $sqlmpcv = $sqlmpc->fetch_row();
	            }else{
	                $sqlmpc = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$idmsj'");
    	            $sqlmpcv = $sqlmpc->fetch_row();
    	            $idmsj2 = $_GET['msj'];
	            }
	        ?>
	            <div id="modal-msj"><img src="/<?php echo $sqlmpcv[1]; ?>"><p><?php echo $sqlmpcv[0]; ?></p></div>
	            <div id="content-modal-msj2">
	                <div id="content-modal-msj-scroll"></div>
	            </div>
	            <form>
                    <input type="text" id="mensajemsj" placeholder="Escribe aqui...">
                    <botton id="msj-pbtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558ZM5 4.38249V10.9999H10V12.9999H5V19.6174L18.8499 11.9999L5 4.38249Z"></path></svg></botton>
                </form>
	        </div>
	        <label for="btn-modal-msj" class="cerrar-modal-msj"></label>
	    </div>
    <?php
        }
    ?>
    	<input type="checkbox" id="btn-modal-1v1">
		<div class="container-modal-1v1">
	        <div class="content-modal-1v1">
	            <h1>Crear desafio</h1>
	            <span id="error3"></span>
	            <form>
	                <div id="desafio-config1">
    	                <label>Juego / categoria</label>
    	                <select id="juego-d" style="margin-left: calc(50% - 5.75rem);">
            			<?php
            				$desafio = "SELECT nombre,tipo FROM juegos ORDER BY nombre DESC";
    						$res_d = $conn->query($desafio);
    						while ($rows = mysqli_fetch_row($res_d)) {
            			?>
    				        <option value="<?php echo $rows[0]; ?>/<?php echo $rows[1]; ?>"><?php echo $rows[0]; ?> / <?php echo $rows[1]; ?></option>
    			        <?php
    			        	}
    			        ?>
    				    </select>
    	                <label>Premios</label>
    	                <select id="monto-d" style="margin-left: calc(50% - 5.75rem);">
    	                    <option value="">Seleccione un premio</option>
    				    	<option value="5">$5</option>
    				        <option value="10">$10</option>
    				    	<option value="20">$20</option>
    				    	<option value="30">$30</option>
    				    	<option value="50">$50</option>
    				    	<option value="80">$80</option>
    				    	<option value="100">$100</option>
    				    	<option value="200">$200</option>
    				    </select>
    				    <script type="text/javascript">
    				        $('#monto-d').click(function(e) {	
    	            			var monto = document.getElementById('monto-d').value;
    	            			if (monto == '') {
    	            				document.getElementById("info-d").style.display = "none";
    	            			}
    		            		if (monto == '5') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$5";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$3";
    		            		}
    		            		if (monto == '10') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$10";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$6";
    		            		}
    		            		if (monto == '20') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$20";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$12";
    		            		}
    		            		if (monto == '30') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$30";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$18";
    		            		}
    		            		if (monto == '50') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$50";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$30";
    		            		}
    		            		if (monto == '80') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$80";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$48";
    		            		}
    		            		if (monto == '100') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$100";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$60";
    		            		}
    		            		if (monto == '200') {
    		            			document.getElementById("info-d").style.display = "flex";
    		            			document.getElementById("gana-d-i").innerHTML = "$200";
    		            			document.getElementById("apuesta-d-i").innerHTML = "$120";
    		            		}
    		            	});
    				    </script>
    				    <label for="incognito-d" style="margin-top: 1rem !important;"><input type="checkbox" id="incognito-d" value="incognito"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M17 13C19.2091 13 21 14.7909 21 17C21 19.2091 19.2091 21 17 21C14.7909 21 13 19.2091 13 17H11C11 19.2091 9.20914 21 7 21C4.79086 21 3 19.2091 3 17C3 14.7909 4.79086 13 7 13C8.48052 13 9.77317 13.8043 10.4648 14.9999H13.5352C14.2268 13.8043 15.5195 13 17 13ZM7 15C5.89543 15 5 15.8954 5 17C5 18.1046 5.89543 19 7 19C8.10457 19 9 18.1046 9 17C9 15.8954 8.10457 15 7 15ZM17 15C15.8954 15 15 15.8954 15 17C15 18.1046 15.8954 19 17 19C18.1046 19 19 18.1046 19 17C19 15.8954 18.1046 15 17 15ZM16 3C18.2091 3 20 4.79086 20 7V10H22V12H2V10H4V7C4 4.79086 5.79086 3 8 3H16ZM16 5H8C6.94564 5 6 5.95 6 7V10H18V7C18 5.94564 17.05 5 16 5Z"></path></svg> Modo incognito</label>
    				    <div id="info-d">
    				        <p>APUESTA: <h3 id="apuesta-d-i"></h3></p>
    				        <p>|</p>
    				        <p>GANAS: <h3 id="gana-d-i"></h3></p>
    				    </div>
    	                <button id="crear-desafio">Crear</button> 
	                </div>
                    <div id="desafio-config2">
                        <label>Dur. de tiempos</label>
    	                <select id="tiempos-d" style="margin-left: calc(50% - 5.75rem);">
    				    	<option value="6">6min</option>
    				    </select>
    				    <label>Tipo de plantilla</label>
    	                <select id="plantilla-d" style="margin-left: calc(50% - 5.75rem);">
    				    	<option value="Online">Online</option>
    				        <option value="95 Global">95 Global</option>
    				    	<option value="Personalizado">Personalizado</option>
    				    </select>
    				    <label>Encuentro</label>
    	                <select id="encuentro-d" style="margin-left: calc(50% - 5.75rem);">
    				    	<option value="Ida">Solo ida</option>
    				        <option value="Vuelta">Ida y vuelta</option>>
    				    </select>
                    </div>
	            </form>
	        </div>
	        <label for="btn-modal-1v1" class="cerrar-modal-1v1"></label>
	    </div>
		<input type="checkbox" id="btn-modal-wallet">
		<div class="container-modal-wallet">
	        <div class="content-modal-wallet">
	            <div id="wallet-home">
	                <h1>
	                    <p style="font-size: .8rem;">Balance disponible | Nvl <?php echo $nvlC; ?></p>
	                    <p>$<?php echo $s_wallet; ?> USD</p>
	                    <p style="font-size: .8rem;">Progreso <del style="text-decoration-line: line-through;">ㅤㅤㅤㅤㅤㅤㅤㅤㅤ</del></p>
	                    <p style="font-size: .8rem;">Torneos: <?php echo $conttdc." | Conexiones: ".round($conT2m, 1); ?></p>
	                </h1>
    	            <div id="wallet-cont">
    	                <div id="wallet-btn">
    	                    <a id="wallet-r">Retirar</a>
    	                    <a id="wallet-d">Depositar</a>
    	                </div>
    	                <h3 style="margin: .5rem 1rem; color: #262626; font-size: .8rem;">Transacciones recientes</h3>
    	                <div id="wallet-transaccines">
    	                    <div id="wallet-transaccines-s">
    	                <?php
    	                    $wtrasc = mysqli_query($conn, "SELECT * FROM wallet_t WHERE id_cuenta = '$id' ORDER BY id_transaccion DESC LIMIT 10");
    	                    while ($wtrascv = mysqli_fetch_row($wtrasc)) {
        	                    if($wtrascv[2] == "Deposito"){
        	                        $wtitle = "Se deposito +".$wtrascv[3]."USD a tu cuenta";
        	                        $wsvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(38,38,38,1)"><path d="M5.37833 4.51335C7.14264 2.95113 9.46301 2.00275 12.0049 2.00275C17.5277 2.00275 22.0049 6.4799 22.0049 12.0027C22.0049 14.1277 21.3421 16.0978 20.212 17.7177L17.5049 12.0027H20.0049C20.0049 7.58447 16.4232 4.00275 12.0049 4.00275C9.76058 4.00275 7.73213 4.92691 6.27932 6.41544L5.37833 4.51335ZM18.6314 19.4921C16.8671 21.0544 14.5468 22.0027 12.0049 22.0027C6.48204 22.0027 2.00488 17.5256 2.00488 12.0027C2.00488 9.8778 2.66767 7.90766 3.79778 6.28776L6.50488 12.0027H4.00488C4.00488 16.421 7.5866 20.0027 12.0049 20.0027C14.2492 20.0027 16.2776 19.0786 17.7304 17.59L18.6314 19.4921ZM8.50488 14.0027H14.0049C14.281 14.0027 14.5049 13.7789 14.5049 13.5027C14.5049 13.2266 14.281 13.0027 14.0049 13.0027H10.0049C8.62417 13.0027 7.50488 11.8835 7.50488 10.5027C7.50488 9.12203 8.62417 8.00275 10.0049 8.00275H11.0049V7.00275H13.0049V8.00275H15.5049V10.0027H10.0049C9.72874 10.0027 9.50488 10.2266 9.50488 10.5027C9.50488 10.7789 9.72874 11.0027 10.0049 11.0027H14.0049C15.3856 11.0027 16.5049 12.122 16.5049 13.5027C16.5049 14.8835 15.3856 16.0027 14.0049 16.0027H13.0049V17.0027H11.0049V16.0027H8.50488V14.0027Z"></path></svg>';
        	                    }if($wtrascv[2] == "Retiro"){
        	                        $wtitle = "Se retiro -".$wtrascv[3]."USD de tu cuenta";
        	                        $wsvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(38,38,38,1)"><path d="M5.37833 4.51335C7.14264 2.95113 9.46301 2.00275 12.0049 2.00275C17.5277 2.00275 22.0049 6.4799 22.0049 12.0027C22.0049 14.1277 21.3421 16.0978 20.212 17.7177L17.5049 12.0027H20.0049C20.0049 7.58447 16.4232 4.00275 12.0049 4.00275C9.76058 4.00275 7.73213 4.92691 6.27932 6.41544L5.37833 4.51335ZM18.6314 19.4921C16.8671 21.0544 14.5468 22.0027 12.0049 22.0027C6.48204 22.0027 2.00488 17.5256 2.00488 12.0027C2.00488 9.8778 2.66767 7.90766 3.79778 6.28776L6.50488 12.0027H4.00488C4.00488 16.421 7.5866 20.0027 12.0049 20.0027C14.2492 20.0027 16.2776 19.0786 17.7304 17.59L18.6314 19.4921ZM8.50488 14.0027H14.0049C14.281 14.0027 14.5049 13.7789 14.5049 13.5027C14.5049 13.2266 14.281 13.0027 14.0049 13.0027H10.0049C8.62417 13.0027 7.50488 11.8835 7.50488 10.5027C7.50488 9.12203 8.62417 8.00275 10.0049 8.00275H11.0049V7.00275H13.0049V8.00275H15.5049V10.0027H10.0049C9.72874 10.0027 9.50488 10.2266 9.50488 10.5027C9.50488 10.7789 9.72874 11.0027 10.0049 11.0027H14.0049C15.3856 11.0027 16.5049 12.122 16.5049 13.5027C16.5049 14.8835 15.3856 16.0027 14.0049 16.0027H13.0049V17.0027H11.0049V16.0027H8.50488V14.0027Z"></path></svg>';
        	                    }if($wtrascv[2] == "Torneo"){
        	                        $sqltn = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = $wtrascv[4]");
        	                        $sqltnv = $sqltn->fetch_row();
        	                        
        	                        $wtitle = "+".$wtrascv[3]."USD por torneo - ".$sqltnv[0];
        	                        $wsvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(38,38,38,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg>';
        	                    }if($wtrascv[2] == "Desafio"){
        	                        $sqltn = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = $wtrascv[4]");
        	                        $sqltnv = $sqltn->fetch_row();
        	                        
        	                        $wtitle = "+".$wtrascv[3]."USD por ganar desafio";
        	                        $wsvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(38,38,38,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg>';
        	                    }if($wtrascv[2] == "Ganancias"){
        	                        $sqltn = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = $wtrascv[4]");
        	                        $sqltnv = $sqltn->fetch_row();
        	                        
        	                        $wtitle = "+".$wtrascv[3]."USD de ganancias por organizar - ".$sqltnv[0];
        	                        $wsvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(38,38,38,1)"><path d="M4.41085 14.5258L7.81249 11.1241L10.6409 13.9526L13.7978 10.7957L12.0049 9.00281H17.0049V14.0028L15.212 12.2099L10.6409 16.781L7.81249 13.9526L5.33834 16.4267C6.77158 18.5822 9.22233 20.0028 12.0049 20.0028C16.4232 20.0028 20.0049 16.4211 20.0049 12.0028C20.0049 7.58453 16.4232 4.00281 12.0049 4.00281C7.5866 4.00281 4.00488 7.58453 4.00488 12.0028C4.00488 12.8844 4.14747 13.7326 4.41085 14.5258ZM2.87288 16.084L2.86275 16.0739L2.86662 16.07C2.31276 14.8274 2.00488 13.4511 2.00488 12.0028C2.00488 6.47996 6.48204 2.00281 12.0049 2.00281C17.5277 2.00281 22.0049 6.47996 22.0049 12.0028C22.0049 17.5257 17.5277 22.0028 12.0049 22.0028C7.93574 22.0028 4.43426 19.5724 2.87288 16.084Z"></path></svg>';
        	                    }
        	            ?>
        	                    <div title='<?php echo $wtitle; ?>' class="transaccines-list">
        	                        <?php echo $wsvg; ?>
        	                        <p>| <?php echo $wtitle; ?></p>
        	                    </div>
        	            <?php
    	                    }
    	                ?>
    	                    </div>
    	                </div>
    	            </div>
	            </div>
	            <div id="wallet-deposit" style="display: none; position: relative;">
	                <div id="wallet-deposit-cont">
	                    <h1>
	                        <p style="font-size: .8rem;">Balance disponible</p>
	                        <p>$<?php echo $s_wallet; ?> USD</p>
    	                    <a id="wallet-volver"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <h2 style="margin: 1rem; color: #262626;">Depositar saldo</h2>
    	                <div id="wallet-cont-d">
    	                    <div class="w-card-d" id="wdm-3">
    	                        <p>$3</p>
    	                        <div><h3>Add</h3></div>
    	                    </div>
    	                    <div class="w-card-d" id="wdm-5">
    	                        <p>$5</p>
    	                        <div><h3>Add</h3></div>
    	                    </div>
    	                    <div class="w-card-d" id="wdm-10">
    	                        <p>$10</p>
    	                        <div><h3>Add</h3></div>
    	                    </div>
    	                    <div class="w-card-d" id="wdm-20">
    	                        <p>$20</p>
    	                        <div><h3>Add</h3></div>
    	                    </div>
    	                    <div class="w-card-d" id="wdm-30">
    	                        <p>$30</p>
    	                        <div><h3>Add</h3></div>
    	                    </div>
        	            </div>
	                </div>
	                <div id="wallet-deposit-3">
	                    <h1>
	                        <p style="width: 70%; font-size: .8rem;">Monto a comprar</p>
	                        <p style="width: 70%;">$3.00 USD</p>
    	                    <a id="wallet-volverdm"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <div class="wallet-dp-scroll">
    	                    <div id="wallet-cont-dp">
            	                <div id="paypal-button-container0"></div>
            	                <script>
            	                    paypal.Buttons({
            	                        style:{
            	                            color: 'blue',
            	                            shape: 'rect',
            	                            label: 'pay'
            	                        },
            	                        createOrder: function(data, actions){
            	                            return actions.order.create({
            	                               purchase_units: [{
            	                                   amount: {
            	                                       value: 3.5
            	                                   }
            	                               }]
            	                            });
            	                        },
            	                        onApprove: function(data, actions){
            	                            actions.order.capture().then(function (orderData){
            	                                var orderID = orderData.id;
            	                                var emailID = orderData.payer.email_address;
            	                                var statusID = orderData.status;
            	                                var fechaID = orderData.update_time;
            	                                var tipoID = "Deposito";
            	                                var metodoID = "Paypal";
            	                                var saldoID = "3";
            	                                var php = "orderID="+orderID+"&emailID="+emailID+"&statusID="+statusID+"&fechaID="+fechaID+"&tipoID="+tipoID+"&metodoID="+metodoID+"&saldoID="+saldoID;
            	                                $.ajax({
                                        			url: '/bd/paid.php',
                                        			type: 'POST',
                                        			dataType: 'json',
                                        			data: php,
                                        		})
                                        		.done(function(res) {
                                        			if (res == "aprobado") {
                                        				setTimeout(() => {
                                        					window.location = "/paid?order="+orderID;
                                        				}, 50);
                                        			}
                                        		});
            	                            });
            	                        },
            	                        onCancel: function(data){
            	                            //console.log(data);
            	                        }
            	                    }).render('#paypal-button-container0');
            	                </script>
            	            </div>
    	                </div>
	                </div>
    	            <div id="wallet-deposit-5">
	                    <h1>
	                        <p style="width: 70%; font-size: .8rem;">Monto a comprar</p>
	                        <p style="width: 70%;">$5.00 USD</p>
    	                    <a id="wallet-volverdm"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <div class="wallet-dp-scroll">
    	                    <div id="wallet-cont-dp">
            	                <div id="paypal-button-container"></div>
            	                <script>
            	                    paypal.Buttons({
            	                        style:{
            	                            color: 'blue',
            	                            shape: 'rect',
            	                            label: 'pay'
            	                        },
            	                        createOrder: function(data, actions){
            	                            return actions.order.create({
            	                               purchase_units: [{
            	                                   amount: {
            	                                       value: 5.6
            	                                   }
            	                               }]
            	                            });
            	                        },
            	                        onApprove: function(data, actions){
            	                            actions.order.capture().then(function (orderData){
            	                                var orderID = orderData.id;
            	                                var emailID = orderData.payer.email_address;
            	                                var statusID = orderData.status;
            	                                var fechaID = orderData.update_time;
            	                                var tipoID = "Deposito";
            	                                var metodoID = "Paypal";
            	                                var saldoID = "5";
            	                                var php = "orderID="+orderID+"&emailID="+emailID+"&statusID="+statusID+"&fechaID="+fechaID+"&tipoID="+tipoID+"&metodoID="+metodoID+"&saldoID="+saldoID;
            	                                $.ajax({
                                        			url: '/bd/paid.php',
                                        			type: 'POST',
                                        			dataType: 'json',
                                        			data: php,
                                        		})
                                        		.done(function(res) {
                                        			if (res == "aprobado") {
                                        				setTimeout(() => {
                                        					window.location = "/paid?order="+orderID;
                                        				}, 50);
                                        			}
                                        		});
            	                            });
            	                        },
            	                        onCancel: function(data){
            	                            //console.log(data);
            	                        }
            	                    }).render('#paypal-button-container');
            	                </script>
            	            </div>
    	                </div>
	                </div>
	                <div id="wallet-deposit-10">
	                    <h1>
	                        <p style="width: 70%; font-size: .8rem;">Monto a comprar</p>
	                        <p style="width: 70%;">$10.00 USD</p>
    	                    <a id="wallet-volverdm">
    	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <div class="wallet-dp-scroll">
    	                    <div id="wallet-cont-dp">
            	                <div id="paypal-button-container2"></div>
            	                <script>
            	                    paypal.Buttons({
            	                        style:{
            	                            color: 'blue',
            	                            shape: 'rect',
            	                            label: 'pay'
            	                        },
            	                        createOrder: function(data, actions){
            	                            return actions.order.create({
            	                               purchase_units: [{
            	                                   amount: {
            	                                       value: 11.2
            	                                   }
            	                               }]
            	                            });
            	                        },
            	                        onApprove: function(data, actions){
            	                            actions.order.capture().then(function (orderData){
            	                                var orderID = orderData.id;
            	                                var emailID = orderData.payer.email_address;
            	                                var statusID = orderData.status;
            	                                var fechaID = orderData.update_time;
            	                                var tipoID = "Deposito";
            	                                var metodoID = "Paypal";
            	                                var saldoID = "10";
            	                                var php = "orderID="+orderID+"&emailID="+emailID+"&statusID="+statusID+"&fechaID="+fechaID+"&tipoID="+tipoID+"&metodoID="+metodoID+"&saldoID="+saldoID;
            	                                $.ajax({
                                        			url: '/bd/paid.php',
                                        			type: 'POST',
                                        			dataType: 'json',
                                        			data: php,
                                        		})
                                        		.done(function(res) {
                                        			if (res == "aprobado") {
                                        				setTimeout(() => {
                                        					window.location = "/paid?order="+orderID;
                                        				}, 50);
                                        			}
                                        		});
            	                            });
            	                        },
            	                        onCancel: function(data){
            	                            //console.log(data);
            	                        }
            	                    }).render('#paypal-button-container2');
            	                </script>
            	            </div>
    	                </div>
	                </div>
	                <div id="wallet-deposit-20">
	                    <h1>
	                        <p style="width: 70%; font-size: .8rem;">Monto a comprar</p>
	                        <p style="width: 70%;">$20.00 USD</p>
    	                    <a id="wallet-volverdm">
    	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <div class="wallet-dp-scroll">
    	                    <div id="wallet-cont-dp">
            	                <div id="paypal-button-container3"></div>
            	                <script>
            	                    paypal.Buttons({
            	                        style:{
            	                            color: 'blue',
            	                            shape: 'rect',
            	                            label: 'pay'
            	                        },
            	                        createOrder: function(data, actions){
            	                            return actions.order.create({
            	                               purchase_units: [{
            	                                   amount: {
            	                                       value: 22.4
            	                                   }
            	                               }]
            	                            });
            	                        },
            	                        onApprove: function(data, actions){
            	                            actions.order.capture().then(function (orderData){
            	                                var orderID = orderData.id;
            	                                var emailID = orderData.payer.email_address;
            	                                var statusID = orderData.status;
            	                                var fechaID = orderData.update_time;
            	                                var tipoID = "Deposito";
            	                                var metodoID = "Paypal";
            	                                var saldoID = "20";
            	                                var php = "orderID="+orderID+"&emailID="+emailID+"&statusID="+statusID+"&fechaID="+fechaID+"&tipoID="+tipoID+"&metodoID="+metodoID+"&saldoID="+saldoID;
            	                                $.ajax({
                                        			url: '/bd/paid.php',
                                        			type: 'POST',
                                        			dataType: 'json',
                                        			data: php,
                                        		})
                                        		.done(function(res) {
                                        			if (res == "aprobado") {
                                        				setTimeout(() => {
                                        					window.location = "/paid?order="+orderID;
                                        				}, 50);
                                        			}
                                        		});
            	                            });
            	                        },
            	                        onCancel: function(data){
            	                            //console.log(data);
            	                        }
            	                    }).render('#paypal-button-container3');
            	                </script>
            	            </div>
    	                </div>
	                </div>
	                <div id="wallet-deposit-30">
	                    <h1>
	                        <p style="width: 70%; font-size: .8rem;">Monto a comprar</p>
	                        <p style="width: 70%;">$30.00 USD</p>
    	                    <a id="wallet-volverdm">
    	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <div class="wallet-dp-scroll">
    	                    <div id="wallet-cont-dp">
            	                <div id="paypal-button-container4"></div>
            	                <script>
            	                    paypal.Buttons({
            	                        style:{
            	                            color: 'blue',
            	                            shape: 'rect',
            	                            label: 'pay'
            	                        },
            	                        createOrder: function(data, actions){
            	                            return actions.order.create({
            	                               purchase_units: [{
            	                                   amount: {
            	                                       value: 33.6
            	                                   }
            	                               }]
            	                            });
            	                        },
            	                        onApprove: function(data, actions){
            	                            actions.order.capture().then(function (orderData){
            	                                var orderID = orderData.id;
            	                                var emailID = orderData.payer.email_address;
            	                                var statusID = orderData.status;
            	                                var fechaID = orderData.update_time;
            	                                var tipoID = "Deposito";
            	                                var metodoID = "Paypal";
            	                                var saldoID = "30";
            	                                var php = "orderID="+orderID+"&emailID="+emailID+"&statusID="+statusID+"&fechaID="+fechaID+"&tipoID="+tipoID+"&metodoID="+metodoID+"&saldoID="+saldoID;
            	                                $.ajax({
                                        			url: '/bd/paid.php',
                                        			type: 'POST',
                                        			dataType: 'json',
                                        			data: php,
                                        		})
                                        		.done(function(res) {
                                        			if (res == "aprobado") {
                                        				setTimeout(() => {
                                        					window.location = "/paid?order="+orderID;
                                        				}, 50);
                                        			}
                                        		});
            	                            });
            	                        },
            	                        onCancel: function(data){
            	                            //console.log(data);
            	                        }
            	                    }).render('#paypal-button-container4');
            	                </script>
            	            </div>
    	                </div>
	                </div>
	            </div>
	            <div id="wallet-withdraw" style="display: none; position: relative;">
	        <?php
	            $sqlwda = mysqli_query($conn, "SELECT telefono,paypal,nyp FROM cuentas WHERE id_cuenta = '$id'");
	            $sqlwdav = $sqlwda->fetch_row();

	            if(($sqlwdav[0] == '') || ($sqlwdav[1] == '') || ($sqlwdav[2] == '')){
            ?>
                    <div id="wallet-withdraw-cont">
    	                <h1><p style="margin-bottom: .75rem;">Necesitas rellenar tus datos</p>
    	                <a id="wallet-volvera-juste">
    	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg>
    	                </a></h1>
    	                <div id="wallet-withdraw-ajustes">
                            <label><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="rgba(38,38,38,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg>Perfil/<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="rgba(38,38,38,1)"><path d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM12 3.311L4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311ZM12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12C16 14.2091 14.2091 16 12 16ZM12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z"></path></svg>Ajustes->Rellenar datos personales & datos de retiros</label>
        	            </div>
	                </div>
	        <?php
	            }else{
	                if($nvlC >= 1){
	        ?>
	                    <div id="wallet-withdraw-cont">
    	                <h1>
    	                    <p style="font-size: .8rem;">Balance disponible | Nvl <?php echo $nvlC; ?></p>
	                        <p>$<?php echo $s_wallet; ?> USD</p>
    	                    <a id="wallet-volver2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                    <a id="wallet-volverfase" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
    	                </h1>
    	                <h2 style="margin: 1rem 1rem 0rem 1rem; color: #262626;">Retira <?php echo $nvlCP*100; ?>% de tu saldo</h2>
    	                <div id="wallet-cont-r">
    	                    <div id="form-W">
    	                        <div id="wr-fase1">
        	                        <label>Saldo a retirar</label>
            	                    <div style="flex-direction: row;">
            	                        <p id="saldor">$</p><input type="number" id="wr_saldo" name="wr_saldo">
            	                    </div>
                                    <label></label>
                                    <div id="m_paypal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M20.0673 8.47768C20.5591 9.35823 20.6237 10.4924 20.3676 11.8053C19.627 15.6107 17.0916 16.9253 13.8536 16.9253H13.3536C12.9583 16.9253 12.6216 17.214 12.5596 17.6047L12.519 17.8253L11.8896 21.818L11.857 21.988C11.795 22.3787 11.4583 22.6667 11.063 22.6667H7.72031C7.42365 22.6667 7.19698 22.402 7.24298 22.1093L7.41807 21H8.9367L9.88603 14.9793H11.2716C15.9496 14.9793 19.0209 12.7768 20.0673 8.47768ZM17.1066 3.38784C17.8693 4.25635 18.0908 5.19891 17.8597 6.67324C17.8405 6.79594 17.82 6.91391 17.7973 7.03253C17.0621 10.8057 14.7087 12.4793 10.8417 12.4793H8.95703C8.32647 12.4793 7.78368 12.8928 7.60372 13.4811L7.58913 13.4788L6.65969 19.3733H3.12169C3.08991 19.3733 3.06598 19.3454 3.07097 19.3136L5.66905 2.80233C5.74174 2.34036 6.13984 2 6.6075 2H12.583C14.7658 2 16.2998 2.46869 17.1066 3.38784Z"></path></svg>
                                        <h5>Retirar por paypal</h5>
                                    </div>
                                    <div id="m_transferencia">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M19.3788 15.1057C20.9258 11.4421 19.5373 7.11431 16.0042 5.0745C13.4511 3.60046 10.4232 3.69365 8.03452 5.0556L7.04216 3.31879C10.028 1.61639 13.8128 1.4999 17.0042 3.34245C21.4949 5.93513 23.2139 11.4848 21.1217 16.112L22.4635 16.8867L18.2984 19.1008L18.1334 14.3867L19.3788 15.1057ZM4.62961 8.89968C3.08263 12.5633 4.47116 16.8911 8.00421 18.9309C10.5573 20.4049 13.5851 20.3118 15.9737 18.9499L16.9661 20.6867C13.9803 22.389 10.1956 22.5055 7.00421 20.663C2.51357 18.0703 0.794565 12.5206 2.88672 7.89342L1.54492 7.11873L5.70999 4.90463L5.87505 9.61873L4.62961 8.89968ZM8.50421 14.0027H14.0042C14.2804 14.0027 14.5042 13.7788 14.5042 13.5027C14.5042 13.2266 14.2804 13.0027 14.0042 13.0027H10.0042C8.6235 13.0027 7.50421 11.8834 7.50421 10.5027C7.50421 9.122 8.6235 8.00271 10.0042 8.00271H11.0042V7.00271H13.0042V8.00271H15.5042V10.0027H10.0042C9.72807 10.0027 9.50421 10.2266 9.50421 10.5027C9.50421 10.7788 9.72807 11.0027 10.0042 11.0027H14.0042C15.3849 11.0027 16.5042 12.122 16.5042 13.5027C16.5042 14.8834 15.3849 16.0027 14.0042 16.0027H13.0042V17.0027H11.0042V16.0027H8.50421V14.0027Z"></path></svg>
                                        <h5>Retirar por transferencia</h5>
                                    </div>
    	                        </div>
        	                    <div id="wr-fase2">
        	                        <label>Correo de paypal</label>
            	                    <select id="wr_email">
            	                        <option value="<?php echo $ci_row[16]; ?>"><?php echo $ci_row[16]; ?></option>
            	                    </select>
                                    <button id="withdraw-saldo"></button>
    	                        </div>
    	                    </div>
        	            </div>
	                </div>
	        <?php
	                }else{
	        ?>
                        <div id="wallet-withdraw-cont">
        	                <h1><p style="margin-bottom: .75rem;">Tu nivel es: 0</p>
        	                <a id="wallet-volvera-juste">
        	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="rgba(242,242,242,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg>
        	                </a></h1>
        	                <div id="wallet-withdraw-ajustes">
                                <label>Necesitas jugar +3 torneos para poder retirar saldo. </label>
                                <label style="margin-top: 1rem;">Más informacion sobre los diferentes niveles <a href="/ayuda" style="color: #1a1b41; text-decoration: none;">(Clic)</a></label>
            	            </div>
    	                </div>
	        <?php
	                }
	            }
	        ?>
	            </div>
	        </div>
	        <label for="btn-modal-wallet" class="cerrar-modal-wallet"></label>
	    </div>
    <?php
	    if ($ci_row[4] >= 2){
	?>
		<input type="checkbox" id="btn-modal">
		<div class="container-modal">
	        <div class="content-modal">
	            <h1>Creacion de torneo</h1>
	            <span id="error"></span>
	            <form action="" method="POST">
	            	<label>Titulo</label>
	            	<input type="text" id="titulo">
	            	<label>Descripcion</label>
	            	<textarea id="descripcion" minlength="250"></textarea>
	            	<label>Tipo de torneo</label>
	            	<select id="inscripcion">
				        <option value="0">Gratis</option>
				        <option value="1">Inscripcion</option>
				        <option value="2">Privado</option>
				        <option value="3">Gratis + Premio</option>
				        <option value="4">Privado + Premio</option>
				    </select>
				    <label id="t_premio" style="display: none;"></label>
	            	<input type="number" id="premio" style="display: none;" min="1">
	            	<label id="t_ganadores" style="display: none;">Cant. de ganadores</label>
	            	<select id="ganadores" style="display: none;">
				        <option value="1">Un solo ganador</option>
				        <option value="2">Dos ganadores</option>
				        <option value="3" disabled>Tres ganadores</option>
				    </select>
				    <script type="text/javascript">
	            		$('#inscripcion').click(function(e) {
	            			var inscripcion = document.getElementById('inscripcion').value;
		            		if (inscripcion == '1') {
		            			document.getElementById("t_premio").style.display = "block";  
		            			document.getElementById("premio").style.display = "block";
		            			document.getElementById("ganadores").style.display = "block";
		            			document.getElementById("t_ganadores").style.display = "block";
		            			document.getElementById('t_premio').innerHTML = "Inscripcion";
		            		}if (inscripcion == '2') {
		            			document.getElementById("t_premio").style.display = "none";
		            			document.getElementById("premio").style.display = "none";
		            			document.getElementById("ganadores").style.display = "none";
		            			document.getElementById("t_ganadores").style.display = "none";
		            		}if (inscripcion == '3') {
		            			document.getElementById("t_premio").style.display = "block";
		            			document.getElementById("premio").style.display = "block";
		            			document.getElementById("ganadores").style.display = "block";
		            			document.getElementById("t_ganadores").style.display = "block";
		            			document.getElementById('t_premio').innerHTML = "Premio";
		            		}if (inscripcion == '4') {
		            			document.getElementById("t_premio").style.display = "block";
		            			document.getElementById("premio").style.display = "block";
		            			document.getElementById("ganadores").style.display = "block";
		            			document.getElementById("t_ganadores").style.display = "block";
		            			document.getElementById('t_premio').innerHTML = "Premio";
		            		}if (inscripcion == '0') {
		            			document.getElementById("t_premio").style.display = "none";
		            			document.getElementById("premio").style.display = "none";
		            			document.getElementById("ganadores").style.display = "none";
		            			document.getElementById("t_ganadores").style.display = "none";
		            		}
		            	});
	            	</script>
	            	<label>Formato</label>
	            	<select id="formato">
	            		<option value="Nada">Seleccionar</option>
				        <option value="Liga">Sistema de Liga</option>
				        <option value="Liga+E">Sist. de Liga + Eliminacion D.</option>
				        <option value="Grupos+E">Grupos + Eliminacion D.</option>
				        <option value="Eliminacion+D">Eliminacion Directa</option>
				    </select>
	            	<label id="cdequipo" style="display: none;">Cant. de equipos</label>
	            	<script type="text/javascript">
	            		$('#formato').click(function(e) {
	            			var formato = document.getElementById('formato').value;
							
	            			if (formato == 'Grupos+E') {
	            				document.getElementById("equipos").style.display = "block";
	            				document.getElementById("equipos_e").style.display = "block";
	            				document.getElementById("equipos2").style.display = "none";
	            				document.getElementById("equipos3").style.display = "none";
	            				document.getElementById("cdequipo").style.display = "block";
	            				document.getElementById("cdequipo_e").style.display = "block";
	            				document.getElementById('cdequipo').innerHTML = "Cant. de grupos";
	            				document.getElementById("cdtipo").style.display = "block";
		            			document.getElementById("tipo").style.display = "block";
		            			document.getElementById("equipos_clasificados").style.display = "block";
		            			document.getElementById("cdtipocla").style.display = "block";
	            			}
		            		if (formato == 'Eliminacion+D') {
		            			document.getElementById("equipos3").style.display = "block";
		            			document.getElementById("equipos2").style.display = "none";
		            			document.getElementById("equipos").style.display = "none";
		            			document.getElementById("equipos_e").style.display = "none";
		            			document.getElementById("cdequipo").style.display = "block";
		            			document.getElementById("cdequipo_e").style.display = "none";
		            			document.getElementById('cdequipo').innerHTML = "Cant. de equipos";
		            			document.getElementById("cdtipo").style.display = "block";
		            			document.getElementById("tipo").style.display = "block";
		            			document.getElementById("equipos_clasificados").style.display = "none";
		            			document.getElementById("cdtipocla").style.display = "none";
		            		}
		            		if (formato == 'Liga') {
		            			document.getElementById("equipos2").style.display = "block";
		            			document.getElementById("equipos").style.display = "none";
		            			document.getElementById("equipos_e").style.display = "none";
		            			document.getElementById("equipos3").style.display = "none";
		            			document.getElementById("cdequipo").style.display = "block";
		            			document.getElementById("cdequipo_e").style.display = "none";
		            			document.getElementById('cdequipo').innerHTML = "Cant. de equipos";
		            			document.getElementById("cdtipo").style.display = "block";
		            			document.getElementById("tipo").style.display = "block";
		            			document.getElementById("equipos_clasificados").style.display = "none";
		            			document.getElementById("cdtipocla").style.display = "none";
		            		}
		            		if (formato == 'Liga+E') {
		            			document.getElementById("equipos2").style.display = "block";
		            			document.getElementById("equipos").style.display = "none";
		            			document.getElementById("equipos_e").style.display = "none";
		            			document.getElementById("equipos3").style.display = "none";
		            			document.getElementById("cdequipo").style.display = "block";
		            			document.getElementById("cdequipo_e").style.display = "none";
		            			document.getElementById('cdequipo').innerHTML = "Cant. de equipos";
		            			document.getElementById("cdtipo").style.display = "block";
		            			document.getElementById("tipo").style.display = "block";
		            			document.getElementById("equipos_clasificados").style.display = "block";
		            			document.getElementById("cdtipocla").style.display = "block";
		            		}
		            		if (formato == 'Nada') {
		            			document.getElementById("equipos2").style.display = "none";
		            			document.getElementById("equipos").style.display = "none";
		            			document.getElementById("equipos_e").style.display = "none";
		            			document.getElementById("equipos3").style.display = "none";
		            			document.getElementById("cdequipo").style.display = "none";
		            			document.getElementById("cdequipo_e").style.display = "none";
		            			document.getElementById("equipos_clasificados").style.display = "none";
		            			document.getElementById("cdtipocla").style.display = "none";
		            			document.getElementById("cdtipo").style.display = "none";
		            			document.getElementById("tipo").style.display = "none";
		            		}
		            	});
	            	</script>
	            	<select id="equipos" style="display: none;"> <!-- CANT. GRUPOS -->
	            	    <option value="">Seleccionar</option>
				        <option value="2">2</option>
				        <option value="4">4</option>
				        <option value="8">8</option>
				    </select>
				    <label id="cdequipo_e" style="display: none;">Cant. de equipos por grupo</label>
				    <input style="display: none;" type="number" name="" id="equipos_e" maxlength="2"><!-- GRUPOS JUGADORES -->
				    <select id="equipos3" style="display: none;"><!-- ELIMINACION DIRECTA -->
				        <option value="4">4</option>
				        <option value="8">8</option>
				        <option value="16">16</option>
				        <option value="32">32</option>
				    </select>
	            	<input style="display: none;" type="number" name="" id="equipos2" maxlength="2"> <!-- LIGA + ELIMINACION -->
	            	<label id="cdtipocla" style="display: none;">Cant. de clasificados</label>
	            	<select id="equipos_clasificados" style="display: none;">
	            	    <option value="">Cant. de clasificados</option>
				        <option style="display: none;" id="c_c2" value="2">2</option>
				        <option style="display: none;" id="c_c4" value="4">4</option>
				        <option style="display: none;" id="c_c8" value="8">8</option>
				    </select>
				    <script type="text/javascript">
				        $('#formato').click(function(e) {
	            			var formato2 = document.getElementById('formato').value;
		            		if (formato2 == 'Liga+E') {
		            		    const input = document.getElementById("equipos2");
	            		
                    		    input.addEventListener('keyup', function(e) {
                                var equipos = document.getElementById('equipos2').value;
    							
    	            			if (equipos >= 2) {
    	            				document.getElementById("c_c2").style.display = "block";
    	            			}else{
    	            			    document.getElementById("c_c2").style.display = "none";
    	            			}
    		            		if (equipos >= 5) {
    		            			document.getElementById("c_c4").style.display = "block";
    		            		}else{
    	            			    document.getElementById("c_c4").style.display = "none";
    	            			}
    		            		if (equipos >= 9) {
    		            			document.getElementById("c_c8").style.display = "block";
    		            		}else{
    	            			    document.getElementById("c_c8").style.display = "none";
    	            			}
                                });	
		            		} 
		            		if (formato2 == 'Grupos+E') {
    							$('#equipos').click(function(e) {
    							    var c_equipos = document.getElementById('equipos').value;
        	            			if ((c_equipos == 4) || (c_equipos == 2)) {
        		            		    document.getElementById("c_c2").style.display = "block";
        		            			document.getElementById("c_c4").style.display = "block";
        		            		}else{
        		            		    document.getElementById("c_c4").style.display = "none";
        		            		}
        		            		if (c_equipos == 8) {
        		            			document.getElementById("c_c2").style.display = "block";
        		            		}
        	            			
    							});
		            		} 
		            	});
	            	</script>
	            	<label id="cdtipo" style="display: none;">Tipo de enfrentamiento</label>
	            	<select id="tipo" style="display: none;">
	            		<option value="Nada">Seleccionar</option>
				        <option value="Ida">Solo ida</option>
				        <option value="Vuelta">Ida y vuelta</option>
				    </select>
				    <label>Seleccionar juego & Plataforma</label>
            		<select id="juego" name="juego">
        			<?php
        				$juegos = "SELECT * FROM juegos GROUP BY nombre ORDER BY nombre DESC";
						$res = $conn->query($juegos);
					?>
						<option value="">Seleccionar</option>
					<?php
						while ($rows = mysqli_fetch_row($res)) {
        			?>
        				
				        <option value="<?php echo $rows[1]; ?>"><?php echo $rows[1]; ?></option>
			        <?php
			        	}
			        ?>
				    </select>
				    <select id="plataforma" name="plataforma">
				        <option value="">Seleccionar</option>
				    	<option value="NEXT GENT">NEXT GENT</option>
				        <option value="OLD GENT">OLD GENT</option>
				        <option value="OTROS">OTROS</option>
				    </select>
	            	<button id="crear_torneo">Crear torneo</button>
	            </form>
	        </div>
	        <label for="btn-modal" class="cerrar-modal"></label>
	    </div>
	<?php
	    }
	?>
		<header id="hbar">
			<ul>
				<?php
					if (empty(($_SESSION['datos']))) {
				?>
					<li><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a href="/login">Iniciar sesion</a></li>
				<?php
					}else{
				?>
				    <li id="btn-desp" style="float: left; display: none;"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M16 18V20H5V18H16ZM21 11V13H3V11H21ZM19 4V6H8V4H19Z"></path></svg></a></li>
					<li style="margin-left: 2rem; float: left;"><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a href="/bd/cerrar" style="margin-right: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z"></path></svg></a></li>
					<li><a href="/perfil/<?php echo $_SESSION['datos']['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg></a></li>
				<?php
        	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id' AND estado = '0'");
        	        $notsql2v = mysqli_num_rows($notsql2);
        	    ?>
					<li id="btn-ntf"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M5 18H19V11.0314C19 7.14806 15.866 4 12 4C8.13401 4 5 7.14806 5 11.0314V18ZM12 2C16.9706 2 21 6.04348 21 11.0314V20H3V11.0314C3 6.04348 7.02944 2 12 2ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z"></path></svg></a><?php if($notsql2v > 0){ ?><p><?php echo $notsql2v; ?></p><?php } ?></li>
					<li id="btn-bonos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M2.00488 9.49979V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V9.49979C20.6242 9.49979 19.5049 10.6191 19.5049 11.9998C19.5049 13.3805 20.6242 14.4998 22.0049 14.4998V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V14.4998C3.38559 14.4998 4.50488 13.3805 4.50488 11.9998C4.50488 10.6191 3.38559 9.49979 2.00488 9.49979ZM14.0049 4.99979H4.00488V7.96755C5.4866 8.7039 6.50488 10.2329 6.50488 11.9998C6.50488 13.7666 5.4866 15.2957 4.00488 16.032V18.9998H14.0049V4.99979ZM16.0049 4.99979V18.9998H20.0049V16.032C18.5232 15.2957 17.5049 13.7666 17.5049 11.9998C17.5049 10.2329 18.5232 8.7039 20.0049 7.96755V4.99979H16.0049Z"></path></svg></li>
					<li id="wallet-cel"><span id="wallet">$<?php echo $s_wallet; ?> <label id="clic-wbtn" for="btn-modal-wallet" style="cursor: pointer;"><a>Depositar</a></label></span></li>
				<?php
					}
				?>
			</ul>
		</header>
		<header id="header-cel" style="height: 3rem;">
		    <span id="wallet2" style="margin-left: 1.5rem;">$<?php echo $s_wallet; ?> <label for="btn-modal-wallet" style="cursor: pointer;"><a>Depositar</a></label></span>
        </header>
		<div id="content-notificacion">
	    <?php
	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id' AND estado = '0'");
	        $notsql2v = mysqli_num_rows($notsql2);
	    ?>
		    <h2>Notificaciones (<?php echo $notsql2v; ?>)</h2>
		    <div id="content-notificacion-scroll">
		    <?php
		        $notsql = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id' ORDER BY id_notificacion DESC");
		        $ncont = 0;
		        while ($notsqlv = mysqli_fetch_row($notsql)) {
		            $notsqlc = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$notsqlv[1]'");
		            $notsqlcv = $notsqlc->fetch_row();
		            $deps = mysqli_query($conn, "SELECT juego FROM desafio WHERE id_desafio = '$notsqlv[5]'");
		            $depsv = $deps->fetch_row();
		            $juegoex = explode("/", $depsv[0]);
		            
		            if($notsqlv[3] == "Desafio"){
		                $imgn = $notsqlcv[1];
		                $nombred = $notsqlcv[0];
		                $msj = "¡Te envio una solicitud de desafio! para [ ".$juegoex[0]." / ".$juegoex[1]." ]";
		                $linkd = "/juego/".$juegoex[0]."/".$juegoex[1]."&desafiop=".$notsqlv[5];
		            }if($notsqlv[3] == "DesafioP"){
		                $imgn = $notsqlcv[1];
		                $nombred = $notsqlcv[0];
		                $msj = "¡Te envio una solicitud de desafio! para [ ".$juegoex[0]." / ".$juegoex[1]." ]";
		                $linkd = "/desafio/".$notsqlv[5];
		            }if($notsqlv[3] == "DesafioA"){
		                $imgn = $notsqlcv[1];
		                $nombred = "Desafio";
		                $msj = $notsqlcv[0]." ¡Acepto tu desafio!";
		                $linkd = "/bd/torneon?id=".$notsqlv[5]."&n=".$notsqlv[0];
		            }if($notsqlv[3] == "DesafioAP"){
		                $imgn = $notsqlcv[1];
		                $nombred = "Desafio";
		                $msj = $notsqlcv[0]." ¡Acepto tu desafio!";
		                $linkd = "/desafio/".$notsqlv[5];
		            }if($notsqlv[3] == "TorneoI"){
		                $imgn = $notsqlcv[1];
		                $sqltn = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $nombred = $sqltnv[0];
		                $msj = $notsqlcv[0]." ¡Te esta invitando a su torneo!";
		                $linkd = "/bd/torneon?id=".$notsqlv[5]."&n=".$notsqlv[0];
		            }if($notsqlv[3] == "TorneoIP"){
		                $imgn = $notsqlcv[1];
		                $sqltn = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $nombred = $sqltnv[0];
		                $msj = $notsqlcv[0]." ¡Te esta invitando a su torneo!";
		                $linkd = "/torneo/".$notsqlv[5]."&u=".$notsqlv[1];
		            }if($notsqlv[3] == "TorneoR"){
		                $sqltn = mysqli_query($conn, "SELECT titulo,id_cuenta FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $sqltn2 = mysqli_query($conn, "SELECT img FROM cuentas WHERE id_cuenta = '$sqltnv[1]'");
		                $sqltnv2 = $sqltn2->fetch_row();
		                $imgn = $sqltnv2[0];
		                $nombred = $sqltnv[0];
		                $msj = "¡Te invitaron a reemplazar un jugador del torneo!";
		                $linkd = "/bd/torneon?id=".$notsqlv[5]."&n=".$notsqlv[0];
		            }if($notsqlv[3] == "TorneoRP"){
		                $sqltn = mysqli_query($conn, "SELECT titulo,id_cuenta FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $sqltn2 = mysqli_query($conn, "SELECT img FROM cuentas WHERE id_cuenta = '$sqltnv[1]'");
		                $sqltnv2 = $sqltn2->fetch_row();
		                $imgn = $sqltnv2[0];
		                $nombred = $sqltnv[0];
		                $msj = "¡Te invitaron a reemplazar un jugador del torneo!";
		                $linkd = "/torneo/".$notsqlv[5]."&u=".$notsqlv[1];
		            }if($notsqlv[3] == "RetiroA"){
		                $sqltn = mysqli_query($conn, "SELECT saldo FROM wallet_t WHERE id_transaccion = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $r_saldoa = number_format($sqltnv[0], 2, '.', ',');
		                $imgn = "img/Logo2.png";
		                $nombred = "Retiro de saldo";
		                $msj = "¡Tu retiro de $".$r_saldoa." fue aprobado!";
		                $linkd = "/bd/torneon?n=".$notsqlv[0];
		            }if($notsqlv[3] == "RetiroAP"){
		                $sqltn = mysqli_query($conn, "SELECT saldo FROM wallet_t WHERE id_transaccion = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $r_saldoa = number_format($sqltnv[0], 2, '.', ',');
		                $imgn = "img/Logo2.png";
		                $nombred = "Retiro de saldo";
		                $msj = "¡Tu retiro de $".$r_saldoa." fue aprobado!";
		                $linkd = "";
		            
		            }if($notsqlv[3] == "TAuditado"){
		                $imgn = $notsqlcv[1];
		                $sqltn = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $nombred = $sqltnv[0];
		                $imgn = "img/Logo2.png";
		                $msj = $notsqlcv[0]." ¡Tu torneo ya fue revisado y finalizado!";
		                $linkd = "/bd/torneon?id=".$notsqlv[5]."&n=".$notsqlv[0];
		            }if($notsqlv[3] == "TPAuditado"){
		                $sqltn = mysqli_query($conn, "SELECT titulo,id_cuenta FROM torneos WHERE id = '$notsqlv[5]'");
		                $sqltnv = $sqltn->fetch_row();
		                $sqltn2 = mysqli_query($conn, "SELECT img FROM cuentas WHERE id_cuenta = '$sqltnv[1]'");
		                $sqltnv2 = $sqltn2->fetch_row();
		                $imgn = "img/Logo2.png";
		                $nombred = $sqltnv[0];
		                $msj = "¡Tu torneo ya fue revisado y finalizado!";
		                $linkd = "/torneo/".$notsqlv[5];
		            }
		    ?>
		        <a href="<?php echo $linkd; ?>"><span title="<?php echo $msj; ?>">
	            <?php
	                if($notsqlv[4] == 0){
	            ?>
	                <div>ㅤ</div>
	            <?php
	                }
	            ?>
    		        <img src="/<?php echo $imgn; ?>">
    		        <h3><?php echo $nombred; ?></h3>
    		        <p><?php echo $msj; ?></p>
    		    </span></a>
		    <?php
		        }
		    ?>
    		    
		    </div>
	    </div>
	    <div id="content-bonos">
    <?php
        $nlvcb = "nvl".$nvlC;
        if($conT2m >= 0.5){
            $activob = "activo";
        }
        $bonosql = mysqli_query($conn, "SELECT * FROM bonos WHERE (aplican = 'todos' OR aplican = '$nlvcb' OR aplican = '$activob') AND status = '0'");
    ?>
		    <h2>Bonos</h2>
		    <div id="content-bonos-scroll">
    <?php
            while ($bsql = mysqli_fetch_row($bonosql)) {
                $fechacb = new DateTime($bsql[7]);
	            $fechacbv = $fechacb->format("M j, Y, g:i a");
	            $fechaeb = new DateTime($bsql[8]);
	            $fechaebv = $fechaeb->format("M j, Y, g:i a");
    ?>
                <div class="item">
                    <div class="item-right">
                <?php
                    if($bsql[3] == 'recarga'){
                ?>
                        <h1 class="num"><?php echo $bsql[4]; ?><p class="num_pctj">%</p></h1>
                        <p class="day">Al recargar</p>
                <?php
                    }
                    if($bsql[3] == 'saldo'){
                ?>
                        <h1 class="num"><?php echo $bsql[4]; ?><p class="num_pctj">USD</p></h1>
                        <p class="day">Saldo</p>
                <?php
                    }
                ?>
                    </div>
                    <div class="item-left">
                        <p class="event"><?php echo $bsql[1]; ?></p>
                        <h2 class="title"><?php echo $bsql[2]; ?></h2>
                      
                        <div class="sce">
                            <div class="icon">
                                <i class="fa fa-table"></i>
                            </div>
                    <?php
                        if($bsql[6] == '0'){
                    ?>
                            <p>de: <?php echo $fechacbv; ?><br/>hasta: <?php echo $fechaebv; ?></p>
                    <?php
                        }else{
                    ?>
                            <p>Sin expiracion</p>
                    <?php
                        }
                    ?>
                        </div>
                        <div class="fix"></div>
                      <div class="fix"></div>
                      <button class="tickets">Aplicar</button>
                    </div>
                  </div>
    <?php
            }
    ?>
		    </div>
	    </div>
	    <div id="content-desplegable" style="display: none;"><span id="wallet2">$<?php echo $w_saldo[1]; ?> <label for="btn-modal-wallet" style="cursor: pointer;"><a>Depositar</a></label></span>
            <ul>
                
                <li id="barra-arena2" class="btn-activo"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM10 9H8V11H6V13H7.999L8 15H10L9.999 13H12V11H10V9ZM18 13H16V15H18V13ZM16 9H14V11H16V9Z"></path></svg> <span>Arena</span></p></li>
                <li id="barra-streams2"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M6 2H18C18.5523 2 19 2.44772 19 3V21C19 21.5523 18.5523 22 18 22H6C5.44772 22 5 21.5523 5 21V3C5 2.44772 5.44772 2 6 2ZM12 17C11.4477 17 11 17.4477 11 18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18C13 17.4477 12.5523 17 12 17Z"></path></svg> <span>Streams</span></p></li>
                <li id="barra-mensajes2"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M2 8.99374C2 5.68349 4.67654 3 8.00066 3H15.9993C19.3134 3 22 5.69478 22 8.99374V21H8.00066C4.68659 21 2 18.3052 2 15.0063V8.99374ZM14 11V13H16V11H14ZM8 11V13H10V11H8Z"></path></svg> <span>Mensajes</span></p></li>
                <li></li>
            <?php
                if ($ci_row[4] >= 1){
        	?>
                <label title="Crear un torneo" id="1v1" for="btn-modal"><li><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg> <span>Crear t.</span></p></li></label>
            <?php
        	    }
        	?>
                <label title="Crear un desafio" id="1v1" for="btn-modal-1v1"><li><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M7.04813 13.4061L10.5831 16.9421L9.1703 18.3558L10.5849 19.7711L9.17064 21.1853L6.69614 18.71L3.86734 21.5388L2.45312 20.1246L5.28192 17.2958L2.80668 14.8213L4.22089 13.4071L5.63477 14.8202L7.04813 13.4061ZM2.99907 3L6.54506 3.00335L18.3624 14.8207L19.7772 13.4071L21.1915 14.8213L18.7166 17.2962L21.545 20.1246L20.1308 21.5388L17.3024 18.7104L14.8275 21.1853L13.4133 19.7711L14.8269 18.3562L3.00181 6.53118L2.99907 3ZM17.4563 3.0001L20.9991 3.00335L21.001 6.52648L16.9481 10.5781L13.4121 7.0431L17.4563 3.0001Z"></path></svg> <span>Crear d.</span></p></li></label>
            </ul>
	    </div>
        <div id="barra-left">
            <ul>
                <li id="barra-arena" class="btn-activo"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM10 9H8V11H6V13H7.999L8 15H10L9.999 13H12V11H10V9ZM18 13H16V15H18V13ZM16 9H14V11H16V9Z"></path></svg> <span>Arena</span></p></li>
                <li id="barra-streams"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M6 2H18C18.5523 2 19 2.44772 19 3V21C19 21.5523 18.5523 22 18 22H6C5.44772 22 5 21.5523 5 21V3C5 2.44772 5.44772 2 6 2ZM12 17C11.4477 17 11 17.4477 11 18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18C13 17.4477 12.5523 17 12 17Z"></path></svg> <span>Streams</span></p></li>
                <li id="barra-mensajes"><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M2 8.99374C2 5.68349 4.67654 3 8.00066 3H15.9993C19.3134 3 22 5.69478 22 8.99374V21H8.00066C4.68659 21 2 18.3052 2 15.0063V8.99374ZM14 11V13H16V11H14ZM8 11V13H10V11H8Z"></path></svg> <span>Mensajes</span></p></li>
                <li></li>
                <label title="Crear un desafio" id="1v1" for="btn-modal-1v1"><li><p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M7.04813 13.4061L10.5831 16.9421L9.1703 18.3558L10.5849 19.7711L9.17064 21.1853L6.69614 18.71L3.86734 21.5388L2.45312 20.1246L5.28192 17.2958L2.80668 14.8213L4.22089 13.4071L5.63477 14.8202L7.04813 13.4061ZM2.99907 3L6.54506 3.00335L18.3624 14.8207L19.7772 13.4071L21.1915 14.8213L18.7166 17.2962L21.545 20.1246L20.1308 21.5388L17.3024 18.7104L14.8275 21.1853L13.4133 19.7711L14.8269 18.3562L3.00181 6.53118L2.99907 3ZM17.4563 3.0001L20.9991 3.00335L21.001 6.52648L16.9481 10.5781L13.4121 7.0431L17.4563 3.0001Z"></path></svg> <span>Crear d.</span></p></li></label>
            </ul>
        </div>
		<div id="contenido">
		    <div id="contenido-pub">
		        <div class="slideshow-container">
                    <?php
    		            $psql = mysqli_query($conn, "SELECT * FROM publicidad ORDER BY id_pub ASC");
    		            $contsl = 0;
    		            while ($rowsp = mysqli_fetch_row($psql)) {
    		                
    		        ?>
    		            <div class="mySlides fade">
                            <a href="<?php echo $rowsp[2]; ?>"><img src="<?php echo $rowsp[1]; ?>"></a>
                        </div>
                    <?php
                        $contsl = $contsl + 1;
    		            }
    		        ?>
                    <div style="position: absolute; z-index: 50; margin-top: .75rem; top: auto; left: 0; width: 100%; display: flex; text-align: center; justify-content: center; align-items: center;">
                    <?php
    		            $psql = mysqli_query($conn, "SELECT * FROM publicidad ORDER BY id_pub ASC");
    		            $contsl = 0;
    		            while ($rowsp = mysqli_fetch_row($psql)) {
    		                
    		        ?>
                        <span class="dot" onclick="currentSlide(<?php echo $contsl; ?>)"></span> 
                    <?php
                        $contsl = $contsl + 1;
    		            }
    		        ?>
                    </div>
                </div>
                <script>
                    function currentSlide(n) {
                      showSlides(slideIndex = n);
                      setTimeout(showSlides, 5000);
                    }
                    let slideIndex = 0;
                    showSlides();
                    function showSlides() {
                        let i;
                        let slides = document.getElementsByClassName("mySlides");
                        let dots = document.getElementsByClassName("dot");
                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";  
                        }
                        slideIndex++;
                        if (slideIndex > slides.length) {slideIndex = 1}
                        for (i = 0; i < dots.length; i++) {
                            dots[i].className = dots[i].className.replace(" active", "");
                        }
                        slides[slideIndex-1].style.display = "block";  
                        dots[slideIndex-1].className += " active";
                        setTimeout(showSlides, 5000); // 5seg de tiempo para cambiar
                    }
                </script>
		    </div>
		    <div id="contenido-s">
			<h2><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="rgba(0,0,0,1)"><path d="M12 2C15.1215 2 17.9089 3.43021 19.7428 5.67108L13.4142 12L19.7428 18.3289C17.9089 20.5698 15.1215 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 5C11.1716 5 10.5 5.67157 10.5 6.5C10.5 7.32843 11.1716 8 12 8C12.8284 8 13.5 7.32843 13.5 6.5C13.5 5.67157 12.8284 5 12 5Z"></path></svg> # Juegos disponibles</h2>
			<div id="c_juegos" style="margin-left: 1rem;">
			    <?php
					$juegos = "SELECT * FROM juegos ORDER BY id_juego DESC LIMIT 6";
					$res = $conn->query($juegos);

					while ($rows = mysqli_fetch_row($res)) {
				?>
				<div class="juegos">
				    <a href="juego/<?php echo $rows[1]; ?>/<?php echo $rows[3]; ?>">
				        <img src="<?php echo $rows[2]; ?>">
				        <p><?php echo $rows[1]; ?> | <?php echo $rows[3]; ?></p>
				    </a>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		    <footer>
		    <div id="f_logo">
		        <img src="/img/Logo.png">
		        <label>CSPORT</label>
		        <span>© 2024 COP SPORT</span>
		    </div>
		    <div id="f_content">
		        <content>
		            <a href="privacidad">Política de privacidad</a>
		            <a href="terminos">Términos y condiciones</a>
		            <a href="nosotros">Hable con nosotros</a>
		            <a href="ayuda">Centro de ayuda</a>
		        </content>
		        <content>
		            <a href="soporte">Soporte tecnico</a>
		            <a></a>
		            <a href="https://www.instagram.com/csport.es/" target="_blank" style="color: #000;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(0,0,0,1)"><path d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z"></path></svg> Instagram</a>
		            <a href="" style="color: #000;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(0,0,0,1)"><path d="M13.001 19.9381C16.9473 19.446 20.001 16.0796 20.001 12C20.001 7.58172 16.4193 4 12.001 4C7.5827 4 4.00098 7.58172 4.00098 12C4.00098 16.0796 7.05467 19.446 11.001 19.9381V14H9.00098V12H11.001V10.3458C11.001 9.00855 11.1402 8.52362 11.4017 8.03473C11.6631 7.54584 12.0468 7.16216 12.5357 6.9007C12.9184 6.69604 13.3931 6.57252 14.2227 6.51954C14.5519 6.49851 14.9781 6.52533 15.501 6.6V8.5H15.001C14.0837 8.5 13.7052 8.54332 13.4789 8.66433C13.3386 8.73939 13.2404 8.83758 13.1653 8.97793C13.0443 9.20418 13.001 9.42853 13.001 10.3458V12H15.501L15.001 14H13.001V19.9381ZM12.001 22C6.47813 22 2.00098 17.5228 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22Z"></path></svg> Facebook</a>
		            <div id="design"><svg style="float: left; margin-right: .25rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="14" height="14" fill="rgba(144,144,144,1)"><path d="M392.8 1.2c-17-4.9-34.7 5-39.6 22l-128 448c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l128-448c4.9-17-5-34.7-22-39.6zm80.6 120.1c-12.5 12.5-12.5 32.8 0 45.3L562.7 256l-89.4 89.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-112-112c-12.5-12.5-32.8-12.5-45.3 0zm-306.7 0c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l112 112c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256l89.4-89.4c12.5-12.5 12.5-32.8 0-45.3z"/></svg><a href="https://instagram.com/oghb1d/" target="blank" style="text-decoration: none; color: #909090; font-size: .7rem;">Producido por @oghb1d</a>
                    </div>
		        </content>
		    </div>
		</footer>
		</div>
		<div id="contenido-msj">
            <div id="contenido-msj-b">
                <h2>Chats recientes</h2>
            </div>
            <main id="cont-msj-p">
                <div id="contenido-msj-scroll">
                <?php
                    $msjd = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$id' AND tipo = 'Msj') OR (id_enfrentamiento = '$id' AND tipo = 'Msj') GROUP BY id_torneo ORDER BY id_chat DESC");
                    while($msjdv = mysqli_fetch_row($msjd)){
                        if($msjdv[1] != $id){
                            if($msjdv[2] == $id){
                            $id_co = $msjdv[3];
                            }else{
                            $id_co = $msjdv[2];
                        }
                        
                            $msjdc = mysqli_query($conn, "SELECT nombre,status,img FROM cuentas WHERE id_cuenta = '$id_co'");
                            $msjdcv = $msjdc->fetch_row();
                            $msju = mysqli_query($conn, "SELECT mensaje,id_cuenta FROM chat WHERE (id_cuenta = '$id' AND id_enfrentamiento = '$msjdv[1]') OR (id_cuenta = '$msjdv[1]' AND id_enfrentamiento = '$id') ORDER BY id_chat DESC");
                            $msjuv = $msju->fetch_row();
                            
                            $shoy = $msjdcv[1];
                            $fechaDes = new DateTime($shoy);
                            $fechaActual = new DateTime();
                            $diferencia = $fechaActual->diff($fechaDes);
                ?>
                            <a href="/buscador?msj=<?php echo $id_co; ?>">
                                <div class="cont-msj-chat"><?php if(($diferencia->d == 0) && ($diferencia->h <= 0) && ($diferencia->i <= 5)){ echo "<span style='background: #56aa57;'>ㅤ</span>"; }else{ echo "<span style='background: #aa5656;'>ㅤ</span>"; } ?>
                                    <img src="/<?php echo $msjdcv[2]; ?>">
                                    <label><?php echo $msjdcv[0]; ?></label>
                                <?php
                                    if($msjuv[1] == $id){
                                        $msjt = "Tu";
                                    }else{
                                        $msjt = "El";
                                    }
                                ?>
                                    <p><?php echo $msjt;?>: <?php echo $msjuv[0]; ?></p>
                                </div>
                            </a>
                <?php
                        }
                    }
                ?>
                </div>
            </main>
		</div>
    </div>
</body>
</html>
<?php
	$buscar_t2 = "SELECT * FROM torneos WHERE id_cuenta = '$id' ORDER BY id_torneo DESC LIMIT 1";
	$rest2 = $conn->query($buscar_t2);
	$valt2 = $rest2->fetch_row();
	$valt22 = $valt2[1] + 1;
?>
<script type="text/javascript">
    $('#btn-ntf').click(function(e) {
        document.getElementById('content-notificacion').style.display = "block";
        document.getElementById('content-bonos').style.display = "none";
    });
    $('#btn-bonos').click(function(e) {
        document.getElementById('content-bonos').style.display = "block";
        document.getElementById('content-notificacion').style.display = "none";
    });
    document.addEventListener('click', function(e) {
        var bonos = document.getElementById('content-bonos');
        var hbar = document.getElementById('hbar');
        if (!bonos.contains(event.target)) {
            if (!hbar.contains(event.target)) {
                bonos.style.display = 'none';
            }
        }
    });
    document.addEventListener('click', function(e) {
        var notificacion = document.getElementById('content-notificacion');
        var hbar = document.getElementById('hbar');
        if (!notificacion.contains(event.target)) {
            if (!hbar.contains(event.target)) {
                notificacion.style.display = 'none';
            }
        }
    });
            
    $('#m_paypal').click(function(e) {
        var saldo = document.getElementById('wr_saldo').value;
        
        if((saldo == '') || (saldo == null)){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Debes ingresar monto a retirar";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('withdraw-saldo').disabled = false;
			}, 2000);
        }else{
            if((<?php echo $s_wallet; ?> <= saldo)){
                document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "No tienes ese balance disponible";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('withdraw-saldo').disabled = false;
    			}, 2000);
            }else{
                if((saldo < 10) || (saldo > 30)){
                    document.getElementById("errorwd1").style.display = "block";
        		  	document.getElementById("errorwd1").innerHTML = "Minimo de saldo a retirar 10USD | max 30USD";
        			setTimeout(() => {
        				document.getElementById("errorwd1").style.display = "none";
        				document.getElementById('withdraw-saldo').disabled = false;
        			}, 2000);
                }else{
                    if(<?php echo $s_wallet * $nvlCP; ?> <= saldo){
                        document.getElementById("errorwd1").style.display = "block";
            		  	document.getElementById("errorwd1").innerHTML = "Solo puedes retirar el <?php echo $nvlCP*100?>% | <?php echo $s_wallet * $nvlCP; ?>USD";
            			setTimeout(() => {
            				document.getElementById("errorwd1").style.display = "none";
            				document.getElementById('withdraw-saldo').disabled = false;
            			}, 2000);
                    }else{
                        document.getElementById('wallet-volver2').style.display = "none";
                        document.getElementById('wr-fase1').style.display = "none";
                        document.getElementById('wr-fase2').style.display = "block";
                        document.getElementById('wallet-volverfase').style.display = "block";
                        document.getElementById('withdraw-saldo').innerHTML = "Retirar $"+saldo;
                    }
                }
                
            }
        }
    });
    $('#wallet-volverfase').click(function(e) {
        document.getElementById('wallet-volverfase').style.display = "none";
        document.getElementById('wr-fase2').style.display = "none";
        document.getElementById('wr-fase1').style.display = "block";
        document.getElementById('wallet-volver2').style.display = "block";
    });
    $(document).ready(function(){
		$('#msj-pbtn').click(function(e) {
			e.preventDefault();

			var mensaje = document.getElementById('mensajemsj').value;
			var mensaje2 = " "+mensaje;
			var php = "mensaje="+mensaje2+"&tipo=Msj";

			$.ajax({
				url: '/bd/mensajeM.php?id=<?php echo $idmsj2; ?>',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "enviado") {
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
				url: '/bd/mensajeTimeM.php?id=<?php echo $idmsj2; ?>',
				type: 'POST',
				dataType: 'text',
				success:function(data){
					$("#content-modal-msj-scroll").html(data);
				}
			});
		}, 1000);
	});
<?php
    if(isset($_GET['m'])){
?>
        document.getElementById('contenido').style.display = "none";
        document.getElementById('contenido-msj').style.display = "block";
        document.getElementById('barra-arena').classList.remove('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.add('btn-activo');
<?php
    }
    if(isset($_GET['msj'])){
?>
        document.getElementById('contenido').style.display = "none";
        document.getElementById('contenido-msj').style.display = "block";
        document.getElementById('barra-arena').classList.remove('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.add('btn-activo');
<?php
    }
    if(isset($_GET['wallet'])){
?>
        var btn = document.getElementById('clic-wbtn');
        btn.click()
<?php
    }
    if(isset($_GET['torneo'])){
?>
        var btn = document.getElementById('btn-modal');
        btn.click()
<?php
    }
    if(isset($_GET['desafio'])){
?>
        var btn = document.getElementById('btn-modal-1v1');
        btn.click()
<?php
    }
?>
    $('.cerrar-modal-msj').click(function(e) {
        window.location = "/buscador?m";
    });
    $('#btn-desp').click(function(e) {
        document.getElementById('content-desplegable').style.display = "block";
    });
    document.addEventListener('click', function(e) {
        var desp = document.getElementById('content-desplegable');
        var hbar = document.getElementById('hbar');
        if (!desp.contains(event.target)) {
            if (!hbar.contains(event.target)) {
                desp.style.display = 'none';
            }
        }
    });
    $('#barra-arena').click(function(e) {
        document.getElementById('contenido').style.display = "block";
        document.getElementById('contenido-msj').style.display = "none";
        
        document.getElementById('barra-arena').classList.add('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.remove('btn-activo');
        
        document.getElementById('content-desplegable').style.display = "none";
    });
    $('#barra-mensajes').click(function(e) {
        document.getElementById('contenido').style.display = "none";
        document.getElementById('contenido-msj').style.display = "block";
        
        document.getElementById('barra-arena').classList.remove('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.add('btn-activo');
        
        document.getElementById('content-desplegable').style.display = "none";
    });
    $('#barra-arena2').click(function(e) {
        document.getElementById('contenido').style.display = "block";
        document.getElementById('contenido-msj').style.display = "none";
        
        document.getElementById('barra-arena').classList.add('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.remove('btn-activo');
        
        document.getElementById('content-desplegable').style.display = "none";
    });
    $('#barra-mensajes2').click(function(e) {
        document.getElementById('contenido').style.display = "none";
        document.getElementById('contenido-msj').style.display = "block";
        
        document.getElementById('barra-arena').classList.remove('btn-activo');
        document.getElementById('barra-streams').classList.remove('btn-activo');
        document.getElementById('barra-mensajes').classList.add('btn-activo');
        
        document.getElementById('content-desplegable').style.display = "none";
    });
    $('#crear-desafio').click(function(e) {
		e.preventDefault();
        
        document.getElementById('crear-desafio').disabled = true;
        
		var juego = document.getElementById('juego-d').value;
		var monto = document.getElementById('monto-d').value;
		var tiempos = document.getElementById('tiempos-d').value;
		var plantilla = document.getElementById('plantilla-d').value;
		var encuentro = document.getElementById('encuentro-d').value;
		var incognito = document.getElementById('incognito-d');
		
		if(incognito.checked){
		    var incognitot = "true";
		}else{
		    var incognitot = "false";
		}

		var php = "juego="+juego+"&monto="+monto+"&incognito="+incognitot+"&tiempos="+tiempos+"&plantilla="+plantilla+"&encuentro="+encuentro;
        
		if ((juego == '') || (monto == '')) {
			document.getElementById("error3").style.display = "block";
		  	document.getElementById("error3").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("error3").style.display = "none";
				document.getElementById('crear-desafio').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: 'bd/desafio.php?id_cuenta=<?php echo $id;?>',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
			    if (res == "balance") {
					document.getElementById("error3").style.display = "block";
				  	document.getElementById("error3").innerHTML = "No tienes suficiente balance para crear este desafio";
					setTimeout(() => {
						document.getElementById("error3").style.display = "none";
						document.getElementById('crear-desafio').disabled = false;
					}, 4000);
				}
				if (res == "subiendo") {
					document.getElementById("error3").style.display = "block";
				  	document.getElementById("error3").innerHTML = "Desafio creado con exito";
					document.getElementById('juego-d').value = "";
		            document.getElementById('monto-d').value = "";
					setTimeout(() => {
						document.getElementById("error3").style.display = "none";
						window.location = "/juego/"+juego+"&desafio";
					}, 1000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
	$('#crear_torneo').click(function(e) {
		e.preventDefault();
        
        document.getElementById('crear_torneo').disabled = true;
        
		var titulo = document.getElementById('titulo').value;
		var descripcion = document.getElementById('descripcion').value;
		var inscripcion = document.getElementById('inscripcion').value;
		var formato = document.getElementById('formato').value;
		var equipos = document.getElementById('equipos').value;
		var equipos2 = document.getElementById('equipos2').value;
		var equipos3 = document.getElementById('equipos3').value;
		var tipo = document.getElementById('tipo').value;
		var plataforma = document.getElementById('plataforma').value;
		var juego = document.getElementById('juego').value;
		var equiposc = document.getElementById('equipos_clasificados').value;
		var cporg = document.getElementById('equipos_e').value;
		var premio = document.getElementById('premio').value;
		var ganadores = document.getElementById('ganadores').value;

		var IdUser = "<?php echo $id; ?>";
		var IdTorn = "<?php echo $valt22; ?>";

		var php = "titulo="+titulo+"&descripcion="+descripcion+"&inscripcion="+inscripcion+"&formato="+formato+"&equipos="+equipos+"&equipos2="+equipos2+"&equipos3="+equipos3+"&tipo="+tipo+"&plataforma="+plataforma+"&juego="+juego+"&equiposc="+equiposc+"&cporg="+cporg+"&premio="+premio+"&ganadores="+ganadores;

		if (formato == 'Nada') {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('crear_torneo').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: 'bd/subir_t.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "vacio") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "*Debes completar el formulario";
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
						document.getElementById('crear_torneo').disabled = false;
					}, 4000);
				}
				if (res == "subiendo") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Registrado con exito";
				  	document.getElementById('titulo').value = "";
					document.getElementById('descripcion').value = "";
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
						window.location = "/perfil/"+IdUser+"&e="+IdTorn;
					}, 100);
				}
				
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
    $('#withdraw-saldo').click(function(e) {
		e.preventDefault();
        
        document.getElementById('withdraw-saldo').disabled = true;
        
		var saldo = document.getElementById('wr_saldo').value;
		var email = document.getElementById('wr_email').value;
		var metodo = "Paypal";
		
		var php = "email="+email+"&metodo="+metodo+"&saldo="+saldo;
        
		if ((saldo == '') || (metodo == '')) {
			document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('withdraw-saldo').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/withdraw.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
			    if (res == "balance") {
					document.getElementById("errorwd1").style.display = "block";
				  	document.getElementById("errorwd1").innerHTML = "No tienes suficiente balance para retirar";
					setTimeout(() => {
						document.getElementById("errorwd1").style.display = "none";
						document.getElementById('withdraw-saldo').disabled = false;
					}, 4000);
				}
				if (res == "aprobado") {
					setTimeout(() => {
						window.location = "/buscador";
					}, 1000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
    
	pantalla = window.innerHeight;
	document.getElementById('pantalla').style.height = pantalla+'px';
	document.getElementById('barra-left').style.height = (pantalla - 56)+'px';
	document.getElementById('contenido').style.height = (pantalla - 56)+'px';
	document.getElementById('contenido-msj').style.height = (pantalla - 56)+'px';
	$('#wdm-3').click(function(e) {
	    document.getElementById('wallet-deposit-3').style.display = "block";
        document.getElementById('wallet-deposit-5').style.display = "none";
        document.getElementById('wallet-deposit-10').style.display = "none";
        document.getElementById('wallet-deposit-20').style.display = "none";
        document.getElementById('wallet-deposit-30').style.display = "none";
        document.getElementById('wallet-deposit-cont').style.display = "none";
    });
    $('#wdm-5').click(function(e) {
        document.getElementById('wallet-deposit-3').style.display = "none";
        document.getElementById('wallet-deposit-5').style.display = "block";
        document.getElementById('wallet-deposit-10').style.display = "none";
        document.getElementById('wallet-deposit-20').style.display = "none";
        document.getElementById('wallet-deposit-30').style.display = "none";
        document.getElementById('wallet-deposit-cont').style.display = "none";
    });
    $('#wdm-10').click(function(e) {
        document.getElementById('wallet-deposit-3').style.display = "none";
        document.getElementById('wallet-deposit-5').style.display = "none";
        document.getElementById('wallet-deposit-10').style.display = "block";
        document.getElementById('wallet-deposit-20').style.display = "none";
        document.getElementById('wallet-deposit-30').style.display = "none";
        document.getElementById('wallet-deposit-cont').style.display = "none";
    });
    $('#wdm-20').click(function(e) {
        document.getElementById('wallet-deposit-3').style.display = "none";
        document.getElementById('wallet-deposit-5').style.display = "none";
        document.getElementById('wallet-deposit-10').style.display = "none";
        document.getElementById('wallet-deposit-20').style.display = "block";
        document.getElementById('wallet-deposit-30').style.display = "none";
        document.getElementById('wallet-deposit-cont').style.display = "none";
    });
    $('#wdm-30').click(function(e) {
        document.getElementById('wallet-deposit-3').style.display = "none";
        document.getElementById('wallet-deposit-5').style.display = "none";
        document.getElementById('wallet-deposit-10').style.display = "none";
        document.getElementById('wallet-deposit-20').style.display = "none";
        document.getElementById('wallet-deposit-30').style.display = "block";
        document.getElementById('wallet-deposit-cont').style.display = "none";
    });
    var elemento = document.querySelectorAll("#wallet-volverdm");
    for (var i = 0; i < elemento.length; i++) {
          $(elemento[i]).click(function(e) {
            document.getElementById('wallet-deposit-3').style.display = "none";
            document.getElementById('wallet-deposit-5').style.display = "none";
            document.getElementById('wallet-deposit-10').style.display = "none";
            document.getElementById('wallet-deposit-20').style.display = "none";
            document.getElementById('wallet-deposit-30').style.display = "none";
            document.getElementById('wallet-deposit-cont').style.display = "block";
        });
    }

    $('#wallet-volvera-juste').click(function(e) {
        document.getElementById('wallet-home').style.display = "block";
        document.getElementById('wallet-deposit').style.display = "none";
        document.getElementById('wallet-withdraw').style.display = "none";
    });
    $('#wallet-d').click(function(e) {
        document.getElementById('wallet-home').style.display = "none";
        document.getElementById('wallet-deposit').style.display = "block";
        document.getElementById('wallet-withdraw').style.display = "none";
    });
    $('#wallet-r').click(function(e) {
        document.getElementById('wallet-home').style.display = "none";
        document.getElementById('wallet-deposit').style.display = "none";
        document.getElementById('wallet-withdraw').style.display = "block";
    });
    $('#wallet-volver').click(function(e) {
        document.getElementById('wallet-home').style.display = "block";
        document.getElementById('wallet-deposit').style.display = "none";
        document.getElementById('wallet-withdraw').style.display = "none";
    });
    $('#wallet-volver2').click(function(e) {
        document.getElementById('wallet-home').style.display = "block";
        document.getElementById('wallet-deposit').style.display = "none";
        document.getElementById('wallet-withdraw').style.display = "none";
    });
</script>