<?php
    error_reporting(0);
	session_start();
	include_once 'bd/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="@oghb1d">
    <meta name="description" content="Es una Plataforma líder para competir en torneos de videojuegos y ganar dinero real. Convierte cada desafío 1v1">
    <meta name="category" content="Esports, Torneos, Juegos">
    <meta itemprop="image" content="img/1.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/index.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
 	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Csport | Juega y Gana </title>
</head>
<body>
    <script src="../status.js"></script>
	<div id="pantalla">
	    <header>
	        <div id="nav">
    	            <ul>
    	            <?php
    					if (empty(($_SESSION['datos']))) {
    				?>
    					<li><a href="/" style="font-weight: 600; font-size: 1.2rem;">CSPORT</a></li>
    					<li><a href="/login" style="margin-right: 3.75rem; color: #000; font-weight: bold; background: #faeec0; padding: .25rem .75rem; border-radius: .5rem;">Iniciar sesion</a></li>
    				<?php
    					}else{
    				?>
    					<li><a href="/" style="font-weight: 600; font-size: 1.2rem;">CSPORT</a></li>
    					<li><a href="/bd/cerrar" style="margin-right: 3.5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z"></path></svg></a></li>
    					<li><a href="/perfil/<?php echo $_SESSION['datos']['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="rgba(242,242,242,1)"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg></a></li>
    					<li><a href="/buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(255,255,255,1)"><path d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z"></path></svg></a></li>
    				<?php
    					}
    				?>
    	            </ul>
    	        </div>
	        <video src="/img/index.mp4" loop="true" muted autoplay preload></video>
	        <div id="t_text">
			    <h1 id="t_titulo">Compite y Gana Premios Reales</h1>
				<p id="t_subt">Torneos de esports para todos</p>
				<p id="t_desc">Pon a prueba tus habilidades en emocionantes competiciones y gana premios increíbles. ¡Elige tu juego y demuestra que eres el mejor!</p>
				<a href="/login">Unete</a>
			</div>
	    </header>
        <div class="contenido">
            <div id="c-juegos">
                <h2>ULTIMOS JUEGOS DISPONIBLES</h2>
    			<h4>Descubra torneos con premios de efectivo en los videojuegos más populares</h4>
    			<div id="c_juegos">
    				<div class="juegos"><label><img src="img/fifa24.jpeg"></label></div>
    				<div class="juegos"><label><img src="img/fifa25.jpg"></label></div>
    				<div class="juegos"><label><img src="img/fcm.jpg"></label></div>
    				<!--<div class="juegos"><label><img src="img/bs.jpg"></label></div>-->
    			</div>
    			<a id="btn" href="/buscador">TORNEOS GRATUITOS</a>
            </div>
		</div>
		<div class="contenido" style="margin-top: 0rem; padding-bottom: 1rem;">
            <div id="c-torneos">
                <h2>ULTIMOS TORNEOS ORGANIZADOS POR LA PLATAFORMA</h2>
    			<div id="c_torneos">
    		<?php
    		    $sqltind = mysqli_query($conn, "SELECT img,titulo,id_cuenta,fecha,price,juego,plataforma,id FROM torneos WHERE (id_cuenta = '2') OR (id_cuenta = '3') ORDER BY id DESC LIMIT 4");
    		    while ($sqltindv = mysqli_fetch_row($sqltind)) {
    		        $pricetin = explode("/", $sqltindv[4]);
    		        $sqlnin = mysqli_query($conn, "SELECT nombre FROM cuentas WHERE id_cuenta = '$sqltindv[2]'");
    		        $sqlnin = $sqlnin->fetch_row();
    		?>
    		        <div class="torneos"><a href="/torneo/<?php echo $sqltindv[7]; ?>">
    			        <img src="/img/FifaI.png">
    			        <label><?php echo $sqltindv[5]; ?> - <?php echo $sqltindv[6]; ?></label>
    			        <p><?php echo $sqltindv[1]; ?></p>
    			        <content>
    			            <span>Organizado por</span>
    			            <span><?php echo $sqlnin[0]; ?></span>
    			        </content>
    			        <div>
    			            <h4><?php echo $sqltindv[3]; ?></h4><h4><?php if($pricetin[1]){ echo $pricetin[1]." USD"; }else{ echo "FREE"; } ?></h4>
    			        </div>
    			    </a></div>
    		<?php
    		    }
    		    
    		?>
    			</div>
            </div>
		</div>
		<div id="discord">
		    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="68" height="68" fill="rgba(242,242,242,1)"><path d="M19.3034 5.33716C17.9344 4.71103 16.4805 4.2547 14.9629 4C14.7719 4.32899 14.5596 4.77471 14.411 5.12492C12.7969 4.89144 11.1944 4.89144 9.60255 5.12492C9.45397 4.77471 9.2311 4.32899 9.05068 4C7.52251 4.2547 6.06861 4.71103 4.70915 5.33716C1.96053 9.39111 1.21766 13.3495 1.5891 17.2549C3.41443 18.5815 5.17612 19.388 6.90701 19.9187C7.33151 19.3456 7.71356 18.73 8.04255 18.0827C7.41641 17.8492 6.82211 17.5627 6.24904 17.2231C6.39762 17.117 6.5462 17.0003 6.68416 16.8835C10.1438 18.4648 13.8911 18.4648 17.3082 16.8835C17.4568 17.0003 17.5948 17.117 17.7434 17.2231C17.1703 17.5627 16.576 17.8492 15.9499 18.0827C16.2789 18.73 16.6609 19.3456 17.0854 19.9187C18.8152 19.388 20.5875 18.5815 22.4033 17.2549C22.8596 12.7341 21.6806 8.80747 19.3034 5.33716ZM8.5201 14.8459C7.48007 14.8459 6.63107 13.9014 6.63107 12.7447C6.63107 11.5879 7.45884 10.6434 8.5201 10.6434C9.57071 10.6434 10.4303 11.5879 10.4091 12.7447C10.4091 13.9014 9.57071 14.8459 8.5201 14.8459ZM15.4936 14.8459C14.4535 14.8459 13.6034 13.9014 13.6034 12.7447C13.6034 11.5879 14.4323 10.6434 15.4936 10.6434C16.5442 10.6434 17.4038 11.5879 17.3825 12.7447C17.3825 13.9014 16.5548 14.8459 15.4936 14.8459Z"></path></svg>
			<p style="float: right;" id="ds">Unete a nuestra comunidad de discord</p>
            <a href="https://discord.com/invite/xGWuQWxrF2" target="blank">¡Entrar!</a>
		</div>
		<div class="contenido-i">
		    <div id="c-info">
		        <h2>Sitio confiable</h2>
    			<h4>COP SPORT | Es la plataforma líder para jugadores que quieren apostar y ganar dinero por sus habilidades. Es una plataforma reconocida que convierte tus competencias de juego en dinero real, y cada sesion de juego en una oportunidad para ganar.</h4>
		    </div>
		    <div id="c-infoimg"></div>
		</div>
		<div class="contenido-t">
			<span class="mySlides">
			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(242,242,242,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
		        <p>Me parece muy bueno este grupo.. Se organizan muy bien los torneos…
		        Aprendes, ríes, llora, hay rivalidad y competencia
		        Pero lo más importante es que te apartas un poco de tus problemas personales, te distraes y la pasas muy bien…  tiene muy buena administración. ✅✅</p>
		        <h5>Jesus Perez</h5>
			</span>
			<span class="mySlides">
			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(242,242,242,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
		        <p>Llevo meses formando parte de la comunidad de COP SPORT y ah sido una experiencia gratificante. El sitio web ofrece emocionantes retos y competiciones de juegos, lo que facilita ganar dinero haciendo lo que me gusta.</p>
		        <h5>Gabriel Diaz</h5>
			</span>
			<span class="mySlides">
			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(242,242,242,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
		        <p>La mejor experiencia en torneos de eSports, competitividad y gran relación con la administración. Perfecto para llegar a niveles semi profesionales y profesionales</p>
                <h5>Alexander Vieyra</h5>
			</span>
			<span class="mySlides">
			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(242,242,242,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
		        <p>Excelenteeeee,muy bien organizado los torneos y buen trabajo de los administradores los cuales admiro mucho por su desempeño de que esta comunidad crezca y se desarrolle cada día más.</p>
		        <h5>Andy Aguila</h5>
			</span>
			<span class="mySlides">
			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(242,242,242,1)"><path d="M4.58341 17.3211C3.55316 16.2274 3 15 3 13.0103C3 9.51086 5.45651 6.37366 9.03059 4.82318L9.92328 6.20079C6.58804 8.00539 5.93618 10.346 5.67564 11.822C6.21263 11.5443 6.91558 11.4466 7.60471 11.5105C9.40908 11.6778 10.8312 13.159 10.8312 15C10.8312 16.933 9.26416 18.5 7.33116 18.5C6.2581 18.5 5.23196 18.0095 4.58341 17.3211ZM14.5834 17.3211C13.5532 16.2274 13 15 13 13.0103C13 9.51086 15.4565 6.37366 19.0306 4.82318L19.9233 6.20079C16.588 8.00539 15.9362 10.346 15.6756 11.822C16.2126 11.5443 16.9156 11.4466 17.6047 11.5105C19.4091 11.6778 20.8312 13.159 20.8312 15C20.8312 16.933 19.2642 18.5 17.3312 18.5C16.2581 18.5 15.232 18.0095 14.5834 17.3211Z"></path></svg>
		        <p>Los torneos de copa sport han sido la mejor oportunidad durante este FC 24 para ganar nivel y experiencia con la mejor organización y acompañamiento</p>
		        <h5>Daniel Alfonso</h5>
			</span>
			<a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>
            <script>
                let slideIndex = 1;
                showSlides(slideIndex);
                
                function plusSlides(n) {
                  showSlides(slideIndex += n);
                }
                function currentSlide(n) {
                  showSlides(slideIndex = n);
                }
                
                function showSlides(n) {
                  let i;
                  let slides = document.getElementsByClassName("mySlides");
                  let dots = document.getElementsByClassName("dot");
                  if (n > slides.length) {slideIndex = 1}    
                  if (n < 1) {slideIndex = slides.length}
                  for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                  }
                  for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                  }
                  slides[slideIndex-1].style.display = "block";  
                  dots[slideIndex-1].className += " active";
                }
            </script>
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
		            <div id="design"><svg style="float: left; margin-right: .25rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="14" height="14" fill="rgba(144,144,144,1)"><path d="M392.8 1.2c-17-4.9-34.7 5-39.6 22l-128 448c-4.9 17 5 34.7 22 39.6s34.7-5 39.6-22l128-448c4.9-17-5-34.7-22-39.6zm80.6 120.1c-12.5 12.5-12.5 32.8 0 45.3L562.7 256l-89.4 89.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-112-112c-12.5-12.5-32.8-12.5-45.3 0zm-306.7 0c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l112 112c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256l89.4-89.4c12.5-12.5 12.5-32.8 0-45.3z"/></svg><a href="https://instagram.com/jean_bazan/" target="blank" style="text-decoration: none; color: #909090; font-size: .7rem;">Producido por @jean_bazan</a>
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