<?php 
	date_default_timezone_set ('America/El_Salvador');

	if (!isset($_GET['data3'])) { 
		//envia a consultar vin o placas
		header("Location: /"); 
		exit; 
	}

	/* Header de la plantilla */
	require_once("template/header-client.php");

	$env = $_SERVER['SERVER_NAME']; // remote || local (excelrecall.test)
	$gcsitekey = ""; 

	if ($env == "excelrecall.com.sv") {
		//excelrecall.com.sv - g-site-recaptcha key
		$gcsitekey =  "6LflCVEgAAAAALz3KEp0LMPZkjzF2pdUa7R0ZDLG";
	} else {
		//excelrecall.test - g-site-recaptcha key
		$gcsitekey =  "6Lct2mEgAAAAAIDGhceYPw1PdetzjV_2oxAiYW0U";
	}

	//echo $_SERVER['SERVER_NAME']."     ".$_SERVER['HTTP_HOST'];
?>

<!-- Inicio Container -->
<div class="container">

	<!-- Inicio Contenido -->
	<section>  
	
		<!-- Inicio datos de usuario -->
		<div class="container-excelautomotriz" style="background-color:#fff; border-top-left-radius:10px; border-top-right-radius:10px;">

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">

					<div class="glide mt-4 mb-4">
					  <div class="glide__track" data-glide-el="track">
					    <ul class="glide__slides">
					      <li class="glide__slide"><img class="brand-logo" alt="bmw-logo" src="./assets/img/brands/bmw.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="fuso-logo" src="./assets/img/brands/fuso.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="hino-logo" src="./assets/img/brands/hino.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="kia-logo" src="./assets/img/brands/kia.jpg"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="mitsubishi-logo" src="./assets/img/brands/mitsubishi.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="toyota-logo" src="./assets/img/brands/toyota.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="chevrolet-logo" src="./assets/img/brands/chevrolet.png"></li>
					    </ul>
					  </div>
					  <!--
					  <div class="glide__arrows" data-glide-el="controls">
					    <button style="left: -20px;" class="glide__arrow glide__arrow--left" data-glide-dir="<"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-left" aria-hidden="true"></i>
</button>
					    <button style="right: -20px;" class="glide__arrow glide__arrow--right" data-glide-dir=">"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-right" aria-hidden="true"></i>
</button>
					  </div>
					  -->
					</div>

				</div>
			</div>
		</div>

		<div class="container-excelautomotriz" style="background-color:#2d2c2c;">

			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="titulo-pagina2">
						<br/>
						<h3>¡MUCHAS GRACIAS POR TU CONSULTA!</h3>
					</div>
				            
					<div class="listacampana">
					<?php 
						/* Decodificamos de base64_encode */ 
						$vinplaca = base64_decode($_GET['data3']);
						/* Deserializamos */
						$vinplaca = unserialize($vinplaca);
						
						echo "<h5 class='text-center'>TU VEHÍCULO VIN/PLACA: <span style='color:#d13239; font-weight:bold;'>$vinplaca</span></h5> <h5 class='text-center'>NO ESTÁ SUJETO A CAMPAÑAS TÉCNICAS DE SERVICIO.</h5>";
					?>					
					</div>

					<br/>

					<br/>
				</div>
			</div> 
		</div>
		<!-- Fin datos de usuario --> 
    
     
		<!-- Inicio Formulario de Suscripción -->
		<div class="container-excelautomotriz fondo">
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="textofooter-f"><p style="font-weight: bold;" class="pulso">ENTÉRATE DE NUESTRAS PROMOCIONES</p></div>
				</div>
			</div>
			
			<div class="cajafcitas">		   
				<form id="citaform" action="controllers/controlador-suscrip" method="POST">
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 centrar">
						
							<div class="formtext">
								<label for="citaname">Nombres:</label><br/>
								<input id="citaname" name="nombre" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>
								<br/>
								<label for="citacorreo">Correo electrónico:</label><br/>
								<input id="citacorreo" name="correo" type="email" maxlength="50" placeholder="ejemplo@email.com" value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
							</div>
						
						</div>
	                    
	                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 centrar">
						
							<div class="formtext">
								<label for="citaapel">Apellidos:</label><br/>
								<input id="citaapel" name="apellido" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="<?php if (isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required>
								<br/>
								<label for="citatel">Teléfono: </label><br/>
								<input id="citatel" name="telefono" type="text" maxlength="9" placeholder="0000-0000" onkeyup="mascara(this,'-',tel,true)" value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>" required>

								<input type="hidden" name="data3" id="dat-3s" value="<?php echo $_GET['data3']; ?>">

								<input type="hidden" name="vincon" id="vincon" value="<?php echo $vinplaca; ?>">
							</div>
						
						</div>

					</div>

					<br/>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-12">
							<div class="centertxt">
								<label><span style="font-weight: normal;">He revisado mi información personal y estoy de acuerdo con la <a title="Leer" class="inline cboxElement" style="color: #d13239; font-weight: bold;" href="#poldepri" >Política de Privacidad</a><br/> establecida por Excel Automotriz El Salvador.</span>
								<input type="checkbox" id="polpri" name="polpri" value="Acepto" required></label>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 centrar">
							<div style="margin: 10px 0px;" class="g-recaptcha" data-theme="light" data-sitekey="<?php echo $gcsitekey; ?>"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 centrar">
							<div style="margin-bottom: 13px;" class="<?php if(isset($_GET['msjcls4'])){ echo $_GET['msjcls4']; } ?>">
								<p style="font-size: 11.5px; margin: 10px 5px;" id="msjf1"><?php if(isset($_GET['mensaje4'])){ echo $_GET['mensaje4']; } ?></p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 centrar">
							<div>
								<button class="botonEnviar" type="submit" id="hacerCita" name="iniSuscrip">ENVIAR <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							</div>
						</div>
					</div>
					
				</form>
			</div> 
		</div>
		<!-- Fin Formulario de Citas -->
		
	</section>
	<!-- Fin Contenido -->
	
	<footer>
	<!-- Inicio Footer -->
      
		<!-- Inicio Nota -->
		<div class="container-excelautomotriz" style="background-color:#d13239; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="centrar" style="margin: 25px;">
					</div>
				</div> 
			</div>
		</div>
		<!-- Fin Nota -->
      
		<?php /* Copyright*/ require_once("template/copy-right-client.php"); ?>

		<!-- Glide JS -->			
		<script src="assets/js/glide.js"></script>

		<script>
			const config = {
				type: "carousel",
				perView: 7,
				gap: 2,
				autoplay: 2000
			};
			new Glide(".glide", config).mount();
		</script>
		
	</footer>
	<!-- Fin Footer -->
	    
</div>
<!-- Fin Container -->

<?php require_once("template/politica-privacidad.php"); ?>
    
</body>
</html>