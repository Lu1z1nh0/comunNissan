<?php 
	/* Permite acceder a la clase AutoPagination */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/class.AutoPagination.php");

	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");

	$db=Db::conectar();
	
	$filtro = array(); 

	/* Validaciones para filtros */
	if (!empty($_GET['filvinplas'])){
    $filtro[]  = 'vinpla = '.'"'.$_GET['filvinplas'].'"';
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
	
	$select1 = $db->prepare("SELECT * FROM suscripciones WHERE $filtro ORDER BY id ASC");
	$select1->execute();
	$totalReg = $select1->rowCount(); /* Total de registros devueltos */
	$select = $db->prepare("SELECT * FROM suscripciones WHERE $filtro ORDER BY id ASC LIMIT $min, $maxreg");
	$select->execute();
	$registros = $select->fetchAll();

	/* Número de suscriptores */
	$select3 = $db->query('SELECT COUNT(DISTINCT vinpla) FROM suscripciones');
	$totalCL = $select3->fetch();

	$paginacion = new AutoPagination($totalReg, @$_GET['page']);

	$reporte = '<thead class="centertxt">
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Correo</th>
						<th>Teléfono</th>
						<th>VIN/Placa</th>
						<th>Política de Privacidad</th>
					</tr>
				</thead>

				<tbody>';
				foreach($registros as $registro) {  
	$reporte .= '    <tr>
						<td class="centertxt">'.$registro['id'].'</td>
						<td class="centertxt">'.$registro['nombre'].'</td>
						<td class="centertxt">'.$registro['apellido'].'</td>
						<td class="centertxt">'.$registro['correo'].'</td>
						<td class="centertxt">'.$registro['telefono'].'</td>
						<td class="centertxt">'.$registro['vinpla'].'</td>
						<td class="centertxt">'.$registro['politicaPrivacida'].'</td>
					</tr>';
					 } 
	$reporte .= '</tbody>';

?>

<!-- Inicio sección de filtros -->
<section id="filters">
	<form class="centertxt" action="reportes#tblsuscrips" method="GET">
		<div class="row">
			<input type="hidden" name="r" value="suscripcionesr">

			<!-- Filtro por Placa o VIN -->
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<label for="filvinplas">Filtrar por Placa/VIN:</label><br/>
				<input class="inputfil" id="filvinplas" title="Ingresa Placa/VIN" type="text" maxlength="17" name="filvinplas" value="<?php if (isset($_GET['filvinplas'])) echo $_GET['filvinplas']; ?>" placeholder="-">

				<button class="botonfil" type="submit" title="Filtrar"><i class="fa fa-filter" aria-hidden="true"></i></button>			
				<button class="botonfil" type="button" title="Limpiar" onclick="$('#filvinplas').val('');"><i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>

		</div>
	</form>
</section>
<!-- Fin sección de filtros -->

<br/>

<!-- Inicio sección descargar reporte -->
<section>
	<form action="controllers/controlador-reporte-suscrip" method="POST">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-12 centrar">
				<div>
					<br/> 
	               	<input type="hidden" name="filvinplasr" id="filvinplasr" value="<?php if (isset($_GET['filvinplas'])) echo $_GET['filvinplas']; ?>"/> 

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
	<p class="centertxt"><?php echo "# Registros devueltos: <b>$totalReg</b>"." <span style='color: #d2081b;'>|</span> "."Total Suscriptores: <b>$totalCL[0]</b>"; ?></p>
</section>
<!-- Fin sección metadatos -->

<!-- Inicio sección mensaje de error -->
<section>
	<div class="centrar"><div id="msjcmp" class="<?php if(isset($_GET['msjcls9'])){ echo $_GET['msjcls9']; } ?>"><?php if(isset($_GET['mensaje9'])){ echo $_GET['mensaje9']; } ?></div></div>
</section>
<!-- Fin sección mensaje de error -->

<!-- Inicio sección mostrar reporte -->
<section class="container">	
	
	<div class="row centrar" style="display: block; overflow-x: auto;">
			  
		<table id="tblsuscrips" style="min-width: 100%; width: max-content; max-width: 2500px;">
		<?php echo $reporte; ?>	                 
		</table>
		
	</div>

	<div id="paginacion"><?php echo '<br/>'; if ($totalReg > 20) echo $paginacion->_paginateDetails(); ?></div>

</section>
<!-- Fin sección mostrar reporte -->