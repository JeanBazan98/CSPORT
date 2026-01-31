<?php
    error_reporting(0);
	session_start();
	include_once 'bd/conexion.php';
	$id_cuenta = $_SESSION['datos']['id'];
	$id_torneo = $_GET['id']; $juego = $_GET['t']; $plataforma = $_GET['p']; $id_d = $_GET['d']; $id_enfd = $_GET['d-enf']; $id_d2 = $_GET['desafio']; $id_d2p = $_GET['desafiop'];
	
	$cvery = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id_cuenta'");
	$cveryv = $cvery->fetch_row();
	
	$torneoid = $_GET['id'];
	$id = mysqli_query($conn, "SELECT * FROM torneos WHERE id = '$torneoid'");
	$val = $id->fetch_row();
	
	$wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id_cuenta'");
    $w_saldo = $wallet->fetch_row();
    $s_wallet = number_format($w_saldo[1], 2, '.', ',');
    if(isset($juego)){
        $titlet = $juego." ".$plataforma." | Torneos de Csport";
    }else{
        $titlet = $val[4]." | Torneo de Csport";
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/torneo.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title><?php echo $titlet; ?></title>
</head>
<body>
    <script src="/status.js"></script>
	<div id="pantalla">
	    <input type="checkbox" id="btn-modal">
		<div class="container-modal">
            <?php
                $editar = "SELECT * FROM torneos WHERE id = '$id_torneo'";
				$res = $conn->query($editar);
				$edt = $res->fetch_row();
				
				if($edt[7] == "Liga"){
				    $torneoF = "Sistema de Liga";
				    $torneoFN = "Liga";
				}if($edt[7] == "Liga E"){
				    $torneoF = "Sist. de Liga + Eliminacion D.";
				    $torneoFN = "Liga E";
				}if($edt[7] == "Grupos E"){
				    $torneoF = "Grupos + Eliminacion D.";
				    $torneoFN = "Grupos E";
				}if($edt[7] == "Eliminacion D"){
				    $torneoF = "Eliminacion Directa";
				    $torneoFN = "Eliminacion D";
				}
            ?>
	        <div class="content-modal">
	            <h1>Configuracion de torneo</h1>
	            <div id="lista_t_p">
	            	<form action="/bd/act_t.php?c=<?php echo $id_cuenta; ?>&e=<?php echo $id_torneo; ?>&ADM=" method="POST" enctype="multipart/form-data">
	            		<label>Cambiar titulo</label>
	            		<input type="text" name="titulo" value="<?php echo $edt[4]; ?>">
	            		<label>Cambiar descripcion</label>
	            		<textarea name="descripcion" id="descripcion"><?php echo $edt[5]; ?></textarea>
    	            	<label id="cdtipo" style="display: none;">Tipo de enfrentamiento</label>
    	            	<select id="tipo" style="display: none;" name="tipo">
    	            		<option selected value="<?php echo $edt[15]; ?>"><?php echo $edt[15]; ?></option>
    				        <option value="Ida">Solo ida</option>
    				        <option value="Vuelta">Ida y vuelta</option>
    				    </select>
	            		<label>Seleccionar juego & Plataforma</label>
	            		<select id="juego" name="juego">
            			<?php
            				$juegos = "SELECT * FROM juegos GROUP BY nombre";
							$res = $conn->query($juegos);
						?>
							<option selected value="<?php echo $edt[9]; ?>"><?php echo $edt[9]; ?></option>
						<?php
							while ($rows = mysqli_fetch_row($res)) {
            			?>
            				
					        <option value="<?php echo $rows[1]; ?>"><?php echo $rows[1]; ?></option>
				        <?php
				        	}
				        ?>
					    </select>
					    <select id="plataforma" name="plataforma">
					    	<option value="<?php echo $edt[11]; ?>"><?php echo $edt[11]; ?></option>
	                    	<option value="NEXT GENT">NEXT GENT</option>
	                        <option value="OLD GENT">OLD GENT</option>
					    </select>
	            		<label>Subir imagen</label>
	            		<input type="file" name="imagen">
	            		<button>Guardar</button>
	            		<a href="/bd/eliminar_t.php?id=<?php echo $edt[0]; ?>&ADM=" id="eliminar_t">Eliminar</a>
	            	</form>
	            </div>
	        </div>
	        <label for="btn-modal" class="cerrar-modal"></label>
	    </div>
    <?php
        if(isset($_GET['msj'])){
    ?>
        <input type="checkbox" id="btn-modal-msj">
		<div class="container-modal-msj">
	        <div class="content-modal-msj">
	        <?php
	            $idmsj = $_GET['msj'];
	            $sqlmp = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$id_cuenta' AND id_enfrentamiento = '$idmsj') OR (id_cuenta = '$idmsj' AND id_enfrentamiento = '$id_cuenta')");
	            $sqlmpv = $sqlmp->fetch_row();
	            if($sqlmpv){
    	            if($sqlmpv[2] == $id_cuenta){
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
                    <botton id="msj-p"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558ZM5 4.38249V10.9999H10V12.9999H5V19.6174L18.8499 11.9999L5 4.38249Z"></path></svg></botton>
                </form>
	        </div>
	        <script type="text/javascript">
            	$(document).ready(function(){
            		$('#msj-p').click(function(e) {
            			e.preventDefault();
            
            			var mensaje = document.getElementById('mensajemsj').value;
            			var php = "mensaje="+mensaje+"&tipo=Msj";
            
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
            		var input = document.getElementById("mensajemsj");
                    input.addEventListener("keypress", function(e) {
                          if (e.key === "Enter") {
                            e.preventDefault();
                            document.getElementById("msj-p").click();
                          }
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
            </script>
	        <label for="btn-modal-msj" class="cerrar-modal-msj"></label>
	    </div>
    <?php
        }
        if(isset($_GET['ed'])){
            if(!empty($_GET['ed'])){
                $id_dp = $_GET['ed'];
                $sqlcdp = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$id_dp'");
                $sqlcdpv = $sqlcdp->fetch_row();
                $sqlcdpw = mysqli_query($conn, "SELECT saldo FROM wallet WHERE id_cuenta = '$id_dp'");
                $sqlcdpvw = $sqlcdpw->fetch_row();
    ?>
                <input type="checkbox" id="btn-modal-1v1">
        		<div class="container-modal-1v1">
        	        <div class="content-modal-1v1">
        	            <h1>Desafiar a <?php echo $sqlcdpv[0]; ?></h1>
        	            <span id="error4"></span>
        	            <form>
        	                <div id="desafio-config1">
            	                <label>Premios</label>
            	                <select id="monto-d" style="margin-left: calc(50% - 5.75rem);">
            	                <?php
            	                    if($sqlcdpvw[0] >= 5){
            	                ?>
            	                    <option value="5">$5</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 10){
            	                ?>
            	                    <option value="10">$10</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 20){
            	                ?>
            	                    <option value="20">$20</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 30){
            	                ?>
            	                    <option value="30">$30</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 50){
            	                ?>
            	                    <option value="50">$50</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 80){
            	                ?>
            	                    <option value="80">$80</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 100){
            	                ?>
            	                    <option value="100">$100</option>
            	                <?php
            	                    }if($sqlcdpvw[0] >= 200){
            	                ?>
            	                    <option value="200">$200</option>
            	                <?php
            	                    }
            	                ?>
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
            				    <div id="info-d">
            				        <p>APUESTA: <h3 id="apuesta-d-i">$3</h3></p>
            				        <p>|</p>
            				        <p>GANAS: <h3 id="gana-d-i">$5</h3></p>
            				    </div>
            	                <button id="crear-desafio-p">Crear</button> 
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
        	            <script type="text/javascript">
        	                $('#crear-desafio-p').click(function(e) {
                        		e.preventDefault();
                                
                                document.getElementById('crear-desafio-p').disabled = true;
                                var juego = "<?php echo $juego;?>";
                                var categoria = "<?php echo $plataforma;?>";
                                var dp = "P/<?php echo $id_dp;?>";
                        		var monto = document.getElementById('monto-d').value;
                        		var tiempos = document.getElementById('tiempos-d').value;
                        		var plantilla = document.getElementById('plantilla-d').value;
                        		var encuentro = document.getElementById('encuentro-d').value;
                                var incognitot = "false";
                        
                        		var php = "juego="+juego+"&categoria="+categoria+"&monto="+monto+"&incognito="+incognitot+"&tiempos="+tiempos+"&plantilla="+plantilla+"&encuentro="+encuentro+"&dp="+dp;
                                
                    			$.ajax({
                    				url: '/bd/desafio_p.php?id_cuenta=<?php echo $id_cuenta;?>',
                    				type: 'POST',
                    				dataType: 'json',
                    				data: php,
                    			})
                    			.done(function(res) {
                    			    if (res == "balance") {
                    					document.getElementById("error4").style.display = "block";
                    				  	document.getElementById("error4").innerHTML = "No tienes suficiente balance para desafiar";
                    					setTimeout(() => {
                    						document.getElementById("error4").style.display = "none";
                    						document.getElementById('crear-desafio-p').disabled = false;
                    					}, 4000);
                    				}
                    				if (res == "subiendo") {
                    					document.getElementById("error4").style.display = "block";
                    				  	document.getElementById("error4").innerHTML = "Desafio creado con exito";
                    					setTimeout(() => {
                    						document.getElementById("error4").style.display = "none";
                    						window.location = "/bd/desafioh.php?id=<?php echo $id_dp;?>";
                    					}, 1000);
                    				}
                    			})
                    			.fail(function() {
                    			})
                    			.always(function() {
                    			});
                        	});
        	            </script>
        	        </div>
        	        <label for="btn-modal-1v1" class="cerrar-modal-1v1"></label>
        	    </div>
    <?php
            }
        }
        if(isset($_GET['desafio'])){
            if((!empty($_GET['desafio'])) && ($_GET['desafio'] !== null)){
    ?>
        <input type="checkbox" id="btn-modal-desafio">
		<div class="container-modal-desafio">
	        <div class="content-modal-desafio">
	        <?php
	            $sqlj2c = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_d2'");
	            $sqlj2cv = $sqlj2c->fetch_row();
	            $sqlj2cn = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqlj2cv[1]'");
	            $sqlj2cn2 = $sqlj2cn->fetch_row();
                if($sqlj2cv[10] == 1){
                    $nombredec = "Incognito";
                }else{
                    $nombredec = $sqlj2cn2[1];
                }
                if ($sqlj2cv[9] == '5') {
        			$montodec = "3";
        		}
        		if ($sqlj2cv[9] == '10') {
        			$montodec = "6";
        		}
        		if ($sqlj2cv[9] == '20') {
        			$montodec = "12";
        		}
        		if ($sqlj2cv[9] == '30') {
        			$montodec = "18";
        		}
        		if ($sqlj2cv[9] == '50') {
        			$montodec = "30";
        		}
        		if ($sqlj2cv[9] == '80') {
        			$montodec = "48";
        		}
        		if ($sqlj2cv[9] == '100') {
        			$montodec = "60";
        		}
        		if ($sqlj2cv[9] == '200') {
        			$montodec = "120";
        		}
	        ?>
	            <h1>¡Confirmar desafio!</h1>
	            <span id="error3"></span>
	            <form>
	                <label>Tu rival</label>
	                <input style="width: 90%;" type="text" value="<?php echo $nombredec; ?>" disabled>
	                <p><input style="margin-right: 1rem;" type="checkbox" id="confm-d"> Confirmar apuesta ($<?php echo $montodec; ?>)</p>
	                <button id="confirmar-desafio">Confirmar</button>
	            </form>
	        </div>
	        <label for="btn-modal-desafio" class="cerrar-modal-desafio"></label>
	        <script type="text/javascript">
	            $('#confirmar-desafio').click(function(e) {
            		e.preventDefault();
                    document.getElementById('confirmar-desafio').disabled = true;
            		var confm = document.getElementById('confm-d');
            		
            		if(confm.checked){
            		    var confm = "true";
            		}else{
            		    var confm = "false";
            		}
                    
            		if (confm == 'false') {
            			document.getElementById("error3").style.display = "block";
            		  	document.getElementById("error3").innerHTML = "*Debes confirmar el desafio";
            			setTimeout(() => {
            				document.getElementById("error3").style.display = "none";
            				document.getElementById('confirmar-desafio').disabled = false;
            			}, 4000);
            		}else{
            			$.ajax({
            				url: '/bd/desafio_c.php?id_enf=<?php echo $id_d2;?>',
            				type: 'POST',
            				dataType: 'json',
            			})
            			.done(function(res) {
            			    if (res == "balance") {
            					document.getElementById("error3").style.display = "block";
            				  	document.getElementById("error3").innerHTML = "No tienes suficiente balance unirte";
            					setTimeout(() => {
            						document.getElementById("error3").style.display = "none";
            						document.getElementById('confirmar-desafio').disabled = false;
            					}, 4000);
            				}
            				if (res == "subiendo") {
            					document.getElementById("error3").style.display = "block";
            				  	document.getElementById("error3").innerHTML = "Desafio confirmado";
            					setTimeout(() => {
            						document.getElementById("error3").style.display = "none";
            						document.getElementById('confirmar-desafio').disabled = true;
            						window.location = "/desafio/<?php echo $id_d2;?>";
            					}, 1000);
            				}
            			})
            			.fail(function() {
            			})
            			.always(function() {
            			});
            		}
            	});
	        </script>
	    </div>
    <?php
            }
        }
        if(isset($_GET['desafiop'])){
            if((!empty($_GET['desafiop'])) && ($_GET['desafiop'] !== null)){
    ?>
        <input type="checkbox" id="btn-modal-desafio">
		<div class="container-modal-desafio">
	        <div class="content-modal-desafio">
	        <?php
	            $sqlj2c = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_d2p'");
	            $sqlj2cv = $sqlj2c->fetch_row();
	            $ntsql = mysqli_query($conn, "SELECT id_notificacion,estado FROM notificaciones WHERE id_cuenta = '$sqlj2cv[1]' AND id_cuentar = '$id_cuenta' AND tipo = 'Desafio'");
	            $ntsqlv = $ntsql->fetch_row();
	            if($ntsqlv[1] == "0"){
	                $ntsql = mysqli_query($conn, "UPDATE notificaciones SET estado = '1' WHERE id_notificacion = '$ntsqlv[0]'");
	            }
	            $sqlj2cn = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqlj2cv[1]'");
	            $sqlj2cn2 = $sqlj2cn->fetch_row();
                $nombredec = $sqlj2cn2[1];
                if ($sqlj2cv[9] == '5') {
        			$montodec = "3";
        		}
        		if ($sqlj2cv[9] == '10') {
        			$montodec = "6";
        		}
        		if ($sqlj2cv[9] == '20') {
        			$montodec = "12";
        		}
        		if ($sqlj2cv[9] == '30') {
        			$montodec = "18";
        		}
        		if ($sqlj2cv[9] == '50') {
        			$montodec = "30";
        		}
        		if ($sqlj2cv[9] == '80') {
        			$montodec = "48";
        		}
        		if ($sqlj2cv[9] == '100') {
        			$montodec = "60";
        		}
        		if ($sqlj2cv[9] == '200') {
        			$montodec = "120";
        		}
	        ?>
	            <h1>¡Confirmar desafio!</h1>
	            <span id="error5"></span>
	            <form>
	                <label>Tu rival</label>
	                <input style="width: 90%;" type="text" value="<?php echo $nombredec; ?>" disabled>
	                <p><input style="margin-right: 1rem;" type="checkbox" id="confm-d2"> Confirmar apuesta ($<?php echo $montodec; ?>)</p>
	                <button id="confirmar-desafiop">Confirmar</button>
	                <a href="/bd/desafio_rd?d=<?php echo $id_d2p; ?>">Rechazar</a>
	            </form>
	        </div>
	        <label for="btn-modal-desafio" class="cerrar-modal-desafio"></label>
	        <script type="text/javascript">
	            $('#confirmar-desafiop').click(function(e) {
            		e.preventDefault();
                    document.getElementById('confirmar-desafiop').disabled = true;
            		var confm = document.getElementById('confm-d2');
            		
            		if(confm.checked){
            		    var confm = "true";
            		}else{
            		    var confm = "false";
            		}
                    
            		if (confm == 'false') {
            			document.getElementById("error5").style.display = "block";
            		  	document.getElementById("error5").innerHTML = "*Debes confirmar el desafio";
            			setTimeout(() => {
            				document.getElementById("error5").style.display = "none";
            				document.getElementById('confirmar-desafiop').disabled = false;
            			}, 4000);
            		}else{
            			$.ajax({
            				url: '/bd/desafio_c.php?id_enf=<?php echo $id_d2p;?>',
            				type: 'POST',
            				dataType: 'json',
            			})
            			.done(function(res) {
            			    if (res == "balance") {
            					document.getElementById("error5").style.display = "block";
            				  	document.getElementById("error5").innerHTML = "No tienes suficiente balance unirte";
            					setTimeout(() => {
            						document.getElementById("error3").style.display = "none";
            						document.getElementById('confirmar-desafiop').disabled = false;
            					}, 4000);
            				}
            				if (res == "subiendo") {
            					document.getElementById("error5").style.display = "block";
            				  	document.getElementById("error5").innerHTML = "Desafio confirmado";
            					setTimeout(() => {
            						document.getElementById("error5").style.display = "none";
            						document.getElementById('confirmar-desafiop').disabled = true;
            						window.location = "/desafio/<?php echo $id_d2p;?>";
            					}, 1000);
            				}
            			})
            			.fail(function() {
            			})
            			.always(function() {
            			});
            		}
            	});
	        </script>
	    </div>
    <?php
            }
        }
        if(isset($_GET['d-enf'])){
    ?>
        <input type="checkbox" id="btn-modal-desafioe">
		<div class="container-modal-desafioe">
	        <div class="content-modal-desafioe">
	            <div id="lista_t_p">
	            	<div id="pruebas">
	                <?php
	                    $sqlda = mysqli_query($conn, "SELECT auditado FROM desafio WHERE id_desafio = '$id_d'");
	            		$sqlda = $sqlda->fetch_row();
	                    $sqlenf = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE id_enfrentamiento = '$id_enfd'");
	            		$sqlenfv = $sqlenf->fetch_row();
	            		
	            		$sqlcu1 = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqlenfv[1]'");
	            		$sqlcuv1 = $sqlcu1->fetch_row();
	            		$sqlcu2 = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqlenfv[2]'");
	            		$sqlcuv2 = $sqlcu2->fetch_row();
	            		
	            		$sqlcu = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'");
	            		$sqlcuv = $sqlcu->fetch_row();
	                ?>
	                    <h1>Resultados</h1>
	            		<?php
	            		    $imgp = mysqli_query($conn, "SELECT * FROM pruebas WHERE id_torneo = '$id_d' AND id_enfrentamiento = '$id_enfd' AND id_cuenta = '$sqlenfv[1]'");
	            			$imgpv = $imgp->fetch_row();
	            			if (empty($imgpv)) {
	            		?>
	            		        <img title="<?php echo $sqlcuv1[1]; ?>" src="/img/pruebas/default.png">
	            		<?php
	            			}else{
	            		?>
	            		        <img title="<?php echo $sqlcuv1[1]; ?>" src="/<?php echo $imgpv[4]; ?>">
	            		<?php
	            			}
	            			$imgp2 = mysqli_query($conn, "SELECT * FROM pruebas WHERE id_torneo = '$id_d' AND id_enfrentamiento = '$id_enfd' AND id_cuenta = '$sqlenfv[2]'");
	            			$imgpv2 = $imgp2->fetch_row();
	            			if (empty($imgpv2)) {
	            		?>
	            		        <img title="<?php echo $sqlcuv2[1]; ?>" src="/img/pruebas/default.png">
	            		<?php
	            			}else{
	            		?>
	            		        <img title="<?php echo $sqlcuv2[1]; ?>" src="/<?php echo $imgpv2[4]; ?>">
	            		<?php
	            			}
	            		?>
	            		    <form action="/bd/subir_pd.php?id=<?php echo $id_d; ?>&enf=<?php echo $sqlenfv[0]; ?>&c=<?php echo $id_cuenta;?>" method="POST" enctype="multipart/form-data">
    	            	<?php
            				if (($sqlenfv[1] == $id_cuenta) || ($sqlenfv[2] == $id_cuenta)){
            				    if((!empty(!$imgpv)) && ($sqlenfv[1] == $id_cuenta)){
                        ?>
                            <label>Sube el resumen del partido (.PNG .JPG .JPEG)</label>
                			<input type="file" name="imagen2" id="imagen" style="float: left;" required>
                			<button id="subir_img">Cargar</button>
                        <?php
            				    }
            				    if((!empty(!$imgpv2)) && ($sqlenfv[2] == $id_cuenta)){
                        ?>
                            <label>Sube el resumen del partido (.PNG .JPG .JPEG)</label>
                			<input type="file" name="imagen2" id="imagen" style="float: left;" required>
                			<button id="subir_img">Cargar</button>
                        <?php
            				    }
            				}
    	            	?>
    	            		</form>
	            		<?php
	            			if (($sqlcuv[4] == 4) && ($sqlenfv[10] == 0) && ($sqlda[0] == $id_cuenta)) {
	            		?>
    	            		<form id="actualizar_p" action="/bd/act_desafio.php?id=<?php echo $id_d; ?>&enf=<?php echo $id_enfd; ?>" method="POST">
    	            			<p style="font-weight: 600;"><?php echo $sqlcuv1[1]; ?></p><input type="number" name="local" value="<?php echo $sqlenfv[3]; ?>">
    	            			<p>vs</p>
    	            			<input type="number" name="visitante" value="<?php echo $sqlenfv[4]; ?>"><p style="font-weight: 600;"><?php echo $sqlcuv2[1]; ?></p>
    	            			<button id="actualizar_pbtn">Actualizar</button>
    	            		</form>
	            		<?php
	            			}else{
	            			    if(($sqlcuv[4] == 4) && ($sqlenfv[10] == 1) && ($sqlda[0] == $id_cuenta)){
	            		?>
	            		    <form id="actualizar_p" action="/bd/act_desafioe.php?id=<?php echo $id_d; ?>&enf=<?php echo $id_enfd; ?>" method="POST">
    	            			<p style="font-weight: 600;"><?php echo $sqlcuv1[1]; ?></p><input type="number" name="local" value="<?php echo $sqlenfv[3]; ?>">
    	            			<p>vs</p>
    	            			<input type="number" name="visitante" value="<?php echo $sqlenfv[4]; ?>"><p style="font-weight: 600;"><?php echo $sqlcuv2[1]; ?></p>
    	            			<button>Editar</button>
    	            		</form>
	            		<?php
	            			    }else{
	            		?>
	            		    <h3 style="width: 100%; float: left; margin-top: 1rem;">Esperando a ser analizado</h3>
	            		<?php 
	            			    }
	            			}
	            		?>
	            	</div>
	            </div>
	            <script type="text/javascript">
    	            $('#actualizar_pbtn').click(function(){
            		    setInterval(function(){
            		        document.getElementById('actualizar_pbtn').disabled = true;
            			}, 10);
					});
    	        </script>
	        </div>
	        <label for="btn-modal-desafioe" class="cerrar-modal-desafioe"></label>
	    </div>
    <?php
        }
        
		if (isset($_GET['id'])) {
			if (!empty($_GET['id'])) {
				switch ($val[7]) {
					case 'Liga':
						$formato = "Sistema de Liga";
						break;
					case 'Liga E':
						$formato = "Sist. de Liga + Eliminacion D.";
						break;
					case 'Grupos E':
						$formato = "Grupos + Eliminacion D.";
						break;
					case 'Eliminacion D':
						$formato = "Eliminacion Directa";
						break;
					case 'Partidos C':
						$formato = "Partidos cruzados";
						break;
				}
				switch ($val[15]) {
					case 'Nada':
						$tipo = "Solo ida";
						break;
					case 'Ida':
						$tipo = "Solo ida";
						break;
					case 'Vuelta':
						$tipo = "Ida y vuelta";
						break;
				}
				switch ($val[6]) {
					case '0':
						$inscripcion = "Gratis";
						break;
					case '2':
						$inscripcion = "Privado";
						break;
				    case '1':
						$inscripcion = "De pago";
						break;
					case '3':
						$inscripcion = "Gratis + Premio";
						break;
					case '4':
						$inscripcion = "Privado + Premio";
						break;
				}
				
				$cuenta = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$val[2]'");
				$valc2 = $cuenta->fetch_row();

				$ins = mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$val[0];'");
				$i_resv = mysqli_num_rows($ins);
	?>
	    <span id="error_copy"></span>
		<div id="tutorial2">
		    <img src="/<?php echo $val[10]; ?>">
		    <p><?php echo $val[4]; ?></p>
		    <a style="cursor: pointer;" title="Compartir" id="compartir"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M13 14H11C7.54202 14 4.53953 15.9502 3.03239 18.8107C3.01093 18.5433 3 18.2729 3 18C3 12.4772 7.47715 8 13 8V3L23 11L13 19V14Z"></path></svg></a>
		    <a title="Ir al buscador" href="/juego/<?php echo $val[9]; ?>/<?php echo $val[11]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg></a>
		    <span>Creado el <?php echo $val[20]; ?></span>
		</div>
		<div id="info_t">
		    <div id="info_torg">
				<a href="/perfil/<?php echo $valc2[0]; ?>"><img src="/<?php echo $valc2[5]; ?>"><h3><?php echo $valc2[1]; ?></h3></a>
				<h2>| Organizador del torneo</h2>
		    </div>
		    <div id="info_tdesc">
		        <h2>Descripcion</h2>
		        <span><?php echo $val[5]; ?></span>
		    </div>
		    <div id="info_tequipo">
		        <h2>Inscriptos <?php echo $i_resv; ?>/<?php echo $val[8]; ?></h2>
			<?php
				$lista = "SELECT * FROM r_torneos WHERE id_torneo = '$id_torneo' ORDER BY id_rtorneos DESC";
				$res = $conn->query($lista);
				
                $pricep2 = explode("/", $val[17]);
                $pricep = number_format($pricep2[1], 2, '.', ',');
                
				while ($rows = mysqli_fetch_row($res)) {
					$user_l = "SELECT * FROM cuentas WHERE id_cuenta = '$rows[1]'";
					$res2 = $conn->query($user_l);
					$rows2 = $res2->fetch_row();
			?>
				<p><a href="/perfil/<?php echo $rows[1]; ?>"><?php echo $rows2[1]; ?></a></p>
			<?php
				}
			?>
			</div>
			<div id="info_tinfo">
			    <h2>Informacion general</h2>
			    <div class="info_tinfos">
			        <h3>Formato</h3><p><?php echo $formato; ?></p>
			        <h3>Tipo de partido</h3><p><?php echo $tipo; ?></p>
			    </div>
		        <div class="info_tinfos">
		            <h3>Juego</h3><p><?php if($val[9] == ""){ echo "No definido"; }else{ echo $val[9]; } ?></p>
		            <h3>Inscripción</h3><p><?php echo $inscripcion; ?></p>
		        </div>
		        <div class="info_tinfos">
		            <h3>Plataforma</h3><p><?php if($val[11] == ""){ echo "No definido"; }else{ echo $val[11]; } ?></p>
		            <h3>Prize pool</h3><p>$<?php echo $pricep; ?></p>
		        </div>
		        <div class="info_tinfos">
		            <h3>Cant. de ganadores</h3><p><?php echo $val[21]; ?></p>
		        </div>
		    </div>
		    <div id="info_tpremio">
		        <h2>Premios</h2>
		        <?php
		            
		            if($val[21] == 1){
		        ?>
		            <p><a>1° puesto | $<?php echo $pricep2[1]; ?></a></p>
		        <?php
		            }if($val[21] == 2){
		                $pmero = $pricep2[1] * 0.575;
		                $sgdo = $pricep2[1] * 0.425;
		        ?>
		            <p><a>1° puesto | $<?php echo $pmero; ?></a></p>
		            <p><a>2° puesto | $<?php echo $sgdo; ?></a></p>
		        <?php
		            }if($val[21] == 3){
		                $pmero = $pricep2[1] * 0.50;
		                $sgdo = $pricep2[1] * 0.30;
		                $tcro = $pricep2[1] * 0.20;
		        ?>
		            <p><a>1° puesto | $<?php echo $pmero; ?></a></p>
		            <p><a>2° puesto | $<?php echo $sgdo; ?></a></p>
		            <p><a>3° puesto | $<?php echo $tcro; ?></a></p>
		        <?php
		            }
		        ?>
			</div>
		    <div id="info_tbtn">
    <?php
            $idnvu = $_GET['u'];
            $sqlnv = mysqli_query($conn, "SELECT id_notificacion FROM notificaciones WHERE id_cuenta = '$idnvu' AND id_cuentar = '$id_cuenta' AND id = '$id_torneo'");
            $sqlnvv = $sqlnv->fetch_row();
            
            $sqlnv2 = mysqli_query($conn, "SELECT id_rtorneos FROM r_torneos WHERE id_cuenta = '$id_cuenta' AND id_torneo = '$id_torneo'");
            $sqlnvv2 = $sqlnv2->fetch_row();
            
                if((!empty($_GET['u'])) && ($sqlnvv[0] !== null) && (!$sqlnvv2)){
                    if($val[6] == 1){
?>
                        <div id="s_i_boton" class="pago"><a id="btn-pago-r">Valor de ingreso $<?php echo $pricep2[0]; ?></a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #72de77;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
                            $res2c = $conn->query($cuenta2);
                            $val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                        </div></label><?php } ?></div>
<?php
	                }else{
?>
                        <div id="s_i_boton" class="unirse"><a href="/bd/unirse_t?id=<?php echo $val[0]; ?>&c=<?php echo $id_cuenta ?>">Unirse al torneo</a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #595959;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
        					$res2c = $conn->query($cuenta2);
        					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                    		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
            		    </div></label><?php } ?></div>
<?php
	        }
                }else{
                    if(empty(($_SESSION['datos']))) {
    			?>
    			    <div id="s_i_boton" class="prop"><a href="/login">Iniciar sesion para unirse</a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #595959;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a></div>
    			<?php
    			    }else{
    			        if ($id_cuenta == $val[2]) {
    ?>
    				        <div id="s_i_boton" style="border-radius: .2rem;" class="prop"><a href="/fixture/<?php echo $val[0]; ?>">Gestionar torneo</a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
        					$res2c = $conn->query($cuenta2);
        					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                    		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                    		    </div></label><?php } ?></div>
    <?php
    				    }else{
        					$r_torneo = "SELECT * FROM r_torneos WHERE id_torneo = '$val[0]' AND id_cuenta = '$id_cuenta'";
        					$res2 = $conn->query($r_torneo);
        					$val2 = $res2->fetch_row();
    			
        					if (($i_resv >= $val[8]) && (!$val2)) {
    ?>
        					    <div id="s_i_boton" class="lleno"><a>Torneo lleno</a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #DE7672;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a>
    <?php                   
                                $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
            					$res2c = $conn->query($cuenta2);
            					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                    		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                    		    </div></label><?php } ?></div>
    <?php
        					}else{
        						if ($val2) {
    ?>
        						    <div id="s_i_boton" class="fixture"><a href="/fixture/<?php echo $val[0]; ?>">Ver fixture</a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
                					$res2c = $conn->query($cuenta2);
                					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                            		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                            		    </div></label><?php } ?></div>
    <?php
        						}else{
        						    if(($val[6] == 2) || ($val[6] == 4)){
    ?>
        			                    <div id="s_i_boton" class="unirse"><a style="cursor: pointer;">Torneo privado</a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
                    					$res2c = $conn->query($cuenta2);
                    					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                                		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                                		    </div></label><?php } ?></div>
    <?php
        						    }else{
        						        if($val[6] == 1){
    ?>
                                            <div id="s_i_boton" class="pago"><a id="btn-pago">Valor de ingreso $<?php echo $pricep2[0]; ?></a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #72de77;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
                    					    $res2c = $conn->query($cuenta2);
                    					    $val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                                		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                                		    </div></label><?php } ?></div>
    <?php
        						        }else{
    ?>
                                            <div id="s_i_boton" class="unirse"><a href="/bd/unirse_t?id=<?php echo $val[0]; ?>&c=<?php echo $id_cuenta ?>">Unirse al torneo</a><a href="/fixture/<?php echo $id_torneo; ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: .2rem; border-bottom-right-radius: .2rem; cursor: pointer; background: #595959;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 11.4872 7.07719 10.9925 7.22057 10.5268C7.61175 11.3954 8.48527 12 9.5 12C10.8807 12 12 10.8807 12 9.5C12 8.48527 11.3954 7.61175 10.5269 7.21995C10.9925 7.07719 11.4872 7 12 7Z"></path></svg></a><?php $cuenta2 = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta'";
                    					$res2c = $conn->query($cuenta2);
                    					$val2c = $res2c->fetch_row(); if(($val2c[4] == 4) || ($val[2] == $id_cuenta)){ ?><label for="btn-modal"><div id="settings_t">
                                		        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                                		    </div></label><?php } ?></div>
    <?php
        						        }
        						    }
        						}
        					}
    				    }
    			    }
                }
	?>
	            <span id="error2"></span>
		    </div>
		</div>
    <?php
    	}else{
    		header('Location: https://csport.es/buscador');
    	}
    }
		if (isset($_GET['t'])) {
			if (!empty($_GET['t'])) {
	?>
	    <header id="hbar">
			<ul>
				<?php
					if (empty(($_SESSION['datos']))) {
				?>
					<li><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a style="margin-right: 1rem;" href="/login">Iniciar sesion</a></li>
				<?php
					}else{
				?>
				    <li id="btn-desp" style="float: left; display: none;"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M16 18V20H5V18H16ZM21 11V13H3V11H21ZM19 4V6H8V4H19Z"></path></svg></a></li>
					<li style="margin-left: 2rem; float: left;"><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a href="/bd/cerrar" style="margin-right: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z"></path></svg></a></li>
					<li><a href="/perfil/<?php echo $_SESSION['datos']['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg></a></li>
					<li id="btn-chat"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M2 8.99374C2 5.68349 4.67654 3 8.00066 3H15.9993C19.3134 3 22 5.69478 22 8.99374V21H8.00066C4.68659 21 2 18.3052 2 15.0063V8.99374ZM20 19V8.99374C20 6.79539 18.2049 5 15.9993 5H8.00066C5.78458 5 4 6.78458 4 8.99374V15.0063C4 17.2046 5.79512 19 8.00066 19H20ZM14 11H16V13H14V11ZM8 11H10V13H8V11Z"></path></svg></a></li>
				<?php
        	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id_cuenta' AND estado = '0'");
        	        $notsql2v = mysqli_num_rows($notsql2);
        	    ?>
					<li id="btn-ntf"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M5 18H19V11.0314C19 7.14806 15.866 4 12 4C8.13401 4 5 7.14806 5 11.0314V18ZM12 2C16.9706 2 21 6.04348 21 11.0314V20H3V11.0314C3 6.04348 7.02944 2 12 2ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z"></path></svg></a><?php if($notsql2v > 0){ ?><p><?php echo $notsql2v; ?></p><?php } ?></li>
					<li id="wallet-cel"><span id="wallet">$<?php echo $s_wallet; ?> <label style="cursor: pointer;"><a href="/buscador?wallet">Saldo</a></label></span></li>
				<?php
					}
				?>
			</ul>
		</header>
		<header id="header-cel" style="height: 3rem;">
		    <span id="wallet2" style="margin-left: 1.5rem;">$<?php echo $s_wallet; ?> <label style="cursor: pointer;"><a href="/buscador?wallet">Saldo</a></label></span>
        </header>
		<div id="content-notificacion">
	    <?php
	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id_cuenta' AND estado = '0'");
	        $notsql2v = mysqli_num_rows($notsql2);
	    ?>
		    <h2>Notificaciones (<?php echo $notsql2v; ?>)</h2>
		    <div id="content-notificacion-scroll">
		    <?php
		        $notsql = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$id_cuenta' ORDER BY id_notificacion DESC");
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
	    <div id="content-chat">
	        <div id="contenido-msj">
                <div id="contenido-msj-b">
                    <ul>
                        <li id="msj-p" class="b-active"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M2 22C2 17.5817 5.58172 14 10 14C14.4183 14 18 17.5817 18 22H2ZM10 13C6.685 13 4 10.315 4 7C4 3.685 6.685 1 10 1C13.315 1 16 3.685 16 7C16 10.315 13.315 13 10 13ZM17.3628 15.2332C20.4482 16.0217 22.7679 18.7235 22.9836 22H20C20 19.3902 19.0002 17.0139 17.3628 15.2332ZM15.3401 12.9569C16.9728 11.4922 18 9.36607 18 7C18 5.58266 17.6314 4.25141 16.9849 3.09687C19.2753 3.55397 21 5.57465 21 8C21 10.7625 18.7625 13 16 13C15.7763 13 15.556 12.9853 15.3401 12.9569Z"></path></svg><h6>CHATS</h6></li>
                        <li id="msj-f"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM13.6695 15.9999H10.3295L8.95053 17.8969L9.5044 19.6031C10.2897 19.8607 11.1286 20 12 20C12.8714 20 13.7103 19.8607 14.4956 19.6031L15.0485 17.8969L13.6695 15.9999ZM5.29354 10.8719L4.00222 11.8095L4 12C4 13.7297 4.54894 15.3312 5.4821 16.6397L7.39254 16.6399L8.71453 14.8199L7.68654 11.6499L5.29354 10.8719ZM18.7055 10.8719L16.3125 11.6499L15.2845 14.8199L16.6065 16.6399L18.5179 16.6397C19.4511 15.3312 20 13.7297 20 12L19.997 11.809L18.7055 10.8719ZM14.2914 4.33299L12.9995 5.27293V7.78993L15.6935 9.74693L17.9325 9.01993L18.4867 7.3168C17.467 5.90685 15.9988 4.84254 14.2914 4.33299ZM9.70857 4.33299C8.00078 4.84265 6.53236 5.90735 5.51261 7.31778L6.06653 9.01993L8.30554 9.74693L10.9995 7.78993V5.27293L9.70857 4.33299Z"></path></svg><h6>FIFA</h6></li>
                        <li id="msj-g"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2ZM16.0043 12.8777C15.6589 12.3533 15.4097 11.9746 14.4622 12.1248C12.6717 12.409 12.4732 12.7224 12.3877 13.2375L12.3636 13.3943L12.3393 13.5597C12.2416 14.2428 12.2453 14.5012 12.5589 14.8308C13.8241 16.1582 14.582 17.115 14.8116 17.6746C14.9237 17.9484 15.2119 18.7751 15.0136 19.5927C16.2372 19.1066 17.3156 18.3332 18.1653 17.3559C18.2755 16.9821 18.3551 16.5166 18.3551 15.9518V15.8472C18.3551 14.9247 18.3551 14.504 17.7031 14.1314C17.428 13.9751 17.2227 13.881 17.0582 13.8064C16.691 13.6394 16.4479 13.5297 16.1198 13.0499C16.0807 12.9928 16.0425 12.9358 16.0043 12.8777ZM12 3.83333C9.68259 3.83333 7.59062 4.79858 6.1042 6.34896C6.28116 6.47186 6.43537 6.64453 6.54129 6.88256C6.74529 7.34029 6.74529 7.8112 6.74529 8.22764C6.74488 8.55621 6.74442 8.8672 6.84992 9.09302C6.99443 9.40134 7.6164 9.53227 8.16548 9.64736C8.36166 9.68867 8.56395 9.73083 8.74797 9.78176C9.25405 9.92233 9.64554 10.3765 9.95938 10.7412C10.0896 10.8931 10.2819 11.1163 10.3783 11.1717C10.4286 11.1356 10.59 10.9608 10.6699 10.6735C10.7307 10.4547 10.7134 10.2597 10.6239 10.1543C10.0648 9.49445 10.0952 8.2232 10.268 7.75495C10.5402 7.01606 11.3905 7.07058 12.012 7.11097C12.2438 7.12589 12.4626 7.14023 12.6257 7.11976C13.2482 7.04166 13.4396 6.09538 13.575 5.91C13.8671 5.50981 14.7607 4.9071 15.3158 4.53454C14.3025 4.08382 13.1805 3.83333 12 3.83333Z"></path></svg><h6>GLOB.</h6></li>
                    </ul>
                </div>
                <main id="cont-msj-p">
                    <div id="contenido-msj-scroll">
                    <?php
                        $msjd = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$id_cuenta' AND tipo = 'Msj') OR (id_enfrentamiento = '$id_cuenta' AND tipo = 'Msj') GROUP BY id_torneo ORDER BY id_chat DESC");
                        while($msjdv = mysqli_fetch_row($msjd)){
                            if($msjdv[1] != $id_cuenta){
                                if($msjdv[2] == $id_cuenta){
                                $id_co = $msjdv[3];
                                }else{
                                $id_co = $msjdv[2];
                            }
                            
                                $msjdc = mysqli_query($conn, "SELECT nombre,status,img FROM cuentas WHERE id_cuenta = '$id_co'");
                                $msjdcv = $msjdc->fetch_row();
                                $msju = mysqli_query($conn, "SELECT mensaje,id_cuenta FROM chat WHERE (id_cuenta = '$id_cuenta' AND id_enfrentamiento = '$msjdv[1]') OR (id_cuenta = '$msjdv[1]' AND id_enfrentamiento = '$id_cuenta') ORDER BY id_chat DESC");
                                $msjuv = $msju->fetch_row();
                                
                                $shoy = $msjdcv[1];
                                $fechaDes = new DateTime($shoy);
                                $fechaActual = new DateTime();
                                $diferencia = $fechaActual->diff($fechaDes);
                    ?>
                                <a href="/juego/<?php echo $juego;?>/<?php echo $plataforma; ?>&msj=<?php echo $id_co; ?>">
                                    <div class="cont-msj-chat"><?php if(($diferencia->d == 0) && ($diferencia->h <= 0) && ($diferencia->i <= 5)){ echo "<span style='background: #56aa57;'>ㅤ</span>"; }else{ echo "<span style='background: #aa5656;'>ㅤ</span>"; } ?>
                                        <img src="/<?php echo $msjdcv[2]; ?>">
                                        <label><?php echo $msjdcv[0]; ?></label>
                                    <?php
                                        if($msjuv[1] == $id_cuenta){
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
                <main id="cont-msj-f" style="display: none;">
                <div id="contenido-msj-scrollf"></div>
                <form>
                    <input type="text" id="mensajef" placeholder="Escribe aqui...">
                    <botton id="msj-fifa"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558ZM5 4.38249V10.9999H10V12.9999H5V19.6174L18.8499 11.9999L5 4.38249Z"></path></svg></botton>
                </form>
                <script type="text/javascript">
            		$(document).ready(function(){
            			$('#msj-fifa').click(function(e) {
							e.preventDefault();

							var mensaje = document.getElementById('mensajef').value;
							var php = "mensaje="+mensaje+"&tipo=Fifa";

							$.ajax({
								url: '/bd/mensajeB.php',
								type: 'POST',
								dataType: 'json',
								data: php,
							})
							.done(function(res) {
								if (res == "enviado") {
									document.getElementById('mensajef').value = "";

								}	
							})
							.fail(function() {
							})
							.always(function() {
							});
						});
						var input = document.getElementById("mensajef");
                        input.addEventListener("keypress", function(e) {
                          if (e.key === "Enter") {
                            e.preventDefault();
                            document.getElementById("msj-fifa").click();
                          }
                        });
            			setInterval(function(){
            				$.ajax({
								url: '/bd/mensajeTimeBF.php',
								type: 'POST',
								dataType: 'text',
								success:function(data){
									$("#contenido-msj-scrollf").html(data);
								}
							});
            			}, 1000);
            		});
            	</script>
            </main>
                <main id="cont-msj-g" style="display: none;">
                <div id="contenido-msj-scrollg"></div>
                <form>
                    <input type="text" id="mensajeg" placeholder="Escribe aqui...">
                    <botton id="msj-global"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558ZM5 4.38249V10.9999H10V12.9999H5V19.6174L18.8499 11.9999L5 4.38249Z"></path></svg></botton>
                </form>
                <script type="text/javascript">
            		$(document).ready(function(){
            			$('#msj-global').click(function(e) {
							e.preventDefault();

							var mensaje = document.getElementById('mensajeg').value;
							var php = "mensaje="+mensaje+"&tipo=Global";

							$.ajax({
								url: '/bd/mensajeB.php',
								type: 'POST',
								dataType: 'json',
								data: php,
							})
							.done(function(res) {
								if (res == "enviado") {
									document.getElementById('mensajeg').value = "";

								}	
							})
							.fail(function() {
							})
							.always(function() {
							});
						});
						var input = document.getElementById("mensajeg");
                        input.addEventListener("keypress", function(e) {
                          if (e.key === "Enter") {
                            e.preventDefault();
                            document.getElementById("msj-global").click();
                          }
                        });
            			setInterval(function(){
            				$.ajax({
								url: '/bd/mensajeTimeBG.php',
								type: 'POST',
								dataType: 'text',
								success:function(data){
									$("#contenido-msj-scrollg").html(data);
								}
							});
            			}, 1000);
            		});
            	</script>
            </main>
    		</div>
	    </div>
	    <script>
	        $('#btn-chat').click(function(e) {
                document.getElementById('content-chat').style.display = "block";
                document.getElementById('content-notificacion').style.display = "none";
                document.addEventListener('click', function(event) {
                    var chat = document.getElementById('content-chat');
                    var hbar = document.getElementById('hbar');
                    if (!chat.contains(event.target)) {
                        if (!hbar.contains(event.target)) {
                            chat.style.display = 'none';
                        }
                    }
                });
            });
	        $('#btn-ntf').click(function(e) {
                document.getElementById('content-notificacion').style.display = "block";
                document.getElementById('content-chat').style.display = "none";
                document.addEventListener('click', function(event) {
                    var notificacion = document.getElementById('content-notificacion');
                    var hbar = document.getElementById('hbar');
                    if (!notificacion.contains(event.target)) {
                        if (!hbar.contains(event.target)) {
                            notificacion.style.display = 'none';
                        }
                    }
                });
            });
        </script>
        
		<div id="tutorial"><p><?php echo $juego; ?> | <?php echo $plataforma; ?></p>
		<a title="Ir al buscador" href="/buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg></a>
		</div>
		<div id="barra-juego">
		    <ul>
		        <li id="jugadores-j"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg> Jugadores</li>
		        <li id="partidos-j"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M17.4563 3L20.9991 3.00335L21.001 6.52648L15.5341 11.992L18.3624 14.8207L19.7772 13.4071L21.1915 14.8213L18.7166 17.2962L21.545 20.1246L20.1308 21.5388L17.3024 18.7104L14.8275 21.1853L13.4133 19.7711L14.8269 18.3562L11.9981 15.528L9.1703 18.3558L10.5849 19.7711L9.17064 21.1853L6.69614 18.71L3.86734 21.5388L2.45312 20.1246L5.28192 17.2958L2.80668 14.8213L4.22089 13.4071L5.63477 14.8202L8.46212 11.992L3.00181 6.53118L2.99907 3L6.54506 3.00335L11.9981 8.457L17.4563 3ZM9.87612 13.406L7.04807 16.234L7.75607 16.941L10.5831 14.113L9.87612 13.406ZM19.0001 5.001H18.2831L13.4121 9.87L14.1191 10.577L19.0001 5.698V5.001ZM5.00007 5.001V5.701L16.2411 16.942L16.9482 16.2349L5.71507 5.002L5.00007 5.001Z"></path></svg> Partidos</li>
		        <li id="torneos-j" class="selected"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg> Torneos</li>
		        <li id="reglas-j"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M21 18H6C5.44772 18 5 18.4477 5 19C5 19.5523 5.44772 20 6 20H21V22H6C4.34315 22 3 20.6569 3 19V4C3 2.89543 3.89543 2 5 2H21V18ZM5 16.05C5.16156 16.0172 5.32877 16 5.5 16H19V4H5V16.05ZM16 9H8V7H16V9Z"></path></svg> Reglas</li>
		    </ul>
		</div>
	    <span id="informacion-u">
        <div id="info-u-btn">
            <svg id="info-usvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(0,0,0,1)"><path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 11H13V17H11V11ZM11 7H13V9H11V7Z"></path></svg>
	        <div id="informacion-u-content">
                <h3 style="margin-bottom: .25rem;">¿Queres aparecer online?</h3>
                <p>Completa el formulario con los juegos disponibles que tengas disponibles</p>
                <p style="margin-top: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="rgba(38,38,38,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg>Perfil/<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="rgba(38,38,38,1)"><path d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM12 3.311L4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311ZM12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12C16 14.2091 14.2091 16 12 16ZM12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z"></path></svg>Ajustes->Rellenar juegos disponibles</p>
            </div>
        </div>
        </span>
	    <div id="jugadores-j2" style="display: none;">
	        
<?php
	        $sqlcst = mysqli_query($conn, "SELECT id_cuenta,status,img,nombre,juegos FROM cuentas");
            while($sqlcstv = mysqli_fetch_row($sqlcst)){
                $slqdpc = mysqli_query($conn, "SELECT id_desafio FROM desafio WHERE id_cuenta = '$sqlcstv[0]' AND status = '0' AND dp = 'P/$id_cuenta'");
                $slqdpcv = mysqli_num_rows($slqdpc);
            
                $shoys = $sqlcstv[1];
                $fechaDess = new DateTime($shoys);
                $fechaActuals = new DateTime();
                $diferencias = $fechaActuals->diff($fechaDess);
                
            	if($sqlcstv[4]){
            	    $juegoS = $sqlcstv[4];
            	    $array = explode("/", $juegoS);
                    $conteo = count($array);
                    $contJ = 0; $arrayJ = array();
                    
                    while($contJ < $conteo){
                        if(array_push($arrayJ, $array[$contJ])){} $contJ = $contJ + 1;
                    }
                    
                    $existe = false;
                    foreach ($arrayJ as $valor) { if ($valor === $juego) { $existe = true; } }
            	}else{
                	$existe = false; 
            	}
                if(($diferencias->d == 0) && ($diferencias->h <= 0) && ($diferencias->i <= 5) && ($existe == true)){
?>
                    <article><span>ㅤ</span>
                        <a href="/perfil/<?php echo $sqlcstv[0]; ?>">
    		                <img src="/<?php echo $sqlcstv[2]; ?>">
    		                <p><?php echo $sqlcstv[3]; ?></p>
    		            </a>
        <?php
                        $star1 = "<li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' width='16' height='16' fill='rgba(48,64,96,1)'><path d='M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z'/></svg></li>";
                        $star2 = "<li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' width='16' height='16' fill='rgba(48,64,96,1)'><path d='M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z'/></svg></li>";
                        
                        $sqls = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE id_local = '$sqlcstv[0]' OR id_visitante = '$sqlcstv[0]'");
                        $gano = 0; $perdio = 0; $pctj = 0; $sumt = 0;
                        
                        while ($sqlsv = mysqli_fetch_row($sqls)){
                            if (($sqlsv[3] > $sqlsv[4]) && ($sqlsv[1] == $sqlcsv[0])){
                                $gano = $gano + 1;
                            }if (($sqlsv[3] < $sqlsv[4]) && ($sqlsv[1] == $sqlcsv[0])){
                                $perdio = $perdio + 1;
                            }if (($sqlsv[4] > $sqlsv[3]) && ($sqlsv[2] == $sqlcsv[0])){
                                $gano = $gano + 1;
                            }if (($sqlsv[4] < $sqlsv[3]) && ($sqlsv[2] == $sqlcsv[0])){
                                $perdio = $perdio + 1;
                            }
                        }
                        $sqls2 = mysqli_query($conn, "SELECT COUNT(id_enfrentamiento) FROM enfrentamientos WHERE id_local = '$sqlcstv[0]' OR id_visitante = '$sqlcstv[0]'");
                        $sqls2v = $sqls2->fetch_row();
                        
                        if($sqls2v[0] == "0"){
                            $pctj = 0;
                        }else{
                            $sumt = $sqls2v[0];
                            $pctj = $gano/$sumt*100;
                    
                            $hab1 = ($gano-$perdio)/$sumt;
                            $pctje = $hab1*100;
                            $pctjet = round($pctje);
                            if($pctjet < 0){
                                $pctjetc = 0;
                            }else{
                                $pctjetc = round($pctje);;
                            }
                        }
                        
                        if($pctjetc <= 20){
                            $habs = $star1.$star2.$star2.$star2.$star2;
                        }if(($pctjetc >= 21) && ($pctjetc <= 40)){
                            $habs = $star1.$star1.$star2.$star2.$star2;
                        }if(($pctjetc >= 41) && ($pctjetc <= 60)){
                            $habs = $star1.$star1.$star1.$star2.$star2;
                        }if(($pctjetc >= 61) && ($pctjetc <= 80)){
                            $habs = $star1.$star1.$star1.$star1.$star2;
                        }if(($pctjetc >= 81) && ($pctjetc <= 100)){
                            $habs = $star1.$star1.$star1.$star1.$star1;
                        }
        ?>
    		            <ul title="Nvl. de habilidad | <?php echo round($pctjetc); ?>%">
    		               <?php echo $habs; ?>
    		            </ul>
        <?php
                        $walletf = mysqli_query($conn, "SELECT saldo FROM wallet WHERE id_cuenta = '$sqlcstv[0]'");
                        $walletfv = $walletf->fetch_row();
                        $walletfvs = number_format($walletfv[0], 2, '.', ',');
                        
                        if(($walletfvs >= 3) && ($s_wallet >= 3)){
                            if($slqdpcv >= 1){
    		        ?>
    		            <a title="Esperando el desafio" id="btn-jd"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg></a>
    		        <?php
    		                }else{
    		        ?>
    		            <a href="/juego/<?php echo $juego;?>/<?php echo$plataforma;?>&ed=<?php echo $sqlcsv[0];?>" id="btn-jd" title="Desafiar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M7.04813 13.4061L10.5831 16.9421L9.1703 18.3558L10.5849 19.7711L9.17064 21.1853L6.69614 18.71L3.86734 21.5388L2.45312 20.1246L5.28192 17.2958L2.80668 14.8213L4.22089 13.4071L5.63477 14.8202L7.04813 13.4061ZM2.99907 3L6.54506 3.00335L18.3624 14.8207L19.7772 13.4071L21.1915 14.8213L18.7166 17.2962L21.545 20.1246L20.1308 21.5388L17.3024 18.7104L14.8275 21.1853L13.4133 19.7711L14.8269 18.3562L3.00181 6.53118L2.99907 3ZM17.4563 3.0001L20.9991 3.00335L21.001 6.52648L16.9481 10.5781L13.4121 7.0431L17.4563 3.0001Z"></path></svg></a>
    		        <?php
    		                }
                        }
                    if($sqlcstv[0] !== $id_cuenta){
        ?>
                        <a href="/juego/<?php echo $juego; ?>/<?php echo $plataforma; ?>&msj=<?php echo $sqlcsv[0]; ?>" id="btn-jm" title="Enviar mensaje" style="background: #568eaa !important;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></a>
        <?php
                    }
        ?>
    		       </article>
<?php
    	        }
            }
?>     
	    </div>
	    <div id="partidos-j2" style="display: none;">
	        <a href="/buscador?desafio" title="Crear un desafio" id="crear_d"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M17.4563 3L20.9991 3.00335L21.001 6.52648L15.5341 11.992L18.3624 14.8207L19.7772 13.4071L21.1915 14.8213L18.7166 17.2962L21.545 20.1246L20.1308 21.5388L17.3024 18.7104L14.8275 21.1853L13.4133 19.7711L14.8269 18.3562L11.9981 15.528L9.1703 18.3558L10.5849 19.7711L9.17064 21.1853L6.69614 18.71L3.86734 21.5388L2.45312 20.1246L5.28192 17.2958L2.80668 14.8213L4.22089 13.4071L5.63477 14.8202L8.46212 11.992L3.00181 6.53118L2.99907 3L6.54506 3.00335L11.9981 8.457L17.4563 3ZM9.87612 13.406L7.04807 16.234L7.75607 16.941L10.5831 14.113L9.87612 13.406ZM19.0001 5.001H18.2831L13.4121 9.87L14.1191 10.577L19.0001 5.698V5.001ZM5.00007 5.001V5.701L16.2411 16.942L16.9482 16.2349L5.71507 5.002L5.00007 5.001Z"></path></svg></a>
	        <?php
	            $juegoc = $juego."/".$plataforma;
	            $sqlj2 = mysqli_query($conn, "SELECT * FROM desafio WHERE juego = '$juegoc' AND status = '0' AND dp = '' ORDER BY id_desafio ASC");
	            $sqlj2d = mysqli_query($conn, "SELECT * FROM desafio WHERE juego = '$juegoc' AND status = '1' AND dp = '' ORDER BY id_desafio DESC");
	            
	            while ($rowsp = mysqli_fetch_row($sqlj2)) {
	                $juegode = explode("/", $rowsp[3]);
	                $sqlj2c = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$rowsp[1]'");
	                $sqlj2cv = $sqlj2c->fetch_row();
	                $sqlj2e = mysqli_query($conn, "SELECT * FROM juegos WHERE nombre = '$juegode[0]' AND tipo = '$juegode[1]'");
	                $sqlj2ve = $sqlj2e->fetch_row();
	                
	                if($rowsp[10] == 1){
	                    $nombrede = "Incognito";
	                    $imgde = "img/cuenta/incognito.png";
	                }else{
	                    $nombrede = $sqlj2cv[1];
	                    $imgde = $sqlj2cv[5];
	                }
	                if($rowspd[8] == 'Ida'){
	                    $tenc = "Solo Ida";
	                }else{
	                    $tenc = "Ida y Vuelta";
	                }
            		if ($rowsp[9] == '5') {
            			$montode = "3";
            		}
            		if ($rowsp[9] == '10') {
            			$montode = "6";
            		}
            		if ($rowsp[9] == '20') {
            			$montode = "12";
            		}
            		if ($rowsp[9] == '30') {
            			$montode = "18";
            		}
            		if ($rowsp[9] == '50') {
            			$montode = "30";
            		}
            		if ($rowsp[9] == '80') {
            			$montode = "48";
            		}
            		if ($rowsp[9] == '100') {
            			$montode = "60";
            		}
            		if ($rowsp[9] == '200') {
            			$montode = "120";
            		}
	        ?>
	            <article>
	                <span id="informacion-d">
                        <div id="info-d-btn">
                                <svg id="info-dsvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(0,0,0,1)"><path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 11H13V17H11V11ZM11 7H13V9H11V7Z"></path></svg>
                    	        <div id="informacion-d-content">
                                    <h3 style="margin-bottom: .25rem;">Informacion</h3>
                                    <ul style="list-style-type: none;">
                                        <li>Dur. de tiempos: <?php echo $rowsp[4]; ?>min</li>
                                        <li>Controles: <?php echo $rowsp[5]; ?></li>
                                        <li>Vel. de juego: <?php echo $rowsp[6]; ?></li>
                                        <li>Tipo de plantilla: <?php echo $rowsp[7]; ?></li>
                                        <li>Encuentro: <?php echo $tenc; ?></li>
                                    </ul>
                                </div>
                            </div>
                    </span>
                    <header>
                        <div>
                            <img src="/<?php echo $sqlj2ve[2]; ?>">
                        </div>
                        <p><?php echo $juegode[0]; ?> | <?php echo $juegode[1]; ?></p>
                        <span class="partidos-ganas">Ganas <h3>$<?php echo $rowsp[9]; ?></h3></span>
                        <span class="partidos-apostas">Apuesta <h3>$<?php echo $montode; ?></h3></span>
                    </header>
                <a href="/desafio/<?php echo $rowsp[0]; ?>"><footer>
                        <div class="partidos-jugador1">
                            <img src="/<?php echo $imgde; ?>">
                            <p>| <?php echo $nombrede; ?></p>
                        </div>
                        <div class="partidos-jugador2">
                        <?php
                            if($id_cuenta !== $rowsp[1]){
                        ?>
                            <a id="desafiar-rival" href="/juego/<?php echo $juegode[0]; ?>/<?php echo $juegode[1]; ?>&desafio=<?php echo $rowsp[0]; ?>">¡Desafiar!</a>
                        <?php
                            }else{
                        ?>
                            <p>Esperando rival</p>
                        <?php
                            }
                        ?>
                        </div>
                    </footer>
                </a></article>
                
	        <?php
	            }
	            while ($rowspd = mysqli_fetch_row($sqlj2d)) {
	                $juegoded = explode("/", $rowspd[3]);
	                $sqlj2cd = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$rowspd[1]'");
	                $sqlj2cvd = $sqlj2cd->fetch_row();
	                $sqlj2cd2 = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$rowspd[2]'");
	                $sqlj2cvd2 = $sqlj2cd2->fetch_row();
	                $sqlj2ed = mysqli_query($conn, "SELECT * FROM juegos WHERE nombre = '$juegoded[0]' AND tipo = '$juegoded[1]'");
	                $sqlj2ved = $sqlj2ed->fetch_row();
	                
	                if($rowspd[7] == 1){
	                    $nombreded = "Incognito";
	                    $imgded = "img/cuenta/incognito.png";
	                }else{
	                    $nombreded = $sqlj2cvd[1];
	                    $imgded = $sqlj2cvd[5];
	                }
	                if($rowspd[8] == 'Ida'){
	                    $tenc = "Solo Ida";
	                }else{
	                    $tenc = "Ida y Vuelta";
	                }
            		if ($rowspd[9] == '5') {
            			$montoded = "3";
            		}
            		if ($rowspd[9] == '10') {
            			$montoded = "6";
            		}
            		if ($rowspd[9] == '20') {
            			$montoded = "12";
            		}
            		if ($rowspd[9] == '30') {
            			$montoded = "18";
            		}
            		if ($rowspd[9] == '50') {
            			$montoded = "30";
            		}
            		if ($rowspd[9] == '80') {
            			$montoded = "48";
            		}
            		if ($rowspd[9] == '100') {
            			$montoded = "60";
            		}
            		if ($rowspd[9] == '200') {
            			$montoded = "120";
            		}
            		
            		if($rowspd[14] == $rowspd[1]){
            		    $glocal = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' fill='rgba(217,159,51,1)'><path d='M2.00488 19H22.0049V21H2.00488V19ZM2.00488 5L7.00488 8L12.0049 2L17.0049 8L22.0049 5V17H2.00488V5Z'></path></svg>";
            		}else{
            		    $glocal = "";
            		}
            		if($rowspd[14] == $rowspd[2]){
            		    $gvisitante = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' fill='rgba(217,159,51,1)'><path d='M2.00488 19H22.0049V21H2.00488V19ZM2.00488 5L7.00488 8L12.0049 2L17.0049 8L22.0049 5V17H2.00488V5Z'></path></svg>";
            		}else{
            		    $gvisitante = "";
            		}
	        ?>
	            <article>
	                <span id="informacion-d">
                        <div id="info-d-btn">
                                <svg id="info-dsvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(0,0,0,1)"><path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM11 11H13V17H11V11ZM11 7H13V9H11V7Z"></path></svg>
                    	        <div id="informacion-d-content">
                                    <h3 style="margin-bottom: .25rem;">Informacion</h3>
                                    <ul style="list-style-type: none;">
                                        <li>Dur. de tiempos: <?php echo $rowspd[4]; ?>min</li>
                                        <li>Controles: <?php echo $rowspd[5]; ?></li>
                                        <li>Vel. de juego: <?php echo $rowspd[6]; ?></li>
                                        <li>Tipo de plantilla: <?php echo $rowspd[7]; ?></li>
                                        <li>Encuentro: <?php echo $tenc; ?></li>
                                    </ul>
                                </div>
                            </div>
                    </span>
                    <header>
                        <div>
                            <img src="/<?php echo $sqlj2ved[2]; ?>">
                            
                        </div>
                        <p><?php echo $juegoded[0]; ?> | <?php echo $juegoded[1]; ?></p>
                        <span class="partidos-ganas">Ganas <h3>$<?php echo $rowspd[9]; ?></h3></span>
                        <span class="partidos-apostas">Apuesta <h3>$<?php echo $montoded; ?></h3></span>
                    </header>
                <a href="/desafio/<?php echo $rowspd[0]; ?>">
                    <footer>
                        <div class="partidos-jugador1">
                            <img src="/<?php echo $imgded; ?>">
                            <p>| <?php echo $nombreded; ?></p>
                            <?php echo $glocal; ?>
                        </div>
                        <div class="partidos-jugador2">
                            <?php echo $gvisitante; ?>
                            <p><?php echo $sqlj2cvd2[1]; ?> |</p>
                            <img src="/<?php echo $sqlj2cvd2[5]; ?>">
                            <span>- VS -</span>
                        </div>
                    </footer>
                </a></article>
	        <?php
	            }
	        ?>
	    </div>
        <div id="torneos-j2">
        <?php
    	    $cverif = mysqli_query($conn, "SELECT verificado FROM cuentas WHERE id_cuenta = '$id_cuenta'");
            $cverifv = $cverif->fetch_row();
            
    	    if ($cverifv[0] >= 2){
    	?>
            <a href="/buscador?torneo" title="Crear un torneo" id="crear_t"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(242,242,242,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg></a>
        <?php
    	    }
        ?>
        <?php
		    $torneos = mysqli_query($conn, "SELECT * FROM torneos WHERE juego = '$juego' AND plataforma = '$plataforma' AND comienzo <= '3' ORDER BY comienzo ASC,id_torneo DESC");
		    
			while ($rows = mysqli_fetch_row($torneos)) {
			    $ins =  mysqli_query($conn, "SELECT * FROM r_torneos WHERE id_torneo = '$rows[0]'");
			    $insv = mysqli_num_rows($ins);
			    $pricep2 = explode("/", $rows[17]);
			    $pricep = number_format($pricep2[1], 2, '.', ',');
		?>
	        <article><a href="/torneo/<?php echo $rows[0]; ?>">
	        <?php
	            if($rows[12] == 0){
	        ?>
	            <p class="t_status wait">En espera</p>
	        <?php
	            }if(($rows[12] == 1) || ($rows[12] == 2)){
	        ?>
	            <p class="t_status execution">En ejecucion</p>
	        <?php
	            }if($rows[12] == 3){
	        ?>
	            <p class="t_status rev">En revisión</p>
	        <?php
	            }if($rows[12] == 4){
	        ?>
	            <p class="t_status finished">Finalizado</p>
	        <?php
	            }
	        ?>
                <img src="/<?php echo $rows[10]; ?>">
                <h2 title="<?php echo $rows[4]; ?>"><?php echo $rows[4]; ?></h2>
                <p class="t_price">PRIZE POOL $<?php echo $pricep; ?></p>
                <span><?php echo $insv; ?>/<?php echo $rows[8]; ?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(0,0,0,1)"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg></span>
            </a></article>
		<?php
			}
		?>
        </div>
        <div id="reglas-j2" style="display: none;">
            <div>
                <h1>FC24, FC23 & FC25</h1>
                <h2>Reglas generales:</h2>
                Es responsabilidad de todos los jugadores de Csport leer y comprender completamente estas reglas y políticas antes de participar en cualquier torneo. Estas reglas se aplican a todos los partidos.
                No se permiten formaciones ni jugadores personalizados. Si personalizas a tus jugadores con el objetivo de obtener una ventaja competitiva, puedes perder el partido. Si personalizas las listas estándar en línea de cualquier forma, puedes recibir una decisión desfavorable. 
                Cualquier jugador que utilice jugadores o formaciones personalizadas para obtener una ventaja injusta será descalificado de cualquier ganancia del torneo y también podrá recibir una multa por un monto que no exceda los $100.
                No se permiten invitados en los partidos de ARENA. Si juegas con un invitado y no informas a tu oponente antes del juego, puede resultar en una decisión desfavorable. 
                Algunos juegos sufren retrasos, lo que no es ideal para la jugabilidad. A menos que se salga del juego inmediatamente o en un punto en el que consideremos que no hay ninguna ventaja para ninguna de las partes y se proporcione evidencia del supuesto retraso, el juego deberá continuar. El administrador decidirá qué se considera un retraso suficiente para cancelar la partida. Si se descubre que alguien sufre retrasos intencionales, se perderá automáticamente.
                La información o evidencia falsa para obtener una ventaja o engañar al personal de Csport conlleva una pérdida automática.
                <h2>Jugabilidad:</h2>
                
                Está prohibido perder el tiempo; la posesión del balón en la línea defensiva está limitada a 10 minutos de juego. Si el balón va a la mitad del campo del oponente, el tiempo se reinicia.
                Los partidos que terminen en empate se informarán como empate, evite jugar una revancha.
                Está prohibido defender el legado.
                <h2>Conectividad y problemas técnicos:</h2>
                
                Las quejas sobre retrasos, configuraciones o equipos prohibidos después de 45 minutos de juego no son válidas.
                Las desconexiones requieren que el tiempo restante se juegue con el puntaje previo a la desconexión.
                La evidencia en video es obligatoria para disputas relacionadas con desconexiones y violaciones de reglas.
                <h2>Protocolo del partido:</h2>
                
                Los equipos en línea son obligatorios; no se permiten jugadores editados ni equipos personalizados.
                Los jugadores deben estar listos dentro de los 20 minutos posteriores al inicio del partido en un partido libre; en caso de no estar listos, perderán el partido.
                Se debe utilizar el "Chat en vivo" para cualquier discrepancia durante el juego.
                Se debe contactar a los administradores inmediatamente si un oponente infringe una regla.
                Las configuraciones incorrectas, si no se informan antes de la primera mitad, darán como resultado el puntaje actual.
                Las violaciones de las reglas determinadas por los administradores pueden resultar en una victoria de 3-0 para el oponente.
                <h2>Configuración del partido (FIFA23 y FC24):</h2>
                
                Modo: Amistosos en línea - Cara a cara 1 contra 1 (no FUT)
                Duración media: 3, 4, 5 y 6 minutos
                Controles: Cualquiera
                Velocidad: Normal
                Tipo de equipo: En línea
                En caso de empate: No hay revancha
                Disputas y pruebas sobre partidos:
                
                Todos los medios de comunicación del partido proporcionados como prueba deben nombrar claramente la identificación de los jugadores, los equipos y el resultado del juego.
                <h2>Política de no presentación:</h2>
                
                Se proporciona un período de gracia de 20 minutos después de la hora de inicio programada del partido para presentarse a un partido gratuito y 60 minutos para presentarse a un partido en efectivo.
                En caso de no presentarse se producirá una pérdida por incumplimiento.
                <h2>Verificación automática</h2>
                
                Desde el momento en que el primer jugador informa los resultados del partido, el otro jugador tiene 10 minutos para verificar o impugnar el informe del partido. Si los resultados no están verificados ni impugnados, el sistema verificará automáticamente el primer resultado informado después de 10 minutos. En los partidos de dinero, el tiempo para verificar o impugnar el resultado es de 60 minutos.
                <h2>Presentación de resultados:</h2>
                
                Los resultados deben enviarse al final del partido utilizando el botón "Reclamar victoria" en la página del partido o por correo electrónico.
                <h2>Regla del medio tiempo:</h2>
                
                Los jugadores deben informar de las trampas, las configuraciones incorrectas o los problemas graves de retraso antes del inicio de la segunda mitad. Una vez que comience la segunda mitad, el puntaje se mantendrá incluso si se juega con configuraciones incorrectas.
                <h2>Verificación automática</h2>
                
                Desde el momento en que el primer jugador informa los resultados del partido, el otro jugador tiene 10 minutos para verificar o impugnar el informe del partido. Si los resultados no están verificados ni impugnados, el sistema verificará automáticamente el primer resultado informado después de 10 minutos. En los partidos de dinero, el tiempo para verificar o impugnar el resultado es de 60 minutos.
                Borrador de campeones
                
                En una partida de Draft de Campeones, ambos jugadores deben seleccionar los equipos que se muestran en el lobby de la partida. Jugar con un equipo diferente al que se muestra en la página de la partida puede resultar en una decisión desfavorable.
                 Disputas
                
                Cualquier regla que se alegue que se ha infringido y que pueda verse al inicio del juego, por ejemplo, cantidad de tiempo por mitad o período, nivel de habilidad, listas, equipos, color de la camiseta, clima, título del juego o mapa, puede considerarse inválida en función de la cantidad de tiempo jugado y/o el puntaje. 
                Cualquier regla incumplida que se reclame en función de configuraciones o funciones que se puedan ver antes del partido en un partido jugado en más del 50 % será automáticamente inválida, independientemente del puntaje. Si espera hasta que su oponente tenga una ventaja para salir y hacer una reclamación con respecto a una configuración previa al partido, su reclamación se considerará inválida. Si no está de acuerdo con una configuración previa al partido o con el equipo que se está utilizando, no comience el juego. 
                Si abandona intencionalmente un partido mientras está perdiendo o el juego está empatado y no proporciona evidencia válida que le dé motivos para abandonar el partido, se le concederá el tiempo restante. 
                Reclamar una victoria durante el juego y que el resultado aún esté en juego puede resultar en una decisión desfavorable. Si el juego se desarrolla hasta un punto en el que consideramos que está ganado, se aplicará el puntaje. Si su oponente reclama una victoria durante el juego y usted continúa jugando después de ese punto, su reclamo se considerará automáticamente inválido.
                Proporcionar información inexacta a su oponente en un intento de engañarlo o de obtener una ventaja competitiva que de otro modo no habría tenido dará como resultado una decisión desfavorable. 
                Proporcionar información y/o evidencia inexacta con el fin de engañar al personal de Csport en una revisión resultará en una pérdida automática.  
                <h2>Reglas de hospedaje</h2>
                
                Csport decidirá el anfitrión según nuestro algoritmo interno y se mostrará una etiqueta verde en el lobby del partido para indicar qué jugador será el anfitrión del juego.
                Csport se reserva el derecho de realizar cambios a estas reglas en cualquier momento.
                <h2></h2>
            </div>
        </div>
	<?php
			}else{
				header('Location: https://csport.es/buscador');
			}
		}
		if (isset($_GET['d'])) {
		    if (!empty($_GET['d'])) {
		        $sqld = mysqli_query($conn, "SELECT * FROM desafio WHERE id_desafio = '$id_d'");
		        $sqldv = $sqld->fetch_row();
		        $tipo_d = explode("/", $sqldv[3]);
		        if ($sqldv[9] == '5') {
        			$montoded = "3";
        		}
        		if ($sqldv[9] == '10') {
        			$montoded = "6";
        		}
        		if ($sqldv[9] == '20') {
        			$montoded = "12";
        		}
        		if ($sqldv[9] == '30') {
        			$montoded = "18";
        		}
        		if ($sqldv[9] == '50') {
        			$montoded = "30";
        		}
        		if ($sqldv[9] == '80') {
        			$montoded = "48";
        		}
        		if ($sqldv[9] == '100') {
        			$montoded = "60";
        		}
        		if ($sqldv[9] == '200') {
        			$montoded = "120";
        		}
        		
        		$sqldc = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqldv[1]'");
		        $sqldcv = $sqldc->fetch_row();
		        $sqldc2 = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqldv[2]'");
		        $sqldcv2 = $sqldc2->fetch_row();
		        
		        if($sqldv[8] == "Vuelta"){
		            $encuentrod = "Ida y vuelta";
		        }else{
		            $encuentrod = "Solo ida";
		        }
		        $sqlenf = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$sqldv[0]' AND torneo = 'Ida' AND tipo = 'Desafio'");
		        $sqlenfv = $sqlenf->fetch_row();
		        $sqlenf2 = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$sqldv[0]' AND torneo = 'Vuelta' AND tipo = 'Desafio'");
		        $sqlenfv2 = $sqlenf2->fetch_row();
		        
		        if($sqldv[12] == 0){
		            $imgdel = "img/equipos/default.png";
		        }else{
		            $sqled = mysqli_query($conn, "SELECT * FROM equipos WHERE id_equipo = '$sqldv[12]'");
		            $sqledv = $sqled->fetch_row();
		            $imgdel = $sqledv[2];
		        }if($sqldv[13] == 0){
		            $imgded = "img/equipos/default.png";
		        }else{
		            $sqled2 = mysqli_query($conn, "SELECT * FROM equipos WHERE id_equipo = '$sqldv[13]'");
		            $sqledv2 = $sqled2->fetch_row();
		            $imgded = $sqledv2[2];
		        }
	?>
            <div id="desafio"><span id="error"></span>
                <div id="desafio-scroll">
                    <div id="header-d">
                        <img id="desafio-img" src="/img/index.jpeg">
                        <a href="/buscador" title="Volver" id="desafio-back"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(38,38,38,1)"><path d="M8 7V11L2 6L8 1V5H13C17.4183 5 21 8.58172 21 13C21 17.4183 17.4183 21 13 21H4V19H13C16.3137 19 19 16.3137 19 13C19 9.68629 16.3137 7 13 7H8Z"></path></svg></a>
                    </div>
                    <main>
                        <h2>Configuracion del partido</h2>
                        <ul>
                            <li>Dur. de tiempos: <?php echo $sqldv[4]; ?>min</li>
                            <li>Controles: <?php echo $sqldv[5]; ?></li>
                            <li>Vel. de juego: <?php echo $sqldv[6]; ?></li>
                            <li>Tipo de plantilla: <?php echo $sqldv[7]; ?></li>
                            <li>Encuentro: <?php echo $encuentrod; ?></li>
                        </ul>
                    </main>
                    <content>
                    <?php
                        if($tipo_d[0] == "P"){
                            $sqlcd = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$tipo_d[1]'");
                            $sqlcdv = $sqlcd->fetch_row();
                    ?>
                        <h2>Desafio <?php echo "contra ".$sqlcdv[0]; ?></h2>
                    <?php
                        }else{
                    ?>
                        <h2>Desafio | <?php echo $tipo_d[0]." ".$tipo_d[1]; ?></h2>
                    <?php
                        }
                    ?>
                        <h5>Apuesta de $<?php echo $montoded; ?> | Ganador se lleva $<?php echo $sqldv[9]; ?></h5>
                    </content>
            <?php
                $sqloro = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$sqldv[0]' AND torneo = 'Oro' AND tipo = 'Desafio'");
		        $sqlorov = $sqloro->fetch_row();
		        
		        $sqloroc = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqlorov[1]'");
		        $sqlorovc = $sqloroc->fetch_row();
		        $sqloroc2 = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqlorov[2]'");
		        $sqlorovc2 = $sqloroc2->fetch_row();
		        
		        $sqloroic = mysqli_query($conn, "SELECT equipo_l FROM desafio WHERE id_desafio = '$id_d' AND id_cuenta = '$sqlorov[1]'");
		        $sqlorovic = $sqloroic->fetch_row();
		        $sqloroci2 = mysqli_query($conn, "SELECT equipo_v FROM desafio WHERE id_desafio = '$id_d' AND id_visitante = '$sqlorov[2]'");
		        $sqlorovci2 = $sqloroci2->fetch_row();
		        
		        $sqloroice = mysqli_query($conn, "SELECT img FROM equipos WHERE id_equipo = '$sqlorovic[0]'");
		        $sqlorovice = $sqloroice->fetch_row();
		        $sqloroci2e = mysqli_query($conn, "SELECT img FROM equipos WHERE id_equipo = '$sqlorovci2[0]'");
		        $sqlorovci2e = $sqloroci2e->fetch_row();
		            
                if($sqlorov){
            ?>
                    <header id="enf-oro">
                        <h2 id="enftitulo">Resultado del partido (3er)</h2>
                        <a href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlorov[0]; ?>"><img src="/<?php echo $sqlorovice[0];?>"><span><?php echo $sqlorovc[0]; ?></span><p><?php echo $sqlorov[3]; ?> - <?php echo $sqlorov[4]; ?></p><span><?php echo $sqlorovc2[0]; ?></span><img src="/<?php echo $sqlorovci2e[0];?>"></a>
                    </header>
            <?php
                }else{
            ?>
                    <header id="enf-ida">
                        <h2 id="enftitulo">Resultado del partido (Ida)
                    <?php
                        if($sqldv[8] == "Vuelta"){
                    ?>
                            <span id="enfvuelva">Sig. partido</span>
                    <?php
                        }
                    ?>
                        </h2>
                <?php
                    if(($sqldv[1] == $id_cuenta) || ($sqldv[2] == $id_cuenta) || ($cveryv[0] == 4)){
                        if($sqldv[11] == 1){
                            if($sqldv[8] == "Vuelta"){
                ?>
                                <a id="enfi" href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlenfv[0]; ?>&ida"><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                                <a id="enfv" style="display: none;" href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlenfv2[0]; ?>&vuelta"><img src="/<?php echo $imgded;?>"><span><?php echo $sqldcv2[0]; ?></span><p><?php echo $sqlenfv2[3]; ?> - <?php echo $sqlenfv2[4]; ?></p><span><?php echo $sqldcv[0]; ?></span><img src="/<?php echo $imgdel;?>"></a>
                <?php
                            }else{
                ?>
                                <a href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlenfv[0]; ?>"><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                            }
                        }else{
                ?>
                            <a><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                        }
                    }else{
                ?>
                        <a><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                    }
                ?>
                    </header>
                    <header id="enf-vuelta" style="display: none;">
                        <h2 id="enftitulo">Resultado del partido (Vuelta)
                    <?php
                        if($sqldv[8] == "Vuelta"){
                    ?>
                            <span id="enfida">Ant. partido</span>
                    <?php
                        }
                    ?>
                        </h2>
                <?php
                    if(($sqldv[1] == $id_cuenta) || ($sqldv[2] == $id_cuenta) || ($cveryv[0] == 4)){
                        if($sqldv[11] == 1){
                            if($sqldv[8] == "Vuelta"){
                ?>
                                <a href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlenfv2[0]; ?>&vuelta"><img src="/<?php echo $imgded;?>"><span><?php echo $sqldcv2[0]; ?></span><p><?php echo $sqlenfv2[3]; ?> - <?php echo $sqlenfv2[4]; ?></p><span><?php echo $sqldcv[0]; ?></span><img src="/<?php echo $imgdel;?>"></a>
                <?php
                            }else{
                ?>
                                <a href="/desafio/<?php echo $id_d; ?>&d-enf=<?php echo $sqlenfv[0]; ?>"><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                            }
                        }else{
                ?>
                            <a><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                        }
                    }else{
                ?>
                        <a><img src="/<?php echo $imgdel;?>"><span><?php echo $sqldcv[0]; ?></span><p><?php echo $sqlenfv[3]; ?> - <?php echo $sqlenfv[4]; ?></p><span><?php echo $sqldcv2[0]; ?></span><img src="/<?php echo $imgded;?>"></a>
                <?php
                    }
                ?>
                    </header>
                    <script type="text/javascript">
                        $('#enfvuelva').click(function(e) {
                            document.getElementById('enf-ida').style.display = "none";
                            document.getElementById('enf-vuelta').style.display = "block";
                            
                        });
                        $('#enfida').click(function(e) {
                            document.getElementById('enf-ida').style.display = "block";
                            document.getElementById('enf-vuelta').style.display = "none";
                        });
                    </script>
            <?php
                }
                    if($sqldv[14] != 0){
            ?>
                    <div id="desafio-ganador">
                        <?php
                            $sqlgd = mysqli_query($conn, "SELECT nombre,id_cuenta FROM cuentas WHERE id_cuenta = '$sqldv[14]'");
                            $sqlgdv = $sqlgd->fetch_row();
                        ?>
                        <h2>Ganador | <a href="/perfil/<?php echo $sqlgdv[1]; ?>" style="text-decoration: none; color: #262626;"><?php echo $sqlgdv[0]; ?></a></h2>
                    </div>
                <?php
                    }
                    if(($sqldv[1] == $id_cuenta) || ($sqldv[2] == $id_cuenta) || ($cveryv[0] == 4)){
                        if($sqldv[11] == 1){
                ?>
                    <barside>
                        <h2>Chat</h2>
                        <div id="desafio-chat">
                            <div id="desafio-chat-scroll">
                            </div>
                        </div>
                        <form>
                            <input id="msj"type="text" placeholder="Escribe aqui...">
                            <button id="btn-msj"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
                        </form>
                        <script type="text/javascript">
    	            		$(document).ready(function(){
    	            			$('#btn-msj').click(function(e) {
    								e.preventDefault();
    
    								var mensaje = document.getElementById('msj').value;
    								var php = "mensaje="+mensaje;
    
    								$.ajax({
    									url: '/bd/mensaje.php?id_torneo=<?php echo $id_d; ?>&id_cuenta=<?php echo $id_cuenta; ?>&enf=0',
    									type: 'POST',
    									dataType: 'json',
    									data: php,
    								})
    								.done(function(res) {
    									if (res == "enviado") {
    										document.getElementById('msj').value = "";
    									}	
    								})
    								.fail(function() {
    								})
    								.always(function() {
    								});
    							});
    	            			setInterval(function(){
    	            				$.ajax({
    									url: '/bd/mensajeTimeD.php?id_torneo=<?php echo $id_d; ?>&id_cuenta=<?php echo $id_cuenta; ?>',
    									type: 'POST',
    									dataType: 'text',
    									success:function(data){
    										$("#desafio-chat-scroll").html(data);
    									}
    								});
    	            			}, 700);
    	            		});
    	            	</script>
                    </barside>
                    <footer>
                    <?php
                        if(($sqldv[1] == $id_cuenta) || ($sqldv[2] == $id_cuenta)){
                            $equipode = mysqli_query($conn, "SELECT * FROM equipos ORDER BY nombre ASC");
                            if(($sqldv[1] == $id_cuenta) && ($sqldv[12] == 0)){
                    ?>
                        <h2>Seleccionar equipo</h2>
                        <ul>
                        <form>
                            <label>Elije un equipo</label>
                            <select id="equipos-de">
                                <option value="">Seleccionar equipo</option>
                            <?php
                                while($equipodev = mysqli_fetch_row($equipode)){
                            ?>
                                <option value="<?php echo $equipodev[0]; ?>"><?php echo $equipodev[3]; ?></option>
                            <?php
                                }
                            ?>
                            </select><br>
                            <button id="cargar-ed">Cargar</button>
                        </form>
                        </ul>
                    <?php
                            }
                            if(($sqldv[2] == $id_cuenta) && ($sqldv[13] == 0)){
                    ?>
                        <h2>Seleccionar equipo</h2>
                        <ul>
                        <form>
                            <label>Elije un equipo</label>
                            <select id="equipos-de">
                                <option value="">Seleccionar equipo</option>
                            <?php
                                while($equipodev = mysqli_fetch_row($equipode)){
                            ?>
                                <option value="<?php echo $equipodev[0]; ?>"><?php echo $equipodev[3]; ?></option>
                            <?php
                                }
                            ?>
                            </select><br>
                            <button id="cargar-ed">Cargar</button>
                        </form>
                        </ul>
                    <?php
                            }
                        }
                    ?>
                        <h2 style="margin-top: 1rem;">Reglas</h2>
                        <ul>
                            <li>*Si el encuentro es Ida y Vuelta (Quiere decir que local como visitante envian invitacion)</li>
                            <li>*Si te desconectas, pierdes</li>
                            <li>*En caso de empate, se hace gol de oro</li>
                            <li>*Equipos EUROPEAN XI y Soccer AID no permitidos</li>
                        </ul>
                    </footer>
                <?php
                        }
                    }
                ?>
                </div>
            </div>
            <script type="text/javascript">
                $('#cargar-ed').click(function(e) {
            		e.preventDefault();
                    document.getElementById('cargar-ed').disabled = true;
            		var equipo = document.getElementById('equipos-de').value;
            		var php = "equipo="+equipo;
                    
            		if (equipo == '') {
            			document.getElementById("error").style.display = "block";
            		  	document.getElementById("error").innerHTML = "*Debes elegir un equipo";
            			setTimeout(() => {
            				document.getElementById("error").style.display = "none";
            				document.getElementById('cargar-ed').disabled = false;
            			}, 4000);
            		}else{
            			$.ajax({
            				url: '/bd/desafio_e.php?id=<?php echo $id_d; ?>&id_cuenta=<?php echo $id_cuenta; ?>',
            				type: 'POST',
            				dataType: 'json',
            				data: php,
            			})
            			.done(function(res) {
            				if (res == "subiendo") {
            				    document.getElementById("error").style.display = "block";
            		  	        document.getElementById("error").innerHTML = "Equipo actualizado";
            					setTimeout(() => {
            						document.getElementById("error").style.display = "none";
            						window.location = "/desafio/"+<?php echo $id_d; ?>;
            					}, 1000);
            				}
            			})
            			.fail(function() {
            			})
            			.always(function() {
            			});
            		}
            	});
            </script>
	<?php
		    }else{
				header('Location: https://csport.es/buscador');
			}
		}
	?>
	</div>
</body>
</html>
<script type="text/javascript">
    $('.cerrar-modal-msj').click(function(e) {
        window.location = "/juego/<?php echo $juego;?>/<?php echo $plataforma;?>";
    });
    $('#msj-p').click(function(e) {
        document.getElementById('cont-msj-p').style.display = "block";
        document.getElementById('cont-msj-f').style.display = "none";
        document.getElementById('cont-msj-g').style.display = "none";
        document.getElementById('msj-p').classList.add('b-active');
        document.getElementById('msj-f').classList.remove('b-active');
        document.getElementById('msj-g').classList.remove('b-active');
    });
    $('#msj-f').click(function(e) {
        document.getElementById('cont-msj-p').style.display = "none";
        document.getElementById('cont-msj-f').style.display = "block";
        document.getElementById('cont-msj-g').style.display = "none";
        document.getElementById('msj-p').classList.remove('b-active');
        document.getElementById('msj-f').classList.add('b-active');
        document.getElementById('msj-g').classList.remove('b-active');
    });
    $('#msj-g').click(function(e) {
        document.getElementById('cont-msj-p').style.display = "none";
        document.getElementById('cont-msj-f').style.display = "none";
        document.getElementById('cont-msj-g').style.display = "block";
        document.getElementById('msj-p').classList.remove('b-active');
        document.getElementById('msj-f').classList.remove('b-active');
        document.getElementById('msj-g').classList.add('b-active');
    });
    <?php
        if (isset($_GET['ed'])) {
    ?>
            $(window).load(function(){
                document.getElementById('reglas-j2').style.display = "none";
                document.getElementById('partidos-j2').style.display = "none";
                document.getElementById('torneos-j2').style.display = "none";
                document.getElementById('jugadores-j2').style.display = "grid";
                document.getElementById('torneos-j').classList.remove('selected');
                document.getElementById('reglas-j').classList.remove('selected');
                document.getElementById('partidos-j').classList.remove('selected');
                document.getElementById('jugadores-j').classList.add('selected');
            });
    <?php
        }
        if (isset($_GET['desafio'])) {
    ?>
            $(window).load(function(){
                document.getElementById('reglas-j2').style.display = "none";
                document.getElementById('partidos-j2').style.display = "grid";
                document.getElementById('torneos-j2').style.display = "none";
                document.getElementById('jugadores-j2').style.display = "none";
                document.getElementById('torneos-j').classList.remove('selected');
                document.getElementById('reglas-j').classList.remove('selected');
                document.getElementById('partidos-j').classList.add('selected');
                document.getElementById('jugadores-j').classList.remove('selected');
            });
    <?php
        }
        if (isset($_GET['ida'])) {
    ?>
            $(window).load(function(){
                document.getElementById('enf-ida').style.display = "block";
                document.getElementById('enf-vuelta').style.display = "none";
            });
    <?php
        }
        if (isset($_GET['vuelta'])) {
    ?>
            $(window).load(function(){
                document.getElementById('enf-ida').style.display = "none";
                document.getElementById('enf-vuelta').style.display = "block";
            });
    <?php
        }
    ?>
    $('#torneos-j').click(function(e) {
        document.getElementById('reglas-j2').style.display = "none";
        document.getElementById('partidos-j2').style.display = "none";
        document.getElementById('torneos-j2').style.display = "grid";
        document.getElementById('jugadores-j2').style.display = "none";
        document.getElementById('torneos-j').classList.add('selected');
        document.getElementById('reglas-j').classList.remove('selected');
        document.getElementById('partidos-j').classList.remove('selected');
        document.getElementById('jugadores-j').classList.remove('selected');
    });
    $('#reglas-j').click(function(e) {
        document.getElementById('reglas-j2').style.display = "block";
        document.getElementById('partidos-j2').style.display = "none";
        document.getElementById('torneos-j2').style.display = "none";
        document.getElementById('jugadores-j2').style.display = "none";
        document.getElementById('torneos-j').classList.remove('selected');
        document.getElementById('reglas-j').classList.add('selected');
        document.getElementById('partidos-j').classList.remove('selected');
        document.getElementById('jugadores-j').classList.remove('selected');
    });
    $('#jugadores-j').click(function(e) {
        document.getElementById('reglas-j2').style.display = "none";
        document.getElementById('partidos-j2').style.display = "none";
        document.getElementById('torneos-j2').style.display = "none";
        document.getElementById('jugadores-j2').style.display = "grid";
        document.getElementById('torneos-j').classList.remove('selected');
        document.getElementById('reglas-j').classList.remove('selected');
        document.getElementById('partidos-j').classList.remove('selected');
        document.getElementById('jugadores-j').classList.add('selected');
    });
    $('#partidos-j').click(function(e) {
        document.getElementById('reglas-j2').style.display = "none";
        document.getElementById('partidos-j2').style.display = "grid";
        document.getElementById('torneos-j2').style.display = "none";
        document.getElementById('jugadores-j2').style.display = "none";
        document.getElementById('torneos-j').classList.remove('selected');
        document.getElementById('reglas-j').classList.remove('selected');
        document.getElementById('partidos-j').classList.add('selected');
        document.getElementById('jugadores-j').classList.remove('selected');
    });
    $('#compartir').click(function(e) {
        let txt = window.location;
        navigator.clipboard.writeText(txt);
        document.getElementById("error_copy").style.display = "block";
      	document.getElementById("error_copy").innerHTML = "Link copiado";
    	setTimeout(() => {
    		document.getElementById("error_copy").style.display = "none";
    	}, 4000);
	});
	$('#btn-pago').click(function(e) {
		e.preventDefault();
        document.getElementById('btn-pago').disabled = true;
		$.ajax({
			url: '/bd/unirse_tp.php?p=<?php echo $pricep2[0]; ?>&id=<?php echo $id_torneo; ?>',
			type: 'POST',
			dataType: 'json',
		})
		.done(function(res) {
		    if (res == "existe") {
				document.getElementById("error2").style.display = "flex";
			  	document.getElementById("error2").innerHTML = "Ya estas registrado en este torneo";
				setTimeout(() => {
					document.getElementById("error2").style.display = "none";
					document.getElementById('btn-pago').disabled = false;
				}, 4000);
			}
		    if (res == "lleno") {
				document.getElementById("error2").style.display = "flex";
			  	document.getElementById("error2").innerHTML = "Torneo lleno";
				setTimeout(() => {
					document.getElementById("error2").style.display = "none";
					document.getElementById('btn-pago').disabled = false;
				}, 4000);
			}
		    if (res == "balance") {
				document.getElementById("error2").style.display = "flex";
			  	document.getElementById("error2").innerHTML = "No tienes suficiente balance para unirte";
				setTimeout(() => {
					document.getElementById("error2").style.display = "none";
					document.getElementById('btn-pago').disabled = false;
				}, 4000);
			}
			if (res == "pagado") {
			    window.location = "/fixture/<?php echo $id_torneo; ?>";
			}
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
    $('#btn-pago-r').click(function(e) {
		e.preventDefault();
        document.getElementById('btn-pago-r').disabled = true;
		$.ajax({
			url: '/bd/unirse_tp.php?p=<?php echo $pricep2[0]; ?>',
			type: 'POST',
			dataType: 'json',
		})
		.done(function(res) {
		    if (res == "balance") {
				document.getElementById("error2").style.display = "flex";
			  	document.getElementById("error2").innerHTML = "No tienes suficiente balance unirte";
				setTimeout(() => {
					document.getElementById("error2").style.display = "none";
					document.getElementById('btn-pago-r').disabled = false;
				}, 4000);
			}
			if (res == "pagado") {
			    window.location = "/bd/unirse_tr.php?id=<?php echo $id_torneo; ?>&u=<?php echo $_GET['u']; ?>";
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