<?php
	date_default_timezone_set ('America/El_Salvador');

	if (!isset($_GET['data']) || !isset($_GET['data1']) || !isset($_GET['data2'])) { 
		//envia a consultar vin o placas
		header("Location: /"); 
		exit; 
	}

	/* Header de la plantilla */
	require_once("template/header-client.php");

	/* Comunicación con modelo sucursales*/
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");

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

	$crudSuc = new CrudSucursal(); 
?>

<script>
	$(document).ready(function(){
	  $( "#citahora" ).prop( "disabled", true );
	});
</script>

<!-- Inicio Container -->
<div class="container"> 

	<!-- Inicio Contenido -->
	<section>  
	
		<!-- Inicio datos de usuario -->
		<div class="container-excelautomotriz" style="background-color:#2d2c2c; border-top-left-radius:10px; border-top-right-radius:10px;">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="titulo-pagina2">
						<br/>
						<h3>¡MUCHAS GRACIAS POR TU CONSULTA!</h3>
						<br/>
						<h5>LOS DATOS DE TU VEHÍCULO SON LOS SIGUIENTES:</h5>
					</div>
				              
                    <!--Inicio datos del carro -->
                    <div class="datoscarro">
                    	<div class="row">

							<div class="col-12 col-sm-5 col-md-5 col-lg-5 logoBrand centrar">
								<?php 
									/* Decodificamos de base64_encode */ 
									$marcaVeh = base64_decode($_GET['data2']);
									/* Deserializamos */
									$marcaVeh = unserialize($marcaVeh); 

									//echo $marcaVeh;
									switch ($marcaVeh) {
									    case "FUSO":
									        echo '<img class="brand-logo" alt="fuso-logo" src="./assets/img/brands/fuso.png">';
									        break;
									    case "TOYOTA":
									        echo '<img class="brand-logo" alt="toyota-logo" src="./assets/img/brands/toyota.png">';
									        break;
									    case "HINO":
									        echo '<img class="brand-logo" alt="hino-logo" src="./assets/img/brands/hino.png">';
									        break;
									    case "MITSUBISHI":
									        echo '<img class="brand-logo" alt="mitsubishi-logo" src="./assets/img/brands/mitsubishi.png">';
									        break;
									    case "BMW":
									        echo '<img class="brand-logo" alt="bmw-logo" src="./assets/img/brands/bmw.png">';
									        break;
									    case "CHEVROLET":
									        echo '<img class="brand-logo" alt="chevrolet-logo" src="./assets/img/brands/chevrolet.png">';
									        break;
									    case "KIA":
									        echo '<img class="brand-logo" alt="kia-logo" src="./assets/img/brands/kia.jpg">';
									        break;
									    default:
									    	echo '<img class="brand-logo" alt="excel-logo" src="./assets/img/excel-logo-small.png">';
										}
								?>
							</div>

							<div class="col-12 col-sm-7 col-md-7 col-lg-7 centrar">

								<div class="visible-inline-block" id="margendatosv">
									VIN:<br/>
									PLACA:<br/>
									MARCA:<br/>
									MODELO:
								</div>
									
								<div class="visible-inline-block">
									<?php 
										/* Decodificamos de base64_encode */ 
										$datos = base64_decode($_GET['data']);
										/* Deserializamos */
										$datos = unserialize($datos);
										
										foreach($datos as $dato) {
										echo "$dato <br/>";
										}		
									?>	
								</div>
							</div> 
                     	</div> 
					</div>   
                    <!-- Fin datos del carro -->

					<div class="listacampana">
						<h5>POR RECOMENDACIÓN DEL FABRICANTE TU VEHÍCULO ES SUJETO A LAS SIGUIENTES CAMPAÑAS TÉCNICAS DE SERVICIO. RECUERDA QUE SON GRATUITAS. </h5>
					</div>

					<div class="textotarjeta">
						<br/>
						<div class="row">
							
							<div class="col-12 col-sm-1 col-md-1 col-lg-1"></div>
							
							<div class="col-12 col-sm-10 col-md-10 col-lg-10 centrar">
								<div id="campanasdatos">

									<div class="row">
										<div class="col-6 col-sm-6 col-md-6 col-lg-6" id="ocultartextocampanas2">
											&nbsp;&nbsp;&nbsp; <b><i class="fa fa-flag" aria-hidden="true"></i> CAMPAÑA</b>
										</div>							
										<div class="col-6 col-sm-6 col-md-6 col-lg-6 centertxt" id="ocultartextocampanas2">
											<b><i aria-hidden="true" class="fa fa-list-ul"></i> DESCRIPCIÓN</b>
										</div>
									</div>

									<div clas="row">
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
											<hr style="margin:6px; border-color: #fff;"/>
										</div>
									</div>
									
									
									<?php 
										/* Decodificamos de base64_encode */ 
										$listacampanyas = base64_decode($_GET['data1']);
										/* Deserializamos */
										$listacampanyas = unserialize($listacampanyas);
										
										$i=1;
										foreach($listacampanyas as $campanyas) {
									?>
									
									<div class="row">
										<div class="col-6 col-sm-6 col-md-6 col-lg-6">
											<div class="ocultartextocampanas"><b><i class="fa fa-flag" aria-hidden="true"></i> CAMPAÑA</b></div>
											<?php echo '<i class="fa fa-arrow-right" aria-hidden="true"></i> '.$campanyas['nombreCampanya']."."; ?>
										</div>
										<div class="col-6 col-sm-6 col-md-6 col-lg-6">
											<div class="ocultartextocampanas"><b><i aria-hidden="true" class="fa fa-list-ul"></i> DESCRIPCIÓN</b></div>
											<?php echo $campanyas['descripcionCampanya']."."; ?> 
										</div>
									</div>
				
									<div clas="row">
										<div class="col-12 col-sm-12 col-md-12 col-lg-12">
											<hr style="margin:6px; border-color: #fff;"/>
										</div>
									</div>

									<?php 
										$i++;
										}
									?>
									
								</div>
							</div>
							
							<div class="col-12 col-sm-1 col-md-1 col-lg-1"></div>

						</div>
					</div>

				</div>
			</div> 
		</div>
		<!-- Fin datos de usuario --> 
    
     
		<!-- Inicio Formulario de Citas -->
		<div class="container-excelautomotriz fondo">
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="textofooter-f"><p style="font-weight: bold;" class="pulso">PROGRAMA TU CITA DE SERVICIO</p></div>
				</div>
			</div>
			
			<div class="cajafcitas">		   
				<form id="citaform" action="controllers/controlador-cita" method="POST">
					<div class="row">
						<div class="col-12 col-sm-6 col-md-6 col-lg-6 centrar">
						
							<div class="formtext">
								<label for="citaname">Nombres:</label><br/>
								<input id="citaname" name="nombre" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>
								<br/>
								<label for="citaapel">Apellidos:</label><br/>
								<input id="citaapel" name="apellido" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="<?php if (isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required>
								<br/>
								<label for="citatel">Teléfono: </label><br/>
								<input id="citatel" name="telefono" type="text" maxlength="9" placeholder="0000-0000" onkeyup="mascara(this,'-',tel,true)" value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>" required>
							</div>
						
						</div>
	                    
	                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 centrar">
						
							<div class="formtext">
								<label for="citacorreo">Correo electrónico:</label><br/>
								<input id="citacorreo" name="correo" type="email" maxlength="50" placeholder="ejemplo@email.com" value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>" required>
								<br/>
								<label for="datepicker">Fecha de visita:</label><br/>
								<input style="cursor: pointer;" id="datepicker" name="fechaM" type="text" placeholder="--/--/----" autocomplete="off" value="<?php if (isset($_POST['fechaM'])) echo $_POST['fechaM']; ?>" readonly="readonly" required>			
								<br/>
								<label for="citahora">Hora:</label><br/>
								<input style="cursor: pointer;" id="citahora" name="horacita" type="text" class="time ui-timepicker-input" placeholder="--:-- --" autocomplete="off" value="<?php if (isset($_POST['horacita'])) echo $_POST['horacita']; ?>" required>

								<input type="hidden" name="fechacon" id="fechacon" value="<?php echo date("d-m-Y h:i:sa"); ?>">
								<input type="hidden" name="vincon" id="vincon" value="<?php echo $datos[0]; ?>">
								<input type="hidden" name="placacon" id="placacon" value="<?php echo $datos[1]; ?>">
								<input type="hidden" name="reservacion" id="reservacion" value="Cliente">

								<input type="hidden" name="data" id="dat-0" value="<?php echo $_GET['data']; ?>">
								<input type="hidden" name="data1" id="dat-1" value="<?php echo $_GET['data1']; ?>"> 
								<input type="hidden" name="data2" id="dat-2" value="<?php echo $_GET['data2']; ?>">
							</div>
							
							<script>

								$("#citahora").timepicker();
							
								$( function() {

									$("#datepicker").datepicker({

										changeMonth: true,
										changeYear: true,
										dateFormat: "DD, d MM, yy",
										minDate: 1,

										beforeShowDay: function(d) {
											var day = d.getDay();
											return [(day != 0)];
										}

									})
								} );

								$("#datepicker").change(function() {
									var seldate = $("#datepicker").datepicker('getDate');
							        seldate = seldate.toDateString();
							        seldate = seldate.split(' ');
							        var weekday=new Array();
							            weekday['Mon']="Lunes";
							            weekday['Tue']="Martes";
							            weekday['Wed']="Miércoles";
							            weekday['Thu']="Jueves";
							            weekday['Fri']="Viernes";
							            weekday['Sat']="Sábado";
							            weekday['Sun']="Domingo";
							        var dayOfWeek = weekday[seldate[0]];

							        if(dayOfWeek == "Domingo"){
						            	$("#citahora").timepicker({ 'disableTimeRanges': [['12:00am', '11:59pm']] });
						            } else if(dayOfWeek == "Sábado") {
				                    	$("#citahora").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:00pm', '11:59pm']] });
				                    } else {
				                    	$("#citahora").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:01pm', '1:29pm'], ['5:00pm', '11:59pm']] });
				                    }
						        	
						        });

								$("#datepicker").click(function(){
								    $("#citahora").prop( "disabled", false );
								  });
					            

								$("#citahora").on("focus",function(){
									$(this).trigger("blur");
								});

	            			</script>
						
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 centrar">
						
							<div class="formtext">
								<label for="citasuc">Sucursal:</label><br/>
								<?php

									//solo las activas interesan acá, 1 activa | 2 inactiva | 3 todas 
									$sucursalesDisp = $crudSuc->obtenerSucursalesLista(1); 

							        echo '<select id="citasuc" title="Elige" name="citasuc">';
							        echo '<option selected value disabled>---</option>';

							        foreach($sucursalesDisp as $sucs) {

							        	echo'<option value="'.$sucs['nombre'].'">'.$sucs['nombre'].'</option>';
							            
							        }
							        
							        echo '</select>'; 

							    ?>
							</div>
						
						</div>

						<div class="col-md-12 col-sm-12 col-12">
							<div class="centertxt">
								<br/>
								<span style="font-weight: normal;">Información completa sobre sucursales, <a title="Ir a" class="inline cboxElement" style="color: #d13239; font-weight: bold;" href="#listaSucC" >ver más</a> 
	

							</div>
						</div>

					</div>

					<br/>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-12">
							<div class="centertxt">
								<label><span style="font-weight: normal;">He revisado los datos de la cita y estoy de acuerdo con la <a title="Leer" class="inline cboxElement" style="color: #d13239; font-weight: bold;" href="#poldepri" >Política de Privacidad</a> establecida por 
								<?php 
	            					/* Decodificamos de base64_encode */ 
									$marcaVehi = base64_decode($_GET['data2']);
									/* Deserializamos */
									$marcaVehi = unserialize($marcaVehi); 

	                				echo $marcaVehi; 
                        		?> El Salvador.</span>
								<input type="checkbox" id="polpri" name="polpri" value="Acepto" required>
								</label>
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
								<button class="botonEnviar" type="submit" id="hacerCita" name="hacerCita">ENVIAR <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
		
	</footer>
	<!-- Fin Footer -->
	    
</div>
<!-- Fin Container -->

<?php 	require_once("template/politica-privacidad.php"); 
		require_once("template/listaSucursales.php");	  
?>
    
</body>
</html>