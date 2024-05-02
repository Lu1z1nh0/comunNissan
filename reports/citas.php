<?php 
	/* Permite acceder a la clase AutoPagination */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/class.AutoPagination.php");
	
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");

	$db=Db::conectar();
	
	$filtro = array(); 

	/* Validaciones para filtros */
	if (!empty($_GET['fecM'])){
	    $filtro[]  = 'fechaManto = '.'"'.$_GET['fecM'].'"';
	}

	if (!empty($_GET['filsucs'])){
	    $filtro[]  = 'sucursal = '.'"'.$_GET['filsucs'].'"';
	}

	if (!empty($_GET['filestate'])){
	    $filtro[]  = 'estado = '.'"'.$_GET['filestate'].'"';
	}	

	if (!empty($_GET['filvinpla'])){
    $filtro[]  = 'placa = '.'"'.$_GET['filvinpla'].'"'.' OR vin = '.'"'.$_GET['filvinpla'].'"';
	}   

	if (!empty($_GET['horM'])){
	    $filtro[]  = 'hora = '.'"'.$_GET['horM'].'"';
	} 

	if (count($filtro)) {
		/* Si hay más de un filtro */ 
		$filtro = implode(" AND ",$filtro);
	} else {
	    unset($filtro);
	    $filtro = '1';
	}
	
	/* Número máximo de registros a mostrar por página */
	$maxreg = 20;

	if (isset($_GET['page'])) {
		$pag = $_GET['page'];
	}
	
	/* Valida la paginacion */
	if(!isset($pag) || empty($pag)){
	  
	      $min = 0;
	      $pag = 1;  
	  
	}else{
	  
	      if($pag == 1){
	  
	            $min = 0;
	  
	      }else{
	  
	            $min = $maxreg * $pag;
	            $min = $min - $maxreg;
	  
	      }
	}
	
	$select1 = $db->prepare("SELECT * FROM cita WHERE $filtro ORDER BY id ASC");
	$select1->execute();
	$totalReg = $select1->rowCount(); /* Total de registros devueltos */

	$select = $db->prepare("SELECT * FROM cita WHERE $filtro ORDER BY id ASC LIMIT $min, $maxreg");
	$select->execute();
	$registros = $select->fetchAll();

	/* Número de citas */
	$select3 = $db->query('SELECT COUNT(DISTINCT id) FROM cita');
	$totalCI = $select3->fetch();

	$paginacion = new AutoPagination($totalReg, @$_GET['page']);

	$reporte = '<thead class="centertxt">
					<tr>
						<th>ID</th>
						<th>VIN</th>
						<th>Placa</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Correo</th>
						<th>Teléfono</th>
						<th>Sucursal</th>
						<th>Fecha de Reserva</th>
						<th>Hora de Reserva</th>
						<th>Política de Privacidad</th>
						<th>Agreg&oacute;/Edit&oacute;</th>
						<th>Fecha/Hora</th>
						<th>Estado</th>
						<th><i class="fa fa-cogs" aria-hidden="true"></i> ACCIÓN</th>
					</tr>
				</thead>

				<tbody>';
				foreach($registros as $registro) {

					$classEst = "";

					if($registro['estado'] == "Activa") {
						$classEst = "stAct";
					} elseif ($registro['estado'] == "En Proceso") {
						$classEst = "stPross";
					} else {
						//Finalizadas
						$classEst = "stFina";
					}


	$reporte .= '    <tr>
						<td id="id-cita-'.$registro['id'].'" class="centertxt">'.$registro['id'].'</td>
						<td id="vin-cita-'.$registro['id'].'" class="centertxt">'.$registro['vin'].'</td>
						<td id="pla-cita-'.$registro['id'].'" class="centertxt">'.$registro['placa'].'</td>
						<td id="nom-cita-'.$registro['id'].'" >'.$registro['nombre'].'</td>
						<td id="ape-cita-'.$registro['id'].'" >'.$registro['apellido'].'</td>
						<td id="cor-cita-'.$registro['id'].'" >'.$registro['correo'].'</td>
						<td id="tel-cita-'.$registro['id'].'" class="centertxt">'.$registro['telefono'].'</td>
						<td id="suc-cita-'.$registro['id'].'" class="centertxt">'.$registro['sucursal'].'</td>
						<td id="fec-cita-'.$registro['id'].'" class="centertxt">'.$registro['fechaManto'].'</td>
						<td id="hor-cita-'.$registro['id'].'" class="centertxt">'.$registro['hora'].'</td>
						<td id="pdp-cita-'.$registro['id'].'" class="centertxt">'.$registro['politicaPrivacida'].'</td>
						<td id="aeu-cita-'.$registro['id'].'" class="centertxt">'.$registro['addEdit'].'</td>
						<td id="fhu-cita-'.$registro['id'].'" class="centertxt">'.$registro['fechaAddEdit'].'</td>
						<td id="st-cita-'.$registro['id'].'" class="centertxt"><span id="est-cita-'.$registro['id'].'" class="'.$classEst.'">'.$registro['estado'].'</span></td>
						<td class="centertxt">
							<a title="Editar" id="editCitaBoton'.$registro['id'].'" class="inline cboxElement" href="#updcita" style="color: #212529;" onclick="editCita(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							&nbsp;&nbsp;
							<a title="Eliminar" id="delCitaBoton'.$registro['id'].'" class="inline cboxElement" href="#delcita" style="color: #212529;" onclick="delCita(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
						</td>
					</tr>';
					 } 
	$reporte .= '</tbody>';

?>

<!-- Inicio sección de filtros -->
<section id="filters">
	<form class="centertxt" action="reportes#tbldate" method="GET">
		<div class="row">
			<input type="hidden" name="r" value="citas">

			<!-- Filtro por Fecha de Mantenimiento -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<label for="fecM">Fecha Mantenimiento:</label><br/>
				<input style="cursor: pointer;" class="inputfil" id="fecM" title="¡Elige una fecha!" type="text" name="fecM" value="<?php if (isset($_GET['fecM'])) echo $_GET['fecM']; ?>" placeholder="--/--/----" autocomplete="off" readonly="readonly"> 

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#fecM').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

			<script type="text/javascript">
						
				$( function() {
					$("#fecM").datepicker({

						changeMonth: true,
						changeYear: true,
						dateFormat: "DD, d MM, yy",

						beforeShowDay: function(d) {
							var day = d.getDay();
							return [(day != 0)];
						}
					});
				});

			</script>

			<!-- Filtro por Placa o VIN -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filvinpla">Filtrar por Placa/VIN:</label><br/>
				<input class="inputfil" id="filvinpla" title="Ingresa Placa/VIN" type="text" maxlength="17" name="filvinpla" value="<?php if (isset($_GET['filvinpla'])) echo $_GET['filvinpla']; ?>" placeholder="-">

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>			
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filvinpla').val('');"><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

			<!-- Filtro por Hora de Cita -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<label for="horM">Hora de Cita:</label><br/>
				<input style="cursor: pointer;" class="inputfil time ui-timepicker-input" title="¡Ingresa una hora en el formato!" id="horM" type="text" name="horM" value="<?php if (isset($_GET['horM'])) echo $_GET['horM']; ?>" placeholder="--:----" autocomplete="off">						
				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#horM').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

			<script type="text/javascript">
						
				$(function() {
                    $('#horM').timepicker({ 'disableTimeRanges': [['12:00am', '7:59am'], ['12:01pm', '1:29pm'], ['5:00pm', '11:59pm']] });
                });	

			</script>


 			<!-- Filtro por Sucursal -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filsucs">Filtrar por Sucursal:</label><br/>
				<?php

					//solo las activas interesan acá, 1 activa | 2 inactiva | 3 todas 
					$sucursalesDisp2 = $crudSuc->obtenerSucursalesLista(1); 

			        echo '<select class="inputfilSel" id="filsucs" title="Elige" name="filsucs">';
			        echo '<option selected value>--- Ver todas ---</option>';

			        $filtroNomSuc = "-";

					if (!empty($_GET['filsucs'])) {
					    $filtroNomSuc = $_GET['filsucs'];
					} 

			        foreach($sucursalesDisp2 as $sucs) {

			            if ($sucs['nombre'] == $filtroNomSuc) {
			                    echo'<option value="'.$sucs['nombre'].'" selected>'.$sucs['nombre'].'</option>';
			            } else {
			                echo'<option value="'.$sucs['nombre'].'">'.$sucs['nombre'].'</option>';
			            }
			   
			        }
			        
			        echo '</select>'; 
			    ?>

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filsucs').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>		
			</div>

 			<!-- Filtro por Estado de Cita -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label for="filestate">Filtrar por Estado:</label><br/>
				<select class="inputfil" id="filestate" title="Elige" name="filestate">';
			        <option selected value>--- Ver Todos ---</option>
			        <option value="Activa">Activa</option>
			        <option value="En Proceso">En Proceso</option> 
			        <option value="Finalizada">Finalizada</option> 
			    </select>

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filestate').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>		
			</div>

		</div>
	</form>
</section>
<!-- Fin sección de filtros -->

<br/>

<!-- Inicio sección descargar reporte -->
<section>
	<form action="controllers/controlador-reporte-citas" method="POST">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 centrar">
				<div>
					<br/>
					<input type="hidden" name="fecMr" id="fecMr" value="<?php if (isset($_GET['fecM'])) echo $_GET['fecM']; ?>"/>
					<input type="hidden" name="filsucsr" id="filsucsr" value="<?php if (isset($_GET['filsucs'])) echo $_GET['filsucs']; ?>"/>                 
	                <input type="hidden" name="horMr" id="horMr" value="<?php if (isset($_GET['horM'])) echo $_GET['horM']; ?>"/> 
	                <input type="hidden" name="filvinplar" id="filvinplar" value="<?php if (isset($_GET['filvinpla'])) echo $_GET['filvinpla']; ?>"/>

	                <input type="hidden" name="filestater" id="filestater" value="<?php if (isset($_GET['filestate'])) echo $_GET['filestate']; ?>"/> 
	                
					<button class="botons" type="submit" id="descargarReporte" name="descargarReporte"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR REPORTE</button>
					<br/>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- Fin sección descargar reporte -->

<br/>

<!-- Inicio sección metadatos -->
<section>
	<p class="centertxt"><?php echo "# Registros devueltos: <b>$totalReg</b>"." <span style='color: #d2081b;'>|</span> "."Total Citas: <b>$totalCI[0]</b>"; ?></p>
</section>
<!-- Fin sección metadatos -->

<!-- Inicio sección botón reservar cita -->
<section>
	<div class="centertxt">
		<a style="color: #b81d1e;" class="inline addusrbutton" href="#addcita"><i class="fa fa-plus" aria-hidden="true" style="font-size: 15px;"></i> <b>Reservar cita</b></a>
	</div>
</section>
<!-- Fin sección botón reservar cita -->

<br/>

<!-- Inicio sección mensaje de error -->
<section>
	<div class="centrar"><div id="msjcita" class="<?php if(isset($_GET['msjcls8'])){ echo $_GET['msjcls8']; } ?>"><?php if(isset($_GET['mensaje8'])){ echo $_GET['mensaje8']; } ?></div></div>
</section>
<!-- Fin sección mensaje de error -->

<!-- Inicio sección mostrar reporte -->
<section class="container">	

	<div class="row centrar" style="display: block; overflow-x: auto;">
			  
		<table id="tbldate" style="min-width: 100%; width: max-content; max-width: 3000px;">
		<?php echo $reporte; ?>	                 
		</table>
		
	</div>

	<div id="paginacion"><?php echo '<br/>'; if ($totalReg > 20) echo $paginacion->_paginateDetails(); ?></div>
	
</section>
<!-- Fin sección mostrar reporte -->		