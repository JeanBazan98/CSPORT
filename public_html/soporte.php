<?php
    error_reporting(0);
    session_start();
	include_once 'bd/conexion.php';
    $id_cuenta = $_SESSION['datos']['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/ayuda.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Soporte - Csport</title>
</head>
<body>
    <script src="../status.js"></script>
	<div id="pantalla"><span id="errorwd1"></span>
    	<div id="soporte-wait">
    	    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="rgba(242,242,242,1)"><path d="M4 2H20V6.45994L13.5366 12L20 17.5401V22H4V17.5401L10.4634 12L4 6.45994V2ZM16.2967 7L18 5.54007V4H6V5.54007L7.70326 7H16.2967ZM12 13.3171L6 18.4599V20H7L12 17L17 20H18V18.4599L12 13.3171Z"></path></svg>
    	</div>
    	<div id="soporte-content">
            <div style="width: 100%; height: 100%; overflow-y: scroll; scrollbar-width: thin;">
                <h3>Centro de tickets</h3>
                <div id="soporte-content-ticket"></div>
                <script type="text/javascript">
                    var userid = localStorage.getItem('sc_oUser');
                    var php = "user="+userid;
                    $.ajax({
        				url: 'bd/soporte-t.php',
        				type: 'POST',
        				dataType: 'text',
        				data: php,
        				success:function(data){
        					$("#soporte-content-ticket").html(data);
        				}
        			});
                </script>
            </div>
    	</div>
    	
	    <input type="checkbox" id="btn-modal-cuenta">
		<div class="container-modal-cuenta">
	        <div class="content-modal-cuenta">
	            <h1>No tengo acceso a mi cuenta</h1>
	            <p>Si no puedes acceder a tu cuenta de CSPORT, selecciona el problema que mejor describa tu situación. Sigue las instrucciones para volver a acceder a tu cuenta.</p>
	            <ul>
	                <li id="cmc-1">Olvidaste la dirección de correo electrónico que usas para acceder.</li>
	                <li id="cmc-2">Conoces tu nombre de usuario y contraseña, pero no puedes acceder.</li>
	                <li id="cmc-3">Crees que otra persona usa tu cuenta.</li>
	            </ul>
	        </div>
	        <div class="content-modal-cuenta-1">
	            <div id="cmc-b">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg>
	            </div>
	            <h1>Olvidaste la dirección de correo electrónico que usas para acceder</h1>
	            <p>Proporciona toda la informacion que tengas de tu cuenta</p>
	            <form>
	                <label>Ingresa tu nombre de usuario</label>
	                <input type="text" id="cmc-user">
	                <span>Breve descripcion de tu problema</span>
	                <input type="text" id="cmc-text">
	                <button id="cmc-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
	            </form>
	        </div>
	        <div class="content-modal-cuenta-2">
	            <div id="cmc-b">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg>
	            </div>
	            <h1>Conoces tu nombre de usuario y contraseña, pero no puedes acceder</h1>
	            <p>Proporciona toda la informacion que tengas de tu cuenta</p>
	            <form>
	                <label>Ingresa tu nombre de usuario</label>
	                <input type="text" id="cmc-user2">
	                <span>Breve descripcion de tu problema</span>
	                <input type="text" id="cmc-text2">
	                <button id="cmc-btn2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
	            </form>
	        </div>
	        <div class="content-modal-cuenta-3">
	            <div id="cmc-b">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg>
	            </div>
	            <h1>Crees que otra persona usa tu cuenta</h1>
	            <p>Proporciona toda la informacion que tengas de tu cuenta</p>
	            <form>
	                <label>Ingresa tu nombre de usuario</label>
	                <input type="text" id="cmc-user3">
	                <span>Breve descripcion de tu problema</span>
	                <input type="text" id="cmc-text3">
	                <button id="cmc-btn3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
	            </form>
	        </div>
	        <label for="btn-modal-cuenta" class="cerrar-modal-cuenta"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-contraseña">
		<div class="container-modal-contraseña">
	        <div class="content-modal-contraseña">
	            <h1>¿Cómo cambio o restablezco la contraseña de mi cuenta?</h1>
	            <p>Puedes cambiar la contraseña por razones de seguridad o restablecerla si te la olvidas.</p>
	            <ol>
	                <li>Abre la seccion de Configuración de tu cuenta de CSPORT.</li>
	                <li>Ingresa la contraseña nueva; luego, presiona Cambiar</li>
	            </ol>
	            <p>o</p>
	            <ol>
	                <li>Abre la seccion de Iniciar Sesion</li>
	                <li>luego, ¿Has olvidado la contraseña?</li>
	                <li>y escribe tu correo electrónico</li>
	            </ol>
	        </div>
	        <label for="btn-modal-contraseña" class="cerrar-modal-contraseña"></label>
	    </div>
	    <input type="checkbox" id="btn-modal-transacciones">
		<div class="container-modal-transacciones">
	        <div class="content-modal-transacciones">
	            <h1>Tengo problemas con mis transacciones</h1>
	            <p>Informacion sobre todo lo que necesitas saber sobre la wallet de CSPORT</p>
	            <ul>
	                <li id="cmt-1">No se como recargar saldo en mi cuenta de CSPORT.</li>
	                <li id="cmt-2">Deposite saldo y todavia no lo veo reflejado en mi cuenta.</li>
	            </ul>
	        </div>
	        <div class="content-modal-transacciones-1">
	            <div id="cmc-t">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg>
	            </div>
	            <h1>No se como recargar saldo en mi cuenta de CSPORT</h1>
	            <p>Proporciona toda la informacion que tengas de tu cuenta</p>
	            <form>
	                <label>Ingresa tu nombre de usuario</label>
	                <input type="text" id="cmt-user">
	                <span>Breve descripcion de tu problema</span>
	                <input type="text" id="cmt-text">
	                <button id="cmt-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
	            </form>
	        </div>
	        <div class="content-modal-transacciones-2">
	            <div id="cmc-t">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(242,242,242,1)"><path d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z"></path></svg>
	            </div>
	            <h1>Deposite saldo y todavia no lo veo reflejado en mi cuenta</h1>
	            <p>Proporciona toda la informacion que tengas de tu cuenta</p>
	            <form>
	                <label>Ingresa tu nombre de usuario</label>
	                <input type="text" id="cmt-user2">
	                <span>Breve descripcion de tu problema</span>
	                <input type="text" id="cmt-text2">
	                <button id="cmt-btn2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="rgba(242,242,242,1)"><path d="M3 12.9999H9V10.9999H3V1.84558C3 1.56944 3.22386 1.34558 3.5 1.34558C3.58425 1.34558 3.66714 1.36687 3.74096 1.40747L22.2034 11.5618C22.4454 11.6949 22.5337 11.9989 22.4006 12.2409C22.3549 12.324 22.2865 12.3924 22.2034 12.4381L3.74096 22.5924C3.499 22.7255 3.19497 22.6372 3.06189 22.3953C3.02129 22.3214 3 22.2386 3 22.1543V12.9999Z"></path></svg></button>
	            </form>
	        </div>
	        <label for="btn-modal-transacciones" class="cerrar-modal-transacciones"></label>
	    </div>
	    
		<header>
			<ul><li><a href="/">CSPORT <p style="background: #009eba; color: #f2f2f2; padding: .125rem .25rem; font-size: .5rem; border-radius: .2rem; margin-left: .5rem; margin-top: .2rem;">BETA</p></a></li></ul>
		</header>
		<div id="tutorial"><p>Soporte</p></div>
		<div id="contenido3">
			<div style="background: #f2f2f2; width: 100%; float: left;">
    		    <h2>¿Con qué podemos ayudarte?</h2>
    			<label for="btn-modal-cuenta" class="stco"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(255,255,255,1)"><path d="M14.2558 21.7442L12 24L9.74416 21.7442C5.30941 20.7204 2 16.7443 2 12C2 6.48 6.48 2 12 2C17.52 2 22 6.48 22 12C22 16.7443 18.6906 20.7204 14.2558 21.7442ZM6.02332 15.4163C7.49083 17.6069 9.69511 19 12.1597 19C14.6243 19 16.8286 17.6069 18.2961 15.4163C16.6885 13.9172 14.5312 13 12.1597 13C9.78821 13 7.63095 13.9172 6.02332 15.4163ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z"></path></svg> No tengo acceso a mi cuenta</label>
    			<label for="btn-modal-contraseña" class="stco"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(255,255,255,1)"><path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path></svg> Olvide mi contraseña</label>
		    </div>
		    <div style="background: #f2f2f2; width: 100%; float: left; padding-top: 2rem;">
    			<label for="btn-modal-transacciones" class="stco"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(255,255,255,1)"><path d="M21.5 9C21.5 11.7039 19.849 14.0223 17.5 15.0018L17.5 15C17.5 10.3056 13.6944 6.5 9.00001 6.5L8.99817 6.5C9.97773 4.15105 12.2961 2.5 15 2.5C18.5899 2.5 21.5 5.41015 21.5 9ZM7 3C4.79086 3 3 4.79086 3 7V8.5H5V7C5 5.89543 5.89543 5 7 5H8.5V3H7ZM19 15.5V17C19 18.1046 18.1046 19 17 19H15.5V21H17C19.2091 21 21 19.2091 21 17V15.5H19ZM9 21.5C12.5899 21.5 15.5 18.5899 15.5 15C15.5 11.4101 12.5899 8.5 9 8.5C5.41015 8.5 2.5 11.4101 2.5 15C2.5 18.5899 5.41015 21.5 9 21.5ZM9 12.5L11.5 15L9 17.5L6.5 15L9 12.5Z"></path></svg> Problemas con mis transacciones</label>
		    </div>
		    <!--<div style="background: #f2f2f2; width: 100%; float: left; padding-top: 2rem;">
    			<label for="btn-modal-plataforma" class="stco"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="rgba(255,255,255,1)"><path d="M21 10.063V4C21 3.44772 20.5523 3 20 3H19C17.0214 4.97864 13.3027 6.08728 11 6.61281V17.3872C13.3027 17.9127 17.0214 19.0214 19 21H20C20.5523 21 21 20.5523 21 20V13.937C21.8626 13.715 22.5 12.9319 22.5 12 22.5 11.0681 21.8626 10.285 21 10.063ZM5 7C3.89543 7 3 7.89543 3 9V15C3 16.1046 3.89543 17 5 17H6L7 22H9V7H5Z"></path></svg> Problemas con la plataforma</label>
    			<label for="btn-modal-soporte" class="stco"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="rgba(255,255,255,1)"><path d="M21 8C22.1046 8 23 8.89543 23 10V14C23 15.1046 22.1046 16 21 16H19.9381C19.446 19.9463 16.0796 23 12 23V21C15.3137 21 18 18.3137 18 15V9C18 5.68629 15.3137 3 12 3C8.68629 3 6 5.68629 6 9V16H3C1.89543 16 1 15.1046 1 14V10C1 8.89543 1.89543 8 3 8H4.06189C4.55399 4.05369 7.92038 1 12 1C16.0796 1 19.446 4.05369 19.9381 8H21ZM7.75944 15.7849L8.81958 14.0887C9.74161 14.6662 10.8318 15 12 15C13.1682 15 14.2584 14.6662 15.1804 14.0887L16.2406 15.7849C15.0112 16.5549 13.5576 17 12 17C10.4424 17 8.98882 16.5549 7.75944 15.7849Z"></path></svg> Hablar con soporte</label>
		    </div>-->
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
<?php
    if(isset($_GET['tickets'])){
?>
        $(window).load(function(){
            document.getElementById("soporte-wait").click();
        });
<?php
    }
?>
    $('#cmc-btn').click(function(e) {
		e.preventDefault();
		//document.getElementById('cmc-btn').disabled = true;
        var user = document.getElementById('cmc-user').value;
    	var text = document.getElementById('cmc-text').value;
    	var tipo = "Olvidaste";
    	
        if(localStorage.getItem("sc_oUser")){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Ya tienes un ticket de esta categoria activa";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('cmc-btn').disabled = false;
			}, 4000);
        }else{
    		if((text == "") || (user == "")) {
    			document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('cmc-btn').disabled = false;
    			}, 2000);
    		}else{
    		    var php = "text="+text+"&tipo="+tipo+"&user="+user;
    		    $.ajax({
    				url: '/bd/soporte.php?olvidaste',
    				type: 'POST',
    				dataType: 'json',
    				data: php,
    			})
    			.done(function(res) {
    			    if(res == "aprobado") {
    				    localStorage.setItem("sc_oUser", user);
    				    
    				    document.getElementById('cmc-user').innerHTML = "";
                    	document.getElementById('cmc-text').innerHTML = "";
    				    document.getElementById("errorwd1").style.display = "block";
    		  	        document.getElementById("errorwd1").innerHTML = "Enviado con exito";
    					setTimeout(() => {
    					    document.getElementById("errorwd1").style.display = "none";
    						window.location = "/soporte?tickets";
    					}, 2000);
    				}
    			})
    			.fail(function() {
    			})
    			.always(function() {
    			});
    		}
        }
	});
	$('#cmc-btn2').click(function(e) {
		e.preventDefault();
		//document.getElementById('cmc-btn').disabled = true;
        var user = document.getElementById('cmc-user2').value;
    	var text = document.getElementById('cmc-text2').value;
    	var tipo = "Conoces";
    	
        if(localStorage.getItem("sc_oUser2")){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Ya tienes un ticket de esta categoria activa";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('cmc-btn2').disabled = false;
			}, 4000);
        }else{
    		if((text == "") || (user == "")) {
    			document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('cmc-btn2').disabled = false;
    			}, 2000);
    		}else{
    		    var php = "text="+text+"&tipo="+tipo+"&user="+user;
    		    $.ajax({
    				url: '/bd/soporte.php?conoces',
    				type: 'POST',
    				dataType: 'json',
    				data: php,
    			})
    			.done(function(res) {
    			    if(res == "aprobado") {
    				    localStorage.setItem("sc_oUser2", user);
    				    
    				    document.getElementById('cmc-user2').innerHTML = "";
                    	document.getElementById('cmc-text2').innerHTML = "";
    				    document.getElementById("errorwd1").style.display = "block";
    		  	        document.getElementById("errorwd1").innerHTML = "Enviado con exito";
    					setTimeout(() => {
    					    document.getElementById("errorwd1").style.display = "none";
    						window.location = "/soporte?tickets";
    					}, 2000);
    				}
    			})
    			.fail(function() {
    			})
    			.always(function() {
    			});
    		}
        }
	});
	$('#cmc-btn3').click(function(e) {
		e.preventDefault();
		//document.getElementById('cmc-btn').disabled = true;
        var user = document.getElementById('cmc-user3').value;
    	var text = document.getElementById('cmc-text3').value;
    	var tipo = "Persona";
    	
        if(localStorage.getItem("sc_oUser3")){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Ya tienes un ticket de esta categoria activa";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('cmc-btn3').disabled = false;
			}, 4000);
        }else{
    		if((text == "") || (user == "")) {
    			document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('cmc-btn3').disabled = false;
    			}, 2000);
    		}else{
    		    var php = "text="+text+"&tipo="+tipo+"&user="+user;
    		    $.ajax({
    				url: '/bd/soporte.php?persona',
    				type: 'POST',
    				dataType: 'json',
    				data: php,
    			})
    			.done(function(res) {
    			    if(res == "aprobado") {
    				    localStorage.setItem("sc_oUser3", user);
    				    
    				    document.getElementById('cmc-user3').innerHTML = "";
                    	document.getElementById('cmc-text3').innerHTML = "";
    				    document.getElementById("errorwd1").style.display = "block";
    		  	        document.getElementById("errorwd1").innerHTML = "Enviado con exito";
    					setTimeout(() => {
    					    document.getElementById("errorwd1").style.display = "none";
    						window.location = "/soporte?tickets";
    					}, 2000);
    				}
    			})
    			.fail(function() {
    			})
    			.always(function() {
    			});
    		}
        }
	});
	
	$('#cmt-btn').click(function(e) {
		e.preventDefault();
		//document.getElementById('cmc-btn').disabled = true;
        var user = document.getElementById('cmt-user').value;
    	var text = document.getElementById('cmt-text').value;
    	var tipo = "Saldo";
    	
        if(localStorage.getItem("st_oUser")){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Ya tienes un ticket de esta categoria activa";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('cmt-btn').disabled = false;
			}, 4000);
        }else{
    		if((text == "") || (user == "")) {
    			document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('cmt-btn').disabled = false;
    			}, 2000);
    		}else{
    		    var php = "text="+text+"&tipo="+tipo+"&user="+user;
    		    $.ajax({
    				url: '/bd/soporte.php?saldo',
    				type: 'POST',
    				dataType: 'json',
    				data: php,
    			})
    			.done(function(res) {
    			    if(res == "aprobado") {
    				    localStorage.setItem("st_oUser", user);
    				    
    				    document.getElementById('cmt-user').innerHTML = "";
                    	document.getElementById('cmt-text').innerHTML = "";
    				    document.getElementById("errorwd1").style.display = "block";
    		  	        document.getElementById("errorwd1").innerHTML = "Enviado con exito";
    					setTimeout(() => {
    					    document.getElementById("errorwd1").style.display = "none";
    						window.location = "/soporte?tickets";
    					}, 2000);
    				}
    			})
    			.fail(function() {
    			})
    			.always(function() {
    			});
    		}
        }
	});
	$('#cmt-btn2').click(function(e) {
		e.preventDefault();
		//document.getElementById('cmc-btn').disabled = true;
        var user = document.getElementById('cmt-user2').value;
    	var text = document.getElementById('cmt-text2').value;
    	var tipo = "Deposite";
    	
        if(localStorage.getItem("st_oUser2")){
            document.getElementById("errorwd1").style.display = "block";
		  	document.getElementById("errorwd1").innerHTML = "*Ya tienes un ticket de esta categoria activa";
			setTimeout(() => {
				document.getElementById("errorwd1").style.display = "none";
				document.getElementById('cmt-btn2').disabled = false;
			}, 4000);
        }else{
    		if((text == "") || (user == "")) {
    			document.getElementById("errorwd1").style.display = "block";
    		  	document.getElementById("errorwd1").innerHTML = "*Debes completar el formulario";
    			setTimeout(() => {
    				document.getElementById("errorwd1").style.display = "none";
    				document.getElementById('cmt-btn2').disabled = false;
    			}, 2000);
    		}else{
    		    var php = "text="+text+"&tipo="+tipo+"&user="+user;
    		    $.ajax({
    				url: '/bd/soporte.php?deposite',
    				type: 'POST',
    				dataType: 'json',
    				data: php,
    			})
    			.done(function(res) {
    			    if(res == "aprobado") {
    				    localStorage.setItem("st_oUser2", user);
    				    
    				    document.getElementById('cmt-user2').innerHTML = "";
                    	document.getElementById('cmt-text2').innerHTML = "";
    				    document.getElementById("errorwd1").style.display = "block";
    		  	        document.getElementById("errorwd1").innerHTML = "Enviado con exito";
    					setTimeout(() => {
    					    document.getElementById("errorwd1").style.display = "none";
    						window.location = "/soporte?tickets";
    					}, 2000);
    				}
    			})
    			.fail(function() {
    			})
    			.always(function() {
    			});
    		}
        }
	});
	
	
    document.addEventListener('click', function(event) {
        var supp = document.getElementById('soporte-content');
        var btn = document.getElementById('soporte-wait');
        if (!supp.contains(event.target)) {
            supp.style.display = 'none';
        }
        if (btn.contains(event.target)) {
            supp.style.display = 'block';
        }
    });
            
    var cmcb = document.querySelectorAll("#cmc-b");
    for (var i = 0; i < cmcb.length; i++) {
          $(cmcb[i]).click(function(e) {
            const cmc1 = document.getElementsByClassName("content-modal-cuenta-1");
            cmc1[0].style.display = "none";
            const cmc2 = document.getElementsByClassName("content-modal-cuenta-2");
            cmc2[0].style.display = "none";
            const cmc3 = document.getElementsByClassName("content-modal-cuenta-3");
            cmc3[0].style.display = "none";
            
            const cmc0 = document.getElementsByClassName("content-modal-cuenta");
            cmc0[0].style.display = "block";
        });
    }
    var cmct = document.querySelectorAll("#cmc-t");
    for (var i = 0; i < cmct.length; i++) {
          $(cmct[i]).click(function(e) {
            const cmt1 = document.getElementsByClassName("content-modal-transacciones-1");
            cmt1[0].style.display = "none";
            const cmt2 = document.getElementsByClassName("content-modal-transacciones-2");
            cmt2[0].style.display = "none";
            
            const cmc0 = document.getElementsByClassName("content-modal-transacciones");
            cmc0[0].style.display = "block";
        });
    }
    
    $('#cmc-1').click(function(e) {
        const cmc = document.getElementsByClassName("content-modal-cuenta");
        cmc[0].style.display = "none";
        const cmc1 = document.getElementsByClassName("content-modal-cuenta-1");
        cmc1[0].style.display = "block";
	});
	$('#cmc-2').click(function(e) {
	    const cmc = document.getElementsByClassName("content-modal-cuenta");
        cmc[0].style.display = "none";
        const cmc2 = document.getElementsByClassName("content-modal-cuenta-2");
        cmc2[0].style.display = "block";
	});
	$('#cmc-3').click(function(e) {
	    const cmc = document.getElementsByClassName("content-modal-cuenta");
        cmc[0].style.display = "none";
        const cmc3 = document.getElementsByClassName("content-modal-cuenta-3");
        cmc3[0].style.display = "block";
	});
	
	$('#cmt-1').click(function(e) {
        const cmt = document.getElementsByClassName("content-modal-transacciones");
        cmt[0].style.display = "none";
        const cmt1 = document.getElementsByClassName("content-modal-transacciones-1");
        cmt1[0].style.display = "block";
	});
	$('#cmt-2').click(function(e) {
        const cmt = document.getElementsByClassName("content-modal-transacciones");
        cmt[0].style.display = "none";
        const cmt2 = document.getElementsByClassName("content-modal-transacciones-2");
        cmt2[0].style.display = "block";
	});
	
	pantalla = window.innerHeight;
	document.getElementById('pantalla').style.height = pantalla+'px';
	document.getElementById('soporte-content').style.height = pantalla+'px';
</script>