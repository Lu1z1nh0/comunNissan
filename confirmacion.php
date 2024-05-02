<?php  	
	date_default_timezone_set ('America/El_Salvador');

	if (!isset($_GET['msjcls4']) || (!isset($_GET['data']) && !isset($_GET['data1']))) { 
		//envia a consultar vin o placas
		header("Location: /"); 
		exit; 
	}

	/* Header de la plantilla */	
	require_once("template/header-client.php"); 
?>

<!-- Inicio Container -->
<div class="container">	

	<!-- Inicio Contenido -->	
	<section class="section" style="background-color:#0000;">		
		
		<!-- Inicio confirmacion -->		
		<div class="container-excelautomotriz" style="background-color:#d13239; border-top-left-radius:10px; border-top-right-radius:10px;">			
			<div class="row">				
				<div class="col-md-12 col-sm-12 col-12">					
					<div class="confirmacion">
						<h4><?php echo $_GET['msjcls4']; ?></h4>
					</div>				
				</div> 			
			</div>		
		</div>

		<div class="container-excelautomotriz fondo">			
			<br/>			
			<p class="centertxt" style="margin-bottom: 0px; font-weight: bold;">RESUMEN DE DATOS:</p>			
			
			<div class="row">				
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">					
					<div class="txtconfirm" style="max-width:680px;">						
						
						<div class="row">																								
							<?php

								//DATOS EN CASO SEA UNA CITA  							
							
								if (isset($_GET['data'])) {								
									/* Decodificamos de base64_encode */ 								
									$datos = base64_decode($_GET['data']);								
									/* Deserializamos */								
									$datos = unserialize($datos);																	
									echo '	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">											
												Nombre: 		<span class="datosv">'.$datos[0].'</span>
												<br/>
												<br/>						
												Apellido: 		<span class="datosv">'.$datos[1].'</span>
												<br/>
												<br/>							
												Teléfono: 		<span class="datosv">'.$datos[3].'</span>
												<br/>
												<br/>									
											</div>										
								
											<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">											
												Correo: 		<span class="datosv">'.$datos[2].'</span>
												<br/>
												<br/>									
												Cita: 	<span class="datosv">'.$datos[4].'</span>
												<br/>
												<br/>		
												Hora de Cita: 	<span class="datosv">'.$datos[5].'</span>
												<br/>
												<br/>										
											</div>	

											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">											
												Sucursal: 		<span class="datosv">'.$datos[6].', '.$datos[7].'</span> 										
											</div>									';							
								} else {

									//DATOS EN CASO SEA UNA SUSCRIPCION

									/* Decodificamos de base64_encode */ 								
									$datos = base64_decode($_GET['data1']);								
									/* Deserializamos */								
									$datos = unserialize($datos);																	
									echo '	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">											
												Nombre: 		<span class="datosv">'.$datos[0].'</span>
												<br/>
												<br/>													
												Correo: 		<span class="datosv">'.$datos[2].'</span>									
											</div>										
								
											<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">						

											    Apellido: 		<span class="datosv">'.$datos[1].'</span>
											    <br/>
											    <br/>			
												Teléfono: 		<span class="datosv">'.$datos[3].'</span>										
											</div>	

											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<br/>											
												VIN/Placa: 		<span class="datosv">'.$datos[4].'</span>										
											</div>									';

								}
							?>						
						</div>					
					</div>				
				</div>						
			</div>			
	
			<div class="row">				
				<div class="col-md-12 col-sm-12 col-12 centrar">					
					<div>						
						<a href="https://excelautomotriz.com/el-salvador/" class="botonEnviar">FINALIZAR</a>						
						<br/>						
						<br/>					
					</div>				
				</div>			
			</div>			

			<div class="row">								
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				    <center>					
					<img alt="confirmacion" src="assets/img/email-confirmacion.png" style="width:100%; max-width:589px;">
					</center>				
				</div>								
			</div>		

		</div>
		<!-- Fin confirmacion -->

		<!-- Inicio WhatsApp -->	
		<div class="whatsappchat pulso">		
			<a href="https://api.whatsapp.com/send?phone=50322104200&amp;text=¡Hola, buen día Excel!" title="Escríbenos" target="_blank"><img alt="whatsApp" width="64px" src="assets/img/whatsApp_ico.png"></a>	
		</div>
		<!--Fin WhatsApp -->   
					
	</section>	
	<!-- Fin Contenido -->	

	<!-- Inicio Footer -->	
	<footer>
		<!-- Inicio Nota -->		
		<div class="container-excelautomotriz" style="background-color:#d13239; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">			<div class="row">				
				<div class="col-md-12 col-sm-12 col-12">					
					<div class="notaconfirmacion"><p style="margin-top: 20px;"><?php if (isset($_GET['data'])) { echo "NOTA: EN BREVE UN AGENTE TE CONTACTARÁ PARA CONFIRMAR LA CITA."; } else { echo "MUY PRONTO TE CONTACTAREMOS"; } ?></p></div>				
				</div> 			
			</div>		
		</div>		
		<!-- Fin Nota -->		

		<?php /* Copyright*/ require_once("template/copy-right-client.php"); ?>

	</footer>	
	<!-- Fin Footer -->	

</div>
<!-- Fin Container --> 

<?php require_once("template/politica-privacidad.php"); ?> 

</body>
</html>