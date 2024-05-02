<?php 
	/* Permite acceder a la clase AutoPagination */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/class.AutoPagination.php");

	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");

	$db=Db::conectar();
	
	$filtro = array(); 

	/* Validaciones para filtros */
	if (!empty($_GET['filvin'])){
	    $filtro[]  = 'vin = '.'"'.$_GET['filvin'].'"';
	} 

	if (!empty($_GET['filpla'])){
	    $filtro[]  = 'placa = '.'"'.$_GET['filpla'].'"';
	} 

	if (!empty($_GET['filcam'])){
	    $filtro[]  = 'nombreCampanya = '.'"'.$_GET['filcam'].'"';
	} 

	if (!empty($_GET['filestateC'])){
	    $filtro[]  = 'estadoCita = '.'"'.$_GET['filestateC'].'"';
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
	
	$select1 = $db->prepare("SELECT * FROM auditoria WHERE $filtro ORDER BY id ASC");
	$select1->execute();
	$totalReg = $select1->rowCount(); //Total de registros devueltos

	$select = $db->prepare("SELECT * FROM auditoria WHERE $filtro ORDER BY id ASC LIMIT $min, $maxreg");
	$select->execute();
	$registros = $select->fetchAll();

	/* Número de clientes */
	$select3 = $db->query('SELECT COUNT(DISTINCT placa) FROM auditoria');
	$totalCL = $select3->fetch();

	/* Número de verificaciones */
	$select4 = $db->query('SELECT COUNT(DISTINCT fechaVerificacion) FROM auditoria');
	$totalVER = $select4->fetch();

	/* Número de citas */
	$select5 = $db->query('SELECT COUNT(DISTINCT fechaCita) FROM auditoria');
	$totalCI = $select5->fetch();

	/* Número de cargas */
	$select6 = $db->query('SELECT COUNT(DISTINCT fechaCarga) FROM auditoria');
	$totalCAR = $select6->fetch();

	$paginacion = new AutoPagination($totalReg, @$_GET['page']);

	$reporte = '<thead class="centertxt">
					<tr>
						<th>ID</th>
						<th>Pais</th>
						<th>VIN</th>
						<th>Placa</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>ID Excel</th>
						<th>ID Fábrica</th>
						<th>Campaña</th>
						<th>Descripción</th>
						<th>Fecha/Hora de verificación VIN/Placa</th>
						<th>Fecha/Hora de reservación de cita</th>
						<th>Estado de cita</th>
						<th>Fecha/Hora de cargado de datos</th>
						<th>Usuario que cargó datos</th>
					</tr>
				</thead>

				<tbody>';
				foreach($registros as $registro) {  
	$reporte .= '    <tr>
						<td class="centertxt">'.$registro['id'].'</td>
						<td class="centertxt">'.$registro['pais'].'</td>
						<td class="centertxt">'.$registro['vin'].'</td>
						<td class="centertxt">'.$registro['placa'].'</td>
						<td class="centertxt">'.$registro['marca'].'</td>
						<td class="centertxt">'.$registro['modelo'].'</td>
						<td class="centertxt">'.$registro['idExcel'].'</td>
						<td class="centertxt">'.$registro['idFabrica'].'</td>
						<td>'.$registro['nombreCampanya'].'</td>
						<td>'.$registro['descripcionCampanya'].'</td>
						<td class="centertxt">'.$registro['fechaVerificacion'].'</td>
						<td class="centertxt">'.$registro['fechaCita'].'</td>
						<td class="centertxt">'.$registro['estadoCita'].'</td>
						<td class="centertxt">'.$registro['fechaCarga'].'</td>
						<td>'.$registro['usuarioCarga'].'</td>
					</tr>';
					 } 
	$reporte .= '</tbody>';

?>

<!-- Inicio sección de filtros -->
<section id="filters">
	<form class="centertxt" action="reportes#tblaus" method="GET">
		<div class="row">
			<input type="hidden" name="r" value="auditoria">

			<!-- Filtro por VIN -->
			<div class="col-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filvin">Filtrar por VIN:</label><br/> 
				<input class="inputfil" id="filvin" title="Ingresa un VIN" type="text" maxlength="17" name="filvin" value="<?php if (isset($_GET['filvin'])) echo $_GET['filvin']; ?>" placeholder="-"> 

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filvin').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

			<!-- Filtro por Placa -->
			<div class="col-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filpla">Filtrar por Placa:</label><br/>
				<input class="inputfil" id="filpla" title="Ingresa una Placa" type="text" maxlength="7" name="filpla" value="<?php if (isset($_GET['filpla'])) echo $_GET['filpla']; ?>" placeholder="P000000">

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>			
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filpla').val('');"><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

			<!-- Filtro por Campaña -->
			<div class="col-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filcam">Filtrar por Campaña:</label><br/>
				
				<?php 

					$select2 = $db->prepare('SELECT DISTINCT nombreCampanya FROM auditoria');
			        $select2->execute();
			        $totalCMP = $select2->rowCount(); /* Total de campañas */
			        $allcampanyas = $select2->fetchAll();


			        echo '<select class="inputfil" id="filcam" title="Elige" name="filcam">';
			        echo '<option selected value>--- Ver todas ---</option>';

			        $filtroNomCamp2 = "-";

					if (!empty($_GET['filcam'])) {
					    $filtroNomCamp2 = $_GET['filcam'];
					}

			        foreach($allcampanyas as $cmp) {

			            if ($cmp['nombreCampanya'] == $filtroNomCamp2) {
			                    echo'<option value="'.$cmp['nombreCampanya'].'" selected>'.$cmp['nombreCampanya'].'</option>';
			            } else {
			                echo'<option value="'.$cmp['nombreCampanya'].'">'.$cmp['nombreCampanya'].'</option>';
			            }

			        }
			        
			        echo '</select>'; 

			    ?>
				
				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filcam').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>		
			</div>

 			<!-- Filtro por Estado de Cita -->
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<label for="filestateC">Filtrar por Estado:</label><br/>
				<select class="inputfil" id="filestateC" title="Elige" name="filestateC">';
			        <option selected value>--- Ver Todos ---</option>
			        <option value="Activa">Activa</option>
			        <option value="En Proceso">En Proceso</option> 
			        <option value="Finalizada">Finalizada</option> 
			    </select>

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filestateC').val('');" ><i class="fa fa-refresh" aria-hidden="true"></i></button>		
			</div>

		</div>
	</form>
</section>
<!-- Fin sección de filtros -->

<br/>

<!-- Inicio sección descargar reporte -->
<section>
	<form action="controllers/controlador-reporte-auditoria" method="POST">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12 centrar">
				<div>
					<input type="hidden" name="filvinr" id="filvinr" value="<?php if (isset($_GET['filvin'])) echo $_GET['filvin']; ?>"/>                
	                <input type="hidden" name="filplar" id="filplar" value="<?php if (isset($_GET['filpla'])) echo $_GET['filpla']; ?>"/>
	                <input type="hidden" name="filcamr" id="filcamr" value="<?php if (isset($_GET['filcam'])) echo $_GET['filcam']; ?>"/>
	                <input type="hidden" name="filstter" id="filstter" value="<?php if (isset($_GET['filestateC'])) echo $_GET['filestateC']; ?>"/> 
					
					<!-- Inicio Limites de Descarga -->
					<div class="row centrar">
						<div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6">
							<label style="width: max-content;" for="limit">Límite (hasta 25000):</label><br/>
	               			<input class="inputfil" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" min="1" max="25000" maxlength="5" name="limit" id="limit" placeholder="1,2,3,..." value="<?php if (isset($_POST['limit'])) echo $_POST['limit']; ?>"/>
						</div>
						</div>
						<div>
						<div class="col-12 col-sm-6 col-md-6 col-lg-6">
							<label for="offset">Desde:</label><br/> 
	                		<input class="inputfil" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" min="1" max="25000" maxlength="5" name="offset" id="offset" placeholder="1,2,3,..." value="<?php if (isset($_POST['offset'])) echo $_POST['offset']; ?>"/>
						</div>
						</div>
					</div>
					<!-- Fin Limites de Descarga -->
					
	                <br/>
	                <center>
					<button class="botons" type="submit" id="descargarReporte" name="descargarReporte"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR REPORTE</button>
					</center>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- Fin sección descargar reporte -->

<br/>

<!-- Inicio sección metadatos -->
<section>
	<p style="margin-bottom: 0px;" class="centertxt"><?php echo "# Registros devueltos: <b>$totalReg</b>"." <span style='color: #d2081b;'>|</span> "."Total Campañas: <b>$totalCMP</b>"." <span style='color: #d2081b;'>|</span> "."Total Clientes: <b>$totalCL[0]</b>"." <span style='color: #d2081b;'>|</span> "."Total Verificaciones: <b>$totalVER[0]</b>"." <span style='color: #d2081b;'>|</span> "."Total Citas: <b>$totalCI[0]</b>"." <span style='color: #d2081b;'>|</span> "."Total Cargas: <b>$totalCAR[0]</b>"; ?></p>
</section>
<!-- Fin sección metadatos -->

<br/>

<!-- Inicio sección mensaje de error -->
<section>
	<div class="centrar"><div id="msjau" class="<?php if(isset($_GET['msjcls7'])){ echo $_GET['msjcls7']; } ?>"><?php if(isset($_GET['mensaje7'])){ echo $_GET['mensaje7']; } ?></div></div>
</section>
<!-- Fin sección mensaje de error -->

<!-- Inicio sección mostrar reporte -->
<section class="container">	
	
	<div class="row centrar" style="display: block; overflow-x: auto;">
			  
		<table id="tblaus" style="min-width: 100%; width: max-content; max-width: 3600px;">
		<?php echo $reporte; ?>	                 
		</table>
		
	</div>

	<div id="paginacion"><?php echo '<br/>'; if ($totalReg > 20) echo $paginacion->_paginateDetails(); ?></div>
	
</section>
<!-- Fin sección mostrar reporte -->				