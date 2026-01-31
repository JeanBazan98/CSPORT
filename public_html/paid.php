<?php
    error_reporting(0);
    session_start();
    include_once 'bd/conexion.php';
    
    $id = $_SESSION['datos']['id'];
    $orderID = $_GET['order'];
    $sql = mysqli_query($conn, "SELECT * FROM wallet_t WHERE id_cuenta = '$id' AND orden = '$orderID'");
    $sqlv = $sql->fetch_row();
    if($sqlv){
        if($sqlv[3] == 3){
            $pagoT = $sqlv[3] + 0.5;
        }else{
            $pago = $sqlv[3] * 0.12;
            $pagoT = $sqlv[3] + $pago;
        }
        
?>
    <html>
    <head>
        <title>Factura - Csport</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/css/paid.css">
        <link rel="icon" type="image/x-icon" href="/img/Logo.png">
    	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    </head>
    <body>
        <div id="pantalla">
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
        	<div id="contenido">
        		<h2>PAGO COMPLETADO</h2>
        		<p>Tu compra se realizo correctamente</p>
        		<div id="resumen">
        			<h2>Detalles</h2>
        			<span style="margin-bottom: 1rem;">• Saldo <?php echo $sqlv[3]; ?>USD</span>
        			<span>Nro de orden: <?php echo $sqlv[5]; ?></span>
        			<span>Fecha: <?php echo $sqlv[8]; ?></span>
        			<h1>Pagaste: <?php echo $pagoT; ?>USD</h1>
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
    </body>
    </html>
    <script type="text/javascript">
    	pantalla = window.innerHeight
    	document.getElementById('pantalla').style.height = pantalla+'px';
    </script>
<?php
    }else{
        header('Location: https://csport.es/buscador');
    }
?>