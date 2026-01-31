<?php
	session_start();
	error_reporting(0);
	include_once 'bd/conexion.php';

	$id = $_SESSION['datos']['id'];
	$id_t = $_GET['e'];
	$id_cuenta = $_GET['c'];

	$c_cuenta = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuenta' OR nombre = '$id_cuenta'");
	$c_rows = $c_cuenta->fetch_row();
	
	$wallet = mysqli_query($conn, "SELECT * FROM wallet WHERE id_cuenta = '$id'");
    $w_saldo = $wallet->fetch_row();
    $s_wallet = number_format($w_saldo[1], 2, '.', ',');
    
    
    $star1 = "<li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' width='16' height='16' fill='rgba(48,64,96,1)'><path d='M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z'/></svg></li>";
    $star2 = "<li><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' width='16' height='16' fill='rgba(48,64,96,1)'><path d='M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z'/></svg></li>";
    $sqls = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE id_local = '$c_rows[0]' OR id_visitante = '$c_rows[0]'");
    $gano = 0; $perdio = 0; $empato = 0; $pctj = 0; $sumt = 0;
    
    $sqlttg = mysqli_query($conn, "SELECT COUNT(id_torneo) FROM r_torneos WHERE id_cuenta = '$c_rows[0]'");
    $sqlttgv = $sqlttg->fetch_row();
    $sqlttg2 = mysqli_query($conn, "SELECT COUNT(id_desafio) FROM desafio WHERE id_cuenta = '$c_rows[0]' OR id_visitante = '$c_rows[0]'");
    $sqlttgv2 = $sqlttg2->fetch_row();

    while ($sqlsv = mysqli_fetch_row($sqls)){
        if (($sqlsv[3] > $sqlsv[4]) && ($sqlsv[1] == $c_rows[0])){
            $gano = $gano + 1;
        }if (($sqlsv[3] < $sqlsv[4]) && ($sqlsv[1] == $c_rows[0])){
            $perdio = $perdio + 1;
        }if (($sqlsv[4] > $sqlsv[3]) && ($sqlsv[2] == $c_rows[0])){
            $gano = $gano + 1;
        }if (($sqlsv[4] < $sqlsv[3]) && ($sqlsv[2] == $c_rows[0])){
            $perdio = $perdio + 1;
        }if (($sqlsv[4] == $sqlsv[3]) && ($sqlsv[1] == $c_rows[0])){
            $empato = $empato + 1;
        }if (($sqlsv[3] == $sqlsv[4]) && ($sqlsv[2] == $c_rows[0])){
            $empato = $empato + 1;
        }
    }
    $sqls2 = mysqli_query($conn, "SELECT COUNT(id_enfrentamiento) FROM enfrentamientos WHERE id_local = '$c_rows[0]' OR id_visitante = '$c_rows[0]'");
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
    
    $sqlbp = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE (id_cuenta = '$c_rows[0]' AND tipo = 'Torneo') OR (id_cuenta = '$c_rows[0]' AND tipo = 'Desafio')");
    $sqlbpv = $sqlbp->fetch_row();
    $balancep = number_format($sqlbpv[0], 2, '.', ',');
                                
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/perfil.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title><?php echo $c_rows[1]; ?> | Perfil de Csport</title>
</head>
<body>
    <script src="/status.js"></script>
	<div id="pantalla"><span id="error"></span>
<?php
	if (empty($_GET['c'])) {
		header('Location: https://csport.es/');
	}else{
		if(empty($c_rows)){
		    header('Location: https://csport.es/');
		}else{
		    if (!empty($_GET['e'])) {
                $editar = "SELECT * FROM torneos WHERE id_torneo = '$id_t' AND id_cuenta = '$c_rows[0]' ORDER BY id_torneo DESC";
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
                <input type="checkbox" id="btn-editor">
                <div class="container-editor">
                      <div class="content-editor">
                          <h1>Torneo | Id.<?php echo $_GET['e']; ?></h1>
                          <div id="lista_t_p">
                            <form action="/bd/act_t.php?c=<?php echo $_GET['c']; ?>&e=<?php echo $_GET['e']; ?>&USER=" method="POST" enctype="multipart/form-data">
                                <label>Cambiar titulo</label>
                                <input type="text" name="titulo" value="<?php echo $edt[4]; ?>">
                                <label>Cambiar descripcion</label>
                                <textarea name="descripcion" id="descripcion"><?php echo $edt[5]; ?></textarea>
                                <label>Formato</label>
                                    <select id="formato" name="formato">
                                      <option selected value="<?php echo $torneoFN; ?>"><?php echo $torneoF; ?></option>
                                    <option value="Liga">Sistema de Liga</option>
                                    <option value="Liga E">Sist. de Liga + Eliminacion D.</option>
                                    <option value="Grupos E">Grupos + Eliminacion D.</option>
                                    <option value="Eliminacion D">Eliminacion Directa</option>
                                </select>
                                <label id="cdequipo" style="display: none;">Cant. de equipos</label>
                                <script type="text/javascript">
                                      $('#formato').click(function(e) { 
                                        var formato = document.getElementById('formato').value;
                                  
                                        if (formato == 'Grupos E') {
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
                                        if (formato == 'Eliminacion D') {
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
                                        if (formato == 'Liga E') {
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
                                <select id="equipos" style="display: none;" name="equipos"> <!-- CANT. GRUPOS -->
                                    <option SELECTED value="<?php echo $edt[19]; ?>"><?php echo $edt[19]; ?></option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                </select>
                                <label id="cdequipo_e" style="display: none;">Cant. de equipos por grupo</label>
                                <?php
                                    if($edt[7] == "Grupos E"){
                                        $gcantj = $edt[8]/$edt[19];
                                    }
                                ?>
                                <input style="display: none;" type="number" name="equipos_e" id="equipos_e" maxlength="2" value="<?php echo $gcantj; ?>"><!-- GRUPOS JUGADORES -->
                                <select id="equipos3" style="display: none;" name="equipos3"><!-- ELIMINACION DIRECTA -->
                                    <option selected value="<?php echo $edt[8]; ?>"><?php echo $edt[8]; ?></option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                    <option value="16">16</option>
                                    <option value="32">32</option>
                                </select>
                                    <input style="display: none;" type="number" name="equipos2" id="equipos2" maxlength="2" value="<?php echo $edt[8]; ?>"> <!-- LIGA + ELIMINACION -->
                                    <label id="cdtipocla" style="display: none;">Cant. de clasificados</label>
                                    <select id="equipos_clasificados" style="display: none;" name="equipos_clasificados">
                                        <option selected value="<?php echo $edt[16]; ?>"><?php echo $edt[16]; ?></option>
                                    <option style="display: none;" id="c_c2" value="2">2</option>
                                    <option style="display: none;" id="c_c4" value="4">4</option>
                                    <option style="display: none;" id="c_c8" value="8">8</option>
                                </select>
                                <script type="text/javascript">
                                    $('#formato').click(function(e) {
                                        var formato2 = document.getElementById('formato').value;
                                        if (formato2 == 'Liga E') {
                                            const input = document.getElementById("equipos2");
                                      
                                                input.addEventListener('keyup', function(event) {
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
                                        if (formato2 == 'Grupos E') {
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
                              <a href="/bd/eliminar_t.php?id=<?php echo $edt[0]; ?>" id="eliminar_t">Eliminar</a>
                            </form>
                          </div>
                      </div>
                      <label for="btn-editor" class="cerrar-editor"></label>
                  </div>
<?php
              }
            if(isset($_GET['msj'])){
?>
                <input type="checkbox" id="btn-modal-msj">
        		<div class="container-modal-msj">
        	        <div class="content-modal-msj">
        	        <?php
        	            $idmsj = $_GET['msj'];
        	            $sqlmp = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$c_rows[0]' AND id_enfrentamiento = '$idmsj') OR (id_cuenta = '$idmsj' AND id_enfrentamiento = '$c_rows[0]')");
        	            $sqlmpv = $sqlmp->fetch_row();
        	            if($sqlmpv){
            	            if($sqlmpv[2] == $c_rows[0]){
            	                $idmsj2 = $sqlmpv[3];
            	            }else{
            	                $idmsj2 = $sqlmpv[2];
            	            }
            	            $sqlmpc = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$c_rows[0]'");
            	            $sqlmpcv = $sqlmpc->fetch_row();
        	            }else{
        	                $sqlmpc = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$c_rows[0]'");
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
        	        <label for="btn-modal-msj" class="cerrar-modal-msj"></label>
        	    </div>
<?php
            }
?>
		<div id="screen-scroll">
            <header id="hbar">
			<ul>
				<?php
					if (empty(($_SESSION['datos']))) {
				?>
					<li style="float: left; margin-left: 2rem;"><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a href="/login" style="margin-right: 1rem;">Iniciar sesion</a></li>
				<?php
					}else{
				?>
				    <li id="btn-desp" style="float: left; display: none;"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M16 18V20H5V18H16ZM21 11V13H3V11H21ZM19 4V6H8V4H19Z"></path></svg></a></li>
					<li style="margin-left: 2rem; float: left;"><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li>
					<li><a href="/bd/cerrar" style="margin-right: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z"></path></svg></a></li>
					<li id="btn-chat"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M2 8.99374C2 5.68349 4.67654 3 8.00066 3H15.9993C19.3134 3 22 5.69478 22 8.99374V21H8.00066C4.68659 21 2 18.3052 2 15.0063V8.99374ZM20 19V8.99374C20 6.79539 18.2049 5 15.9993 5H8.00066C5.78458 5 4 6.78458 4 8.99374V15.0063C4 17.2046 5.79512 19 8.00066 19H20ZM14 11H16V13H14V11ZM8 11H10V13H8V11Z"></path></svg></a></li>
				<?php
        	        $notsql2 = mysqli_query($conn, "SELECT * FROM notificaciones WHERE id_cuentar = '$c_rows[0]' AND estado = '0'");
        	        $notsql2v = mysqli_num_rows($notsql2);
        	    ?>
					<li id="btn-ntf"><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M5 18H19V11.0314C19 7.14806 15.866 4 12 4C8.13401 4 5 7.14806 5 11.0314V18ZM12 2C16.9706 2 21 6.04348 21 11.0314V20H3V11.0314C3 6.04348 7.02944 2 12 2ZM9.5 21H14.5C14.5 22.3807 13.3807 23.5 12 23.5C10.6193 23.5 9.5 22.3807 9.5 21Z"></path></svg></a><?php if($notsql2v > 0){ ?><p><?php echo $notsql2v; ?></p><?php } ?></li>
					<li id="wallet-cel"><span id="wallet">$<?php echo $s_wallet; ?> <label style="cursor: pointer;"><a href="/buscador?wallet">Saldo</a></label></span></li>
				<?php
					}
				?>
			</ul>
		</header>
    	<?php
    	     if(!empty($_SESSION['datos']['id'])){
    	?>
    	    	<header id="header-cel" style="height: 3rem;">
    	            <span id="wallet2" style="margin-left: 1.5rem;">$<?php echo $s_wallet; ?> <label style="cursor: pointer;"><a href="/buscador?wallet">Saldo</a></label></span>
    	        </header>
    	<?php
    	     }
    	?>
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
    		                $msj = $notsqlcv[0]." ¡ te esta invitando a su torneo!";
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
                        $msjd = mysqli_query($conn, "SELECT * FROM chat WHERE (id_cuenta = '$c_rows[0]' AND tipo = 'Msj') OR (id_enfrentamiento = '$c_rows[0]' AND tipo = 'Msj') GROUP BY id_torneo ORDER BY id_chat DESC");
                        while($msjdv = mysqli_fetch_row($msjd)){
                            if($msjdv[1] != $c_rows[0]){
                                if($msjdv[2] == $c_rows[0]){
                                $id_co = $msjdv[3];
                                }else{
                                $id_co = $msjdv[2];
                            }
                            
                                $msjdc = mysqli_query($conn, "SELECT nombre,status,img FROM cuentas WHERE id_cuenta = '$id_co'");
                                $msjdcv = $msjdc->fetch_row();
                                $msju = mysqli_query($conn, "SELECT mensaje,id_cuenta FROM chat WHERE (id_cuenta = '$c_rows[0]' AND id_enfrentamiento = '$msjdv[1]') OR (id_cuenta = '$msjdv[1]' AND id_enfrentamiento = '$c_rows[0]') ORDER BY id_chat DESC");
                                $msjuv = $msju->fetch_row();
                                
                                $shoy = $msjdcv[1];
                                $fechaDes = new DateTime($shoy);
                                $fechaActual = new DateTime();
                                $diferencia = $fechaActual->diff($fechaDes);
                    ?>
                                <a href="/perfil/<?php echo $c_rows[0];?>&msj=<?php echo $id_co; ?>">
                                    <div class="cont-msj-chat"><?php if(($diferencia->d == 0) && ($diferencia->h <= 0) && ($diferencia->i <= 5)){ echo "<span style='background: #56aa57;'>ㅤ</span>"; }else{ echo "<span style='background: #aa5656;'>ㅤ</span>"; } ?>
                                        <img src="/<?php echo $msjdcv[2]; ?>">
                                        <label><?php echo $msjdcv[0]; ?></label>
                                    <?php
                                        if($msjuv[1] == $c_rows[0]){
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
    		<div id="header-banner">
    		    <content>
    		        <div id="foto"><img src="/<?php echo $c_rows[5]; ?>"></div>
    		        <p><?php echo $c_rows[1]; ?></p>
    		        <div id="barra-menu">
    		            <a href="/buscador" title="Buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="rgba(242,242,242,1)"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path></svg></a>
    		        </div>
    		    <?php
    		        if($id !== $c_rows[0]){
    		    ?>
    		        <a href="/perfil/<?php echo $c_rows[0]; ?>&msj"><div id="agregar-p" title="Enviar mensaje privado"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M2 8.99374C2 5.68349 4.67654 3 8.00066 3H15.9993C19.3134 3 22 5.69478 22 8.99374V21H8.00066C4.68659 21 2 18.3052 2 15.0063V8.99374ZM20 19V8.99374C20 6.79539 18.2049 5 15.9993 5H8.00066C5.78458 5 4 6.78458 4 8.99374V15.0063C4 17.2046 5.79512 19 8.00066 19H20ZM14 11H16V13H14V11ZM8 11H10V13H8V11Z"></path></svg> Mensaje</div></a>
    		    <?php
    		        }
    		    ?>
    		    </content>
    		</div>
    		    <main>
    		        <div id="barra">
    		            <ul>
    		                <li title="Perfil" id="btn-perfil" class="selected"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="rgba(38,38,38,1)"><path d="M21.0082 3C21.556 3 22 3.44495 22 3.9934V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V3.9934C2 3.44476 2.45531 3 2.9918 3H21.0082ZM20 5H4V19H20V5ZM18 15V17H6V15H18ZM12 7V13H6V7H12ZM18 11V13H14V11H18ZM10 9H8V11H10V9ZM18 7V9H14V7H18Z"></path></svg></li>
    		        <?php
		                if($c_rows[0] == $id){
		            ?>
		                    <li title="Torneos" id="btn-torneos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="rgba(38,38,38,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM17 6H7C4.8578 6 3.10892 7.68397 3.0049 9.80036L3 10V14C3 16.1422 4.68397 17.8911 6.80036 17.9951L7 18H17C19.1422 18 20.8911 16.316 20.9951 14.1996L21 14V10C21 7.8578 19.316 6.10892 17.1996 6.0049L17 6ZM10 9V11H12V13H9.999L10 15H8L7.999 13H6V11H8V9H10ZM18 13V15H16V13H18ZM16 9V11H14V9H16Z"></path></svg></li>
    		                <li title="Ajustes" id="btn-ajustes"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="rgba(38,38,38,1)"><path d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM12 3.311L4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311ZM12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12C16 14.2091 14.2091 16 12 16ZM12 14C13.1046 14 14 13.1046 14 12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12C10 13.1046 10.8954 14 12 14Z"></path></svg></li>
    		        <?php
		                }
    		        ?>
    		            </ul>
    		        </div>
    		        <div id="contenido">
    		            <div id="c-perfil">
    		                <section>
    		                    <h2>Nvl de habilidad | <?php echo round($pctjetc); ?>%</h2>
    		                    <div id="stats" style="margin-bottom: 1rem !important; flex-direction: row !important;">
    		                        <ul title="Nvl. de habilidad | <?php echo round($pctjetc); ?>%">
            		                    <?php echo $habs; ?>
            		                </ul>
            		            </div>
    		                    <h2>Informacion</h2>
    		                    <div id="stats" style="margin-bottom: 0 !important;">
    		                    <?php
    		                        if($c_rows[18]){
    		                    ?>
    		                            <p title="Nombre completo"><?php echo $c_rows[18]; ?></p>
    		                    <?php
    		                        }else{
    		                    ?>
    		                            <p title="Nombre completo">No se agrego nombre</p>
    		                    <?php
    		                        }
    		                        if($c_rows[8]){
    		                    ?>
    		                            <p title="Pais"><?php echo $c_rows[8]; ?></p>
    		                    <?php
    		                        }else{
    		                    ?>
    		                            <p title="Pais">No se agrego pais/ciudad</p>
    		                    <?php
    		                        }
    		                    ?>
    		                    </div>
    		                    <div id="stats">
    		                    <?php
    		                        if($c_rows[11] == ""){
    		                            $eaid = "No tiene EA ID";
    		                        }else{
    		                            $eaid = $c_rows[11];
    		                        }if($c_rows[12] == ""){
    		                            $psnid = "No tiene PSN ID";
    		                        }else{
    		                            $psnid = $c_rows[12];
    		                        }if($c_rows[13] == ""){
    		                            $xboxid = "No tiene XBOX ID";
    		                        }else{
    		                            $xboxid = $c_rows[13];
    		                        }
    		                        if($c_rows[14] == ""){
    		                            $actid = "No tiene ACTIVISION ID";
    		                        }else{
    		                            $actid = $c_rows[14];
    		                        }
    		                        if($c_rows[15] == ""){
    		                            $nbaid = "No tiene NBA ID";
    		                        }else{
    		                            $nbaid = $c_rows[15];
    		                        }
    		                    ?>
    		                    <p title="EA ID"><img src="/img/ea.svg" height="10"> <?php echo $eaid; ?></p>
    		                    <p title="PSN ID"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="rgba(38,38,38,1)"><path d="M570.9 372.3c-11.3 14.2-38.8 24.3-38.8 24.3L327 470.2v-54.3l150.9-53.8c17.1-6.1 19.8-14.8 5.8-19.4-13.9-4.6-39.1-3.3-56.2 2.9L327 381.1v-56.4c23.2-7.8 47.1-13.6 75.7-16.8 40.9-4.5 90.9 .6 130.2 15.5 44.2 14 49.2 34.7 38 48.9zm-224.4-92.5v-139c0-16.3-3-31.3-18.3-35.6-11.7-3.8-19 7.1-19 23.4v347.9l-93.8-29.8V32c39.9 7.4 98 24.9 129.2 35.4C424.1 94.7 451 128.7 451 205.2c0 74.5-46 102.8-104.5 74.6zM43.2 410.2c-45.4-12.8-53-39.5-32.3-54.8 19.1-14.2 51.7-24.9 51.7-24.9l134.5-47.8v54.5l-96.8 34.6c-17.1 6.1-19.7 14.8-5.8 19.4 13.9 4.6 39.1 3.3 56.2-2.9l46.4-16.9v48.8c-51.6 9.3-101.4 7.3-153.9-10z"/></svg> <?php echo $psnid; ?></p>
    		                    <p title="XBOX ID"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="rgba(38,38,38,1)"><path d="M369.9 318.2c44.3 54.3 64.7 98.8 54.4 118.7-7.9 15.1-56.7 44.6-92.6 55.9-29.6 9.3-68.4 13.3-100.4 10.2-38.2-3.7-76.9-17.4-110.1-39C93.3 445.8 87 438.3 87 423.4c0-29.9 32.9-82.3 89.2-142.1 32-33.9 76.5-73.7 81.4-72.6 9.4 2.1 84.3 75.1 112.3 109.5zM188.6 143.8c-29.7-26.9-58.1-53.9-86.4-63.4-15.2-5.1-16.3-4.8-28.7 8.1-29.2 30.4-53.5 79.7-60.3 122.4-5.4 34.2-6.1 43.8-4.2 60.5 5.6 50.5 17.3 85.4 40.5 120.9 9.5 14.6 12.1 17.3 9.3 9.9-4.2-11-.3-37.5 9.5-64 14.3-39 53.9-112.9 120.3-194.4zm311.6 63.5C483.3 127.3 432.7 77 425.6 77c-7.3 0-24.2 6.5-36 13.9-23.3 14.5-41 31.4-64.3 52.8C367.7 197 427.5 283.1 448.2 346c6.8 20.7 9.7 41.1 7.4 52.3-1.7 8.5-1.7 8.5 1.4 4.6 6.1-7.7 19.9-31.3 25.4-43.5 7.4-16.2 15-40.2 18.6-58.7 4.3-22.5 3.9-70.8-.8-93.4zM141.3 43C189 40.5 251 77.5 255.6 78.4c.7 .1 10.4-4.2 21.6-9.7 63.9-31.1 94-25.8 107.4-25.2-63.9-39.3-152.7-50-233.9-11.7-23.4 11.1-24 11.9-9.4 11.2z"/></svg> <?php echo $xboxid; ?></p>
    		                    <p title="ACTIVISION ID"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M8.01266 4.56502C8.75361 4.16876 9.5587 4 11.1411 4H12.8589C14.4413 4 15.2464 4.16876 15.9873 4.56502C16.6166 4.90155 17.0985 5.38342 17.435 6.01266C17.8312 6.75361 18 7.5587 18 9.14111V14.8589C18 16.4413 17.8312 17.2464 17.435 17.9873C17.0985 18.6166 16.6166 19.0985 15.9873 19.435C15.2464 19.8312 14.4413 20 12.8589 20H11.1411C9.5587 20 8.75361 19.8312 8.01266 19.435C7.38342 19.0985 6.90155 18.6166 6.56502 17.9873C6.16876 17.2464 6 16.4413 6 14.8589V9.14111C6 7.5587 6.16876 6.75361 6.56502 6.01266C6.90155 5.38342 7.38342 4.90155 8.01266 4.56502ZM12.8589 2H11.1411C9.12721 2 8.04724 2.27848 7.06946 2.8014C6.09168 3.32432 5.32432 4.09168 4.8014 5.06946C4.27848 6.04724 4 7.12721 4 9.14111V14.8589C4 16.8728 4.27848 17.9528 4.8014 18.9305C5.32432 19.9083 6.09168 20.6757 7.06946 21.1986C8.04724 21.7215 9.12721 22 11.1411 22H12.8589C14.8728 22 15.9528 21.7215 16.9305 21.1986C17.9083 20.6757 18.6757 19.9083 19.1986 18.9305C19.7215 17.9528 20 16.8728 20 14.8589V9.14111C20 7.12721 19.7215 6.04724 19.1986 5.06946C18.6757 4.09168 17.9083 3.32432 16.9305 2.8014C15.9528 2.27848 14.8728 2 12.8589 2ZM13 6H11V11H13V6ZM7.75781 13.758L12.0005 18.0006L16.2431 13.758L14.8289 12.3438L12.0005 15.1722L9.17203 12.3438L7.75781 13.758Z"></path></svg> <?php echo $actid; ?></p>
    		                    <p title="NBA ID"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="rgba(38,38,38,1)"><path d="M86.6 64l85.2 85.2C194.5 121.7 208 86.4 208 48c0-14.7-2-28.9-5.7-42.4C158.6 15 119 35.5 86.6 64zM64 86.6C35.5 119 15 158.6 5.6 202.3C19.1 206 33.3 208 48 208c38.4 0 73.7-13.5 101.3-36.1L64 86.6zM256 0c-7.3 0-14.6 .3-21.8 .9C238 16 240 31.8 240 48c0 47.3-17.1 90.5-45.4 124L256 233.4 425.4 64C380.2 24.2 320.9 0 256 0zM48 240c-16.2 0-32-2-47.1-5.8C.3 241.4 0 248.7 0 256c0 64.9 24.2 124.2 64 169.4L233.4 256 172 194.6C138.5 222.9 95.3 240 48 240zm463.1 37.8c.6-7.2 .9-14.5 .9-21.8c0-64.9-24.2-124.2-64-169.4L278.6 256 340 317.4c33.4-28.3 76.7-45.4 124-45.4c16.2 0 32 2 47.1 5.8zm-4.7 31.9C492.9 306 478.7 304 464 304c-38.4 0-73.7 13.5-101.3 36.1L448 425.4c28.5-32.3 49.1-71.9 58.4-115.7zM340.1 362.7C317.5 390.3 304 425.6 304 464c0 14.7 2 28.9 5.7 42.4C353.4 497 393 476.5 425.4 448l-85.2-85.2zM317.4 340L256 278.6 86.6 448c45.1 39.8 104.4 64 169.4 64c7.3 0 14.6-.3 21.8-.9C274 496 272 480.2 272 464c0-47.3 17.1-90.5 45.4-124z"/></svg> <?php echo $nbaid; ?></p>
    		                    </div>
    		                    <div id="stats" style="margin-top: -1rem !important;">
    		                        <p style="font-weight: 600;">Juegos obtenidos</p>
    		                        <p title="Pais">No se agrego ninguno</p>
    		                    </div>
    		                    
    		                    <h2>Torneo organizados</h2>
    		                    <div id="stats">
    		                    <?php
                                    $pmtsql = mysqli_query($conn, "SELECT id,titulo FROM torneos WHERE id_cuenta = '$c_rows[0]' ORDER BY id DESC LIMIT 5");
                                    while ($pmtsqlv = mysqli_fetch_row($pmtsql)){
                                ?>
    		                        <a href="/torneo/<?php echo $pmtsqlv[0]; ?>" class="mptorneo"><div>
    		                            <label><?php echo $pmtsqlv[1]; ?></label>
    		                        </div></a>
    		                    <?php
                                    }
                                ?>
    		                    </div>
    		                </section>
    		                <main>
                                <div id="stats">
                                    <div id="team">
                                        <img src="/img/Logo.png">
                                        <p>~ No team</p>
                                        <a ><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512"><path fill="#f2f2f2" d="M352 0c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9L370.7 96 201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L416 141.3l41.4 41.4c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6l0-128c0-17.7-14.3-32-32-32L352 0zM80 32C35.8 32 0 67.8 0 112L0 432c0 44.2 35.8 80 80 80l320 0c44.2 0 80-35.8 80-80l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 112c0 8.8-7.2 16-16 16L80 448c-8.8 0-16-7.2-16-16l0-320c0-8.8 7.2-16 16-16l112 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 32z"/></svg></a>
                                    </div>
                                </div>
    		                    <h2>Estadisticas</h2>
                                <div id="stats">
                                    <div class="s_balance">
                                        <h4>Ganancias totales</h4>
                                        <p>$<?php echo $balancep; ?></p>
                                    </div>
                                    <div>
                                        <h4>Partidos ganados</h4>
                                        <p><?php echo $gano; ?></p>
                                    </div>
                                    <div>
                                        <h4>Partidos perdidos</h4>
                                        <p><?php echo $perdio; ?></p>
                                    </div>
                                    <div>
                                        <h4>Partidos empatados</h4>
                                        <p><?php echo $empato; ?></p>
                                    </div>
                                    <div>
                                        <h4>Torneos jugados</h4>
                                        <p><?php echo $sqlttgv[0]; ?></p>
                                    </div>
                                    <div>
                                        <h4>Desafios jugados</h4>
                                        <p><?php echo $sqlttgv2[0]; ?></p>
                                    </div>
                                    <div>
                                        <h4>Porcentaje de victorias</h4>
                                        <p><?php echo round($pctj); ?>%</p>
                                    </div>
                                </div>
                                
                                <h2>Torneos jugados</h2>
                                <div id="stats">
                                <?php
                                    $pmtsql = mysqli_query($conn, "SELECT r.id_torneo FROM r_torneos r JOIN torneos t ON r.id_torneo = t.id WHERE r.id_cuenta = '$c_rows[0]' ORDER BY id_rtorneos DESC LIMIT 10");
                                    while ($pmtsqlv = mysqli_fetch_row($pmtsql)){
                                        $sqltnp = mysqli_query($conn, "SELECT titulo FROM torneos WHERE id = '$pmtsqlv[0]'");
                                        $sqltnpv = $sqltnp->fetch_row();
                                ?>
    		                        <a href="/torneo/<?php echo $pmtsqlv[0]; ?>" class="mptorneo"><div>
    		                            <label><?php echo $sqltnpv[0]; ?></label>
    		                        </div></a>
    		                    <?php
                                    }
                                ?>
                                </div>
                                
    		                    <h2>Desafios recientes</h2>
        		                <div id="partidos-j2">
                		        <?php
                		            $sqlj2d = mysqli_query($conn, "SELECT * FROM desafio WHERE id_cuenta = '$c_rows[0]' OR id_visitante = '$c_rows[0]' ORDER BY id_desafio DESC LIMIT 4");
                		            while ($rowspd = mysqli_fetch_row($sqlj2d)) {
                		                $sqldp = mysqli_query($conn, "SELECT * FROM enfrentamientos WHERE grupo = '$rowspd[0]' AND tipo = 'Desafio'");
                		                $sqldpv = $sqldp->fetch_row();
                		                $juegoded = explode("/", $rowspd[3]);
                		                
                		                $sqlj2cd = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqldpv[1]'");
                		                $sqlj2cvd = $sqlj2cd->fetch_row();
                		                $sqlj2cd2 = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$sqldpv[2]'");
                		                $sqlj2cvd2 = $sqlj2cd2->fetch_row();
                		                
                		                $sqlj2ed = mysqli_query($conn, "SELECT * FROM juegos WHERE nombre = '$juegoded[0]' AND tipo = '$juegoded[1]'");
                		                $sqlj2ved = $sqlj2ed->fetch_row();
                		               
                                        $nombreded = $sqlj2cvd[1]; $imgded = $sqlj2cvd[5];
                		                
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
                	            		if($sqldpv[1] == $c_rows[0]){
                	            		    if($rowspd[2] > 0){
                	            		        $nombredep = $sqlj2cvd2[1];
                	            		    }else{
                	            		        $nombredep = "ESPERANDO R.";
                	            		    }
                	            		}if($sqldpv[2] == $c_rows[0]){
                	            		    if($rowspd[1] > 0){
                	            		        $nombredep = $sqlj2cvd[1];
                	            		    }else{
                	            		        $nombredep = "ESPERANDO R.";
                	            		    }
                	            		}
                		        ?>
                		            <article>
                                        <header>
                                            <div>
                                                <img src="/<?php echo $sqlj2ved[2]; ?>">
                                            </div>
                                            <p><?php echo $juegoded[0]; ?> | <?php echo $juegoded[1]; ?></p>
                                            <span class="partidos-ganas">Ganas <h3>$<?php echo $rowspd[9]; ?></h3></span>
                                            <span class="partidos-apostas">Apostas <h3>$<?php echo $montoded; ?></h3></span>
                                        </header>
                                        <footer>
                                            <span>VS</span>
                                            <div class="partidos-jugador2">
                                                <p><?php echo $nombredep; ?></p>
                                            </div>
                                        </footer>
                                    </article>
                		        <?php
                		            }
                		        ?>
                		        </div>
    		                </main>
    		            </div>
    		            <div id="c-torneos" style="display: none;">
    		                <h2>Torneos organizados</h2>
    		                <section>
    		                    <?php
                                    $torneos = mysqli_query($conn, "SELECT * FROM torneos WHERE id_cuenta = '$c_rows[0]' ORDER BY id DESC");
                                    while ($torneosv = mysqli_fetch_row($torneos)){
                                        $pricep2 = explode("/", $torneosv[17]);
                                        $pricep = number_format($pricep2[1], 2, '.', ',');
                                ?>
                                    <article><a id="btn-torneo" href="/torneo/<?php echo $torneosv[0]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(242,242,242,1)"><path d="M18.3638 15.5355L16.9496 14.1213L18.3638 12.7071C20.3164 10.7545 20.3164 7.58866 18.3638 5.63604C16.4112 3.68341 13.2453 3.68341 11.2927 5.63604L9.87849 7.05025L8.46428 5.63604L9.87849 4.22182C12.6122 1.48815 17.0443 1.48815 19.778 4.22182C22.5117 6.95549 22.5117 11.3876 19.778 14.1213L18.3638 15.5355ZM15.5353 18.364L14.1211 19.7782C11.3875 22.5118 6.95531 22.5118 4.22164 19.7782C1.48797 17.0445 1.48797 12.6123 4.22164 9.87868L5.63585 8.46446L7.05007 9.87868L5.63585 11.2929C3.68323 13.2455 3.68323 16.4113 5.63585 18.364C7.58847 20.3166 10.7543 20.3166 12.7069 18.364L14.1211 16.9497L15.5353 18.364ZM14.8282 7.75736L16.2425 9.17157L9.17139 16.2426L7.75717 14.8284L14.8282 7.75736Z"></path></svg></a>
                                <?php
                    	            if($torneosv[12] == 0){
                    	        ?>
                    	            <p class="t_status wait">En espera</p>
                    	        <?php
                    	            }if(($torneosv[12] == 1) || ($torneosv[12] == 2)){
                    	        ?>
                    	            <p class="t_status execution">En ejecucion</p>
                    	        <?php
                    	            }if($torneosv[12] == 3){
                    	        ?>
                    	            <p class="t_status rev">En revisión</p>
                    	        <?php
                    	            }if($torneosv[12] == 4){
                    	        ?>
                    	            <p class="t_status finished">Finalizado</p>
                    	        <?php
                    	            }
                    	        ?>
                                    <a href="<?php if($c_rows[0] == $id){ ?>/perfil/<?php echo $id."&e=".$torneosv[1]; }else{ ?>/torneo/<?php echo $torneosv[0]; } ?>">
                                        <img src="/<?php echo $torneosv[10]; ?>">
                                        <h2 title="<?php echo $torneosv[4]; ?>"><?php echo $torneosv[4]; ?></h2>
                                        <p class="t_price">PRIZE POOL $<?php echo $pricep; ?></p>
                                        <span><?php echo $torneosv[8]; ?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="rgba(0,0,0,1)"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg></span>
                                    </a></article>
                                <?php
                                    }
                                ?>
    		                </section>
    		            </div>
    		            <div id="c-ajustes" style="display: none;">
    		                <h2>Configuracion de cuenta</h2>
    		                <div id="c-ajustes-grid">
    		                <?php
    		                    if (($c_rows[6] !== "") && ($c_rows[4] == 0)){
    		                ?>
    		                    <form action="" method="POST">
                                    <h3>Verificar email</h3>
                                    <label>Ingresa tu codigo</label>
                                    <input type="number" id="code" placeholder="Ej: 111222">
                                    <button id="validar-code">Verificar</button>
                                </form>
    		                <?php
    		                    }else{
    		                        if($c_rows[4] >= 1){
    		                        }else{
                            ?>
                                        <form action="/bd/v_correo.php" method="POST">
                                        <h3>Verificar email</h3>
                                        <label>Email | <?php echo $c_rows[2]; ?></label>
                            <?php
                                        if($c_rows[4] == 0){
                            ?>
                                        <button id="validar-email">Validar email</button>
                            <?php
                                        }else{
                            ?>
                                        <p>Ya tienes el email validado</p>
                            <?php
                                        }
                            ?>
                                        <!--<label>Cambiar email</label>
                                        <input type="text" placeholder="Ingresa tu nuevo email">
                                        <button id="cambiar-email">Cambiar email</button>-->
                                    </form>
                            <?php
    		                        }
    		                    }
    		                ?>
    		                    <form action="/bd/validar-img.php" method="POST" enctype="multipart/form-data">
                                    <h3>Cambiar foto de perfil</h3>
                                    <label>Subir foto de perfil</label>
                                    <input type="file" name="imagen" style="color: #f2f2f2;">
                                    <button name="cfoto">Actualizar</button>
                                </form>
    		                    <form action="" method="POST">
    		                        <?php $pais_ciudad = explode("/", $c_rows[8]); ?>
                                    <h3>Datos personales</h3>
                                    <label>Nombre y apellido</label>
                                    <input type="text" id="nyp" placeholder="Nombre completo" <?php if($c_rows[18] !== ""){ ?> value="<?php echo $c_rows[18]; ?>"<?php } ?>>
                                    <label>Pais</label>
                                    <select id="pais">
                                        <?php
                                            if($c_rows[8] !== ""){
                                        ?>
                                        <option selected value="<?php echo $pais_ciudad[0]; ?>"><?php echo $pais_ciudad[0]; ?></option>
                                        <?php
                                            }
                                        ?>
                                        <option value="">Selecciona tu pais</option>
                                        <option value="Afganistán">Afganistán</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Alemania">Alemania</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Antigua y Barbuda">Antigua y Barbuda</option>
                                        <option value="Arabia Saudita">Arabia Saudita</option>
                                        <option value="Argelia">Argelia</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaiyán">Azerbaiyán</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bangladés">Bangladés</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Baréin">Baréin</option>
                                        <option value="Bélgica">Bélgica</option>
                                        <option value="Belice">Belice</option>
                                        <option value="Benín">Benín</option>
                                        <option value="Bielorrusia">Bielorrusia</option>
                                        <option value="Birmania/Myanmar">Birmania/Myanmar</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia y Herzegovina">Bosnia y Herzegovina</option>
                                        <option value="Botsuana">Botsuana</option>
                                        <option value="Brasil">Brasil</option>
                                        <option value="Brunéi">Brunéi</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Bután">Bután</option>
                                        <option value="Cabo Verde">Cabo Verde</option>
                                        <option value="Camboya">Camboya</option>
                                        <option value="Camerún">Camerún</option>
                                        <option value="Canadá">Canadá</option>
                                        <option value="Catar">Catar</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Chipre">Chipre</option>
                                        <option value="Ciudad del Vaticano">Ciudad del Vaticano</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoras">Comoras</option>
                                        <option value="Corea del Norte">Corea del Norte</option>
                                        <option value="Corea del Sur">Corea del Sur</option>
                                        <option value="Costa de Marfil">Costa de Marfil</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Croacia">Croacia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Dinamarca">Dinamarca</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egipto">Egipto</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Emiratos Árabes Unidos">Emiratos Árabes Unidos</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Eslovaquia">Eslovaquia</option>
                                        <option value="Eslovenia">Eslovenia</option>
                                        <option value="España">España</option>
                                        <option value="Estados Unidos">Estados Unidos</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Etiopía">Etiopía</option>
                                        <option value="Filipinas">Filipinas</option>
                                        <option value="Finlandia">Finlandia</option>
                                        <option value="Fiyi">Fiyi</option>
                                        <option value="Francia">Francia</option>
                                        <option value="Gabón">Gabón</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Granada">Granada</option>
                                        <option value="Grecia">Grecia</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea ecuatorial">Guinea ecuatorial</option>
                                        <option value="Guinea-Bisáu">Guinea-Bisáu</option>
                                        <option value="Haití">Haití</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hungría">Hungría</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Irak">Irak</option>
                                        <option value="Irán">Irán</option>
                                        <option value="Irlanda">Irlanda</option>
                                        <option value="Islandia">Islandia</option>
                                        <option value="Islas Marshall">Islas Marshall</option>
                                        <option value="Islas Salomón">Islas Salomón</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italia">Italia</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japón">Japón</option>
                                        <option value="Jordania">Jordania</option>
                                        <option value="Kazajistán">Kazajistán</option>
                                        <option value="Kenia">Kenia</option>
                                        <option value="Kirguistán">Kirguistán</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Lesoto">Lesoto</option>
                                        <option value="Letonia">Letonia</option>
                                        <option value="Líbano">Líbano</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libia">Libia</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lituania">Lituania</option>
                                        <option value="Luxemburgo">Luxemburgo</option>
                                        <option value="Macedonia del Norte">Macedonia del Norte</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malasia">Malasia</option>
                                        <option value="Malaui">Malaui</option>
                                        <option value="Maldivas">Maldivas</option>
                                        <option value="Malí">Malí</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marruecos">Marruecos</option>
                                        <option value="Mauricio">Mauricio</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="México">México</option>
                                        <option value="Micronesia">Micronesia</option>
                                        <option value="Moldavia">Moldavia</option>
                                        <option value="Mónaco">Mónaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montenegro">Montenegro</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Níger">Níger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Noruega">Noruega</option>
                                        <option value="Nueva Zelanda">Nueva Zelanda</option>
                                        <option value="Omán">Omán</option>
                                        <option value="Países Bajos">Países Bajos</option>
                                        <option value="Pakistán">Pakistán</option>
                                        <option value="Palaos">Palaos</option>
                                        <option value="Panamá">Panamá</option>
                                        <option value="Papúa Nueva Guinea">Papúa Nueva Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Perú">Perú</option>
                                        <option value="Polonia">Polonia</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Reino Unido">Reino Unido</option>
                                        <option value="República Centroafricana">República Centroafricana</option>
                                        <option value="República Checa">República Checa</option>
                                        <option value="República del Congo">República del Congo</option>
                                        <option value="República Democrática del Congo">República Democrática del Congo</option>
                                        <option value="República Dominicana">República Dominicana</option>
                                        <option value="República Sudafricana">República Sudafricana</option>
                                        <option value="Ruanda">Ruanda</option>
                                        <option value="Rumanía">Rumanía</option>
                                        <option value="Rusia">Rusia</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Cristóbal y Nieves">San Cristóbal y Nieves</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="San Vicente y las Granadinas">San Vicente y las Granadinas</option>
                                        <option value="Santa Lucía">Santa Lucía</option>
                                        <option value="Santo Tomé y Príncipe">Santo Tomé y Príncipe</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia">Serbia</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leona">Sierra Leona</option>
                                        <option value="Singapur">Singapur</option>
                                        <option value="Siria">Siria</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Suazilandia">Suazilandia</option>
                                        <option value="Sudán">Sudán</option>
                                        <option value="Sudán del Sur">Sudán del Sur</option>
                                        <option value="Suecia">Suecia</option>
                                        <option value="Suiza">Suiza</option>
                                        <option value="Surinam">Surinam</option>
                                        <option value="Tailandia">Tailandia</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Tayikistán">Tayikistán</option>
                                        <option value="Timor Oriental">Timor Oriental</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad y Tobago">Trinidad y Tobago</option>
                                        <option value="Túnez">Túnez</option>
                                        <option value="Turkmenistán">Turkmenistán</option>
                                        <option value="Turquía">Turquía</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Ucrania">Ucrania</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistán">Uzbekistán</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Yibuti">Yibuti</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabue">Zimbabue</option>
                                        </select>
                                    <label>Ciudad</label>
                                    <input type="text" id="ciudad" placeholder="Ciudad en la que vives" <?php if($c_rows[8] !== ""){ ?> value="<?php echo $pais_ciudad[1]; ?>"<?php } ?>>
                                    <label>Fecha de Nac.</label>
                                    <input type="date" id="fdnac" <?php if($c_rows[9] !== ""){ ?> value="<?php echo $c_rows[9]; ?>"<?php } ?>>
                                    <label>Contacto <?php if($c_rows[10] !== ""){ echo "(".$c_rows[10].")"; } ?></label>
                                    <select id="tel-c">
                                        <option value="">Selecciona un pais</option>
                                        <option value="93">(+93) Afganistán</option>
                                        <option value="355">(+355) Albania</option>
                                        <option value="49">(+49) Alemania</option>
                                        <option value="376">(+376) Andorra</option>
                                        <option value="244">(+244) Angola</option>
                                        <option value="1">(+1) Antigua y Barbuda</option>
                                        <option value="966">(+966) Arabia Saudita</option>
                                        <option value="213">(+213) Argelia</option>
                                        <option value="54">(+54) Argentina</option>
                                        <option value="374">(+374) Armenia</option>
                                        <option value="61">(+61) Australia</option>
                                        <option value="43">(+43) Austria</option>
                                        <option value="994">(+994)Azerbaiyán</option>
                                        <option value="1">(+1) Bahamas</option>
                                        <option value="880">(+880) Bangladés</option>
                                        <option value="1">(+1) Barbados</option>
                                        <option value="973">(+973) Baréin</option>
                                        <option value="32">(+32) Bélgica</option>
                                        <option value="501">(+501) Belice</option>
                                        <option value="229">(+229) Benín</option>
                                        <option value="375">(+375) Bielorrusia</option>
                                        <option value="95">(+95) Birmania/Myanmar</option>
                                        <option value="591">(+591) Bolivia</option>
                                        <option value="387">(+387) Bosnia y Herzegovina</option>
                                        <option value="267">(+267) Botsuana</option>
                                        <option value="55">(+55) Brasil</option>
                                        <option value="673">(+673) Brunéi</option>
                                        <option value="359">(+359) Bulgaria</option>
                                        <option value="226">(+226) Burkina Faso</option>
                                        <option value="257">(+257) Burundi </option>
                                        <option value="975">(+975) Bután</option>
                                        <option value="238">(+238) Cabo Verde</option>
                                        <option value="855">(+855) Camboya</option>
                                        <option value="237">(+237) Camerún</option>
                                        <option value="1">(+1) Canadá</option>
                                        <option value="974">(+974) Catar</option>
                                        <option value="235">(+235) Chad</option>
                                        <option value="56">(+56) Chile</option>
                                        <option value="86">(+86) China</option>
                                        <option value="357">(+357) Chipre</option>
                                        <option value="39">(+39) Ciudad del Vaticano</option>
                                        <option value="57">(+57) Colombia</option>
                                        <option value="269">(+269) Comoras</option>
                                        <option value="850">(+850) Corea del Norte</option>
                                        <option value="82">(+82) Corea del Sur</option>
                                        <option value="225">(+225) Costa de Marfil</option>
                                        <option value="506">(+506) Costa Rica</option>
                                        <option value="385">(+385) Croacia</option>
                                        <option value="53">(+53) Cuba</option>
                                        <option value="45">(+45) Dinamarca</option>
                                        <option value="1">(+1) Dominica</option>
                                        <option value="593">(+593) Ecuador</option>
                                        <option value="20">(+20) Egipto</option>
                                        <option value="503">(+503) El Salvador</option>
                                        <option value="971">(+971) Emiratos Árabes Unidos</option>
                                        <option value="291">(+291) Eritrea</option>
                                        <option value="421">(+421) Eslovaquia</option>
                                        <option value="386">(+386) Eslovenia</option>
                                        <option value="34">(+34) España</option>
                                        <option value="1">(+1) Estados Unidos</option>
                                        <option value="372">(+372) Estonia</option>
                                        <option value="251">(+251) Etiopía</option>
                                        <option value="63">(+63) Filipinas</option>
                                        <option value="358">(+358) Finlandia</option>
                                        <option value="679">(+679) Fiyi</option>
                                        <option value="33">(+33) Francia</option>
                                        <option value="241">(+241) Gabón</option>
                                        <option value="220">(+220) Gambia</option>
                                        <option value="995">(+995) Georgia</option>
                                        <option value="233">(+233) Ghana</option>
                                        <option value="1">(+1) Granada</option>
                                        <option value="30">(+30) Grecia</option>
                                        <option value="502">(+502) Guatemala</option>
                                        <option value="592">(+592) Guyana</option>
                                        <option value="224">(+224) Guinea </option>
                                        <option value="240">(+240) Guinea ecuatorial </option>
                                        <option value="245">(+245) Guinea-Bisáu </option>
                                        <option value="509">(+509) Haití </option>
                                        <option value="504">(+504) Honduras </option>
                                        <option value="36">(+36) Hungría </option>
                                        <option value="91">(+91) India </option>
                                        <option value="62">(+62) Indonesia </option>
                                        <option value="964">(+964) Irak </option>
                                        <option value="98">(+98) Irán </option>
                                        <option value="353">(+353) Irlanda </option>
                                        <option value="354">(+354) Islandia </option>
                                        <option value="692">(+692) Islas Marshall </option>
                                        <option value="677">(+677) Islas Salomón </option>
                                        <option value="972">(+972) Israel </option>
                                        <option value="39">(+39) Italia </option>
                                        <option value="1">(+1) Jamaica </option>
                                        <option value="81">(+81) Japón </option>
                                        <option value="962">(+962) Jordania </option>
                                        <option value="7">(+7) Kazajistán </option>
                                        <option value="254">(+254) Kenia </option>
                                        <option value="996">(+996) Kirguistán </option>
                                        <option value="686">(+686) Kiribati </option>
                                        <option value="965">(+965) Kuwait </option>
                                        <option value="856">(+856) Laos </option>
                                        <option value="266">(+266) Lesoto </option>
                                        <option value="371">(+371) Letonia </option>
                                        <option value="961">(+961) Líbano </option>
                                        <option value="231">(+231) Liberia </option>
                                        <option value="218">(+218) Libia </option>
                                        <option value="423">(+423) Liechtenstein </option>
                                        <option value="370">(+370) Lituania </option>
                                        <option value="352">(+352) Luxemburgo </option>
                                        <option value="389">(+389) Macedonia del Norte </option>
                                        <option value="261">(+261) Madagascar </option>
                                        <option value="60">(+60) Malasia </option>
                                        <option value="265">(+265) Malaui </option>
                                        <option value="960">(+960) Maldivas </option>
                                        <option value="223">(+223) Malí </option>
                                        <option value="356">(+356) Malta </option>
                                        <option value="212">(+212) Marruecos </option>
                                        <option value="230">(+230) Mauricio </option>
                                        <option value="222">(+222) Mauritania </option>
                                        <option value="52">(+52) México </option>
                                        <option value="691">(+691) Micronesia </option>
                                        <option value="373">(+373) Moldavia </option>
                                        <option value="377">(+377) Mónaco </option>
                                        <option value="976">(+976) Mongolia </option>
                                        <option value="382">(+382) Montenegro </option>
                                        <option value="258">(+258) Mozambique </option>
                                        <option value="264">(+264) Namibia </option>
                                        <option value="674">(+674) Nauru </option>
                                        <option value="977">(+977) Nepal </option>
                                        <option value="505">(+505) Nicaragua </option>
                                        <option value="227">(+227) Níger </option>
                                        <option value="234">(+234) Nigeria </option>
                                        <option value="47">(+47) Noruega </option>
                                        <option value="64">(+64) Nueva Zelanda </option>
                                        <option value="968">(+968) Omán </option>
                                        <option value="31">(+31) Países Bajos </option>
                                        <option value="92">(+92) Pakistán </option>
                                        <option value="680">(+680) Palaos </option>
                                        <option value="507">(+507) Panamá </option>
                                        <option value="675">(+675) Papúa Nueva Guinea </option>
                                        <option value="595">(+595) Paraguay </option>
                                        <option value="51">(+51) Perú </option>
                                        <option value="48">(+48) Polonia </option>
                                        <option value="351">(+351) Portugal </option>
                                        <option value="44">(+44) Reino Unido </option>
                                        <option value="236">(+236) República Centroafricana </option>
                                        <option value="420">(+420) República Checa </option>
                                        <option value="242">(+242) República del Congo </option>
                                        <option value="243">(+243) República Democrática del Congo </option>
                                        <option value="1">(+1) República Dominicana </option>
                                        <option value="27">(+27) República Sudafricana </option>
                                        <option value="250">(+250) Ruanda </option>
                                        <option value="40">(+40) Rumanía </option>
                                        <option value="7">(+7) Rusia </option>
                                        <option value="685">(+685) Samoa </option>
                                        <option value="1">(+1) San Cristóbal y Nieves </option>
                                        <option value="378">(+378) San Marino </option>
                                        <option value="1">(+1) San Vicente y las Granadinas </option>
                                        <option value="1">(+1) Santa Lucía </option>
                                        <option value="239">(+239) Santo Tomé y Príncipe </option>
                                        <option value="221">(+221) Senegal </option>
                                        <option value="381">(+381) Serbia </option>
                                        <option value="248">(+248) Seychelles </option>
                                        <option value="232">(+232) Sierra Leona </option>
                                        <option value="65">(+65) Singapur </option>
                                        <option value="963">(+963) Siria </option>
                                        <option value="252">(+252) Somalia </option>
                                        <option value="94">(+94) Sri Lanka </option>
                                        <option value="268">(+268) Suazilandia </option>
                                        <option value="249">(+249) Sudán </option>
                                        <option value="211">(+211) Sudán del Sur </option>
                                        <option value="46">(+46) Suecia </option>
                                        <option value="41">(+41) Suiza </option>
                                        <option value="597">(+597) Surinam </option>
                                        <option value="66">(+66) Tailandia </option>
                                        <option value="255">(+255) Tanzania </option>
                                        <option value="992">(+992) Tayikistán </option>
                                        <option value="670">(+670) Timor Oriental </option>
                                        <option value="228">(+228) Togo </option>
                                        <option value="676">(+676) Tonga </option>
                                        <option value="1">(+1) Trinidad y Tobago </option>
                                        <option value="216">(+216) Túnez </option>
                                        <option value="993">(+993) Turkmenistán </option>
                                        <option value="90">(+90) Turquía </option>
                                        <option value="688">(+688) Tuvalu </option>
                                        <option value="380">(+380) Ucrania </option>
                                        <option value="256">(+256) Uganda </option>
                                        <option value="598">(+598) Uruguay </option>
                                        <option value="998">(+998) Uzbekistán </option>
                                        <option value="678">(+678) Vanuatu </option>
                                        <option value="58">(+58) Venezuela </option>
                                        <option value="84">(+84) Vietnam </option>
                                        <option value="967">(+967) Yemen </option>
                                        <option value="253">(+253) Yibuti </option>
                                        <option value="260">(+260) Zambia </option>
                                        <option value="263">(+263) Zimbabue </option>
                                    </select>
                                    <input type="number" id="tel" placeholder="Nro de celular">
                                    <button id="cargar-perfil">Actualizar</button>
                                </form>
                                <form action="" method="POST">
                                    <h3>Cambiar contraseña</h3>
                                    <label>Contraseña actual</label>
                                    <input type="password" id="acon" placeholder="Ingresa contraseña actual">
                                    <label>Contraseña nueva</label>
                                    <input type="password" id="ncon" placeholder="Ingresa nueva contraseña">
                                    <button id="cambiar-password">Cambiar</button>
                                </form>
                                <form action="" method="POST">
                                    <h3>Agregar gametags</h3>
                                    <label>EA ID</label>
                                    <input type="text" id="eaid" value="<?php echo $c_rows[11]; ?>">
                                    <label>PSN ID</label>
                                    <input type="text" id="psnid" value="<?php echo $c_rows[12]; ?>">
                                    <label>XBOX ID</label>
                                    <input type="text" id="xboxid" value="<?php echo $c_rows[13]; ?>">
                                    <label>ACTIVISION ID</label>
                                    <input type="text" id="actid" value="<?php echo $c_rows[14]; ?>">
                                    <label>NBA ID</label>
                                    <input type="text" id="nbaid" value="<?php echo $c_rows[15]; ?>">
                                    <button id="cargar-id">Actualizar</button>
                                </form>
                                <form action="" method="POST">
                                    <h3>Agregar juegos disponibles</h3>
                                    <label>Juegos</label>
                                    <select id="juegoc" name="juegoc">
                        	<?php
                        				$juegosc = mysqli_query($conn, "SELECT * FROM juegos GROUP BY nombre ORDER BY nombre DESC");
                			?>
                						<option value="">Seleccionar</option>
                			<?php
                						while ($juegoscv = mysqli_fetch_row($juegosc)) {
                        	?>
                				        <option value="<?php echo $juegoscv[1]; ?>"><?php echo $juegoscv[1]; ?></option>
                		    <?php
                			        	}
                			?>
                				    </select>
                                    <button id="cargar-j">Cargar</button>
                                    <h2 style="width: 85%; border-bottom: .1rem solid #f2f2f2; float: left;"></h2>
                            <?php
                                $sqlc = mysqli_query($conn, "SELECT juegos FROM cuentas WHERE id_cuenta = '$id'");
                            	$sqlcv = $sqlc->fetch_row();
                                $juegoSj = $sqlcv[0];
                        	    $array = explode("/", $juegoSj);
                                $conteo = count($array); $contJ = 0;
                                while($contJ < $conteo){
                            ?>
                                    <div class="juegosS"><?php echo $array[$contJ]; ?> <a style="padding-left: .5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="rgba(0,0,0,1)"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM12 10.5858L14.8284 7.75736L16.2426 9.17157L13.4142 12L16.2426 14.8284L14.8284 16.2426L12 13.4142L9.17157 16.2426L7.75736 14.8284L10.5858 12L7.75736 9.17157L9.17157 7.75736L12 10.5858Z"></path></svg></a></div>
                            <?php
                                    $contJ = $contJ + 1;
                                }
                            ?>
                                </form>
                                <form action="" method="POST">
                                    <h3>Datos para retiros</h3>
                                    <label>Paypal <?php if($c_rows[16] !== ""){ echo "(".$c_rows[16].")"; } ?></label>
                                    <input type="text" id="paypal" placeholder="Tu correo de paypal">
                                    <button id="cargar-paypal">Actualizar</button>
                                </form>
    		                </div>
    		            </div>
    		        </div>
    		    </main>
        		<footer>
        		    <div id="f_logo">
        		        <img src="/img/Logo.png">
        		        <label>CSPORT</label>
        		        <span>© 2024 COP SPORT</span>
        		    </div>
        		    <div id="f_content">
        		        <content>
        		            <a href="/privacidad">Política de privacidad</a>
        		            <a href="/terminos">Términos y condiciones</a>
        		            <a href="/nosotros">Hable con nosotros</a>
        		            <a href="/ayuda">Centro de ayuda</a>
        		        </content>
        		        <content>
        		            <a href="/soporte">Soporte tecnico</a>
        		            <a></a>
        		            <a href="https://www.instagram.com/csport.es/" target="_blank" style="color: #000;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(0,0,0,1)"><path d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z"></path></svg> Instagram</a>
        		            <a href="" style="color: #000;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(0,0,0,1)"><path d="M13.001 19.9381C16.9473 19.446 20.001 16.0796 20.001 12C20.001 7.58172 16.4193 4 12.001 4C7.5827 4 4.00098 7.58172 4.00098 12C4.00098 16.0796 7.05467 19.446 11.001 19.9381V14H9.00098V12H11.001V10.3458C11.001 9.00855 11.1402 8.52362 11.4017 8.03473C11.6631 7.54584 12.0468 7.16216 12.5357 6.9007C12.9184 6.69604 13.3931 6.57252 14.2227 6.51954C14.5519 6.49851 14.9781 6.52533 15.501 6.6V8.5H15.001C14.0837 8.5 13.7052 8.54332 13.4789 8.66433C13.3386 8.73939 13.2404 8.83758 13.1653 8.97793C13.0443 9.20418 13.001 9.42853 13.001 10.3458V12H15.501L15.001 14H13.001V19.9381ZM12.001 22C6.47813 22 2.00098 17.5228 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22Z"></path></svg> Facebook</a>
        		            <div id="design"><svg style="float: left; margin-right: .25rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="14" height="14" fill="rgba(144,144,144,1)"><path d="M392.8 1.2c-17-4.9-34.7 5-39.6 22l-128 448c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l128-448c4.9-17-5-34.7-22-39.6zm80.6 120.1c-12.5 12.5-12.5 32.8 0 45.3L562.7 256l-89.4 89.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-112-112c-12.5-12.5-32.8-12.5-45.3 0zm-306.7 0c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l112 112c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256l89.4-89.4c12.5-12.5 12.5-32.8 0-45.3z"/></svg><a href="https://instagram.com/jean_bazan/" target="blank" style="text-decoration: none; color: #909090; font-size: .7rem;">Producido por @jean_bazan</a>
                            </div>
        		        </content>
        		    </div>
    		    </footer>
		</div>
<?php
	    }
	}
?>
	</div>
</body>
</html>
<script type="text/javascript">
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

    $('.cerrar-modal-msj').click(function(e) {
        window.location = "/perfil/<?php echo $id_cuenta;?>";
    });
    $('.cerrar-editor').click(function(e) {
        window.location = "/perfil/<?php echo $id_cuenta;?>&t";
    });
    $('#cargar-paypal').click(function(e) {
		e.preventDefault();
        
		var paypal = document.getElementById('paypal').value;

		var php = "paypal="+paypal;

		if (paypal == '') {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('cargar-paypal').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/subir_paypal.php?id=<?php echo $id; ?>',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "cambiado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Datos actualizados con exito";
				  	document.getElementById('paypal').value = "";
				  	document.getElementById('cargar-paypal').disabled = true;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 4000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
    $('#cargar-perfil').click(function(e) {
		e.preventDefault();
        
		var pais = document.getElementById('pais').value;
		var ciudad = document.getElementById('ciudad').value;
		var nac = document.getElementById('fdnac').value;
		var tel = document.getElementById('tel').value;
		var telc = document.getElementById('tel-c').value;
		var nyp = document.getElementById('nyp').value;

		var php = "pais="+pais+"&ciudad="+ciudad+"&nac="+nac+"&tel="+tel+"&telc="+telc+"&nyp="+nyp;

		if ((pais == '') && (ciudad == '') && (nac == '') && (telc == '') && (nyp == '')) {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('cargar-perfil').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/datos_p.php?id=<?php echo $id; ?>',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "cambiado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Datos actualizados con exito";
				  	document.getElementById('cargar-perfil').disabled = true;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 4000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
	$('#validar-code').click(function(e) {
		e.preventDefault();
        
		var code = document.getElementById('code').value;

		var php = "code="+code;

		if (code == '') {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes ingresar el codigo de 6 digitos";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('validar-code').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/validar.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "verificado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Verificado con exito";
				  	document.getElementById('code').value = "";
				  	document.getElementById('validar-code').disabled = true;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
						location.href = "/perfil/<?php echo $id; ?>";
					}, 4000);
				}
				if (res == "error") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Codigo no valido";
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
						document.getElementById('validar-code').disabled = false;
					}, 4000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
	$('#cambiar-password').click(function(e) {
		e.preventDefault();

		var acon = document.getElementById('acon').value;
		var ncon = document.getElementById('ncon').value;

		var php = "acon="+acon+"&ncon="+ncon+"&id="+<?php echo $c_rows[0]; ?>;

		if ((acon == null) && (ncon == null)) {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes completar el formulario";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('cambiar-password').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/cambiar_c.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "contraseña") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Contraseña actual incorrecta";
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
						document.getElementById('cambiar-password').disabled = false;
					}, 4000);
				}
				if (res == "cambiado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Contraseña actualizada";
				  	document.getElementById('acon').value = "";
					document.getElementById('ncon').value = "";
					document.getElementById('cambiar-password').disabled = true;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 4000);
				}
				
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
	$('#cargar-id').click(function(e) {
		e.preventDefault();

		var ea = document.getElementById('eaid').value;
		var psn = document.getElementById('psnid').value;
		var xbox = document.getElementById('xboxid').value;
		var act = document.getElementById('actid').value;
		var nba = document.getElementById('nbaid').value;

		var php = "ea="+ea+"&psn="+psn+"&xbox="+xbox+"&act="+act+"&nba="+nba;

		if ((ea == "") && (psn == "") && (xbox == "") && (act == "") && (nba == "")) {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes colocar una ID";
		  	
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('cargar-id').disabled = false;
			}, 4000);
		}else{
			$.ajax({
				url: '/bd/subir_id.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "cambiado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Registrado con exito";
				  	document.getElementById('eaid').value = "";
					document.getElementById('psnid').value = "";
					document.getElementById('xboxid').value = "";
					document.getElementById('cargar-id').disabled = true;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 4000);
				}
				
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
	$('#cargar-j').click(function(e) {
		e.preventDefault();
		var juego = document.getElementById('juegoc').value;
        document.getElementById('cargar-j').disabled = true;
		var php = "juego="+juego;

		if (juego == "") {
			document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "*Debes seleccionar un juego";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('cargar-j').disabled = false;
			}, 2000);
		}else{
			$.ajax({
				url: '/bd/cargar_j.php',
				type: 'POST',
				dataType: 'json',
				data: php,
			})
			.done(function(res) {
				if (res == "cambiado") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Juego agregado";
					document.getElementById('cargar-j').disabled = false;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 2000);
				}
				if (res == "existe") {
					document.getElementById("error").style.display = "block";
				  	document.getElementById("error").innerHTML = "Ya tenes este juego";
					document.getElementById('cargar-j').disabled = false;
					setTimeout(() => {
						document.getElementById("error").style.display = "none";
					}, 2000);
				}
			})
			.fail(function() {
			})
			.always(function() {
			});
		}
	});
    $('#btn-perfil').click(function(e) {
        document.getElementById('c-perfil').style.display = "block";
        document.getElementById('c-torneos').style.display = "none";
        document.getElementById('btn-perfil').classList.add('selected');
        document.getElementById('btn-torneos').classList.remove('selected');
        document.getElementById('btn-ajustes').classList.remove('selected');
        document.getElementById('c-ajustes').style.display = "none";
    });
    $('#btn-torneos').click(function(e) {
        document.getElementById('c-perfil').style.display = "none";
        document.getElementById('c-torneos').style.display = "block";
        document.getElementById('btn-perfil').classList.remove('selected');
        document.getElementById('btn-torneos').classList.add('selected');
        document.getElementById('btn-ajustes').classList.remove('selected');
        document.getElementById('c-ajustes').style.display = "none";
    });
    $('#btn-ajustes').click(function(e) {
        document.getElementById('c-perfil').style.display = "none";
        document.getElementById('c-ajustes').style.display = "block";
        document.getElementById('c-torneos').style.display = "none";
        document.getElementById('btn-perfil').classList.remove('selected');
        document.getElementById('btn-torneos').classList.remove('selected');
        document.getElementById('btn-ajustes').classList.add('selected');
    });
    <?php
        if ((isset($_GET['enviado'])) || (isset($_GET['no-enviado']))) {
            if(isset($_GET['enviado'])){
    ?>
                document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Codigo enviado a su email";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
				}, 4000);
	<?php
            }if(isset($_GET['no-enviado'])){
    ?>
                document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Error al enviar codigo";
			  	document.getElementById('code').value = "";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
				}, 4000);
	<?php 
            }
    ?>
        $(window).load(function(){
            document.getElementById('c-perfil').style.display = "none";
            document.getElementById('c-torneos').style.display = "none";
            document.getElementById('c-historial').style.display = "none";
            document.getElementById('btn-perfil').classList.remove('selected');
            document.getElementById('btn-torneos').classList.remove('selected');
            document.getElementById('btn-historial').classList.remove('selected');
            document.getElementById('btn-ajustes').classList.add('selected');
            document.getElementById('c-ajustes').style.display = "block";
        });
    <?php
        }
        if (!empty($_GET['e'])) {
    ?>
        $(window).load(function(){
            document.getElementById('c-perfil').style.display = "none";
            document.getElementById('c-torneos').style.display = "block";
            document.getElementById('c-historial').style.display = "none";
            document.getElementById('btn-perfil').classList.remove('selected');
            document.getElementById('btn-torneos').classList.add('selected');
            document.getElementById('btn-historial').classList.remove('selected');
            document.getElementById('btn-ajustes').classList.remove('selected');
            document.getElementById('c-ajustes').style.display = "none";
        });
    <?php
        }
        if (isset($_GET['t'])) {
    ?>
            $(window).load(function(){
                document.getElementById('c-perfil').style.display = "none";
                document.getElementById('c-torneos').style.display = "block";
                document.getElementById('c-historial').style.display = "none";
                document.getElementById('btn-perfil').classList.remove('selected');
                document.getElementById('btn-torneos').classList.add('selected');
                document.getElementById('btn-historial').classList.remove('selected');
                document.getElementById('btn-ajustes').classList.remove('selected');
                document.getElementById('c-ajustes').style.display = "none";
            });
    <?php
        }
        if(isset($_GET['error_ext'])){
    ?>
        document.getElementById("error").style.display = "block";
      	document.getElementById("error").innerHTML = "Extenciones validas (.jpg .png)";
    	setTimeout(() => {
    		document.getElementById("error").style.display = "none";
    	}, 4000);
    <?php
        }if(isset($_GET['error_img'])){
    ?>
        document.getElementById("error").style.display = "block";
      	document.getElementById("error").innerHTML = "Error al subir la imagen";
    	setTimeout(() => {
    		document.getElementById("error").style.display = "none";
    	}, 4000);
    <?php
        }
    ?>
	pantalla = window.innerHeight
	document.getElementById('pantalla').style.height = pantalla+'px';
</script>