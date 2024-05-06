<?php
	date_default_timezone_set ('America/El_Salvador'); 

	/*Header de la plantilla */
	require_once("template/header-client.php");

	/* Conforma la conexion con la BD */
	require_once("config/conexion-config.php");

	echo '<script> console.log("DOCUMENT_ROOT: '.$_SERVER['DOCUMENT_ROOT'].'"); </script>';
	//echo $_SERVER['HTTP_HOST'];

	// Gestión de ruta de acceso a archivos
	require_once($_SERVER['DOCUMENT_ROOT']."/config/ruta.php");
?>
<!-- Inicio Container -->
<div class="container">

	<!-- Inicio Contenido -->
	<section>

		<!-- Inicio titulo de campaña -->
		<div class="container-excelautomotriz" style="background-color:#fff; border-top-left-radius:10px; border-top-right-radius:10px;">

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">

					<br/>
					<h1 class="centertxt mb-4">Sitio de Consulta para Campañas Técnicas</h1>
					<!--
					<div class="glide mt-4 mb-4">
					  <div class="glide__track" data-glide-el="track">
					    <ul class="glide__slides">
					      <li class="glide__slide"><img class="brand-logo" alt="bmw-logo" src="assets/img/brands/bmw.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="fuso-logo" src="assets/img/brands/fuso.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="hino-logo" src="assets/img/brands/hino.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="kia-logo" src="assets/img/brands/kia.jpg"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="mitsubishi-logo" src="assets/img/brands/mitsubishi.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="toyota-logo" src="assets/img/brands/toyota.png"></li>
					      <li class="glide__slide"><img class="brand-logo" alt="chevrolet-logo" src="assets/img/brands/chevrolet.png"></li>
					    </ul>
					  </div>
					  
					  <div class="glide__arrows" data-glide-el="controls">
					    <button style="left: -20px;" class="glide__arrow glide__arrow--left" data-glide-dir="<"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-left" aria-hidden="true"></i>
</button>
					    <button style="right: -20px;" class="glide__arrow glide__arrow--right" data-glide-dir=">"><i style="color: #d13239; font-size: 30px;" class="fa fa-chevron-right" aria-hidden="true"></i>
</button>
					  </div>
		
					</div>
					-->

				</div>
			</div>

			<hr style="border-color: #1e1e1e38; border-width: 0.5px; margin: 5px 0px;" />

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<?php //<div class="titulocampana"><h1 class="pulso"> - </h1></div> ?>
					<div class="textocampana"><p>Como parte del respaldo de los fabricantes ponemos a tu disposición este sitio de consulta para validar si tu vehículo aplica a una inspección técnica especializada, mira el siguiente video para mayor explicación.<br/></p></div>
				</div> 
			</div>
		</div>
		<!-- Fin titulo de campaña -->

		<!-- Inicio seccion de video -->
                  
		<div class="container-excelautomotriz" style="background-color:#1e1e1e;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="video">
						<center>
							<video id="videoresponsive" controls="controls" autoplay="autoplay">
  								<source src="video/excel-automotriz-recall-home-video.mp4" type="video/mp4">
	                       	</video>
	                    </center>
                  	</div>
				</div> 
			</div>
		</div>
		<!-- Fin seccion de video -->

		<!-- Inicio seccion verificar VIN -->
		<form action="controllers/controlador-campanya" method="POST">
			<div class="container-excelautomotriz" style="background-color:#fff;">

				<div class="row">
					<div class="col-md-3 col-sm-3 col-12">
						<img class="icovehiculo" alt="" src="assets/img/ico-car-white.png">
					</div>
					<div class="col-md-6 col-sm-6 col-12">
						<div class="textogeneral"><label class="labClie" for="vinpla">INGRESA EL NÚMERO VIN O PLACA DE TU VEHÍCULO DE AGENCIA</label></div>
						<input type="text" name="vinpla" id="vinpla" maxlength="17" class="form-control" value="" placeholder="INGRESA TU NÚMERO DE VIN O PLACA" required>

						<p class="centertxt">Marcas que aplican: TOYOTA, MITSUBISHI, CHEVROLET, KIA, BMW, HINO y FUSO.</p>


						<div class="centrar">
							<div id="novin" class="<?php if(isset($_GET['msjcls6'])){ echo $_GET['msjcls6']; } ?>"><?php if(isset($_GET['mensaje6'])){ echo $_GET['mensaje6']; } ?></div>
						</div>
						<input type="hidden" name="fechaver" id="fechaver" value="<?php echo date("d-m-Y h:i:sa"); ?>">
						<div class="textogeneral"></div>
					</div>
					<div class="col-md-3 col-sm-3 col-12"></div>
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-12">
						<div style="display: flex; justify-content: center; margin-bottom:30px;">
							<button class="boton-v2 espacio-top" type="submit" id="boton" name="verVinPla">VERIFICAR</button>
						</div>
						
						<div style="display: flex; justify-content: center;" class="espacio-top">
							<img src="assets/img/ico-cur-png.png" title="Verifica tu VIN o Placa" style="animation-duration: 2.5s; animation-delay: 2s;" class="animated bounce infinite">
						</div>
						<br/>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-12"> 
						<div class="abajovin">
							<p>Puedes encontrar el VIN de tu vehículo en el reverso de tu tarjeta de circulación como: N° VIN, también puedes encontrarlo en algunas etiquetas cerca de la puerta del conductor en tu vehículo.</a></p>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- Fin seccion verificar VIN -->

	</section> 
	<!-- Fin Contenido -->

	<!-- Inicio Footer -->
	<footer>
		<!-- Inicio Footer-parte 1 -->
		<div class="container-excelautomotriz" style="background-color:#1e1e1e;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="textofooter1"><p>Esta iniciativa es parte del respaldo de Excel Automotriz El Salvador para que conduzcas miles de kilómetros con</p></div>
					<div class="textofondorojo"><h3>CERO PREOCUPACIONES</h3></div>
				</div> 
			</div>
		</div>
		<!-- Fin Footer-parte 1 -->

		<!-- Inicio Footer-parte 2 -->
		<div class="container-excelautomotriz" style="background-color:#fff; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="centrar" style="margin: 30px;">
						<!-- Sello de Seguridad -->
						<!--<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=chnovgVZT4Xe9vGMpAzdXv9Uwc93FgaJkCgchcabwUtjaTZR8aK1MunPMclU"></script></span>-->
					</div>
				</div> 
			</div>
		</div>
		<!-- Fin Footer-parte 2 -->

		
		<?php /* Copyright*/ require_once("template/copy-right-client.php"); ?>

	</footer>
	<!-- Fin Footer -->
    <!-- Inicio WhatsApp -->
	<div class="whatsappchat pulso">
		<a href="https://api.whatsapp.com/send?phone=50322104200&amp;text=¡Hola, buen día Excel!" title="Escríbenos" target="_blank"><img alt="whatsApp" width="64px" src="assets/img/whatsApp_ico.png"></a>
	</div>
	<!--Fin WhatsApp -->
	
</div>
<!-- Fin Container -->

<!-- Glide JS 			
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
-->
<?php require_once("template/politica-privacidad.php"); ?>

<?php 

	//Validar si está o no activo el popup

	$db=Db::conectar();	
	$select=$db->prepare("SELECT id, parametro FROM administracion WHERE variable = 'popupEstado'");
	$select->execute();
	$parametros = $select->fetchAll();

	foreach ($parametros as $popupEst) {
		$popUpEstVal = $popupEst['parametro'];
		$popUpEstID = $popupEst['id']; 
	}

	if ($popUpEstVal == "activo") {
		//El popup está activo
		//echo '<script>console.log("estado del popup: '.$popUpEstVal.' ");</script>';
		require_once("template/popup.php");
	} else {
		//El popup está inactivo
		//echo '<script>console.log("estado del popup: '.$popUpEstVal.' ");</script>';
	}

	 

?>

</body>
</html>