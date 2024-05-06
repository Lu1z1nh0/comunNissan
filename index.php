<?php
	date_default_timezone_set ('America/El_Salvador'); 

	/*Header de la plantilla */
	require_once("template/header-client.php");

	/* Conforma la conexion con la BD */
	require_once("config/conexion-config.php");

	//echo '<script> console.log("DOCUMENT_ROOT: '.$_SERVER['DOCUMENT_ROOT'].'"); </script>';
	//echo '<script> console.log("HTTP_HOST: '.$_SERVER['HTTP_HOST'].'"); </script>';
	//echo $_SERVER['HTTP_HOST'];

	// Gestión de ruta de acceso a archivos
	require_once($_SERVER['DOCUMENT_ROOT']."/config/ruta.php");
	//require_once($_SERVER['DOCUMENT_ROOT']."/comunNissan/config/ruta.php");
?>
<!-- Inicio Container -->
<div class="container-fluid">

	<!-- Inicio Contenido -->
	<section>

		<!-- Inicio contenido principal -->
		<div class="container-excelautomotriz" style="background-image:url('./assets/img/fondo-principal-n1.png'); background-size: cover; border-radius:10px;">

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">

					<br/>
					<br/>
					<br/>
					<h1 class="centertxt mb-4" style="color: #fff; font-size: 50px;     text-shadow: 1px 3px 4px black;">BIENVENIDO A <br/>COMUNIDAD NISSAN</h1>
					<br/>
					<p class="centertxt mb-4" style="color: #fff; font-size: 24px;     text-shadow: 1px 3px 4px black;">¡UNIDOS por una misma pasión!</p>
					<br/>
					<p class="centertxt mb-5 mx-5" style="color: #fff; font-size: 24px; line-height: 24px;     text-shadow: 1px 3px 4px black;">Si tienes un Nissan Frontier, X-Trail, Qashqai, Kicks o Versa de agencia, de año 2019 a 2024, ingresa el VIN o placa de tu auto y descubre el regalo que tenemos para tu carro:</p>
					
					<!-- Inicio seccion verificar VIN/Placa -->
					<form action="controllers/controlador-campanya" method="POST">
						
						<input style="width:100%; max-width:420px; margin: 0 auto; border: 1px solid #000;" type="text" name="vinpla" id="vinpla" maxlength="17" class="form-control" value="" placeholder="VIN/PLACA" required>
						
						<div class="centrar">
							<div id="novin" class="<?php if(isset($_GET['msjcls6'])){ echo $_GET['msjcls6']; } ?>"><?php if(isset($_GET['mensaje6'])){ echo $_GET['mensaje6']; } ?></div>
						</div>
						
						<input style="margin: 0 auto;" type="hidden" name="fechaver" id="fechaver" value="<?php echo date("d-m-Y h:i:sa"); ?>">
						
						<button style="display: block;" class="boton-v2 mt-4 mb-5" type="submit" id="boton" name="verVinPla">ENVIAR</button>
					</form>
					<!-- Fin seccion verificar VIN/Placa -->
					<br/>
					<br/>
					
					<img src="assets/img/bandera-nss.png" style="animation-duration: 2.5s; animation-delay: 2s; max-width: 350px; width: 100%; position: absolute; left: 0; bottom: 0;" class="animated bounce infinite">
					
					<img src="assets/img/persona-nss.png" style="max-width: 350px; width: 100%; position: absolute; right: 0; bottom: 0;" class="">
					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
				</div>
			</div>

			<hr style="border-color: #1e1e1e38; border-width: 0.5px; margin: 5px 0px;" />


		</div>
		<!-- Fin contenido principal -->

	</section> 
	<!-- Fin Contenido -->

	<!-- Inicio Footer -->
	<footer>
		<?php /* Copyright*/ require_once("template/copy-right-client.php"); ?>
	</footer>
	<!-- Fin Footer -->
	
    <!-- Inicio WhatsApp -->
	<div class="whatsappchat pulso">
		<a href="https://api.whatsapp.com/send?phone=50764876933.&amp;text=¡Hola, buen día Excel Talleres!" title="Escríbenos" target="_blank"><img alt="whatsApp" width="64px" src="assets/img/whatsApp_ico.png"></a>
	</div>
	<!--Fin WhatsApp -->
	
</div>
<!-- Fin Container -->

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