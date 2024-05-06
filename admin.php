<?php
	session_start();
	unset($_SESSION['usuario']);
	session_destroy();

	$env = $_SERVER['SERVER_NAME']; // remote || local (localhost)
	$gcsitekey = ""; 

	if ($env == "comunidadnissan.com.pa") {
		//comunidadnissan.com.pa - g-site-recaptcha key
		$gcsitekey =  "6LfQ4tEpAAAAABExI50w5IVQEYHH27kvDYCigwXY";
	} else {
		//localhost - g-site-recaptcha key
		$gcsitekey =  "6LddMvofAAAAANbWAsNCBY8sHjIOAxZt5VYPCuG_";
	}

	//echo $_SERVER['SERVER_NAME']."     ".$_SERVER['HTTP_HOST'];
?>

<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">    
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<meta content="MarkCoWeb" name="author">
		<meta content="Excel-Talleres-Recall-SV" name="description">

		<title>Administraci&oacute;n</title>

		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/img/excel-favico.ico">

		<!-- CSS -->
		<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="assets/css/login-style.css" type="text/css" media="all">

		<style type="text/css">
			h1 a { 
				background-image:url("assets/img/excel-logo-white.png") !important; 
			}
		</style>

		<!-- Google Recaptcha -->
		<script src="https://www.google.com/recaptcha/api.js?hl=es" async defer></script>	

	</head>
	
	<body class="login wp-core-ui">


		
		<header>
			<h1 style="margin-top: 25px;"><a href="/" title="Ir a Excel Talleres Recall SV">Administración</a></h1>	
		</header>
			   
			
		<!-- Inicio Login -->
		<section id="login">	
			<form action="controllers/controlador-login" method="POST">

			    <p style="text-align: center;">
					<i class="fa fa-user-circle-o" aria-hidden="true" style="color: #535b32; font-size: 70px; color: #d3081b;"></i>
				</p>
				<br/>
				<p>
					<label for="correo"><i class="fa fa-envelope-o" aria-hidden="true" style="color: #d3081b;"></i> Correo Electr&oacute;nico</label>
					<br/>
					<input style="text-align: center; font-weight: 400; font-size: 17px;" type="email" id="correo" name="correo" class="input" value="" maxlength="100" placeholder="ejemplo@email.com" required>
				</p>
				<p>
					<label for="clave"><i class="fa fa-key" aria-hidden="true" style="color: #d3081b;"></i> Contraseña</label>
					<br/>
					<input style="text-align: center;" type="password" id="clave" name="clave" class="input" value="" maxlength="20" required>
				</p>		
						
				<div>
					<!--
					<p class="forgetmenot">
						<label for="rememberme">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever"> Recuérdame!</label>
					</p>
					-->
		
					<div style="margin-bottom: 10px;" class="g-recaptcha" data-theme="light" data-sitekey="<?php echo $gcsitekey; ?>"></div>


					<div class="<?php if(isset($_GET['msjcls3'])){ echo $_GET['msjcls3']; } ?>">
						<p style="font-size: 11.5px;" id="msj3"><?php if(isset($_GET['mensaje3'])){ echo $_GET['mensaje3']; } ?></p>
					</div>
					
					<p class="submit">
						<input type="hidden" name="entrar" value="entrar">
						<button style="position:relative; top:12px;" class="button button-primary button-large">Iniciar Sesión</button>
					</p>

				</div>
			
			</form>
		</section>
		<!-- Fin Login -->

		<section>
			<br/>
			<br/>
			<br/>
		</section>

		<footer class="footerlogin">
			<div style="margin: 0px 45px;">
				<i class="fa fa-copyright" aria-hidden="true"></i> Todos los Derechos Reservados <?php $anyo = getdate(); echo "$anyo[year]"; ?> | <a class="foot" href="https://www.markcoweb.com/" target="_blank" title="Ir a">Powered by: MarkCoWeb</a>
			</div>
		</footer>

	</body>
</html>