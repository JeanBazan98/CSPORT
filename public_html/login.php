<?php
    error_reporting(0);
	session_start();
    include_once 'bd/conexion.php';

	if (!empty(($_SESSION['datos']))) {
		header('Location: https://csport.es/');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/login.css">
	<link rel="stylesheet" type="text/css" href="/fonts/fonts.css">
	<link rel="icon" type="image/x-icon" href="/img/Logo.png">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Login | Csport</title>
</head>
<body>
	<div id="pantalla">
	    <?php
            if ((empty($_GET['id'])) && (empty($_GET['code']))) {
        	}else{
        	    $codec = $_GET['code'];
        	    $id_cuentac = $_GET['id'];
        
        	    $codesql = "SELECT * FROM cuentas WHERE id_cuenta = '$id_cuentac' AND code = '$codec'";
        	    $codesqlr = $conn->query($codesql);
        	    $codesqlv = $codesqlr->fetch_row();
        	    if($codesqlv){
        ?>
        <input type="checkbox" id="btn-modal2">
        <div class="container-modal2">
            <div class="content-modal2">
                <form id="olvc">
                    <h1>¿Cambia tu contraseña?</h1>
                    <span id="errornc"></span>
                    <label>Nueva contraseña</label>
                    <input type="password" id="ncontra" placeholder="Ingresa tu nueva contraseña">
                    <label>Repite contraseña</label>
                    <input type="password" id="rcontra" placeholder="Repite tu nueva contraseña">
                    <button id="enviarnc">Cambiar</button>
                </form>
            </div>
            <label for="btn-modal2" class="cerrar-modal2"></label>
        </div>
        <script type="text/javascript">
        	$('#enviarnc').click(function(e) {
        		e.preventDefault();
        
        		var ncontra = document.getElementById('ncontra').value;
        		var rcontra = document.getElementById('rcontra').value;
        
        		var php = "ncontra="+ncontra+"&rcontra="+rcontra;
        
        		$.ajax({
        			url: 'bd/contraseña_n.php?id=<?php echo $_GET['id']; ?>',
        			type: 'POST',
        			dataType: 'json',
        			data: php,
        		})
        		.done(function(res) {
        			if (res == "vacio") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Debes completar el formulario";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        				}, 4000);
        			}
        			if (res == "contraseña") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Las contraseñas no coinciden";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        				}, 4000);
        			}
        			if (res == "cambiado") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Cambiado con exito";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        					location.reload();
        				}, 2500);
        			}	
        		})
        		.fail(function() {
        		})
        		.always(function() {
        		});
        	});
        </script>
        <?php
        	    }
        	}
        ?>
	    
        <input type="checkbox" id="btn-modal">
		<div class="container-modal">
	        <div class="content-modal">
	            <form id="olvc">
	                <h1>¿Olvidate tu contraseña?</h1>
	                <span id="errornc"></span>
	                <label>Ingresa tu email</label>
	                <input id="emailc" placeholder="Ingresa tu email">
	                <button id="enviarc" style="font-weight: 600;">Verificar</button>
	            </form>
	        </div>
	        <label for="btn-modal" class="cerrar-modal"></label>
	    </div>
	    <script type="text/javascript">
        	$('#enviarc').click(function(e) {
        		e.preventDefault();
        
        		var email = document.getElementById('emailc').value;
        
        		var php = "email="+email;
        
        		$.ajax({
        			url: 'bd/olvide_c.php',
        			type: 'POST',
        			dataType: 'json',
        			data: php,
        		})
        		.done(function(res) {
        			if (res == "vacio") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Debes completar el formulario";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        				}, 4000);
        			}
        			if (res == "email") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Email no registrado";
        			  	document.getElementById("emailc").value = "";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        				}, 4000);
        			}
        			if (res == "error") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Error al enviar correo";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        				}, 4000);
        			}
        			if (res == "exitoso") {
        				document.getElementById("errornc").style.display = "block";
        			  	document.getElementById("errornc").innerHTML = "Email enviado";
        			  	document.getElementById("emailc").value = "";
        				setTimeout(() => {
        					document.getElementById("errornc").style.display = "none";
        					location.reload();
        				}, 2500);
        			}
        		})
        		.fail(function() {
        		})
        		.always(function() {
        		});
        	});
        </script>
	    
	    
		<div id="tutorial">
		    <img src="img/5.jpeg">
		</div>
		<div id="login">
			<span id="error"></span>
			<form id="l_login" action="" method="POST">
				<div id="cerrar">
					<a href="/"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="rgba(255,255,255,1)"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg></a>
				</div>
				<h1>¿Tienes cuenta?</h1>
				<label style="margin-left: 25%; text-align: left;">Email</label>
				<input id="email_ac" type="text" name="email" placeholder="Ingresa tu email">
				<label style="margin-left: 25%; text-align: left;">Contraseña</label>
				<input id="pass_ac" type="password" name="contraseña" placeholder="Ingresa tu contraseña">
				    <svg id="lpass1" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>
				    <svg id="lpass1r" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M17.8827 19.2968C16.1814 20.3755 14.1638 21.0002 12.0003 21.0002C6.60812 21.0002 2.12215 17.1204 1.18164 12.0002C1.61832 9.62282 2.81932 7.5129 4.52047 5.93457L1.39366 2.80777L2.80788 1.39355L22.6069 21.1925L21.1927 22.6068L17.8827 19.2968ZM5.9356 7.3497C4.60673 8.56015 3.6378 10.1672 3.22278 12.0002C4.14022 16.0521 7.7646 19.0002 12.0003 19.0002C13.5997 19.0002 15.112 18.5798 16.4243 17.8384L14.396 15.8101C13.7023 16.2472 12.8808 16.5002 12.0003 16.5002C9.51498 16.5002 7.50026 14.4854 7.50026 12.0002C7.50026 11.1196 7.75317 10.2981 8.19031 9.60442L5.9356 7.3497ZM12.9139 14.328L9.67246 11.0866C9.5613 11.3696 9.50026 11.6777 9.50026 12.0002C9.50026 13.3809 10.6196 14.5002 12.0003 14.5002C12.3227 14.5002 12.6309 14.4391 12.9139 14.328ZM20.8068 16.5925L19.376 15.1617C20.0319 14.2268 20.5154 13.1586 20.7777 12.0002C19.8603 7.94818 16.2359 5.00016 12.0003 5.00016C11.1544 5.00016 10.3329 5.11773 9.55249 5.33818L7.97446 3.76015C9.22127 3.26959 10.5793 3.00016 12.0003 3.00016C17.3924 3.00016 21.8784 6.87992 22.8189 12.0002C22.5067 13.6998 21.8038 15.2628 20.8068 16.5925ZM11.7229 7.50857C11.8146 7.50299 11.9071 7.50016 12.0003 7.50016C14.4855 7.50016 16.5003 9.51488 16.5003 12.0002C16.5003 12.0933 16.4974 12.1858 16.4919 12.2775L11.7229 7.50857Z"></path></svg>
				<input id="login_b" type="submit" value="Iniciar sesion">
				<a><label id="" for="btn-modal" style="color: #262626;">¿Has olvidado la contraseña?</label></a>
				<p>¿No tienes una cuenta?</p><a href="javascript:login()">Registrate</a>
			</form>
			<form id="l_register" action="" method="POST">
				<h1>Crear una cuenta</h1>
				<label style="margin-left: 25%; text-align: left;">Usuario</label>
				<input id="name_ac2" type="text" name="nombre" placeholder="Ingresa tu usuario" required>
				<label style="margin-left: 25%; text-align: left;">Email</label>
				<input id="email_ac2" type="email" name="email" placeholder="Ingresa tu email" required>
				<label style="margin-left: 25%; text-align: left;">Contraseña</label>
				<input id="pass_ac2" type="password" name="contraseña" placeholder="Ingresa tu contraseña" required>
				    <svg id="rpass1" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>
				    <svg id="rpass1r" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M17.8827 19.2968C16.1814 20.3755 14.1638 21.0002 12.0003 21.0002C6.60812 21.0002 2.12215 17.1204 1.18164 12.0002C1.61832 9.62282 2.81932 7.5129 4.52047 5.93457L1.39366 2.80777L2.80788 1.39355L22.6069 21.1925L21.1927 22.6068L17.8827 19.2968ZM5.9356 7.3497C4.60673 8.56015 3.6378 10.1672 3.22278 12.0002C4.14022 16.0521 7.7646 19.0002 12.0003 19.0002C13.5997 19.0002 15.112 18.5798 16.4243 17.8384L14.396 15.8101C13.7023 16.2472 12.8808 16.5002 12.0003 16.5002C9.51498 16.5002 7.50026 14.4854 7.50026 12.0002C7.50026 11.1196 7.75317 10.2981 8.19031 9.60442L5.9356 7.3497ZM12.9139 14.328L9.67246 11.0866C9.5613 11.3696 9.50026 11.6777 9.50026 12.0002C9.50026 13.3809 10.6196 14.5002 12.0003 14.5002C12.3227 14.5002 12.6309 14.4391 12.9139 14.328ZM20.8068 16.5925L19.376 15.1617C20.0319 14.2268 20.5154 13.1586 20.7777 12.0002C19.8603 7.94818 16.2359 5.00016 12.0003 5.00016C11.1544 5.00016 10.3329 5.11773 9.55249 5.33818L7.97446 3.76015C9.22127 3.26959 10.5793 3.00016 12.0003 3.00016C17.3924 3.00016 21.8784 6.87992 22.8189 12.0002C22.5067 13.6998 21.8038 15.2628 20.8068 16.5925ZM11.7229 7.50857C11.8146 7.50299 11.9071 7.50016 12.0003 7.50016C14.4855 7.50016 16.5003 9.51488 16.5003 12.0002C16.5003 12.0933 16.4974 12.1858 16.4919 12.2775L11.7229 7.50857Z"></path></svg>
				<label style="margin-left: 25%; text-align: left;">Repetir contraseña</label>
				<input id="passr_ac2" type="password" name="contraseña2" placeholder="Repite la contraseña" required>
				    <svg id="rpass2" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z"></path></svg>
				    <svg id="rpass2r" class="passeye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="rgba(38,38,38,1)"><path d="M17.8827 19.2968C16.1814 20.3755 14.1638 21.0002 12.0003 21.0002C6.60812 21.0002 2.12215 17.1204 1.18164 12.0002C1.61832 9.62282 2.81932 7.5129 4.52047 5.93457L1.39366 2.80777L2.80788 1.39355L22.6069 21.1925L21.1927 22.6068L17.8827 19.2968ZM5.9356 7.3497C4.60673 8.56015 3.6378 10.1672 3.22278 12.0002C4.14022 16.0521 7.7646 19.0002 12.0003 19.0002C13.5997 19.0002 15.112 18.5798 16.4243 17.8384L14.396 15.8101C13.7023 16.2472 12.8808 16.5002 12.0003 16.5002C9.51498 16.5002 7.50026 14.4854 7.50026 12.0002C7.50026 11.1196 7.75317 10.2981 8.19031 9.60442L5.9356 7.3497ZM12.9139 14.328L9.67246 11.0866C9.5613 11.3696 9.50026 11.6777 9.50026 12.0002C9.50026 13.3809 10.6196 14.5002 12.0003 14.5002C12.3227 14.5002 12.6309 14.4391 12.9139 14.328ZM20.8068 16.5925L19.376 15.1617C20.0319 14.2268 20.5154 13.1586 20.7777 12.0002C19.8603 7.94818 16.2359 5.00016 12.0003 5.00016C11.1544 5.00016 10.3329 5.11773 9.55249 5.33818L7.97446 3.76015C9.22127 3.26959 10.5793 3.00016 12.0003 3.00016C17.3924 3.00016 21.8784 6.87992 22.8189 12.0002C22.5067 13.6998 21.8038 15.2628 20.8068 16.5925ZM11.7229 7.50857C11.8146 7.50299 11.9071 7.50016 12.0003 7.50016C14.4855 7.50016 16.5003 9.51488 16.5003 12.0002C16.5003 12.0933 16.4974 12.1858 16.4919 12.2775L11.7229 7.50857Z"></path></svg>
				<span><input type="checkbox" id="terminosc"><a href="/terminos"><h5 style="color: #262626;">Aceptar términos y condiciones</h5></a></span>
				<input id="register_b" type="submit" value="Registrarse">
				<p>¿Ya tienes una cuenta?</p><a href="javascript:register()">Iniciar sesion</a>
			</form>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
    $('#lpass1').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('pass_ac');
        pass.type = 'text';
        document.getElementById('lpass1').style.display = 'none';
        document.getElementById('lpass1r').style.display = 'block';
	});
	$('#lpass1r').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('pass_ac');
        pass.type = 'password';
        document.getElementById('lpass1').style.display = 'block';
        document.getElementById('lpass1r').style.display = 'none';
	});
    $('#rpass1').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('pass_ac2');
        pass.type = 'text';
        document.getElementById('rpass1').style.display = 'none';
        document.getElementById('rpass1r').style.display = 'block';
	});
	$('#rpass2').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('passr_ac2');
        pass.type = 'text';
        document.getElementById('rpass2').style.display = 'none';
        document.getElementById('rpass2r').style.display = 'block';
	});
	$('#rpass1r').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('pass_ac2');
        pass.type = 'password';
        document.getElementById('rpass1').style.display = 'block';
        document.getElementById('rpass1r').style.display = 'none';
	});
	$('#rpass2r').click(function(e) {
		e.preventDefault();
		var pass = document.getElementById('passr_ac2');
        pass.type = 'password';
        document.getElementById('rpass2').style.display = 'block';
        document.getElementById('rpass2r').style.display = 'none';
	});
	$('#register_b').click(function(e) {
		e.preventDefault();
        document.getElementById('register_b').disabled = true;
		var nombre = document.getElementById('name_ac2').value;
		var email = document.getElementById('email_ac2').value;
		var contraseña = document.getElementById('pass_ac2').value;
		var contraseña2 = document.getElementById('passr_ac2').value;
		var terminos = document.getElementById('terminosc');
		
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		var php = "nombre="+nombre+"&email="+email+"&contraseña="+contraseña+"&contraseña2="+contraseña2;
		
        if(terminos.checked){
            if(!emailRegex.test(email)) {
                document.getElementById("error").style.display = "block";
    		  	document.getElementById("error").innerHTML = "Debes ingresar un email valido";
    			setTimeout(() => {
    				document.getElementById("error").style.display = "none";
    				document.getElementById('register_b').disabled = false;
    			}, 4000);
            }else{
                $.ajax({
        			url: 'bd/registrar.php',
        			type: 'POST',
        			dataType: 'json',
        			data: php,
        		})
        		.done(function(res) {
        			if (res == "vacio") {
        				document.getElementById("error").style.display = "block";
        			  	document.getElementById("error").innerHTML = "Debes completar el formulario";
        				setTimeout(() => {
        					document.getElementById("error").style.display = "none";
        					document.getElementById('register_b').disabled = false;
        				}, 4000);
        			}
        			if (res == "email") {
        				document.getElementById("error").style.display = "block";
        			  	document.getElementById("error").innerHTML = "Email ya registrado";
        				setTimeout(() => {
        					document.getElementById("error").style.display = "none";
        					document.getElementById('register_b').disabled = false;
        				}, 4000);
        			}
        			if (res == "nombre") {
        				document.getElementById("error").style.display = "block";
        			  	document.getElementById("error").innerHTML = "Usuario ya registrado";
        				setTimeout(() => {
        					document.getElementById("error").style.display = "none";
        					document.getElementById('register_b').disabled = false;
        				}, 4000);
        			}
        			if (res == "contraseña") {
        				document.getElementById("error").style.display = "block";
        			  	document.getElementById("error").innerHTML = "Las contraseña no coinciden";
        				setTimeout(() => {
        					document.getElementById("error").style.display = "none";
        					document.getElementById('register_b').disabled = false;
        				}, 4000);
        			}
        			if (res == "iniciando") {
        				document.getElementById("error").style.display = "block";
        			  	document.getElementById("error").innerHTML = "Registrado con exito";
        				setTimeout(() => {
        					document.getElementById("error").style.display = "none";
        					location.reload();
        				}, 2500);
        			}
        			
        		})
        		.fail(function() {
        		})
        		.always(function() {
        		});
            }
        }else{
            document.getElementById("error").style.display = "block";
		  	document.getElementById("error").innerHTML = "Debes aceptar los términos y condiciones";
			setTimeout(() => {
				document.getElementById("error").style.display = "none";
				document.getElementById('register_b').disabled = false;
			}, 4000);
        }
	});
	$('#login_b').click(function(e) {
		e.preventDefault();
        document.getElementById('login_b').disabled = true;
		var email = document.getElementById('email_ac').value;
		var contraseña = document.getElementById('pass_ac').value;

		var php = "email="+email+"&contraseña="+contraseña;

		$.ajax({
			url: 'bd/login.php',
			type: 'POST',
			dataType: 'json',
			data: php,
		})
		.done(function(res) {
			if (res == "vacio") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Debes completar el formulario";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('login_b').disabled = false;
				}, 4000);
			}
			if (res == "email") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Email no registrado";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('login_b').disabled = false;
				}, 4000);
			}
			if (res == "contrasena") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Contraseña incorrecta";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					document.getElementById('login_b').disabled = false;
				}, 4000);
			}
			if (res == "iniciando") {
				document.getElementById("error").style.display = "block";
			  	document.getElementById("error").innerHTML = "Iniciando";
				setTimeout(() => {
					document.getElementById("error").style.display = "none";
					location.reload();
				}, 2500);
			}	
		})
		.fail(function() {
		})
		.always(function() {
		});
	});

	pantalla = window.innerHeight
	document.getElementById('pantalla').style.height = pantalla+'px';
	function login(){
  		document.getElementById("l_login").style.display = "none";
  		document.getElementById("l_register").style.display = "block";
    	document.getElementById("email_ac").value = "";
    	document.getElementById("pass_ac").value = "";
	}
	function register(){
  		document.getElementById("l_login").style.display = "block";
  		document.getElementById("l_register").style.display = "none";
  		document.getElementById("name_ac2").value = "";
    	document.getElementById("email_ac2").value = "";
    	document.getElementById("pass_ac2").value = "";
    	document.getElementById("passr_ac2").value = "";
	}
</script>