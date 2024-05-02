<?php
	date_default_timezone_set ('America/El_Salvador'); 

	/* Conforma el inicio de sesión del sistema */
	require_once("config/sesion.php"); 

	/* Conforma la conexion con la BD */
	require_once("config/conexion-config.php"); 

	/* Header de la plantilla */ 
	require_once("template/header-admin.php"); 

	/* Titulo de la página */
	require_once("template/titulo.php"); 

	/* Menu del administrador */   
	require_once("template/menu.php");

	/* Comunicación con modelo sucursales*/
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");

	$crudSuc = new CrudSucursal(); 
?>

<script>
	$(document).ready(function(){
	  $( "#citahoraadd" ).prop( "disabled", true );
	  //$( "#citahoraupd" ).prop( "disabled", true );
	});
</script>

<!-- Inicio Contenido -->
<section>
	<div class="container-excelautomotriz" style="background-color: #ffffffd6; border: solid 3px #1e1e1e;">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			
				<br/>
				<h1 class="centertxt";>Reportes</h1> 
				<!-- Botón Ayuda -->
				<a title="¡Ver Ayuda!" class="inline ayuda cboxElement animated bounce infinite" href="#help3" style="animation-duration: 2.5s; animation-delay: 2s;"><i class="fa fa-question" aria-hidden="true"></i></a>				
				<br/>
				<span class="line"></span>

				<?php 
				    
				    /* Lógica para capturar la pagina que queremos abrir */
				    $pagina = isset($_GET['r']) ? strtolower($_GET['r']) : 'campanyas'; 
				
				?>
				
				<p class="centertxt pestana">
					<b>
					
					<a id="campanyastab" title="Ir a" class="<?php echo $pagina == 'campanyas' ? 'linkactivo' : ''; ?>" href="?r=campanyas#campanyastab">Campañas</a> 
					
					&nbsp;&nbsp;|&nbsp;&nbsp; 
					
					<a id="citastab" title="Ir a" class="<?php echo $pagina == 'citas' ? 'linkactivo' : ''; ?>" href="?r=citas#citastab">Citas</a> 
					
					&nbsp;&nbsp;|&nbsp;&nbsp; 
					
					<a id="suscriptab" title="Ir a" class="<?php echo $pagina == 'suscripcionesr' ? 'linkactivo' : ''; ?>" href="?r=suscripcionesr#suscriptab">Suscripciones</a>
					
					&nbsp;&nbsp;|&nbsp;&nbsp; 
					
					<a id="auditoriatab" title="Ir a" class="<?php echo $pagina == 'auditoria' ? 'linkactivo' : ''; ?>" href="?r=auditoria#auditoriatab">Auditoria</a>

					</b>
				</p>
				
				<br/>

				<?php 
				    
				    /* Esto es asi considerando que el parámetro enviado tiene el mismo nombre del archivo a cargar, si este no fuera así
				    se produciría un error de archivo no encontrado */
				    require_once('reports/'.$pagina.'.php'); 
				
				?>

				<br/>
				<br/>				
			</div>
		</div> 
	</div>
</section>
<!-- Fin Contenido -->



<!-- Contiene la ventana emergente para agregar un nueva cita -->
<div style="display:none">
	<div id="addcita" style="padding:10px; background:#fff;">
		<h2 class="centertxt";>Reservación de Citas en Línea</h2>
		<br/>	
		<span class="line"></span>
		
		<form style="max-width: 99%;" class="users" action="controllers/controlador-cita" method="POST">

			<p><b>*</b>Verificar si aplica a alguna campaña antes de reservar.</p>

			<div class="row">

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citaplaadd">Placa:</label><br/>
					<input class="usersinputinput" id="citaplaadd" name="citaplaadd" type="text" maxlength="9" placeholder="P000000" value="" required>
				</div>			
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citavinadd">VIN:</label><br/>
					<input class="usersinputinput" id="citavinadd" name="citavinadd" type="text" maxlength="17" placeholder="-" value="" required>
				</div>

			</div>

			<div class="row">

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citanameadd">Nombre:</label><br/>
					<input class="usersinputinput" id="citanameadd" name="citanameadd" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="" required>
				</div>			
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citaapeladd">Apellidos:</label><br/>
					<input class="usersinputinput" id="citaapeladd" name="citaapeladd" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="" required>
				</div>

			</div>

			<div class="row">

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citateladd">Teléfono: </label><br/>
					<input class="usersinputinput" id="citateladd" name="citateladd" type="text" maxlength="9" placeholder="0000-0000" onkeyup="mascara(this,'-',tel,true)" value="" required>
				</div>			
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">

					<label for="citacorreoadd">Correo electrónico:</label><br/>
					<input class="usersinputinput" id="citacorreoadd" name="citacorreoadd" type="email" maxlength="50" placeholder="ejemplo@email.com" value="" required>
				</div>

			</div>	

			<div class="row">

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citafechaadd">Fecha para el mantenimiento:</label><br/>
					<input style="cursor: pointer;" class="usersinputinput" id="citafechaadd" name="citafechaadd" type="text" placeholder="--/--/----" autocomplete="off" value="" readonly="readonly" required>
				</div>			
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citahoraadd">Hora:</label><br/>
					<input style="cursor: pointer;" class="usersinputinput" id="citahoraadd" name="citahoraadd" type="text" class="time ui-timepicker-input" placeholder="--:-- --" autocomplete="off" value="" required>
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citasucadd">Sucursal:</label><br/>
					<?php
						//solo las activas interesan acá, 1 activa | 2 inactiva | 3 todas 
						$sucursalesDisp = $crudSuc->obtenerSucursalesLista(1); 

					    echo '<select class="usersinputinput" id="citasucadd" title="Elige" name="citasucadd">';
					    echo '<option selected value disabled>---</option>';

					    foreach($sucursalesDisp as $sucs) {

					    	echo'<option value="'.$sucs['nombre'].'">'.$sucs['nombre'].'</option>';
					        
					    }
					    
					    echo '</select>'; 

					?>
				</div>			

			</div>

			<input type="hidden" name="dateReser" id="dateReser" value="<?php echo date("d-m-Y h:i:sa"); ?>">
			<input type="hidden" name="whoReser" id="whoReser" value="<?php echo $usrname; ?>">

			<br/>
			<button type="submit" name="reservarCita" class="botons">Reservar</button>

		</form>

		<script type="text/javascript">

			$("#citahoraadd").timepicker();
									
			$( function() {

				$("#citafechaadd").datepicker({

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

			$("#citafechaadd").change(function() {
				var seldate = $("#citafechaadd").datepicker('getDate');
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
		        	$("#citahoraadd").timepicker({ 'disableTimeRanges': [['12:00am', '11:59pm']] });
		        } else if(dayOfWeek == "Sábado") {
		        	$("#citahoraadd").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:00pm', '11:59pm']] });
		        } else {
		        	$("#citahoraadd").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:01pm', '1:29pm'], ['5:00pm', '11:59pm']] });
		        }
		    	
		    });

			$("#citafechaadd").click(function(){
			    $("#citahoraadd").prop( "disabled", false );
			  });

		</script>

	</div>
</div>
<!-- fin ventana emergente para agregar un nueva cita -->


<!-- Contiene la ventana emergente para editar una reservación de cita -->
<div style="display:none">
	<div id="updcita" style="padding:10px; background:#fff;">
		<h2 class="centertxt";>Editar reservación de cita</h2>
		<br/>	
		<span class="line"></span>

		<form style="width: 99%;" class="users" action="controllers/controlador-cita" method="POST">

			<input type="hidden" id="idupdcita" name="idupdcita" value="">
			
			<div class="row">
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citavinupd">VIN:</label><br/>
					<input class="usersinputinput" id="citavinupd" name="citavinupd" type="text" maxlength="17" placeholder="-" value="" required>
				</div>

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citaplaupd">Placa:</label><br/>
					<input class="usersinputinput" id="citaplaupd" name="citaplaupd" type="text" maxlength="9" placeholder="P000000" value="" required>
				</div>
			
			</div>

			<div class="row">

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citanameupd">Nombre:</label><br/>
					<input class="usersinputinput" id="citanameupd" name="citanameupd" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="" required>
				</div>

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citaapelupd">Apellidos:</label><br/>
					<input class="usersinputinput" id="citaapelupd" name="citaapelupd" type="text" maxlength="50" placeholder="-" onkeypress="return validarLetras(event)" value="" required>
				</div>

			</div>

			<div class="row">
			
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citatelupd">Teléfono: </label><br/>
					<input class="usersinputinput" id="citatelupd" name="citatelupd" type="text" maxlength="9" placeholder="0000-0000" onkeyup="mascara(this,'-',tel,true)" value="" required>
				</div>

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citacorreoupd">Correo electrónico:</label><br/>
					<input class="usersinputinput" id="citacorreoupd" name="citacorreoupd" type="email" maxlength="50" placeholder="ejemplo@email.com" value="" required>
				</div>

			</div>

			<div class="row">
				
				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citafechaupd">Fecha para el mantenimiento:</label><br/>
					<input style="cursor: pointer;" class="usersinputinput" id="citafechaupd" name="citafechaupd" type="text" placeholder="--/--/----" autocomplete="off" value="" readonly="readonly" required>			
				</div>

				<div class="col-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citahoraupd">Hora:</label><br/>
					<input style="cursor: pointer;" class="usersinputinput" id="citahoraupd" name="citahoraupd" type="text" class="time ui-timepicker-input" placeholder="--:-- --" autocomplete="off" value="" required>
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citasucupd">Sucursal:</label><br/>
					<?php
						//solo las activas interesan acá, 1 activa | 2 inactiva | 3 todas 
						$sucursalesDisp1 = $crudSuc->obtenerSucursalesLista(3); 

					    echo '<select class="usersinputinput" id="citasucupd" title="Elige" name="citasucupd">';
					    echo '<option value disabled>---</option>';

					    foreach($sucursalesDisp1 as $sucs) {

					    	echo'<option value="'.$sucs['nombre'].'">'.$sucs['nombre'].'</option>';
					        
					    }
					    
					    echo '</select>'; 

					?>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<label for="citastateupd">Estado de Cita:</label><br/>
					<select class="usersinputinput" id="citastateupd" title="Elige" name="citastateupd">';
						<option value="Activa">Activa</option>
						<option value="En Proceso">En Proceso</option>
						<option value="Finalizada">Finalizada</option>
					</select>
				</div>			

			</div> 

			<input type="hidden" name="dateReserupd" id="dateReserupd" value="<?php echo date("d-m-Y h:i:sa"); ?>">
			<input type="hidden" name="whoReserupd" id="whoReserupd" value="<?php echo $usrname; ?>">

			<br/>
			<button type="submit" name="reservarCitaupd" class="botons">Actualizar</button>
			
		</form>

		<script type="text/javascript">

			$("#citahoraupd").timepicker();
							
			$( function() {

				$("#citafechaupd").datepicker({

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

			$("#citafechaupd").change(function() {
				var seldate = $("#citafechaupd").datepicker('getDate');
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
	            	$("#citahoraupd").timepicker({ 'disableTimeRanges': [['12:00am', '11:59pm']] });
	            } else if(dayOfWeek == "Sábado") {
                	$("#citahoraupd").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:00pm', '11:59pm']] });
                } else {
                	$("#citahoraupd").timepicker('remove').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:01pm', '1:29pm'], ['5:00pm', '11:59pm']] });
                }
	        	
	        });

			/*
			$("#citafechaupd").click(function(){
			    $("#citahoraupd").prop( "disabled", false );
			  });
			*/

		</script>

	</div>
</div>
<!-- fin ventana emergente para editar una reservación de cita -->


<!-- Contiene la ventana emergente para eliminar una reservación -->
<div style='display:none'>
	<div id='delcita' style='padding:10px; background:#fff;'>
		
		<br/>
		<h2 class="centertxt";>Eliminar una reservación de cita</h2>
		<br/>	
		<span class="line"></span>

		<p class="centertxt">La reservación: </p> 

		<div class="centrar" style="display: block; overflow-x: auto;">
			<table style="width: 100%; max-width: 1000px;">		
				<thead class="centertxt">
					<tr>
						<th><i class="fa fa-hashtag" aria-hidden="true"></i></th>
						<th><b>NOMBRE</b></th>
						<th><b>CORREO</b></th>
						<th><b>TELÉFONO</b></th>
						<th><b>FECHA/HORA DE RESERVACIÓN</b></th>
					</tr>
				</thead>
				<tbody>
				    <tr>
						<td id="id-cita-del" class="centertxt"></td>
						<td id="nom-cita-del" ></td>
						<td id="cor-cita-del" class="centertxt"></td>
						<td id="tel-cita-del" class="centertxt"></td>
						<td id="fhr-cita-del" class="centertxt"></td>
					</tr>
				</tbody>
			</table>	
		</div>

		<br/>
		<p class="centertxt"><b>Será eliminada de forma definitiva, esta acción es irreversible ¿Estás seguro?</b></p>
		
		<form style="display: contents;" action="controllers/controlador-cita" method="POST">

			<div class="centrar">
				<input type="hidden" id="iddelcita" name="iddelcita" value="">
				<div><button class="botons" type="submit" name="deletecita" title="¿Seguro?">Eliminar</button></div>
			</div>

		</form>
	
	</div>
</div>
<!-- fin ventana emergente para eliminar una reservación -->


<!-- Contiene la ventana emergente para ayuda -->
<div style='display:none'>
	<div id='help3' style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>AYUDA</h2>
		<br/>	
		<span class="line"></span>	
		<div class="centrar">
			<div>
				<p style="text-align: justify;">
					<b>1.</b> <button class="botonfil" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button> Este botón filtra los resultados según el parámetro ingresado.<br/>
					<br/>
					<br/>
					<b>2.</b> <button class="botonfil" title="Limpiar"><i class="fa fa-refresh" aria-hidden="true" contenteditable="false"></i></button> Este botón refresca el "input" para el parámetro ingresado.<br/>
					<br/>
					<br/>
					<b>3.</b> Los filtros son mutuamente incluyentes (donde hay más de uno), es decir que puedes filtrar un VIN y luego filtrar por campaña a fin de verificar si aplica a alguna campaña en específico por ejemplo.
					<br/>
					<br/>
					<img style="width: 100%; height: auto;" src="/assets/img/filters-hint.png" alter="img-filters">
					<br/>
					<center>Figura 1.</center>
					<br/>
					<b>4.</b> La vista únicamente despliega 20 registros por página (si hay más de una), ver paginación al pie de la tabla.
					<br/>
					<br/>
					<b>5.</b> Puedes descargar el reporte entero dejando en blanco los filtros o puedes descargar los registros de tu interés aplicando previamente los filtros y por último presionando el botón:<br/><br/> <center><button class="botons"><i class="fa fa-download" aria-hidden="true" contenteditable="false"></i> DESCARGAR REPORTE</button></center> 
					<br/>

					<hr style="margin-bottom: 30px;">

					<b>1.</b> Mantenimiento de reservación de citas.<br/>
					<br/>
					<b>1.1</b> Puedes reservar, editar o eliminar reservaciones de citas desde este panel:<br/>
					<br/>
					<b>1.1.1</b> <a style="color: red; cursor: pointer;"><i class="fa fa-plus" aria-hidden="true" style="font-size: 15px;"></i> <b>Reservar cita</b></a> presionando este botón puedes agregar una cita nueva.<br/>
					<br/>
					<b>1.1.2</b> Mediante la combinación de: <b>shift + scroll</b> posicionando el mouse sobre la tabla de registros, podrás desplazarte horizontalmente y ver la columna ACCIÓN, donde podrás editar o eliminar reservaciones de citas hechas aquí o por algún cliente, ver Figura 2.<br/>
					<br/>
					<img style="width: 100%; height: auto;" src="/assets/img/dates-hint.png" alter="img-filters">
					<br/>
					<br/>
					<center>Figura 2.</center>
					<br/>
					<b>2.</b> Al agregar/actualizar una reservación de cita se enviara el respectivo correo de confirmación.
					<br/>

					<hr style="margin-bottom: 30px;">

					<b>1.</b> <i style="color: #ffc107;" class="fa fa-exclamation-triangle" aria-hidden="true"></i> Limite de descarga excedido.<br/>
					<br/>
					<b>1.1</b> Cuando la cantidad de registros supere los 25000, la descarga completa (sin aplicar filtros) será imposible, por lo que será necesario limitar la descarga.  
					<br/>
					<br/>
					<b>1.2</b> El parámetro <b>"Límite"</b> indica la cantidad máxima de registros a descargar, no debería exceder 25000.
					<br/>
					<br/>
					<b>1.3</b> El parámetro <b>"Desde"</b> indica a partir de donde se desea realizar la descarga, por ejemplo: <b>Desde: 40</b>, hará la descarga desde 40 hasta el máximo establecido en el parámetro <b>"Límite"</b>.
					<br/>
					<br/>
					<b>1.4</b> NOTA: esta sección sólo sería útil cuando los registros de la tabla sean superiores a 25000 y se requiera descargar una cantidad igual o mayor a ese límite para evitar un colapso en la memoria de la cual dispone el servidor, en cualquier otro caso puede hacerse caso omiso de su uso. 

					<div class="centrar"><div><img style="width: 100%; height: auto;" src="/assets/img/filters-aus-limit-hint.png" alter="img-filters-limit"></div></div>
					<center>Figura 3.</center>

					<hr style="margin-bottom: 30px;">
							
					<div class="centrar">
						<a href="https://www.markcoweb.com" target="_blank"><img class="imglogo" src="./assets/img/logoMarkco2.png" style="width: 150px;" alt="logo"></a>	
					</div>
				</p>
			</div>
		</div>
	</div>
</div>
<!-- fin ventana emergente para ayuda -->

<?php  

	/* Footer de la plantilla */
	require_once("template/footer-admin.php"); 

?> 