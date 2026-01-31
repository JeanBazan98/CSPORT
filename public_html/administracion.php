<?php
	session_start();
	error_reporting(0);
	include_once 'bd/conexion.php';
	
	$id = $_SESSION['datos']['id'];
	$sqlid = mysqli_query($conn, "SELECT nombre,img FROM cuentas WHERE id_cuenta = '$id'");
	$sqlidv = $sqlid->fetch_row();
	
	#----- SECCION TORNEO
	
	$sqlrtt = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Torneo'");
    $sqlrtt = $sqlrtt->fetch_row();
	$sqlrtts = number_format($sqlrtt[0], 2, '.', ',');
	
	$sqlh_tstt = mysqli_query($conn, "SELECT id,price FROM torneos WHERE inscripcion = '1' ORDER BY id DESC");
    $schtt = 0;
    while ($sqlh_tsvttt = mysqli_fetch_row($sqlh_tstt)) {
    $sqlh_ttt = mysqli_query($conn, "SELECT id_rtorneos,id_torneo,id_cuenta,fecha FROM r_torneos WHERE id_torneo = '$sqlh_tsvttt[0]' ORDER BY id_torneo DESC");
    while ($sqlh_tvtt = mysqli_fetch_row($sqlh_ttt)) {
        $schtt = $schtt + 1;
    }}
	
	$sqlbsp = mysqli_query($conn, "SELECT COUNT(id_soporte) FROM soporte WHERE status = '0' AND adm = '0'");
    $sqlbvsp = $sqlbsp->fetch_row();
	$sqlb = mysqli_query($conn, "SELECT COUNT(id) FROM torneos WHERE formato = 'Liga' AND comienzo = '2'");
    $sqlbv = $sqlb->fetch_row();
    $sqlbd = mysqli_query($conn, "SELECT COUNT(id_desafio) FROM desafio WHERE status = '1' AND ganador = ''");
    $sqlbvd = $sqlbd->fetch_row();
    $sqlpc = mysqli_query($conn, "SELECT nombre,email,verificado,id_cuenta FROM cuentas WHERE verificado > '1'");
    
    $sqlpc2 = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE verificado > '1'");
    
    $sqlb2 = mysqli_query($conn, "SELECT id,formato FROM torneos WHERE comienzo = '2'");
    $juegos = mysqli_query($conn, "SELECT nombre FROM juegos GROUP BY nombre ORDER BY nombre DESC");
	$juegosv = mysqli_num_rows($juegos);
	$juegos2 = mysqli_query($conn, "SELECT img,nombre,tipo,id_juego FROM juegos ORDER BY id_juego DESC");
	
	$juegost = mysqli_query($conn, "SELECT id_juego FROM juegos ORDER BY id_juego DESC");
	$juegosti = mysqli_query($conn, "SELECT id_juego FROM juegos ORDER BY id_juego DESC");
	$juegosi = mysqli_query($conn, "SELECT id_juego FROM juegos ORDER BY id_juego DESC");
	$juegose = mysqli_query($conn, "SELECT id_juego FROM juegos ORDER BY id_juego DESC");
	
	$publicidad = mysqli_query($conn, "SELECT id_pub FROM publicidad");
	$publicidadv = mysqli_num_rows($publicidad);
	$publicidad2 = mysqli_query($conn, "SELECT id_pub,img,link FROM publicidad");
	
	$publicidadl = mysqli_query($conn, "SELECT id_pub FROM publicidad");
	$publicidadi = mysqli_query($conn, "SELECT id_pub FROM publicidad");
	$publicidade = mysqli_query($conn, "SELECT id_pub FROM publicidad");
	
	$sqltt = mysqli_query($conn, "SELECT COUNT(id) FROM torneos");
    $sqlttv = $sqltt->fetch_row();
    
    $sqlpt = mysqli_query($conn, "SELECT COUNT(id_rtorneos) FROM r_torneos");
    $sqlptv = $sqlpt->fetch_row();
    
    $auditarT = array();
    $contT = 0;
    while ($rows = mysqli_fetch_row($sqlb2)) {
        if($rows[1] == "Liga"){
            if(($rows[0] !== "") && ($rows[0] !== null)){
                array_push($auditarT, $rows[0]);
            }
        }else{
            $sqlb2a = mysqli_query($conn, "SELECT id_tabla,id_torneo FROM tablas WHERE id_torneo = '$rows[0]' AND ganador = '1'");
            $sqlbv2a = $sqlb2a->fetch_row();
            if(($sqlbv2a[0] !== "") && ($sqlbv2a[0] !== null)){ $contT = $contT + 1; array_push($auditarT, $rows[0]); }
        }
    }
    $tauditar = $sqlbv[0] + $contT;
    $tdesafio = $sqlbvd[0];
    
    $sqlrt = mysqli_query($conn, "SELECT COUNT(id_transaccion) FROM wallet_t WHERE tipo = 'Retiro' AND status = 'WAIT'");
    $sqlrtv = $sqlrt->fetch_row();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/administracion.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Administracion - Csport</title>
</head>
<body>
<?php
    $cverif = mysqli_query($conn, "SELECT * FROM cuentas WHERE id_cuenta = '$id'");
    $cverifv = $cverif->fetch_row();
    
    if($cverifv[4] > 2){
?>
    <div id="pantalla"><span id="error"></span>
<?php
    if (isset($_GET['s'])) {
        $id_t = $_GET['s'];
        $sqlrs = mysqli_query($conn, "SELECT c.nombre,w.saldo,w.metodo,w.email,c.pais_ciudad,c.telefono,c.nyp FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.id_transaccion = '$id_t'");
        $sqlrsv = $sqlrs->fetch_row();
        $saldor = number_format( $sqlrsv[1], 2, '.', ',');
?>
        <input type="checkbox" id="btn-modal-s">
		<div class="container-modal-s">
	        <div class="content-modal-s">
	            <h1>Solicitud de retiro <h1 style="color: #4d4d4d; font-size: 1.2rem; margin-top: .6rem; margin-left: .5rem;">(<?php echo $sqlrsv[0]; ?>)</h1></h1>
	            <div style="margin-left: .5rem;">
    	            <label>Metodo de retiro</label>
    	            <span><?php echo $sqlrsv[2]; ?></span>
    	            <label>Datos</label>
    	            <span>Nombre completo:</span>
    	            <p><?php echo $sqlrsv[6]; ?></p>
    	            <label></label>
    	            <span>Email de paypal:</span>
    	            <p><?php echo $sqlrsv[3]; ?></p>
    	            <label></label>
    	            <span>Telefono:</span>
    	            <p><?php echo $sqlrsv[5]; ?></p>
    	            <label></label>
    	            <span>Cantidad a retirar:</span>
    	            <p>$<?php echo $saldor; ?></p>
    	            <form>
    	            <a id="r-transferido">Transferido</a>
    	            </form>
	            </div>
	        </div>
	        <label for="btn-modal-s" class="cerrar-modal-s"></label>
	    </div>
<?php
    }
    if (isset($_GET['l'])) {
        $id_t = $_GET['l'];
        $sqlrs = mysqli_query($conn, "SELECT titulo FROM equipos_t WHERE id = '$id_t'");
        $sqlrsv = $sqlrs->fetch_row();
        $sqlec2 = mysqli_query($conn, "SELECT COUNT(id_equipo) FROM equipos WHERE titulo = '$id_t'");
        $sqlec2 = $sqlec2->fetch_row();
        $sqlec3 = mysqli_query($conn, "SELECT id_equipo,img,nombre FROM equipos WHERE titulo = '$id_t'");
        
?>
        <input type="checkbox" id="btn-modal-l">
		<div class="container-modal-l">
	        <div class="content-modal-l">
	            <h1><?php echo $sqlrsv[0]; ?> <h1 style="color: #4d4d4d; font-size: 1.2rem; margin-top: .6rem; margin-left: .5rem;">(<?php echo $sqlec2[0]; ?>)</h1></h1>
	            <div style="margin-left: .5rem;">
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Escudo</th>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
        <?php
                        while ($sqlec3v = mysqli_fetch_row($sqlec3)) {
        ?>
                            <tr>
                                <td><img id="img-el" src="/<?php echo $sqlec3v[1]; ?>"></td>
                                <td><?php echo $sqlec3v[2]; ?></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M20 3C20.5523 3 21 3.44772 21 4V5.757L19 7.757V5H5V13.1L9 9.1005L13.328 13.429L12.0012 14.7562L11.995 18.995L16.2414 19.0012L17.571 17.671L18.8995 19H19V16.242L21 14.242V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H20ZM21.7782 7.80761L23.1924 9.22183L15.4142 17L13.9979 16.9979L14 15.5858L21.7782 7.80761ZM15.5 7C16.3284 7 17 7.67157 17 8.5C17 9.32843 16.3284 10 15.5 10C14.6716 10 14 9.32843 14 8.5C14 7.67157 14.6716 7 15.5 7Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Subir nuevo escudo?</p>
                                        <form>
                                            <input id="pid<?php echo $rowsP; ?>" value="<?php echo $sqlapv[3]; ?>" style="display: none;">
                                            <input type="file" class="dropdown-input">
                                            <button id="c_rol<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M16.7574 2.99677L9.29145 10.4627L9.29886 14.7098L13.537 14.7024L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar nombre?</p>
                                        <form>
                                            <input id="pid<?php echo $rowsP; ?>" value="<?php echo $sqlapv[3]; ?>" style="display: none;">
                                            <input type="text" class="dropdown-input">
                                            <button id="c_rol<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-l" class="cerrar-modal-l"></label>
	    </div>
<?php
    }
?>
        <input type="checkbox" id="btn-modal-bonos">
		<div class="container-modal-bonos">
	        <div class="content-modal-bonos">
	            <h1>Administrar bonos</h1><p style="margin-top: -.5rem; margin-left: .5rem; cursor: pointer; display: flex; text-align: center; align-items: center;"><svg style="margin-right: .25rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="rgba(38,38,38,1)"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg> Ver todos los bonos</p>
	            <form>
	                <div id="ab-part1">
    	                <label>Evento</label>
    	                <input id="b_evento" type="text">
    	                <label>Titulo</label>
    	                <input id="b_titulo" type="text">
    	                <label>Tipo de bono</label>
    	                <select id="b_tipob">
    	                    <option value="recarga">Recarga</option>
    	                    <option value="saldo">Saldo</option>
    	                </select>
    	                <script type="text/javascript">
    	            		$('#b_tipob').click(function(e) {
    	            			var formato = document.getElementById('b_tipob').value;
    							
    	            			if (formato == 'recarga') {
    	            				document.getElementById('b_tipobt').innerHTML = "Porcentaje de recarga";
    	            			}
    		            		if (formato == 'saldo') {
    		            		    document.getElementById('b_tipobt').innerHTML = "Cantidad de saldo";
    		            		}
    		            	});
    	            	</script>
	                </div>
	                <div id="ab-part2">
    	                <label id="b_tipobt">Porcentaje de recarga</label>
    	                <input id="b_nro" type="num">
    	                <label>Tipo de publico</label>
    	                <select id="b_tipop">
    	                    <option value="todos">Todos</option>
    	                    <option value="activo">Mas activos</option>
    	                    <option value="nvl4">Nvl 4</option>
    	                    <option value="nvl3">Nvl 3</option>
    	                    <option value="nvl2">Nvl 2</option>
    	                    <option value="nvl1">Nvl 1</option>
    	                </select>
    	                <label>Tiempo del bono</label>
    	                <select id="b_tiempo">
    	                    <option value="0">Con expiracion</option>
    	                    <option value="1">Sin expiracion</option>
    	                </select>
    	                <script type="text/javascript">
    	            		$('#b_tiempo').click(function(e) {
    	            			var formato = document.getElementById('b_tiempo').value;
    							
    	            			if (formato == '0') {
    	            				document.getElementById("ab-part3d").style.display = "block";
    	            			}
    		            		if (formato == '1') {
    		            		    document.getElementById("ab-part3d").style.display = "none";
    		            		}
    		            	});
    	            	</script>
	                </div>
	                <div id="ab-part3">
	                    <div id="ab-part3d">
    	                <label>Fecha de expiracion</label>
    	                <input id="b_fechae" type="date">
    	                </div>
    	            </div>
    	            <button id="btn-bono">Cargar bono</button>
	            </form>
	        </div>
	        <label for="btn-modal-bonos" class="cerrar-modal-bonos"></label>
	    </div>

        <input type="checkbox" id="btn-modal-aggb">
		<div class="container-modal-aggb">
	        <div class="content-modal-aggb">
	            <h1>Cargar/Restar balance</h1>
	            <span id="errorsl"></span>
	            <form id="formdp">
        			<label>Email del usuario</label>
	            	<input type="text" name="emailsl" id="emailsl">
        			<button name="cargarsl" id="cargarsl">Buscar</button>
	            </form>
	            <form id="formdp2" style="display: none;">
	                <label id="emaildp"></label>
	                <input type="text" name="idsl" id="idsl" style="display: none;">
	                <label>Saldo</label>
	            	<input type="number" name="saldosl" id="saldosl">
	            	<label>Nro de orden</label>
	            	<input type="text" name="ordensl" id="ordensl">
	            	<label>Tipo de transsacion</label>
	            	<select name="transl" id="transl">
	            	    <option value="">Seleccionar tipo</option>
	            	    <option value="d/Yape">Deposito - Yape!</option>
	            	    <option value="d/Paypal">Deposito - Paypal</option>
	            	</select>
        			<button name="cargarsl2" id="cargarsl2">Cargar</button>
	            </form>
	        </div>
	        <label for="btn-modal-aggb" class="cerrar-modal-aggb"></label>
	    </div>
        
        <input type="checkbox" id="btn-modal-liga">
		<div class="container-modal-liga">
	        <div class="content-modal-liga">
	            <h1>Cargar equipos / ligas</h1>
	            <span id="error2"></span>
	            <form name="formulario_sl" action="/bd/subir_e2.php" method="POST" enctype="multipart/form-data">
        			<label>Cargar nombre de la Liga</label>
	            	<input type="text" name="nombree" id="nombree" required>
        			<button name="subir_equipo" id="subir_equipo">Subir</button>
	            </form>
	            <p style="margin-bottom: 1.5rem; border-bottom: 1px solid #262626; float: left; width: 80%; margin-left: 10%;"></p>
	            <form name="formulario_s" action="/bd/subir_e.php" method="POST" enctype="multipart/form-data">
        			<select name="tituloe" id="tituloe">
        			    <?php
        			        $etsel = "SELECT * FROM equipos_t WHERE id > 0";
        			        $etselr = $conn->query($etsel);
        			        
        			        while($etselv = mysqli_fetch_row($etselr)){
        			    ?>
        			        <option value="<?php echo $etselv[0]; ?>"><?php echo $etselv[1]; ?></option>
        			    <?php
        			        }
        			    ?>
        			</select>
        			<label>Nombre del equipo</label>
	            	<input type="text" name="nombree" id="nombree" required>
	            	<label>Cuadro del equipo</label>
	            	<input type="file" name="imagene" id="imagene" required>
        			<button name="subir_equipo" id="subir_equipo">Subir</button>
	            </form>
	        </div>
	        <label for="btn-modal-liga" class="cerrar-modal-liga"></label>
	        <script type="text/javascript">
        		$('#subir_equipo').click(function(){
        		    setInterval(function(){
        		        document.getElementById('actualizar_pbtn').disabled = true;
        			}, 100);
				});
        	</script>
	    </div>
	    <input type="checkbox" id="btn-modal-torneo">
		<div class="container-modal-torneo">
	        <div class="content-modal-torneo">
	            <div>
    	            <h1>Torneos para auditar</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Titulo</th>
                                <th>Organizador</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Auditar</th>
                            </tr>
        <?php
                        $rowsA = 0;
                        while ($rowsA < $tauditar) {
                            $sqlAtr = mysqli_query($conn, "SELECT t.titulo,c.nombre,t.fecha,t.inscripcion FROM torneos t JOIN cuentas c ON t.id_cuenta = c.id_cuenta WHERE id = '$auditarT[$rowsA]'");
                            $sqlAtrv = $sqlAtr->fetch_row();
                            if($sqlAtrv[3] == 0){
                                $inscT = "Gratis";
                            }if($sqlAtrv[3] == 1){
                                $inscT = "Inscripcion";
                            }if($sqlAtrv[3] == 2){
                                $inscT = "Privado";
                            }if($sqlAtrv[3] == 3){
                                $inscT = "Gratis + Premio";
                            }if($sqlAtrv[3] == 4){
                                $inscT = "Privado + Premio";
                            }
        ?>
                            <tr>
                                <td><?php echo $sqlAtrv[0]; ?></td>
                                <td><?php echo $sqlAtrv[1]; ?></td>
                                <td><?php echo $inscT; ?></td>
                                <td><?php echo $sqlAtrv[2]; ?></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Auditar?</p>
                                        <a href="/bd/auditar_c?t=<?php echo $auditarT[$rowsA]; ?>" class="dropdown-a">Confirmar</a>
                                    </div>
                                </td>
                            </tr>
        <?php
                            $rowsA = $rowsA + 1;
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-torneo" class="cerrar-modal-torneo"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-desafio">
		<div class="container-modal-desafio">
	        <div class="content-modal-desafio">
	            <div>
    	            <h1>Desafios para auditar</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_desafio</th>
                                <th>Creador</th>
                                <th>Desafiante</th>
                                <th>Premio</th>
                                <th>Auditar</th>
                            </tr>
        <?php
                        $sqlda = mysqli_query($conn, "SELECT id_desafio,id_cuenta,id_visitante,premio FROM desafio WHERE auditado = '0' ORDER BY id_desafio DESC");
                        while ($sqldav = mysqli_fetch_row($sqlda)) {
                            $sqldan1 = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqldav[1]'");
                            $sqldan1v = $sqldan1->fetch_row();
                            $sqldan2 = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqldav[2]'");
                            $sqldan2v = $sqldan2->fetch_row();
        ?>
                            <tr>
                                <td><?php echo $sqldav[0]; ?></td>
                                <td><?php echo $sqldan1v[0]; ?></td>
                                <td><?php echo $sqldan2v[0]; ?></td>
                                <td>$<?php echo $sqldav[3]; ?></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Auditar?</p>
                                        <a href="/bd/auditar_d?d=<?php echo $sqldav[0]; ?>" class="dropdown-a">Confirmar</a>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-desafio" class="cerrar-modal-desafio"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-retiros">
		<div class="container-modal-retiros">
	        <div class="content-modal-retiros">
	            <div>
    	            <h1>Solicitud de retiro</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Email</th>
                                <th>Retiro</th>
                                <th>Metodo</th>
                                <th>Fecha</th>
                            </tr>
        <?php
                        $sqlrtw = mysqli_query($conn, "SELECT * FROM wallet_t WHERE tipo = 'Retiro' AND status = 'WAIT'");
                        while ($sqlrtwv = mysqli_fetch_row($sqlrtw)) {
                            
                            $s_walletrp = number_format( $sqlrtwv[3], 2, '.', ',');
        ?>
                            <tr>
                                <td><?php echo $sqlrtwv[6]; ?></td>
                                <td>$<?php echo $s_walletrp; ?></td>
                                <td><?php echo $sqlrtwv[4]; ?></td>
                                <td><?php echo $sqlrtwv[8]; ?></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <a href="/administracion?s=<?php echo $sqlrtwv[0]; ?>" class="dropdown-a">Confirmar</a>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-retiros" class="cerrar-modal-retiros"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-soporte">
		<div class="container-modal-soporte">
	        <div class="content-modal-soporte">
	            <div>
    	            <h1>Tickets</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_soporte</th>
                                <th>Id_cuenta</th>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                                <th>Fecha</th>
                            </tr>
        <?php
                        $sqlrtw = mysqli_query($conn, "SELECT * FROM soporte WHERE status = '0' AND adm = '0'");
                        while ($sqlrtwv = mysqli_fetch_row($sqlrtw)) {
                            if($sqlrtwv[2] == "Olvidaste"){
                                $tiposp = "Dirección de correo electrónico";
                            }if($sqlrtwv[2] == "Conoces"){
                                $tiposp = "No puedo entrar a mi cuenta";
                            }if($sqlrtwv[2] == "Persona"){
                                $tiposp = "Otra persona usa mi cuenta";
                            }
        ?>
                            <tr>
                                <td><?php echo $sqlrtwv[0]; ?></td>
                                <td><?php echo $sqlrtwv[1]; ?></td>
                                <td><?php echo $tiposp; ?></td>
                                <td><?php echo $sqlrtwv[3]; ?></td>
                                <td><?php echo $sqlrtwv[4]; ?></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Reclamar ticket?</p>
                                        <a href="/ticket?id=<?php echo $sqlrtwv[0]; ?>&r=<?php echo $id; ?>" class="dropdown-a">Confirmar</a>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-soporte" class="cerrar-modal-soporte"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-personal">
		<div class="container-modal-personal">
	        <div id="content-personal" class="content-modal-personal">
	            <div>
    	            <h1>Administrar personal</h1>
    	            <form id="agregarpf">
    	                <input id="paemail" type="text" placeholder="Ingrese un email">
    	                <label>Seleccione un rol</label>
    	                <select id="parol">
    	                    <option value="2">Organizador</option>
    	                    <option value="3">Auditor</option>
    	                    <option value="4">Administrador</option>
    	                </select>
    	                <button id="btn-pa">Agregar</button>
    	            </form>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
        <?php
                        $rowsP = 0;
                        while ($sqlapv = mysqli_fetch_row($sqlpc)) {
                            $rowsP = $rowsP + 1;
                            if($sqlapv[2] == 2){
                                $rol = "Organizador";
                            }if($sqlapv[2] == 3){
                                $rol = "Auditor";
                            }if($sqlapv[2] == 4){
                                $rol = "Administrador";
                            }
        ?>
                            <tr>
                                <td><?php echo $sqlapv[0]; ?></td>
                                <td><?php echo $sqlapv[1]; ?></td>
                                <td><p id="rolca<?php echo $rowsP; ?>"><?php echo $rol; ?></p></td>
                                <td class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l293.1 0c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1l-91.4 0zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z"/></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar rango?</p>
                                        <form>
                                            <input id="pid<?php echo $rowsP; ?>" value="<?php echo $sqlapv[3]; ?>" style="display: none;">
                                            <select id="prol<?php echo $rowsP; ?>" class="dropdown-select">
                                                <option value="1">Sin rango</option>
                                                <option value="2">Organizador</option>
                                                <option value="3">Auditor</option>
                                                <option value="4">Administrador</option>
                                            </select>
                                            <button id="c_rol<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-personal" class="cerrar-modal-personal"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-juegos">
		<div class="container-modal-juegos">
	        <div class="content-modal-juegos">
	            <div>
    	            <h1>Administrar juegos</h1>
    	            <form id="agregarpf" name="formulario_s" action="/bd/subir_j.php" method="POST" enctype="multipart/form-data">
    	            	<label>Titulo</label>
    	            	<input type="text" name="titulo2" id="titulo2" placeholder="Titulo del juego" required>
    	            	<input type="file" name="imagen2" id="imagen2" required>
    	            	<select id="plataforma2" name="plataforma" required>
    				    	<option value="OTROS">OTROS</option>
    				        <option value="NEXT GENT">NEXT GENT</option>
    				    	<option value="OLD GENT">OLD GENT</option>
    				    </select>
    				    <button name="subir_juego" id="subir_juego">Subir</button>
    	            </form>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Img</th>
                                <th>Titulo</th>
                                <th>Tipo</th>
                            </tr>
        <?php
                        $rowsP = 0;
                        while ($juegos2v = mysqli_fetch_row($juegos2)) {
                        $rowsP = $rowsP + 1;
        ?>
                            <tr>
                                <input id="cid<?php echo $rowsP; ?>" value="<?php echo $juegos2v[3]; ?>" style="display: none;">
                                <td style="height: 2.25rem;"><img id="img-j" src="<?php echo $juegos2v[0]; ?>"></td>
                                <td style="height: 2.25rem;"><?php echo $juegos2v[1]; ?></td>
                                <td style="height: 2.25rem;"><?php echo $juegos2v[2]; ?></td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M16.7574 2.99677L9.29145 10.4627L9.29886 14.7098L13.537 14.7024L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar titulo?</p>
                                        <form>
                                            <input class="dropdown-input" type="text" id="c_tj<?php echo $rowsP; ?>" placeholder="Cambiar titulo">
                                            <button id="btn_ctj<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M16.7574 2.99677L9.29145 10.4627L9.29886 14.7098L13.537 14.7024L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar tipo?</p>
                                        <form>
                                            <select id="c_tij<?php echo $rowsP; ?>">
                        				    	<option value="OTROS">OTROS</option>
                        				        <option value="NEXT GENT">NEXT GENT</option>
                        				    	<option value="OLD GENT">OLD GENT</option>
                        				    </select>
                                            <button id="btn_ctij<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M20 3C20.5523 3 21 3.44772 21 4V5.757L19 7.757V5H5V13.1L9 9.1005L13.328 13.429L12.0012 14.7562L11.995 18.995L16.2414 19.0012L17.571 17.671L18.8995 19H19V16.242L21 14.242V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H20ZM21.7782 7.80761L23.1924 9.22183L15.4142 17L13.9979 16.9979L14 15.5858L21.7782 7.80761ZM15.5 7C16.3284 7 17 7.67157 17 8.5C17 9.32843 16.3284 10 15.5 10C14.6716 10 14 9.32843 14 8.5C14 7.67157 14.6716 7 15.5 7Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar imagen?</p>
                                        <form>
                                            <input class="dropdown-input" type="file" id="c_ij<?php echo $rowsP; ?>" placeholder="Cambiar img">
                                            <button id="btn_cij<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Eliminar?</p>
                                        <form>
                                            <button id="btn_ej<?php echo $rowsP; ?>" class="dropdown-ap">Confirmar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-juegos" class="cerrar-modal-juegos"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-pub">
		<div class="container-modal-pub">
	        <div class="content-modal-pub">
	            <div>
    	            <h1>Administrar publicidades</h1>
    	            <form id="agregarpf" action="/bd/subir_pub.php" method="POST" enctype="multipart/form-data">
    	                <label>Banner</label>
    	                <input type="file" name="imagen">
    	                <label>Link</label>
    	                <input type="text" name="link" placeholder="Ej: https://csport.es/torneo/1">
    	                <button id="actualizar_pbtn">Subir</button>
    	            </form>
    	            <script type="text/javascript">
                		$('#actualizar_pbtn').click(function(){
                		    setInterval(function(){
                		        document.getElementById('actualizar_pbtn').disabled = true;
                			}, 100);
        				});
                	</script>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Img</th>
                                <th>Link</th>
                            </tr>
        <?php
                        $rowsP = 0;
                        while ($publicidad2v = mysqli_fetch_row($publicidad2)) {
                            $rowsP = $rowsP + 1;
        ?>
                            <input id="pubid<?php echo $rowsP; ?>" value="<?php echo $publicidad2v[0]; ?>" style="display: none;">
                            <tr>
                                <td style="height: 2.25rem;"><img id="img-p" src="<?php echo $publicidad2v[1]; ?>"></td>
                                <td style="height: 2.25rem;"><?php echo $publicidad2v[2]; ?></td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M20 3C20.5523 3 21 3.44772 21 4V5.757L19 7.757V5H5V13.1L9 9.1005L13.328 13.429L12.0012 14.7562L11.995 18.995L16.2414 19.0012L17.571 17.671L18.8995 19H19V16.242L21 14.242V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H20ZM21.7782 7.80761L23.1924 9.22183L15.4142 17L13.9979 16.9979L14 15.5858L21.7782 7.80761ZM15.5 7C16.3284 7 17 7.67157 17 8.5C17 9.32843 16.3284 10 15.5 10C14.6716 10 14 9.32843 14 8.5C14 7.67157 14.6716 7 15.5 7Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar banner?</p>
                                        <form>
                                            <input class="dropdown-input" type="file" id="pubi<?php echo $rowsP; ?>" placeholder="Cambiar img">
                                            <button id="btn_pubi<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M16.7574 2.99677L9.29145 10.4627L9.29886 14.7098L13.537 14.7024L21 7.23941V19.9968C21 20.5491 20.5523 20.9968 20 20.9968H4C3.44772 20.9968 3 20.5491 3 19.9968V3.99677C3 3.44448 3.44772 2.99677 4 2.99677H16.7574ZM20.4853 2.09727L21.8995 3.51149L12.7071 12.7039L11.2954 12.7063L11.2929 11.2897L20.4853 2.09727Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Cambiar link?</p>
                                        <form>
                                            <input class="dropdown-input" type="text" id="publ<?php echo $rowsP; ?>" placeholder="Cambiar link">
                                            <button id="btn_publ<?php echo $rowsP; ?>" class="dropdown-ap">Cambiar</button>
                                        </form>
                                    </div>
                                </td>
                                <td style="height: 2.25rem;" class="dropdown">
                                    <a>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z"></path></svg>
                                    </a>
                                    <div class="dropdown-content">
                                        <p>¿Eliminar?</p>
                                        <form>
                                            <button id="btn_pubd<?php echo $rowsP; ?>" class="dropdown-ap">Confirmar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-pub" class="cerrar-modal-pub"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-actuser">
		<div class="container-modal-actuser">
	        <div id="content-actuser" class="content-modal-actuser">
	            <div>
    	            <h1>Actividad de los usuarios <span id="actti">(Total)</span></h1>
    	            <h3 id="act-ut" class="acta">Total</h3><h3 id="act-ud">Diario</h3><h3 id="act-us">Semanal</h3><h3 id="act-um">Mensual</h3>
    	            <div id="tabla-users-r">
                        <table id="act-utt" style="display: block;">
                            <tr>
                                <th>Id_usuario</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Conexion</th>
                                <th>Dispositivo</th>
                                <th>IP</th>
                            </tr>
        <?php
            $sql2u = mysqli_query($conn, "SELECT c.id_cuenta,c.nombre,c.email,a.inicio,a.tipo,a.ip FROM cuentas c JOIN actividad a ON c.id_cuenta = a.id_cuenta ORDER BY a.id_actividad DESC");
                        while ($sql2uv = mysqli_fetch_row($sql2u)) {
        ?>
                            <tr>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $sql2uv[2]; ?></td>
                                <td><?php echo $sql2uv[3]; ?></td>
                                <td><?php echo $sql2uv[4]; ?></td>
                                <td><?php echo $sql2uv[5]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
                        <table id="act-utd" style="display: none;">
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Conexiones diaria</th>
                                <th>Dispositivo</th>
                            </tr>
        <?php
            $sql2u = mysqli_query($conn, "SELECT c.id_cuenta,c.nombre FROM cuentas c JOIN actividad a ON c.id_cuenta = a.id_cuenta GROUP BY a.id_cuenta DESC");
                        while ($sql2uv = mysqli_fetch_row($sql2u)) {
                            $sqlia = mysqli_query($conn, "SELECT inicio,tipo FROM actividad WHERE id_cuenta = '$sql2uv[0]'");
                            $condc = 0; $condp = 0; $confd = 0;
                            $fechaActd = new DateTime();
                            while ($sqliav = mysqli_fetch_row($sqlia)) {
                                $cond = $sqliav[0];
                                $fechacd = new DateTime($cond);
                                $difcd = $fechaActd->diff($fechacd);
                                if(($difcd->d <= 0) && ($difcd->m <= 0)){
                                    $confd = $confd + 1;
                                    if($sqliav[1] == "PC"){
                                        $condp = $condp + 1;
                                    }else{
                                        $condc = $condc + 1;
                                    }
                                }
                            }
        ?>
                            <tr>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $confd; ?></td>
                                <td><?php echo "PC: ".$condp." | CELULAR:".$condc; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
                        <table id="act-uts" style="display: none;">
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Conexiones semanal</th>
                                <th>Dispositivo</th>
                            </tr>
        <?php
            $sql2u = mysqli_query($conn, "SELECT c.id_cuenta,c.nombre FROM cuentas c JOIN actividad a ON c.id_cuenta = a.id_cuenta GROUP BY a.id_cuenta DESC");
                        while ($sql2uv = mysqli_fetch_row($sql2u)) {
                            $sqlia = mysqli_query($conn, "SELECT inicio,tipo FROM actividad WHERE id_cuenta = '$sql2uv[0]'");
                            $condc = 0; $condp = 0; $confd = 0;
                            $fechaActd = new DateTime();
                            while ($sqliav = mysqli_fetch_row($sqlia)) {
                                $cond = $sqliav[0];
                                $fechacd = new DateTime($cond);
                                $difcd = $fechaActd->diff($fechacd);
                                if(($difcd->d <= 7) && ($difcd->m == 0)){
                                    $confd = $confd + 1;
                                    if($sqliav[1] == "PC"){
                                        $condp = $condp + 1;
                                    }else{
                                        $condc = $condc + 1;
                                    }
                                }
                            }
        ?>
                            <tr>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $confd; ?></td>
                                <td><?php echo "PC: ".$condp." | CELULAR:".$condc; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
                        <table id="act-utm" style="display: none;">
                            <tr>
                                <th>Id</th>
                                <th>Usuario</th>
                                <th>Conexiones mensual</th>
                                <th>Dispositivo</th>
                            </tr>
        <?php
            $sql2u = mysqli_query($conn, "SELECT c.id_cuenta,c.nombre FROM cuentas c JOIN actividad a ON c.id_cuenta = a.id_cuenta GROUP BY a.id_cuenta DESC");
                        while ($sql2uv = mysqli_fetch_row($sql2u)) {
                            $sqlia = mysqli_query($conn, "SELECT inicio,tipo FROM actividad WHERE id_cuenta = '$sql2uv[0]'");
                            $condc = 0; $condp = 0; $confd = 0;
                            $fechaActd = new DateTime();
                            while ($sqliav = mysqli_fetch_row($sqlia)) {
                                $cond = $sqliav[0];
                                $fechacd = new DateTime($cond);
                                $difcd = $fechaActd->diff($fechacd);
                                if(($difcd->d <= 30) && ($difcd->m <= 0)){
                                    $confd = $confd + 1;
                                    if($sqliav[1] == "PC"){
                                        $condp = $condp + 1;
                                    }else{
                                        $condc = $condc + 1;
                                    }
                                }
                            }
        ?>
                            <tr>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $confd; ?></td>
                                <td><?php echo "PC: ".$condp." | CELULAR:".$condc; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-actuser" class="cerrar-modal-actuser"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-userv">
		<div class="container-modal-userv">
	        <div id="content-userv" class="content-modal-userv">
	            <div>
    	            <h1>Usuarios verificados</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_usuario</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Nombre y apellido</th>
                                <th>Telefono</th>
                                <th>Pais/Ciudad</th>
                            </tr>
        <?php
            $sql2u = mysqli_query($conn, "SELECT nombre,email,nyp,telefono,pais_ciudad,id_cuenta FROM cuentas WHERE email != '#ID' AND verificado > '0' ORDER BY id_cuenta DESC");
                        while ($sql2uv = mysqli_fetch_row($sql2u)) {
        ?>
                            <tr>
                                <td><?php echo $sql2uv[5]; ?></td>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $sql2uv[2]; ?></td>
                                <td><?php echo $sql2uv[3]; ?></td>
                                <td><?php echo $sql2uv[4]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-userv" class="cerrar-modal-userv"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-usernv">
	    <div class="container-modal-usernv">
	        <div id="content-usernv" class="content-modal-usernv">
	            <div>
    	            <h1>Usuarios no verificados</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_usuario</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Nombre y apellido</th>
                                <th>Telefono</th>
                                <th>Pais/Ciudad</th>
                            </tr>
        <?php
            $sql2un = mysqli_query($conn, "SELECT nombre,email,nyp,telefono,pais_ciudad,id_cuenta FROM cuentas WHERE email != '#ID' AND verificado = '0' ORDER BY id_cuenta DESC");
                        while ($sql2unv = mysqli_fetch_row($sql2un)) {
        ?>
                            <tr>
                                <td><?php echo $sql2unv[5]; ?></td>
                                <td><?php echo $sql2unv[0]; ?></td>
                                <td><?php echo $sql2unv[1]; ?></td>
                                <td><?php echo $sql2unv[2]; ?></td>
                                <td><?php echo $sql2unv[3]; ?></td>
                                <td><?php echo $sql2unv[4]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-usernv" class="cerrar-modal-usernv"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-balance">
	    <div class="container-modal-balance">
	        <div id="content-balance" class="content-modal-balance">
	            <div>
    	            <h1>Balance de usuarios</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_usuario</th>
                                <th>Nombre y apellido</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Saldo</th>
                            </tr>
        <?php
            $sql2b = mysqli_query($conn, "SELECT c.id_cuenta, c.nyp, c.email, c.telefono, w.saldo FROM wallet w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.saldo != '0' ORDER BY saldo DESC");
                        while ($rowsb = mysqli_fetch_row($sql2b)) {
        ?>
                            <tr>
                                <td><?php echo $rowsb[0]; ?></td>
                                <td><?php echo $rowsb[1]; ?></td>
                                <td><?php echo $rowsb[2]; ?></td>
                                <td><?php echo $rowsb[3]; ?></td>
                                <td>$<?php echo $rowsb[4]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balance" class="cerrar-modal-balance"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-balancer">
	    <div class="container-modal-balancer">
	        <div id="content-balancer" class="content-modal-balancer">
	            <div>
    	            <h1>Transacciones de depositos</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_transaccion</th>
                                <th>Id_usuario</th>
                                <th>Saldo depositado</th>
                                <th>Metodo de pago</th>
                                <th>Nro. orden</th>
                                <th>Email de Paypal</th>
                                <th>Fecha</th>
                            </tr>
        <?php
            $sql2b2 = mysqli_query($conn, "SELECT w.id_transaccion, c.id_cuenta, w.saldo, w.metodo, w.orden, w.email, w.fecha FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.tipo = 'Deposito' ORDER BY id_transaccion DESC");
                        while ($rowsb2 = mysqli_fetch_row($sql2b2)) {
                        $saldotr2 = number_format( $rowsb2[2], 2, '.', ',');
        ?>
                            <tr>
                                <td><?php echo $rowsb2[0]; ?></td>
                                <td><?php echo $rowsb2[1]; ?></td>
                                <td>$<?php echo $saldotr2; ?></td>
                                <td><?php echo $rowsb2[3]; ?></td>
                                <td><?php echo $rowsb2[4]; ?></td>
                                <td><?php echo $rowsb2[5]; ?></td>
                                <td><?php echo $rowsb2[6]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balancer" class="cerrar-modal-balancer"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-balancerr">
	    <div class="container-modal-balancerr">
	        <div id="content-balancerr" class="content-modal-balancerr">
	            <div>
    	            <h1>Transacciones de retiros</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_transaccion</th>
                                <th>Id_usuario</th>
                                <th>Saldo retirado</th>
                                <th>Metodo de retiro</th>
                                <th>Nro. orden</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
        <?php
            $sql2b2 = mysqli_query($conn, "SELECT w.id_transaccion, c.id_cuenta, w.saldo, w.metodo, w.orden, w.email, w.fecha FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.tipo = 'Retiro' ORDER BY id_transaccion DESC");
                        while ($rowsb2 = mysqli_fetch_row($sql2b2)) {
                        $saldotr2 = number_format( $rowsb2[2], 2, '.', ',');
        ?>
                            <tr>
                                <td><?php echo $rowsb2[0]; ?></td>
                                <td><?php echo $rowsb2[1]; ?></td>
                                <td>$<?php echo $saldotr2; ?></td>
                                <td><?php echo $rowsb2[3]; ?></td>
                                <td><?php echo $rowsb2[4]; ?></td>
                                <td><?php echo $rowsb2[5]; ?></td>
                                <td><?php echo $rowsb2[6]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balancerr" class="cerrar-modal-balancerr"></label>
	    </div>
	    
        <input type="checkbox" id="btn-modal-balancecp">
	    <div class="container-modal-balancecp">
	        <div id="content-balancecp" class="content-modal-balancecp">
	            <div>
    	            <h1>Comisiones de la plataforma</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_comision</th>
                                <th>Id_torneo</th>
                                <th>Tipo de comision</th>
                                <th>Comision</th>
                                <th>Fecha</th>
                            </tr>
        <?php
            $sql2b2cp = mysqli_query($conn, "SELECT id_transaccion, metodo, orden, saldo, fecha FROM wallet_t WHERE tipo = 'Plataforma' ORDER BY id_transaccion DESC");
                        while ($rowsb2cp = mysqli_fetch_row($sql2b2cp)) {
                        $saldot2cp = number_format($rowsb2cp[3], 2, '.', ',');
        ?>
                            <tr>
                                <td><?php echo $rowsb2cp[0]; ?></td>
                                <td><?php echo $rowsb2cp[1]; ?></td>
                                <td><?php echo $rowsb2cp[2]; ?></td>
                                <td>$<?php echo $saldot2cp; ?></td>
                                <td><?php echo $rowsb2cp[4]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balancecp" class="cerrar-modal-balancecp"></label>
	    </div>
        <input type="checkbox" id="btn-modal-balancepp">
	    <div class="container-modal-balancepp">
	        <div id="content-balancepp" class="content-modal-balancepp">
	            <div>
    	            <h1>Premios entregados</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_premio</th>
                                <th>Id_usuario</th>
                                <th>Id_torneo</th>
                                <th>Tipo</th>
                                <th>Premio</th>
                                <th>Fecha</th>
                            </tr>
        <?php
            $sql2b2pp = mysqli_query($conn, "SELECT w.id_transaccion, c.id_cuenta, w.metodo, w.saldo, w.fecha, w.tipo FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.tipo = 'Torneo' OR w.tipo = 'Desafio' ORDER BY id_transaccion DESC");
                        while ($rowsb2pp = mysqli_fetch_row($sql2b2pp)) {
                        $saldotr2pp = number_format( $rowsb2pp[3], 2, '.', ',');
        ?>
                            <tr>
                                <td><?php echo $rowsb2pp[0]; ?></td>
                                <td><?php echo $rowsb2pp[1]; ?></td>
                                <td><?php echo $rowsb2pp[2]; ?></td>
                                <td><?php echo $rowsb2pp[5]; ?></td>
                                <td>$<?php echo $saldotr2pp; ?></td>
                                <td><?php echo $rowsb2pp[4]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balancepp" class="cerrar-modal-balancepp"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-balancego">
	    <div class="container-modal-balancego">
	        <div id="content-balancego" class="content-modal-balancego">
	            <div>
    	            <h1>Ganancias de organizadores</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_ganancia</th>
                                <th>Id_organizador</th>
                                <th>Id_torneo</th>
                                <th>Ganancia</th>
                                <th>Fecha</th>
                            </tr>
        <?php
                        
        ?>
                            <tr>
                                <td><?php echo $rowsb2go[0]; ?></td>
                                <td><?php echo $rowsb2go[1]; ?></td>
                                <td><?php echo $rowsb2go[2]; ?></td>
                                <td>$<?php echo $saldotr2go; ?></td>
                                <td><?php echo $rowsb2go[4]; ?></td>
                            </tr>
        <?php
                        
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-balancego" class="cerrar-modal-balancego"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-tickets">
		<div class="container-modal-tickets">
	        <div id="content-tickets" class="content-modal-tickets">
	            <div>
    	            <h1>Tickets</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Nombre</th>
                                <th>Problema</th>
                                <th>Finalizado por</th>
                                <th>Calificacion</th>
                            </tr>
        <?php
                        $sqltf = mysqli_query($conn, "SELECT * FROM soporte WHERE status = '1' ORDER BY id_soporte DESC");
                        while ($rows = mysqli_fetch_row($sqltf)) {
                            $sqlfc = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows[5]'");
                            $sqlfcv = $sqlfc->fetch_row();
        ?>
                            <tr>
                                <td><?php echo $rows[1]; ?></td>
                                <td><?php echo $rows[2]; ?></td>
                                <td><?php echo $sqlfcv[0]; ?></td>
                                <td><?php echo $rows[8]; ?> <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-tickets" class="cerrar-modal-tickets"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-raprobado">
		<div class="container-modal-raprobado">
	        <div id="content-raprobado" class="content-modal-raprobado">
	            <div>
    	            <h1>Retiros aprobados</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Email</th>
                                <th>Saldo</th>
                                <th>Aprobado por</th>
                                <th>Deposito enviado</th>
                            </tr>
        <?php
            $sql3a = mysqli_query($conn, "SELECT c.email,w.saldo,w.fecha_d,w.adm FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.status = 'COMPLETED' AND tipo = 'Retiro' ORDER BY w.id_transaccion DESC");
                        while ($rows2a = mysqli_fetch_row($sql3a)) {
                        $saldor2a = number_format( $rows2a[1], 2, '.', ',');
                        $sqladma = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows2a[3]'");
                        $sqladmav = $sqladma->fetch_row();
        ?>
                            <tr>
                                <td><?php echo $rows2a[0]; ?></td>
                                <td>$<?php echo $saldor2a; ?></td>
                                <td><?php echo $sqladmav[0]; ?></td>
                                <td><?php echo $rows2a[2]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-raprobado" class="cerrar-modal-raprobado"></label>
	    </div>
	    
	    <input type="checkbox" id="btn-modal-torneo-t">
		<div class="container-modal-torneo-t">
	        <div id="content-torneo-t" class="content-modal-torneo-t">
	            <div>
    	            <h1>Torneos</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_torneo</th>
                                <th>Nombre torneo</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Estado torneo</th>
                                <th>Id organizador</th>
                                <th>Monto inscripcion</th>
                                <th>Participantes</th>
                                <th>Premio total</th>
                            </tr>
        <?php
            $sqlt_t = mysqli_query($conn, "SELECT id,titulo,fecha,fechaf,comienzo,id_cuenta,price,equipos FROM torneos ORDER BY id DESC");
                        while ($sqlt_tv = mysqli_fetch_row($sqlt_t)) {
                            if($sqlt_tv[4] == 0){
                                $comienzot = "En espera";
                            }if(($sqlt_tv[4] == 1) || ($sqlt_tv[4] == 2)){
                                $comienzot = "En ejecucion";
                            }if($sqlt_tv[4] == 3){
                                $comienzot = "En revisión";
                            }if($sqlt_tv[4] == 4){
                                $comienzot = "Finalizado";
                            }
                            $pricet = explode("/", $sqlt_tv[6]);
        ?>
                            <tr>
                                <td><?php echo $sqlt_tv[0]; ?></td>
                                <td><?php echo $sqlt_tv[1]; ?></td>
                                <td><?php echo $sqlt_tv[2]; ?></td>
                                <td><?php echo $sqlt_tv[3]; ?></td>
                                <td><?php echo $comienzot; ?></td>
                                <td><?php echo $sqlt_tv[5]; ?></td>
                                <td>$<?php echo $pricet[0]; ?></td>
                                <td><?php echo $sqlt_tv[7]; ?></td>
                                <td>$<?php echo $pricet[1]; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-torneo-t" class="cerrar-modal-torneo-t"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-part-t">
		<div class="container-modal-part-t">
	        <div id="content-part-t" class="content-modal-part-t">
	            <div>
    	            <h1>Participantes en torneos</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_participante</th>
                                <th>Id_torneo</th>
                                <th>Id_usuario</th>
                                <th>Formato</th>
                                <th>Resultado</th>
                                <th>Premio</th>
                            </tr>
        <?php
            $sqlp_t = mysqli_query($conn, "SELECT id_rtorneos,id_torneo,id_cuenta,formato FROM r_torneos ORDER BY id_torneo DESC");
                        while ($sqlp_tv = mysqli_fetch_row($sqlp_t)) {
                            $sqltpp = mysqli_query($conn, "SELECT comienzo FROM torneos WHERE id = '$sqlp_tv[1]'");
                            $sqltppv = $sqltpp->fetch_row();
                            if(($sqlp_tv[3] == "Eliminacion D") && ($sqltppv[0] >= 3)){
                                $sqledt = mysqli_query($conn, "SELECT * FROM tablas WHERE id_torneo = '$sqlp_tv[1]' AND id_cuenta = '$sqlp_tv[2]'");
                                $sqledtv = $sqledt->fetch_row();
                                if($sqledtv[8] == 0){
                                    if($sqledtv[7] == 0){
                                        if($sqledtv[6] == 0){
                                            if($sqledtv[5] == 0){
                                                if($sqledtv[4] == 0){
                                                    if($sqledtv[3] == 0){
                                                        
                                                    }else{
                                                        $resutaldot = "Elim. en 16avos";
                                                    }
                                                }else{
                                                    $resutaldot = "Elim. en Octavos";
                                                }
                                            }else{
                                                $resutaldot = "Elim. en Cuartos";
                                            }
                                        }else{
                                            $resutaldot = "Elim. en Semis";
                                        }
                                    }else{
                                        $resutaldot = "Elim. en la Final";
                                    }
                                }else{
                                    $resutaldot = "Ganador";
                                }
                            }if(($sqlp_tv[3] == "Liga E") && ($sqltppv[0] >= 3)){
                                $sqledt = mysqli_query($conn, "SELECT * FROM tablas WHERE id_torneo = '$sqlp_tv[1]' AND id_cuenta = '$sqlp_tv[2]'");
                                $sqledtv = $sqledt->fetch_row();
                                if($sqledtv[8] == 0){
                                    if($sqledtv[7] == 0){
                                        if($sqledtv[6] == 0){
                                            if($sqledtv[5] == 0){
                                                if($sqledtv[4] == 0){
                                                    if($sqledtv[3] == 0){
                                                        $resutaldot = "Elim. en Fase d. G.";
                                                    }else{
                                                        $resutaldot = "Elim. en 16avos";
                                                    }
                                                }else{
                                                    $resutaldot = "Elim. en Octavos";
                                                }
                                            }else{
                                                $resutaldot = "Elim. en Cuartos";
                                            }
                                        }else{
                                            $resutaldot = "Elim. en Semis";
                                        }
                                    }else{
                                        $resutaldot = "Elim. en la Final";
                                    }
                                }else{
                                    $resutaldot = "Ganador";
                                }
                            }if(($sqlp_tv[3] == "Liga") && ($sqltppv[0] >= 3)){
                                
                            }if(($sqlp_tv[3] == "Grupos E") && ($sqltppv[0] >= 3)){
                                $sqledt = mysqli_query($conn, "SELECT * FROM tablas WHERE id_torneo = '$sqlp_tv[1]' AND id_cuenta = '$sqlp_tv[2]'");
                                $sqledtv = $sqledt->fetch_row();
                                if($sqledtv[8] == 0){
                                    if($sqledtv[7] == 0){
                                        if($sqledtv[6] == 0){
                                            if($sqledtv[5] == 0){
                                                if($sqledtv[4] == 0){
                                                    if($sqledtv[3] == 0){
                                                        $resutaldot = "Elim. en Fase d. G.";
                                                    }else{
                                                        $resutaldot = "Elim. en 16avos";
                                                    }
                                                }else{
                                                    $resutaldot = "Elim. en Octavos";
                                                }
                                            }else{
                                                $resutaldot = "Elim. en Cuartos";
                                            }
                                        }else{
                                            $resutaldot = "Elim. en Semis";
                                        }
                                    }else{
                                        $resutaldot = "Elim. en la Final";
                                    }
                                }else{
                                    $resutaldot = "Ganador";
                                }
                            }
        ?>
                            <tr>
                                <td><?php echo $sqlp_tv[0]; ?></td>
                                <td><?php echo $sqlp_tv[1]; ?></td>
                                <td><?php echo $sqlp_tv[2]; ?></td>
                                <td><?php echo $sqlp_tv[3]; ?></td>
                                <td><?php echo $resutaldot; ?></td>
                                <td>$<?php echo "0"; ?></td>
                            </tr>
        <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-part-t" class="cerrar-modal-part-t"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-historial-t">
		<div class="container-modal-historial-t">
	        <div id="content-historial-t" class="content-modal-historial-t">
	            <div>
    	            <h1>Historial de inscripciones</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_inscripcion</th>
                                <th>Id_torneo</th>
                                <th>Id_usuario</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                            </tr>
        <?php
                    $sqlh_ts = mysqli_query($conn, "SELECT id,price FROM torneos WHERE inscripcion = '1' ORDER BY id DESC");
                    $sqlh_tsv = $sqlh_ts->fetch_row();
                        while ($sqlh_tsv = mysqli_fetch_row($sqlh_ts)) {
                            $sqlh_t = mysqli_query($conn, "SELECT id_rtorneos,id_torneo,id_cuenta,fecha FROM r_torneos WHERE id_torneo = '$sqlh_tsv[0]' ORDER BY id_torneo DESC");
                                while ($sqlh_tv = mysqli_fetch_row($sqlh_t)) {
                                    $priceht = explode("/", $sqlh_tsv[1]);
            ?>
                                <tr>
                                    <td><?php echo $sqlh_tv[0]; ?></td>
                                    <td><?php echo $sqlh_tv[1]; ?></td>
                                    <td><?php echo $sqlh_tv[2]; ?></td>
                                    <td>$<?php echo $priceht[0]; ?></td>
                                    <td><?php echo $sqlh_tv[3]; ?></td>
                                    
                                </tr>
            <?php
                            }
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-historial-t" class="cerrar-modal-historial-t"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-recau-t">
		<div class="container-modal-recau-t">
	        <div id="content-recau-t" class="content-modal-recau-t">
	            <div>
    	            <h1>Recaudacion por torneos</h1>
    	            <div id="tabla-users-r">
                        <table>
                            <tr>
                                <th>Id_torneo</th>
                                <th>Equipos</th>
                                <th>Total por inscripcion</th>
                                <th>Comision por plataforma</th>
                                <th>Premios</th>
                            </tr>
        <?php
                    $sqlh_tsrt = mysqli_query($conn, "SELECT id,price,equipos FROM torneos WHERE inscripcion = '1' ORDER BY id DESC");
                    $sqlh_tsvrt = $sqlh_tsrt->fetch_row();
                        while ($sqlh_tsvrt = mysqli_fetch_row($sqlh_tsrt)) {
                            $sqlh_trt = mysqli_query($conn, "SELECT COUNT(id_rtorneos) FROM r_torneos WHERE id_torneo = '$sqlh_tsvrt[0]'");
                            $contprt = $sqlh_trt->fetch_row();
                            
                            $pricehtrt = explode("/", $sqlh_tsvrt[1]);
                            $pricertrt = $pricehtrt[0] * $contprt[0];
            ?>
                                <tr>
                                    <td><?php echo $sqlh_tsvrt[0]; ?></td>
                                    <td><?php echo $contprt[0]." / ".$sqlh_tsvrt[2]; ?></td>
                                    <td>$<?php echo $pricertrt; ?></td>
                                    <td>$<?php echo "0"; ?></td>
                                    <td>$<?php echo $pricehtrt[1]; ?></td>
                                    
                                </tr>
            <?php
                        }
        ?>
                        </table>
    	            </div>
	            </div>
	        </div>
	        <label for="btn-modal-recau-t" class="cerrar-modal-recau-t"></label>
	    </div>
	    
	    <a id="nav-cel">
	        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(31,31,31,1)"><path d="M16 18V20H5V18H16ZM21 11V13H3V11H21ZM19 4V6H8V4H19Z"></path></svg>
	    </a>
	    <header id="header">
	        <div id="perfil">
	            <h2>DASHBOARD</h2>
	        </div>
	        <div id="lista">
	            <ul>
	                <li id="btn-info" class="activo"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg> Informacion</li>
	                <li id="btn-balance"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M20.0049 6.99979V4.99979H4.00488V18.9998H20.0049V16.9998H12.0049C11.4526 16.9998 11.0049 16.5521 11.0049 15.9998V7.99979C11.0049 7.4475 11.4526 6.99979 12.0049 6.99979H20.0049ZM3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM13.0049 8.99979V14.9998H20.0049V8.99979H13.0049ZM15.0049 10.9998H18.0049V12.9998H15.0049V10.9998Z"></path></svg> Balances</li>
	                <li id="btn-torneo"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg> Torneos</li>
	                <li id="btn-soporte"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M2.00488 3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V9.49979C20.6242 9.49979 19.5049 10.6191 19.5049 11.9998C19.5049 13.3805 20.6242 14.4998 22.0049 14.4998V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979ZM8.09024 18.9998C8.29615 18.4172 8.85177 17.9998 9.50488 17.9998C10.158 17.9998 10.7136 18.4172 10.9195 18.9998H20.0049V16.032C18.5232 15.2957 17.5049 13.7666 17.5049 11.9998C17.5049 10.2329 18.5232 8.7039 20.0049 7.96755V4.99979H10.9195C10.7136 5.58238 10.158 5.99979 9.50488 5.99979C8.85177 5.99979 8.29615 5.58238 8.09024 4.99979H4.00488V18.9998H8.09024ZM9.50488 10.9998C8.67646 10.9998 8.00488 10.3282 8.00488 9.49979C8.00488 8.67136 8.67646 7.99979 9.50488 7.99979C10.3333 7.99979 11.0049 8.67136 11.0049 9.49979C11.0049 10.3282 10.3333 10.9998 9.50488 10.9998ZM9.50488 15.9998C8.67646 15.9998 8.00488 15.3282 8.00488 14.4998C8.00488 13.6714 8.67646 12.9998 9.50488 12.9998C10.3333 12.9998 11.0049 13.6714 11.0049 14.4998C11.0049 15.3282 10.3333 15.9998 9.50488 15.9998Z"></path></svg> Soporte</li>
	                <li id="btn-auditar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M6.49323 19H17.5068L16.8401 16H7.1599L6.49323 19ZM19.5556 19H21V21H3V19H4.44444L7.82598 3.78307C7.92766 3.32553 8.33347 3 8.80217 3H15.1978C15.6665 3 16.0723 3.32553 16.174 3.78307L19.5556 19ZM7.60434 14H16.3957L15.5068 10H8.49323L7.60434 14ZM8.93768 8H15.0623L14.3957 5H9.60434L8.93768 8Z"></path></svg> Auditoria</li>
	                <li id="btn-config"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M2 18H9V20H2V18ZM2 11H11V13H2V11ZM2 4H22V6H2V4ZM20.674 13.0251L21.8301 12.634L22.8301 14.366L21.914 15.1711C21.9704 15.4386 22 15.7158 22 16C22 16.2842 21.9704 16.5614 21.914 16.8289L22.8301 17.634L21.8301 19.366L20.674 18.9749C20.2635 19.3441 19.7763 19.6295 19.2391 19.8044L19 21H17L16.7609 19.8044C16.2237 19.6295 15.7365 19.3441 15.326 18.9749L14.1699 19.366L13.1699 17.634L14.086 16.8289C14.0296 16.5614 14 16.2842 14 16C14 15.7158 14.0296 15.4386 14.086 15.1711L13.1699 14.366L14.1699 12.634L15.326 13.0251C15.7365 12.6559 16.2237 12.3705 16.7609 12.1956L17 11H19L19.2391 12.1956C19.7763 12.3705 20.2635 12.6559 20.674 13.0251ZM18 18C19.1046 18 20 17.1046 20 16C20 14.8954 19.1046 14 18 14C16.8954 14 16 14.8954 16 16C16 17.1046 16.8954 18 18 18Z"></path></svg> Configuracion</li>
	                <label for="btn-modal-bonos"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(38,38,38,1)"><path d="M10.0544 2.0941C11.1756 1.13856 12.8248 1.13855 13.9461 2.09411L15.2941 3.24286C15.4542 3.37935 15.6533 3.46182 15.8631 3.47856L17.6286 3.61945C19.0971 3.73663 20.2633 4.9028 20.3805 6.37131L20.5214 8.13679C20.5381 8.34654 20.6205 8.54568 20.757 8.70585L21.9058 10.0539C22.8614 11.1751 22.8614 12.8243 21.9058 13.9456L20.757 15.2935C20.6206 15.4537 20.538 15.6529 20.5213 15.8627L20.3805 17.6281C20.2633 19.0967 19.0971 20.2628 17.6286 20.3799L15.8631 20.5208C15.6533 20.5376 15.4542 20.6201 15.2941 20.7566L13.9461 21.9053C12.8248 22.8609 11.1756 22.8608 10.0543 21.9053L8.70631 20.7566C8.54615 20.6201 8.34705 20.5376 8.1373 20.5209L6.37184 20.3799C4.9033 20.2627 3.73716 19.0966 3.61997 17.6281L3.47906 15.8627C3.46232 15.6529 3.37983 15.4538 3.24336 15.2936L2.0946 13.9455C1.13905 12.8243 1.13904 11.1752 2.09458 10.0539L3.24334 8.70589C3.37983 8.54573 3.46234 8.34654 3.47907 8.13678L3.61996 6.3713C3.73714 4.90278 4.90327 3.73665 6.3718 3.61946L8.13729 3.47857C8.34705 3.46183 8.54619 3.37935 8.70636 3.24286L10.0544 2.0941ZM12.6488 3.61632C12.2751 3.29782 11.7253 3.29781 11.3516 3.61632L10.0036 4.76509C9.5231 5.17456 8.92568 5.42201 8.29637 5.47223L6.5309 5.61312C6.04139 5.65219 5.65268 6.04089 5.61362 6.53041L5.47272 8.29593C5.4225 8.92521 5.17505 9.52259 4.76559 10.0031L3.61683 11.3511C3.29832 11.7248 3.29831 12.2746 3.61683 12.6483L4.76559 13.9963C5.17506 14.4768 5.4225 15.0743 5.47275 15.7035L5.61363 17.469C5.65268 17.9585 6.04139 18.3473 6.53092 18.3863L8.29636 18.5272C8.92563 18.5774 9.5231 18.8249 10.0036 19.2344L11.3516 20.3831C11.7254 20.7016 12.2751 20.7016 12.6488 20.3831L13.9969 19.2343C14.4773 18.8249 15.0747 18.5774 15.704 18.5272L17.4695 18.3863C17.959 18.3472 18.3478 17.9585 18.3868 17.469L18.5277 15.7035C18.5779 15.0742 18.8253 14.4768 19.2349 13.9964L20.3836 12.6483C20.7022 12.2746 20.7021 11.7249 20.3836 11.3511L19.2348 10.0031C18.8253 9.52259 18.5779 8.92519 18.5277 8.2959L18.3868 6.53041C18.3478 6.0409 17.959 5.65219 17.4695 5.61312L15.704 5.47224C15.0748 5.42203 14.4773 5.17455 13.9968 4.76508L12.6488 3.61632ZM14.8284 7.75718L16.2426 9.1714L9.17154 16.2425L7.75733 14.8282L14.8284 7.75718ZM10.2322 10.232C9.64641 10.8178 8.69667 10.8178 8.11088 10.232C7.52509 9.6463 7.52509 8.69652 8.11088 8.11073C8.69667 7.52494 9.64641 7.52494 10.2322 8.11073C10.818 8.69652 10.818 9.6463 10.2322 10.232ZM13.7677 15.8889C14.3535 16.4747 15.3032 16.4747 15.889 15.8889C16.4748 15.3031 16.4748 14.3534 15.889 13.7676C15.3032 13.1818 14.3535 13.1818 13.7677 13.7676C13.1819 14.3534 13.1819 15.3031 13.7677 15.8889Z"></path></svg> Bonos</label>
	            </ul>
	        </div>
	    </header>
	    <content>
	        <main id="informacion">
	        <?php
                $sqlb = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email != '#ID'");
                $sqlv = mysqli_num_rows($sqlb);
                $sql2 = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email != '#ID' AND verificado > '0'");
                $sqlv2 = mysqli_num_rows($sql2);
                $sql3 = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE email != '#ID' AND verificado = '0'");
                $sqlv3 = mysqli_num_rows($sql3);
            ?>
	            <div id="barra">
	                <label class="layout" for="btn-modal-userr" style="cursor: context-menu;">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlv; ?></h2>
	                    <p>Total registrados</p>
	                </label>
                    <label class="layout" for="btn-modal-userv">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M10.0073 2.10365C8.60568 1.64993 7.08206 2.28104 6.41181 3.59294L5.60603 5.17011C5.51029 5.35751 5.35787 5.50992 5.17048 5.60566L3.5933 6.41144C2.2814 7.08169 1.6503 8.60532 2.10401 10.0069L2.64947 11.6919C2.71428 11.8921 2.71428 12.1077 2.64947 12.3079L2.10401 13.9929C1.6503 15.3945 2.28141 16.9181 3.5933 17.5883L5.17048 18.3941C5.35787 18.4899 5.51029 18.6423 5.60603 18.8297L6.41181 20.4068C7.08206 21.7187 8.60569 22.3498 10.0073 21.8961L11.6923 21.3507C11.8925 21.2859 12.108 21.2859 12.3082 21.3507L13.9932 21.8961C15.3948 22.3498 16.9185 21.7187 17.5887 20.4068L18.3945 18.8297C18.4902 18.6423 18.6426 18.4899 18.83 18.3941L20.4072 17.5883C21.7191 16.9181 22.3502 15.3945 21.8965 13.9929L21.351 12.3079C21.2862 12.1077 21.2862 11.8921 21.351 11.6919L21.8965 10.0069C22.3502 8.60531 21.7191 7.08169 20.4072 6.41144L18.83 5.60566C18.6426 5.50992 18.4902 5.3575 18.3945 5.17011L17.5887 3.59294C16.9185 2.28104 15.3948 1.64993 13.9932 2.10365L12.3082 2.6491C12.108 2.71391 11.8925 2.71391 11.6923 2.6491L10.0073 2.10365ZM8.19283 4.50286C8.41624 4.06556 8.92412 3.8552 9.39132 4.00643L11.0763 4.55189C11.6769 4.74632 12.3236 4.74632 12.9242 4.55189L14.6092 4.00643C15.0764 3.8552 15.5843 4.06556 15.8077 4.50286L16.6135 6.08004C16.9007 6.64222 17.3579 7.09946 17.9201 7.38668L19.4973 8.19246C19.9346 8.41588 20.145 8.92375 19.9937 9.39095L19.4483 11.076C19.2538 11.6766 19.2538 12.3232 19.4483 12.9238L19.9937 14.6088C20.145 15.076 19.9346 15.5839 19.4973 15.8073L17.9201 16.6131C17.3579 16.9003 16.9007 17.3576 16.6135 17.9197L15.8077 19.4969C15.5843 19.9342 15.0764 20.1446 14.6092 19.9933L12.9242 19.4479C12.3236 19.2535 11.6769 19.2535 11.0763 19.4479L9.39132 19.9933C8.92412 20.1446 8.41624 19.9342 8.19283 19.4969L7.38705 17.9197C7.09983 17.3576 6.64258 16.9003 6.08041 16.6131L4.50323 15.8073C4.06593 15.5839 3.85556 15.076 4.0068 14.6088L4.55226 12.9238C4.74668 12.3232 4.74668 11.6766 4.55226 11.076L4.0068 9.39095C3.85556 8.92375 4.06593 8.41588 4.50323 8.19246L6.0804 7.38668C6.64258 7.09946 7.09983 6.64222 7.38705 6.08004L8.19283 4.50286ZM6.75984 11.7573L11.0025 15.9999L18.0736 8.92885L16.6594 7.51464L11.0025 13.1715L8.17406 10.343L6.75984 11.7573Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlv2; ?></h2>
	                    <p>Verificados</p>
	                </label>
                    <label class="layout" for="btn-modal-usernv">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C13.6418 20 15.1681 19.5054 16.4381 18.6571L17.5476 20.3214C15.9602 21.3818 14.0523 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12V13.5C22 15.433 20.433 17 18.5 17C17.2958 17 16.2336 16.3918 15.6038 15.4659C14.6942 16.4115 13.4158 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C13.1258 7 14.1647 7.37209 15.0005 8H17V13.5C17 14.3284 17.6716 15 18.5 15C19.3284 15 20 14.3284 20 13.5V12ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlv3; ?></h2>
	                    <p>No verificados</p>
	                </label>
	            </div>
	            <div id="barra">
	                <label class="layout" for="btn-modal-actuser">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z"></path></svg>
	                    </div>
	                    <h2>Avd</h2>
	                    <p>de usuarios</p>
	                </label>
	                <label class="layout" for="btn-modal-aggb">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
	                    </div>
	                    <h2>Add</h2>
	                    <p>Balances</p>
	                </label>
	                <label class="layout2"></label>
	            </div>
	            <h3>Conexion de usuarios</h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre y apellido</th>
                            <th>Email</th>
                            <th>Se conecto</th>
                        </tr>
    <?php
                $sql2u = mysqli_query($conn, "SELECT nombre,nyp,email,id_cuenta,status FROM cuentas WHERE email != '#ID' ORDER BY status DESC");
                    while ($sql2uv = mysqli_fetch_row($sql2u)) {
                            $fdesc2 = $sql2uv[4];
                            $fechaDes2 = new DateTime($fdesc2);
                            $fechaActual2 = new DateTime();
                            $diferencia2 = $fechaActual2->diff($fechaDes2);
                            if(($diferencia2->d <= 0) && ($diferencia2->m <= 0)){
                                $diadd = "Hoy";
                            }else{
                                if(($diferencia2->d >= 0) && ($diferencia2->m <= 0)){
                                    $diadd = "hace ".$diferencia2->d." dias";
                                }else{
                                    if(($diferencia2->d >= 0) && ($diferencia2->m >= 0)){
                                        $diadd = "hace ".$diferencia2->m." mes y ".$diferencia2->d." dias";
                                    }
                                }
                            }
                            if($sql2uv[4] == '0000-00-00 00:00:00'){
                                $diadd = "Sin conexiones";
                            }
    ?>
                            <tr>
                                <td><?php echo $sql2uv[0]; ?></td>
                                <td><?php echo $sql2uv[1]; ?></td>
                                <td><?php echo $sql2uv[2]; ?></td>
                                <td><?php echo $diadd; ?></td>
                            </tr>
    <?php
                        
                    }
    ?>
                    </table>
	            </div>
	        </main>
	        <main id="balances" style="display: none;">
	        <?php
                $sqlb = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet");
                $sqlbv = $sqlb->fetch_row();
                $sqlb2 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Deposito'");
                $sqlbv2 = $sqlb2->fetch_row();
                $sqlb3 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Retiro' AND status = 'COMPLETED'");
                $sqlbv3 = $sqlb3->fetch_row();
                $sqlb4 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Torneo' OR tipo = 'Desafio' AND status = 'COMPLETED'");
                $sqlbv4 = $sqlb4->fetch_row();
                $sqlb5 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Ganancias' AND status = 'COMPLETED'");
                $sqlbv5 = $sqlb5->fetch_row();
                $sqlb6 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Plataforma'");
                $sqlbv6 = $sqlb6->fetch_row();
                $s_walletd = number_format( $sqlbv2[0], 2, '.', ',');
                $s_walletr = number_format( $sqlbv3[0], 2, '.', ',');
                $s_wallepp = number_format( $sqlbv4[0], 2, '.', ',');
                $s_wallego = number_format( $sqlbv5[0], 2, '.', ',');
                $s_wallecp = number_format( $sqlbv6[0], 2, '.', ',');
            ?>
	            <div id="barra">
	                <label for="btn-modal-balance" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M20.0049 6.99979V4.99979H4.00488V18.9998H20.0049V16.9998H12.0049C11.4526 16.9998 11.0049 16.5521 11.0049 15.9998V7.99979C11.0049 7.4475 11.4526 6.99979 12.0049 6.99979H20.0049ZM3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM13.0049 8.99979V14.9998H20.0049V8.99979H13.0049ZM15.0049 10.9998H18.0049V12.9998H15.0049V10.9998Z"></path></svg>
	                    </div>
	                    <h2>$<?php echo $sqlbv[0]; ?></h2>
	                    <p>Balance total disponible</p>
	                </label>
	                <label for="btn-modal-balancer" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64l241.9 0c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
	                    </div>
	                    <h2>$<?php echo $s_walletd; ?></h2>
	                    <p>Depositado</p>
	                </label>
	                <label for="btn-modal-balancerr" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64l241.9 0c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
	                    </div>
	                    <h2>$<?php echo $s_walletr; ?></h2>
	                    <p>Retirado</p>
	                </label>
	            </div>
	            <div id="barra">
	                <label for="btn-modal-balancecp" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M20.0049 20.3331V21.9998H18.0049V20.6664L10.5871 21.9027C10.3147 21.9481 10.0571 21.7641 10.0117 21.4917C10.0072 21.4646 10.0049 21.4371 10.0049 21.4095V19.9998H6.00488V21.9998H4.00488V19.9998H3.00488C2.4526 19.9998 2.00488 19.552 2.00488 18.9998V3.99977C2.00488 3.44748 2.4526 2.99977 3.00488 2.99977H10.0049V1.59C10.0049 1.31385 10.2287 1.09 10.5049 1.09C10.5324 1.09 10.5599 1.09227 10.5871 1.0968L21.1693 2.8605C21.6515 2.94086 22.0049 3.35805 22.0049 3.84689V5.99977H23.0049V7.99977H22.0049V14.9998H23.0049V16.9998H22.0049V19.1526C22.0049 19.6415 21.6515 20.0587 21.1693 20.139L20.0049 20.3331ZM4.00488 4.99977V17.9998H10.0049V4.99977H4.00488ZM12.0049 19.6388L20.0049 18.3055V4.69402L12.0049 3.36069V19.6388ZM16.5049 13.9998C15.6765 13.9998 15.0049 12.8805 15.0049 11.4998C15.0049 10.1191 15.6765 8.99977 16.5049 8.99977C17.3333 8.99977 18.0049 10.1191 18.0049 11.4998C18.0049 12.8805 17.3333 13.9998 16.5049 13.9998Z"></path></svg>
	                    </div>
	                    <h2>$<?php echo $s_wallecp; ?></h2>
	                    <p>Comisiones de la plataforma</p>
	                </label>
	                <label for="btn-modal-balancepp" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M15.0049 2.00281C17.214 2.00281 19.0049 3.79367 19.0049 6.00281C19.0049 6.73184 18.8098 7.41532 18.4691 8.00392L23.0049 8.00281V10.0028H21.0049V20.0028C21.0049 20.5551 20.5572 21.0028 20.0049 21.0028H4.00488C3.4526 21.0028 3.00488 20.5551 3.00488 20.0028V10.0028H1.00488V8.00281L5.54065 8.00392C5.19992 7.41532 5.00488 6.73184 5.00488 6.00281C5.00488 3.79367 6.79574 2.00281 9.00488 2.00281C10.2001 2.00281 11.2729 2.52702 12.0058 3.35807C12.7369 2.52702 13.8097 2.00281 15.0049 2.00281ZM11.0049 10.0028H5.00488V19.0028H11.0049V10.0028ZM19.0049 10.0028H13.0049V19.0028H19.0049V10.0028ZM9.00488 4.00281C7.90031 4.00281 7.00488 4.89824 7.00488 6.00281C7.00488 7.05717 7.82076 7.92097 8.85562 7.99732L9.00488 8.00281H11.0049V6.00281C11.0049 5.00116 10.2686 4.1715 9.30766 4.02558L9.15415 4.00829L9.00488 4.00281ZM15.0049 4.00281C13.9505 4.00281 13.0867 4.81869 13.0104 5.85355L13.0049 6.00281V8.00281H15.0049C16.0592 8.00281 16.923 7.18693 16.9994 6.15207L17.0049 6.00281C17.0049 4.89824 16.1095 4.00281 15.0049 4.00281Z"></path></svg>
	                    </div>
	                    <h2>$<?php echo $s_wallepp; ?></h2>
	                    <p>Premios pagados</p>
	                </label>
	                <label for="btn-modal-balancego" class="layout">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M17.0047 16.0027H19.0047V4.00275H9.00468V6.00275H17.0047V16.0027ZM17.0047 18.0027V21.0019C17.0047 21.5546 16.5547 22.0027 15.9978 22.0027H4.01154C3.45548 22.0027 3.00488 21.5581 3.00488 21.0019L3.00748 7.00362C3.00759 6.45085 3.45752 6.00275 4.0143 6.00275H7.00468V3.00275C7.00468 2.45046 7.4524 2.00275 8.00468 2.00275H20.0047C20.557 2.00275 21.0047 2.45046 21.0047 3.00275V17.0027C21.0047 17.555 20.557 18.0027 20.0047 18.0027H17.0047ZM5.0073 8.00275L5.00507 20.0027H15.0047V8.00275H5.0073ZM7.00468 16.0027H11.5047C11.7808 16.0027 12.0047 15.7789 12.0047 15.5027C12.0047 15.2266 11.7808 15.0027 11.5047 15.0027H8.50468C7.12397 15.0027 6.00468 13.8835 6.00468 12.5027C6.00468 11.122 7.12397 10.0027 8.50468 10.0027H9.00468V9.00275H11.0047V10.0027H13.0047V12.0027H8.50468C8.22854 12.0027 8.00468 12.2266 8.00468 12.5027C8.00468 12.7789 8.22854 13.0027 8.50468 13.0027H11.5047C12.8854 13.0027 14.0047 14.122 14.0047 15.5027C14.0047 16.8835 12.8854 18.0027 11.5047 18.0027H11.0047V19.0027H9.00468V18.0027H7.00468V16.0027Z"></path></svg>
	                    </div>
	                    <h2>$<?php echo $s_wallego; ?></h2>
	                    <p>Ganancias de organizador</p>
	                </label>
	            </div>
	            <h3>Balance de usuarios <label class="btn-mas" for="btn-modal-balance">+Ver más</label></h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Saldo</th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT w.saldo, c.nombre, c.email, c.telefono FROM wallet w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.saldo != '0' ORDER BY saldo DESC LIMIT 5");
                    while ($rows = mysqli_fetch_row($sql2)) {
    ?>
                        <tr>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $rows[2]; ?></td>
                            <td><?php echo $rows[3]; ?></td>
                            <td>$<?php echo $rows[0]; ?></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	            <h3>Transacciones de deposito recientes <label class="btn-mas" for="btn-modal-balancer">+Ver más</label></h3>
	            <div id="tabla-users-td">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Saldo</th>
                            <th>Metodo</th>
                            <th>Nro. orden</th>
                            <th>Email</th>
                            <th>Fecha</th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT c.nombre, w.tipo, w.saldo, w.metodo, w.orden, w.email, w.fecha FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.tipo = 'Deposito' ORDER BY id_transaccion DESC LIMIT 5");
                    while ($rows = mysqli_fetch_row($sql2)) {
                        $saldotr = number_format( $rows[2], 2, '.', ',');
    ?>
                        <tr>
                            <td><?php echo $rows[0]; ?></td>
                            <td><?php echo $rows[1]; ?></td>
                            <td>$<?php echo $saldotr; ?></td>
                            <td><?php echo $rows[3]; ?></td>
                            <td><?php echo $rows[4]; ?></td>
                            <td><?php echo $rows[5]; ?></td>
                            <td><?php echo $rows[6]; ?></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	            <h3>Transacciones de retiro recientes <label class="btn-mas" for="btn-modal-balancerr">+Ver más</label></h3>
	            <div id="tabla-users-tr">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Saldo</th>
                            <th>Metodo</th>
                            <th>Nro. orden</th>
                            <th>Email</th>
                            <th>Fecha</th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT c.nombre, w.tipo, w.saldo, w.metodo, w.orden, w.email, w.fecha FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.tipo = 'Retiro' AND w.status = 'COMPLETED' ORDER BY id_transaccion DESC LIMIT 5");
                    while ($rows = mysqli_fetch_row($sql2)) {
                        $saldotr2 = number_format( $rows[2], 2, '.', ',');
    ?>
                        <tr>
                            <td><?php echo $rows[0]; ?></td>
                            <td><?php echo $rows[1]; ?></td>
                            <td>$<?php echo $saldotr2; ?></td>
                            <td><?php echo $rows[3]; ?></td>
                            <td><?php echo $rows[4]; ?></td>
                            <td><?php echo $rows[5]; ?></td>
                            <td><?php echo $rows[6]; ?></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	        </main>
	        <main id="torneo" style="display: none;">
	            <div id="barra">
	                <label class="layout" for="btn-modal-torneo-t">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M13.0049 16.9409V19.0027H18.0049V21.0027H6.00488V19.0027H11.0049V16.9409C7.05857 16.4488 4.00488 13.0824 4.00488 9.00275V3.00275H20.0049V9.00275C20.0049 13.0824 16.9512 16.4488 13.0049 16.9409ZM6.00488 5.00275V9.00275C6.00488 12.3165 8.69117 15.0027 12.0049 15.0027C15.3186 15.0027 18.0049 12.3165 18.0049 9.00275V5.00275H6.00488ZM1.00488 5.00275H3.00488V9.00275H1.00488V5.00275ZM21.0049 5.00275H23.0049V9.00275H21.0049V5.00275Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlttv[0]; ?></h2>
	                    <p>Torneos</p>
	                </label>
	                <label class="layout" for="btn-modal-part-t">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M3 6H21V18H3V6ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM13 8H19V10H13V8ZM18 12H13V14H18V12ZM10.5 10C10.5 11.3807 9.38071 12.5 8 12.5C6.61929 12.5 5.5 11.3807 5.5 10C5.5 8.61929 6.61929 7.5 8 7.5C9.38071 7.5 10.5 8.61929 10.5 10ZM8 13.5C6.067 13.5 4.5 15.067 4.5 17H11.5C11.5 15.067 9.933 13.5 8 13.5Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlptv[0]; ?></h2>
	                    <p>Participantes en torneos</p>
	                </label>
	                <label class="layout" for="btn-modal-historial-t">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M10.4142 3L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H10.4142ZM9.58579 5H4V19H20V7H11.5858L9.58579 5ZM13 9V13H16V15H11V9H13Z"></path></svg>
	                    </div>
	                    <h2><?php echo $schtt; ?></h2>
	                    <p>Historial de inscripciones</p>
	                </label>
	            </div>
	            <div id="barra">
	                <label class="layout" for="btn-modal-recau-t">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M4.00488 5.00281V19.0028H20.0049V5.00281H4.00488ZM3.00488 3.00281H21.0049C21.5572 3.00281 22.0049 3.45052 22.0049 4.00281V20.0028C22.0049 20.5551 21.5572 21.0028 21.0049 21.0028H3.00488C2.4526 21.0028 2.00488 20.5551 2.00488 20.0028V4.00281C2.00488 3.45052 2.4526 3.00281 3.00488 3.00281ZM14.7978 9.7957L13.0049 8.00281H18.0049V13.0028L16.212 11.2099L12.348 15.0739L10.2267 12.9526L7.39828 15.781L5.98407 14.3668L10.2267 10.1241L12.348 12.2454L14.7978 9.7957Z"></path></svg>
	                    </div>
	                    <h2>$<?php echo $sqlrtts; ?></h2>
	                    <p>Recaudacion por torneos</p>
	                </label>
	                <label class="layout2"></label>
	                <label class="layout2"></label>
	            </div>
	            <h3>Torneos</h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Titulo</th>
                            <th>Organizador</th>
                            <th>Tipo</th>
                            <th>Auditado por</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT t.id,t.titulo,c.nombre,t.inscripcion,t.fecha,t.auditado FROM torneos t JOIN cuentas c ON t.id_cuenta = c.id_cuenta ORDER BY id DESC LIMIT 10");
                    while ($rows = mysqli_fetch_row($sql2)) {
                        if($rows[3] == 0){
                            $insc = "Gratis";
                        }if($rows[3] == 1){
                            $insc = "Inscripcion";
                        }if($rows[3] == 2){
                            $insc = "Privado";
                        }if($rows[3] == 3){
                            $insc = "Gratis + Premio";
                        }if($rows[3] == 4){
                            $insc = "Privado + Premio";
                        }
                        $sqlnca = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows[5]'");
                        $sqlncav = $sqlnca->fetch_row();
    ?>
                        <tr>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $rows[2]; ?></td>
                            <td><?php echo $insc; ?></td>
                            <td><?php echo $sqlncav[0]; ?></td>
                            <td><?php echo $rows[4]; ?></td>
                            <td><a href="/torneo/<?php echo $rows[0]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                </a></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	        </main>
	        <main id="soporte" style="display: none;">
	        <?php
                $sqlb = mysqli_query($conn, "SELECT COUNT(id_transaccion) FROM wallet_t WHERE tipo = 'Retiro' AND status = 'WAIT'");
                $sqlbv = $sqlb->fetch_row();
                $sqlb2 = mysqli_query($conn, "SELECT SUM(saldo) FROM wallet_t WHERE tipo = 'Deposito'");
                $sqlbv2 = $sqlb2->fetch_row();
            ?>
	            <div id="barra">
	                <label class="layout" for="btn-modal-retiros">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416l400 0c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4l0-25.4c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112l0 25.4c0 47.9 13.9 94.6 39.7 134.6L72.3 368C98.1 328 112 281.3 112 233.4l0-25.4c0-61.9 50.1-112 112-112zm64 352l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg>
	                    </div>
	                    <h2><?php echo $sqlbv[0]; ?></h2>
	                    <p>Solicitud de retiros</p>
	                </label>
	                <label class="layout" for="btn-modal-soporte">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
	                    </div>
	                    <h2><?php echo $sqlbvsp[0]; ?></h2>
	                    <p>Tickets sin resolver</p>
	                </label>
	            </div>
	            <h3>Tickets finalizados <label class="btn-mas" for="btn-modal-tickets">+Ver más</label></h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Problema</th>
                            <th>Finalizado por</th>
                            <th>Calificacion</th>
                        </tr>
    <?php
                    $sqltf = mysqli_query($conn, "SELECT * FROM soporte WHERE status = '1' ORDER BY id_soporte DESC LIMIT 5");
                    while ($rows = mysqli_fetch_row($sqltf)) {
                        $sqlfc = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows[5]'");
                        $sqlfcv = $sqlfc->fetch_row();
    ?>
                        <tr>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $rows[2]; ?></td>
                            <td><?php echo $sqlfcv[0]; ?></td>
                            <td><?php echo $rows[8]; ?> <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='20' fill='rgba(240,187,64,1)'><path d='M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z'></path></svg></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	            <h3>Retiros aprobados <label class="btn-mas" for="btn-modal-raprobado">+Ver más</label></h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Email</th>
                            <th>Saldo</th>
                            <th>Aprobado por</th>
                            <th>Deposito enviado</th>
                        </tr>
    <?php
                    $sql3 = mysqli_query($conn, "SELECT c.email,w.saldo,w.fecha_d,w.adm FROM wallet_t w JOIN cuentas c ON w.id_cuenta = c.id_cuenta WHERE w.status = 'COMPLETED' AND tipo = 'Retiro' ORDER BY w.id_transaccion DESC LIMIT 5");
                    while ($rows2 = mysqli_fetch_row($sql3)) {
                        $saldor2 = number_format( $rows2[1], 2, '.', ',');
                        $sqladm = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows2[3]'");
                        $sqladmv = $sqladm->fetch_row();
    ?>
                        <tr>
                            <td><?php echo $rows2[0]; ?></td>
                            <td>$<?php echo $saldor2; ?></td>
                            <td><?php echo $sqladmv[0]; ?></td>
                            <td><?php echo $rows2[2]; ?></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	        </main>
	        <main id="auditar" style="display: none;">
	            <div id="barra">
	                <label class="layout" for="btn-modal-torneo">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM17 6H7C4.8578 6 3.10892 7.68397 3.0049 9.80036L3 10V14C3 16.1422 4.68397 17.8911 6.80036 17.9951L7 18H17C19.1422 18 20.8911 16.316 20.9951 14.1996L21 14V10C21 7.8578 19.316 6.10892 17.1996 6.0049L17 6ZM10 9V11H12V13H9.999L10 15H8L7.999 13H6V11H8V9H10ZM18 13V15H16V13H18ZM16 9V11H14V9H16Z"></path></svg>
	                    </div>
	                    <h2><?php echo $tauditar; ?></h2>
	                    <p>Torneos para auditar</p>
	                </label>
	                <label class="layout" for="btn-modal-desafio">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM17 6H7C4.8578 6 3.10892 7.68397 3.0049 9.80036L3 10V14C3 16.1422 4.68397 17.8911 6.80036 17.9951L7 18H17C19.1422 18 20.8911 16.316 20.9951 14.1996L21 14V10C21 7.8578 19.316 6.10892 17.1996 6.0049L17 6ZM10 9V11H12V13H9.999L10 15H8L7.999 13H6V11H8V9H10ZM18 13V15H16V13H18ZM16 9V11H14V9H16Z"></path></svg>
	                    </div>
	                    <h2><?php echo $tdesafio; ?></h2>
	                    <p>Desafios para auditar</p>
	                </label>
	            </div>
	            <h3>Torneos auditados</h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Titulo</th>
                            <th>Organizador</th>
                            <th>Tipo</th>
                            <th>Auditado por</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT t.id,t.titulo,c.nombre,t.inscripcion,t.fecha,t.auditado FROM torneos t JOIN cuentas c ON t.id_cuenta = c.id_cuenta WHERE comienzo = '4' ORDER BY id DESC;");
                    while ($rows = mysqli_fetch_row($sql2)) {
                        if($rows[3] == 0){
                            $insc = "Gratis";
                        }if($rows[3] == 1){
                            $insc = "Inscripcion";
                        }if($rows[3] == 2){
                            $insc = "Privado";
                        }if($rows[3] == 3){
                            $insc = "Gratis + Premio";
                        }if($rows[3] == 4){
                            $insc = "Privado + Premio";
                        }
                        $sqlnca = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$rows[5]'");
                        $sqlncav = $sqlnca->fetch_row();
    ?>
                        <tr>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $rows[2]; ?></td>
                            <td><?php echo $insc; ?></td>
                            <td><?php echo $sqlncav[0]; ?></td>
                            <td><?php echo $rows[4]; ?></td>
                            <td><a href="/torneo/<?php echo $rows[0]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path></svg>
                                </a></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	        </main>
	        <main id="configuracion" style="display: none;">
	        <?php
	            $personal = mysqli_query($conn, "SELECT id_cuenta FROM cuentas WHERE verificado >= 3");
	            $personalv = mysqli_num_rows($personal);
	        ?>
	            <div id="barra">
	                <label class="layout" for="btn-modal-juegos">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M17 4C20.3137 4 23 6.68629 23 10V14C23 17.3137 20.3137 20 17 20H7C3.68629 20 1 17.3137 1 14V10C1 6.68629 3.68629 4 7 4H17ZM17 6H7C4.8578 6 3.10892 7.68397 3.0049 9.80036L3 10V14C3 16.1422 4.68397 17.8911 6.80036 17.9951L7 18H17C19.1422 18 20.8911 16.316 20.9951 14.1996L21 14V10C21 7.8578 19.316 6.10892 17.1996 6.0049L17 6ZM10 9V11H12V13H9.999L10 15H8L7.999 13H6V11H8V9H10ZM18 13V15H16V13H18ZM16 9V11H14V9H16Z"></path></svg>
	                    </div>
	                    <h2><?php echo $juegosv; ?></h2>
	                    <p>Juegos</p>
	                </label>
	                <label class="layout" for="btn-modal-personal">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M3 6H21V18H3V6ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM13 8H19V10H13V8ZM18 12H13V14H18V12ZM10.5 10C10.5 11.3807 9.38071 12.5 8 12.5C6.61929 12.5 5.5 11.3807 5.5 10C5.5 8.61929 6.61929 7.5 8 7.5C9.38071 7.5 10.5 8.61929 10.5 10ZM8 13.5C6.067 13.5 4.5 15.067 4.5 17H11.5C11.5 15.067 9.933 13.5 8 13.5Z"></path></svg>
	                    </div>
	                    <h2><?php echo $personalv; ?></h2>
	                    <p>Personal</p>
	                </label>
	                <label class="layout" for="btn-modal-pub">
	                    <div id="svgr">
	                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(93,93,93,1)"><path d="M12.598 16 9.39893 8H7.39893L5.39893 13 5.39795 13.002 4.19897 16H6.35303L6.75293 15H10.043L10.443 16H12.598ZM7.552 13 8.39893 10.8851 9.24402 13H7.552ZM17 8H19V16H16C14.3431 16 13 14.6569 13 13 13 11.3431 14.3431 10 16 10H17V8ZM16 12C15.4478 12 15 12.4478 15 13 15 13.5522 15.4478 14 16 14H17V12H16ZM21 3H3C2.44775 3 2 3.44775 2 4V20C2 20.5522 2.44775 21 3 21H21C21.5522 21 22 20.5522 22 20V4C22 3.44775 21.5522 3 21 3ZM4 19V5H20V19H4Z"></path></svg>
	                    </div>
	                    <h2><?php echo $publicidadv; ?></h2>
	                    <p>Publicidades</p>
	                </label>
	            </div>
	            <h3>Configuracion de equipos <label class="btn-mas" for="btn-modal-liga">+Subir equipos/ligas</label></h3>
	            <div id="tabla-users-r">
                    <table>
                        <tr>
                            <th>Nombre</th>
                            <th>Cant. de equipos</th>
                            <th></th>
                        </tr>
    <?php
                    $sql2 = mysqli_query($conn, "SELECT * FROM equipos_t WHERE id > 0");
                    while ($rows = mysqli_fetch_row($sql2)) {
                        $sqlec = mysqli_query($conn, "SELECT COUNT(id_equipo) FROM equipos WHERE titulo = '$rows[0]'");
                        $sqlec = $sqlec->fetch_row();
    ?>
                        <tr>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $sqlec[0]; ?></td>
                            <td><a href="/administracion?l=<?php echo $rows[0]; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(93,93,93,1)"><path d="M21 15.2426V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5511 3 20.9925V9H9C9.55228 9 10 8.55228 10 8V2H20.0017C20.5531 2 21 2.45531 21 2.9918V6.75736L12.0012 15.7562L11.995 19.995L16.2414 20.0012L21 15.2426ZM21.7782 8.80761L23.1924 10.2218L15.4142 18L13.9979 17.9979L14 16.5858L21.7782 8.80761ZM3 7L8 2.00318V7H3Z"></path></svg>
                                </a></td>
                        </tr>
    <?php
                    }
    ?>
                    </table>
	            </div>
	        </main>
	    </content>
	</div>
<?php
    }else{
        header('Location: https://csport.es');
    }
?>
</body>
</html>
<script type="text/javascript">
    $('#act-ut').click(function(e) {
        document.getElementById('act-utt').style.display = "block";
        document.getElementById('act-utd').style.display = "none";
        document.getElementById('act-uts').style.display = "none";
        document.getElementById('act-utm').style.display = "none";
        
        document.getElementById('act-ut').classList.add('acta');
        document.getElementById('act-us').classList.remove('acta');
        document.getElementById('act-ud').classList.remove('acta');
        document.getElementById('act-um').classList.remove('acta');
        document.getElementById("actti").innerHTML = "(Total)";
    });
    $('#act-ud').click(function(e) {
        document.getElementById('act-utt').style.display = "none";
        document.getElementById('act-utd').style.display = "block";
        document.getElementById('act-uts').style.display = "none";
        document.getElementById('act-utm').style.display = "none";
        
        document.getElementById('act-ut').classList.remove('acta');
        document.getElementById('act-ud').classList.add('acta');
        document.getElementById('act-us').classList.remove('acta');
        document.getElementById('act-um').classList.remove('acta');
        document.getElementById("actti").innerHTML = "(Diario)";
    });
    $('#act-us').click(function(e) {
        document.getElementById('act-utt').style.display = "none";
        document.getElementById('act-utd').style.display = "none";
        document.getElementById('act-uts').style.display = "block";
        document.getElementById('act-utm').style.display = "none";
        
        document.getElementById('act-ut').classList.remove('acta');
        document.getElementById('act-ud').classList.remove('acta');
        document.getElementById('act-us').classList.add('acta');
        document.getElementById('act-um').classList.remove('acta');
        document.getElementById("actti").innerHTML = "(Semanal)";
    });
    $('#act-um').click(function(e) {
        document.getElementById('act-utt').style.display = "none";
        document.getElementById('act-utd').style.display = "none";
        document.getElementById('act-uts').style.display = "none";
        document.getElementById('act-utm').style.display = "block";
        
        document.getElementById('act-ut').classList.remove('acta');
        document.getElementById('act-ud').classList.remove('acta');
        document.getElementById('act-us').classList.remove('acta');
        document.getElementById('act-um').classList.add('acta');
        document.getElementById("actti").innerHTML = "(Mensual)";
    });
    $('#r-transferido').click(function(e) {
		e.preventDefault();
        document.getElementById('r-transferido').disabled = true;
        
		$.ajax({
			url: '/bd/retiro-a.php?id=<?php echo $id_t; ?>',
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
<?php
    if(isset($_GET['s'])){
?>
    $(window).load(function(){
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "block";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('configuracion').style.display = "none";
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.add('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        document.getElementById('btn-auditar').classList.remove('activo');
        document.getElementById('btn-config').classList.remove('activo');
    });
<?php
    }
    if(isset($_GET['l'])){
?>
    $(window).load(function(){
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('configuracion').style.display = "block";
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        document.getElementById('btn-auditar').classList.remove('activo');
        document.getElementById('btn-config').classList.add('activo');
    });
<?php
    }
    if(isset($_GET['config'])){
?>
    $(window).load(function(){
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('configuracion').style.display = "block";
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        document.getElementById('btn-auditar').classList.remove('activo');
        document.getElementById('btn-config').classList.add('activo');
    });
<?php
    }
?>
    px = window.innerWidth
    $('#nav-cel').click(function(e) {
        document.getElementById('header').style.display = "block";
        document.getElementById('nav-cel').style.display = "none";
    });
    $('#btn-info').click(function(e) {
        document.getElementById('informacion').style.display = "block";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('btn-auditar').classList.remove('activo');
        
        document.getElementById('btn-info').classList.add('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        if(px <= '600'){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
    $('#btn-balance').click(function(e) {
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "block";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('configuracion').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('btn-auditar').classList.remove('activo');
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.add('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-config').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        if(px <= 600){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
    $('#btn-soporte').click(function(e) {
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "block";
        document.getElementById('configuracion').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('btn-auditar').classList.remove('activo');
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.add('activo');
        document.getElementById('btn-config').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        if(px <= 600){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
    $('#btn-torneo').click(function(e) {
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('configuracion').style.display = "none";
        document.getElementById('torneo').style.display = "block";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('btn-auditar').classList.remove('activo');
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-config').classList.remove('activo');
        document.getElementById('btn-torneo').classList.add('activo');
        if(px <= 600){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
    $('#btn-config').click(function(e) {
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('configuracion').style.display = "block";
        document.getElementById('auditar').style.display = "none";
        document.getElementById('btn-auditar').classList.remove('activo');
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        document.getElementById('btn-config').classList.add('activo');
        if(px <= 600){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
    $('#btn-auditar').click(function(e) {
        document.getElementById('informacion').style.display = "none";
        document.getElementById('balances').style.display = "none";
        document.getElementById('soporte').style.display = "none";
        document.getElementById('torneo').style.display = "none";
        document.getElementById('configuracion').style.display = "none";
        document.getElementById('auditar').style.display = "block";
        document.getElementById('btn-auditar').classList.add('activo');
        
        document.getElementById('btn-info').classList.remove('activo');
        document.getElementById('btn-balance').classList.remove('activo');
        document.getElementById('btn-soporte').classList.remove('activo');
        document.getElementById('btn-torneo').classList.remove('activo');
        document.getElementById('btn-config').classList.remove('activo');
        if(px <= 600){
            document.getElementById('header').style.display = "none";
            document.getElementById('nav-cel').style.display = "block";
        }
    });
<?php
    $rowsP2 = 0;
    while ($sqlapv2 = mysqli_fetch_row($sqlpc2)) {
        $rowsP2 = $rowsP2 + 1;
?>
        $('#c_rol<?php echo $rowsP2; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('c_rol<?php echo $rowsP2; ?>').disabled = true;
            
    		var id = document.getElementById('pid<?php echo $rowsP2; ?>').value;
    		var rol = document.getElementById('prol<?php echo $rowsP2; ?>').value;
    		
    		var php = "id="+id+"&rol="+rol;
            
    		$.ajax({
    			url: '/bd/rol.php',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    			    $("#rolca<?php echo $rowsP2; ?>").load(location.href + " #rolca<?php echo $rowsP2; ?>");
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Rol cambiado con exitor";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('c_rol<?php echo $rowsP2; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    
    $rowsct = 0;
    while ($ctj = mysqli_fetch_row($juegost)) {
        $rowsct = $rowsct + 1;
?>
        $('#btn_ctj<?php echo $rowsct; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_ctj<?php echo $rowsct; ?>').disabled = true;
            
    		var ti = document.getElementById('c_tj<?php echo $rowsct; ?>').value;
    		var id = document.getElementById('cid<?php echo $rowsct; ?>').value;
    		
    		var php = "ti="+ti+"&id="+id;
            
    		$.ajax({
    			url: '/bd/juegos_admin.php?titulo',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Titulo cambiado con exito";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_ctj<?php echo $rowsct; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    $rowscti = 0;
    while ($ctij = mysqli_fetch_row($juegosti)) {
        $rowscti = $rowscti + 1;
?>
        $('#btn_ctij<?php echo $rowscti; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_ctij<?php echo $rowscti; ?>').disabled = true;
            
    		var tipo = document.getElementById('c_tij<?php echo $rowscti; ?>').value;
    		var id = document.getElementById('cid<?php echo $rowscti; ?>').value;
    		
    		var php = "tipo="+tipo+"&id="+id;
            
    		$.ajax({
    			url: '/bd/juegos_admin.php?tipo',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Tipo cambiado con exito";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_ctij<?php echo $rowsP2; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    $rowsci = 0;
    while ($cij = mysqli_fetch_row($juegosi)) {
        $rowsci = $rowsci + 1;
?>
        $('#btn_cij<?php echo $rowsci; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_cij<?php echo $rowsci; ?>').disabled = true;
            
    		var img = document.getElementById('cid<?php echo $rowsci; ?>').value;
    		var id = document.getElementById('cid<?php echo $rowsct; ?>').value;
    		
    		var php = "img"+img+"&id="+id;
            
    		$.ajax({
    			url: '/bd/juegos_admin.php?img',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Rol cambiado con exitor";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_cij<?php echo $rowsci; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    $rowsce = 0;
    while ($cej = mysqli_fetch_row($juegose)) {
        $rowsce = $rowsce + 1;
?>
        $('#btn_ej<?php echo $rowsce; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_ej<?php echo $rowsce; ?>').disabled = true;
            
    		var id = document.getElementById('cid<?php echo $rowsce; ?>').value;
    		
    		var php = "eliminar="+id;
            
    		$.ajax({
    			url: '/bd/juegos_admin.php?eliminar',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Juego eliminado con exito";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_ej<?php echo $rowsce; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    
    $rowspubl = 0;
    while ($bpubl = mysqli_fetch_row($publicidadl)) {
        $rowspubl = $rowspubl + 1;
?>
        $('#btn_publ<?php echo $rowspubl; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_publ<?php echo $rowspubl; ?>').disabled = true;
            
    		var link = document.getElementById('publ<?php echo $rowspubl; ?>').value;
    		var id = document.getElementById('pubid<?php echo $rowspubl; ?>').value;
    		
    		var php = "link="+link+"&id="+id;
            
    		$.ajax({
    			url: '/bd/pubs_admin.php?link',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Link actualizado";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_publ<?php echo $rowspubl; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
    $rowspube = 0;
    while ($bpube = mysqli_fetch_row($publicidade)) {
        $rowspube = $rowspube + 1;
?>
        $('#btn_pubd<?php echo $rowspube; ?>').click(function(e) {
    		e.preventDefault();
            
            document.getElementById('btn_pubd<?php echo $rowspube; ?>').disabled = true;
            
    		var id = document.getElementById('pubid<?php echo $rowspube; ?>').value;
    		
    		var php = "eliminar="+id;
            
    		$.ajax({
    			url: '/bd/pubs_admin.php?eliminar',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Publicidad eliminada";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn_pubd<?php echo $rowspube; ?>').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
	    });
<?php
    }
?>
    $('#btn-bono').click(function(e) {
		e.preventDefault();
        
        document.getElementById('btn-bono').disabled = true;
        
		var evento = document.getElementById('b_evento').value;
		var titulo = document.getElementById('b_titulo').value;
		var tipob = document.getElementById('b_tipob').value;
		var nro = document.getElementById('b_nro').value;
		var tipop = document.getElementById('b_tipop').value;
		var tiempo = document.getElementById('b_tiempo').value;
		var fecha = document.getElementById('b_fechae').value;
		
		var php = "evento="+evento+"&titulo="+titulo+"&tipob="+tipob+"&nro="+nro+"&tipop="+tipop+"&tiempo="+tiempo+"&fecha="+fecha;
        
        if((evento == "") || (titulo == "") || (nro == "")){
            document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "Debes rellenar el formulario";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('btn-bono').disabled = false;
			}, 4000);
        }else{
            $.ajax({
    			url: '/bd/c_bono.php',
    			type: 'POST',
    			dataType: 'json',
    			data: php,
    		})
    		.done(function(res) {
    			if (res == "aprobado") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Bono creado con exito";
    			  	document.getElementById('b_evento').value = "";
    			  	document.getElementById('b_titulo').value = "";
    			  	document.getElementById('b_nro').value = "";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn-bono').disabled = false;
    				}, 4000);
    			}
    			if (res == "existe") {
    				document.getElementById("error").style.display = "block";
    			  	document.getElementById("error").innerHTML = "Titulo de bono ya existente";
    				setTimeout(() => {
    					document.getElementById("error").style.display = "none";
    					document.getElementById('btn-bono').disabled = false;
    				}, 4000);
    			}
    		})
    		.fail(function() {
    		})
    		.always(function() {
    		});
        }
	});
	$('#btn-pa').click(function(e) {
		e.preventDefault();
        
        document.getElementById('btn-pa').disabled = true;
        
		var email = document.getElementById('paemail').value;
		var rol = document.getElementById('parol').value;
		
		var php = "email="+email+"&rol="+rol;
        
		$.ajax({
			url: '/bd/rol_a.php',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "aprobado") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Personal agregado";
			  	document.getElementById('paemail').value = "";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('btn-pa').disabled = false;
				}, 4000);
			}
			if (res == "email") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Este personal ya existe";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('btn-pa').disabled = false;
				}, 4000);
			}
			if (res == "nexiste") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Email no registrado";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('btn-pa').disabled = false;
				}, 4000);
			}
		})
		.fail(function() {
		})
		.always(function() {
		});
	});
    $('#cargarsl').click(function(e) {
		e.preventDefault();
        
        //document.getElementById('cargarsl').disabled = true;
        
		var email = document.getElementById('emailsl').value;
		
		var php = "email="+email;
        $.ajax({
            url: '/bd/agg_s.php',
            type: 'POST',
            data: php,
            success: function(response) {
                var datos = response.split('"');

                if (datos[1] == "aprobado") {
                    document.getElementById("errorsl").style.display = "block";
    			  	document.getElementById("errorsl").innerHTML = "Cargando...";
    				setTimeout(() => {
    				    document.getElementById("errorsl").style.display = "none";
    					document.getElementById("formdp2").style.display = "block";
    					document.getElementById("formdp").style.display = "none";
    					document.getElementById("emaildp").innerHTML = "Id: "+datos[3]+" | "+datos[5];
    					document.getElementById("idsl").value = datos[3];
    				}, 2000);
    			}
                if (datos[1] == "email") {
    				document.getElementById("errorsl").style.display = "block";
    			  	document.getElementById("errorsl").innerHTML = "Este email no existe";
    				setTimeout(() => {
    					document.getElementById("errorsl").style.display = "none";
    					document.getElementById('cargarsl').disabled = false;
    				}, 4000);
    			}
            },
        });
	});
    $('#cargarsl2').click(function(e) {
		e.preventDefault();
        
        document.getElementById('cargarsl2').disabled = true;
        
		var saldo = document.getElementById('saldosl').value;
		var orden = document.getElementById('ordensl').value;
		var transs = document.getElementById('transl').value;
		var id = document.getElementById('idsl').value;
		
		var php = "saldo="+saldo+"&orden="+orden+"&transs="+transs+"&id="+id;
        if((saldo !== "") && (orden !== "") && (transs !== "")){
            $.ajax({
                url: '/bd/agg_s.php?dp=0',
                type: 'POST',
                data: php,
                success: function(response) {
                    var datos = response.split('"');
    
                    if (datos[1] == "agregado") {
                        document.getElementById("errorsl").style.display = "block";
        			  	document.getElementById("errorsl").innerHTML = "Saldo actualizado con exito";
        				setTimeout(() => {
        				    document.getElementById("errorsl").style.display = "none";
        					document.getElementById("formdp").style.display = "block";
        					document.getElementById("formdp2").style.display = "none";
        					document.getElementById('cargarsl2').disabled = false;
        				}, 2000);
        			}
                },
            });
        }else{
            document.getElementById("errorsl").style.display = "block";
		  	document.getElementById("errorsl").innerHTML = "Debes completar los datos";
			setTimeout(() => {
				document.getElementById("errorsl").style.display = "none";
				document.getElementById('cargarsl2').disabled = false;
			}, 4000);
        }
	});
	pantalla = window.innerHeight
	document.getElementById('pantalla').style.height = pantalla+'px';
</script>