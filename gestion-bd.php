<?php 
	date_default_timezone_set ('America/El_Salvador');

	/* Conforma el inicio de sesion del sistema */
	require_once("config/sesion.php");

	/* Conforma la conexion con la BD */
	require_once("config/conexion-config.php"); 

	/* Header de la plantilla */ 
	require_once("template/header-admin.php"); 

	/* Titulo de la página */
	require_once("template/titulo.php"); 

	/* Menu del administrador */   
	require_once("template/menu.php"); 

?>  

<!-- Inicio Contenido -->
<section>
	<div class="container-excelautomotriz" style="background-color: #ffffffd6; border: solid 3px #1e1e1e;"> 
		<div class="row">	
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
	
				<br/>
				<h1 class="centertxt">Gestión de Base de Datos</h1>
				<br/>
				<!-- Botón Ayuda -->
				<a title="¡Ver Ayuda!" class="inline ayuda cboxElement animated bounce infinite" href="#help1" style="animation-duration: 2.5s; animation-delay: 2s;"><i class="fa fa-question" aria-hidden="true"></i></a>
				<span class="line"></span>
				
				<br/>
				<div class="centertxt"><b><i class="fa fa-database" aria-hidden="true"></i> Importar el archivo Excel a la BD.</b></div>
			
				<?php 

				/*
				PASO 1 comentado
				
				<br/>
				<p class="pasosbd"><span style="color: #b62126;">1er.</span> Paso: vaciar BD.</p>
				<br/>
				
				<form class="centertxt" action="controllers/controlador-vaciar-bd" method="POST" name="eraseform" id="eraseform" enctype="multipart/form-data">
					<input type="hidden" name="tabla" value="campanyas">
					<button class="botons" type="submit" id="erasebd" name="erasebd"><i class="fa fa-trash" aria-hidden="true"></i> Vaciar</button>
				</form>

				<br/>
				
				<div class="centrar">
					<div class="<?php if(isset($_GET['msjcls'])){ echo $_GET['msjcls']; }?>"><?php if(isset($_GET['mensaje'])){ echo $_GET['mensaje']; }?></div>
				</div>
				
				<hr class="separador"/>
				*/ 

				?>
				
				<br/>
				<p class="pasosbd"><span style="color: #b62126;">1er.</span> Paso: cargar Archivo.</p>
				<br/>
				<p class="centertxt">Renombra el archivo a importar.<br/>Ej.: excelbd-01-06-2022.xls ó .xlsx</p>
				
				<form class="centertxt" action="controllers/controlador-import-bd" method="POST" name="frmExcelImport" enctype="multipart/form-data">
					<div class="centrar">
						<input class="botons" type="file" name="file" id="file" accept=".xls,.xlsx">
					</div>
					<br/>
					<hr style="margin: 0px 0px 10px 0px;"/>
					<p class="pasosbd"><span style="color: #b62126;">2do.</span> Paso: importar Archivo.</p>
					<br/>
					<p class="centertxt">Asegúrate que el formato del archivo a importar sea el correcto.</p> 
					<input type="hidden" name="tabla" value="campanyas">
					<input type="hidden" name="fechacarga" id="fechacarga" value="<?php echo date("d-m-Y h:i:sa"); ?>">
					
					<input type="hidden" name="usercarga" id="usercarga" value="<?php echo $usrname; ?>">
					<button class="botons" type="submit" id="submit" name="importar"><i class="fa fa-upload" aria-hidden="true"></i> Importar</button>  
				</form>
				
				<br/>
				<div class="centrar">
					<div id="msj1" class="<?php if(isset($_GET['msjcls1'])){ echo $_GET['msjcls1']; } ?>"><?php if(isset($_GET['mensaje1'])){ echo $_GET['mensaje1']; } ?></div>
				</div>
				
			</div>
			
		</div>

		<hr class="separador"/>

		<?php 
					
			$db=Db::conectar();	
			$select=$db->prepare("SELECT * FROM campanyas ORDER BY id ASC LIMIT 10");
			$select->execute();
			$total = $db->query("SELECT * FROM campanyas")->rowCount();
			$listaCampanyas = $select->fetchAll(); 				
				
		?>

		<p class="pasosbd"><span style="color: #b62126;"><i class="fa fa-search" aria-hidden="true"></i></span> Vista Previa de la Tabla</p>
		<br/>
		<p class="centertxt"># Registros importados: <b><?php echo "$total"; ?></b></p>

		<div class="container">	
			<div class="row centrar" style="display: block; overflow-x: auto;">
					  
				<table style="width: max-content; max-width: 2800px;">
					<thead class="centertxt">
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
						</tr>
					</thead>                 
					<tbody>
						<?php foreach($listaCampanyas as $campanyas) { ?> 
						<tr>
							<td class="centertxt"><?php  echo $campanyas['id']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['pais']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['vin']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['placa']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['marca']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['modelo']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['idExcel']; ?></td>
							<td class="centertxt"><?php  echo $campanyas['idFabrica']; ?></td>
							<td><?php  echo $campanyas['nombreCampanya']; ?></td>
							<td><?php  echo $campanyas['descripcionCampanya']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

	<br/>
	<br/>
	</div>
</section>
<!-- Fin Contenido -->

<!-- Contiene la ventana emergente para ayuda -->
<div style='display:none'>
	<div id='help1' style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>AYUDA</h2>
		<br/>	
		<span class="line"></span>
		<div class="centrar">
			<div>
				<p style="text-align: justify;">
					<b>1.</b> La tabla a subir debe cumplir el formato siguiente:<br/>
					Los campos válidos son: <b>País, VIN, Placa, Marca, Modelo, ID Excel, ID Fábrica, Nombre de Campaña y Descripción;</b> en ese orden y comenzando en la celda A1 tal como se muestra en la Figura 1.
					<br/>
					<br/>
					<b>2.</b> Debes eliminar <b>(No ocultar)</b> los encabezados de la tabla a subir, tal como se muestra en la Figura 1.
					<br/>
					<br/> 
					<img style="width: 100%; height: auto;" src="/assets/img/import-bd-hint.jpg" alter="img-import1">
					<br/>
					<center>Figura 1.</center>
					<br/>
					<b>3.</b> Debes eliminar <b>(No ocultar)</b> las hojas de Excel que no serán utilizadas, tal como se muestra en la Figura 2.
					<br/>
					<br/> 
					<img style="width: 100%; height: auto;" src="/assets/img/import-bd-2-hint.jpg" alter="img-import2">
					<br/>
					<center>Figura 2.</center>
					<br/>
					<b>4.</b> Debes nombrar el archivo como se sugiere: excelbd-02-12-2018, colocando la fecha en la que se realizará la carga de datos.
					<br/>
					<br/>
					<b>5.</b> Los formatos admitidos son: <b>.xls</b> o <b>.xlsx</b> de <img class="officeIcons" src="/assets/img/excel-win-ico.png" alter="win-excel"> <b>Microsoft Excel v2003-16</b> en <img class="officeIcons" src="/assets/img/windows-logo.png" alter="windows"> <b>SO Microsoft Windows x32/x64 7/8/8.1/10</b>. 
					<br/>
					<br/>
					<b>6.</b> El cargado del archivo Excel presentara problemas si este proviene de exportaciones a los formatos <b>.xls</b> o <b>.xlsx</b> desde versiones de <b>Apache OpenOffice - <img class="officeIcons" src="/assets/img/calc-openOffice-ico.png" alter="calc-1"> Calc</b> ó <b>LibreOffice - <img class="officeIcons" src="/assets/img/calc-libreOffice-ico.png" alter="calc-2"> Calc (<img class="officeIcons" src="/assets/img/linux-logo.png" alter="linux"> GNU/Linux, <img class="officeIcons" style="vertical-align: baseline;" src="/assets/img/mac-logo.png" alter="mac"> MAC OS X ó <img class="officeIcons" src="/assets/img/windows-logo.png" alter="windows"> MS Windows, etc.)</b>, así como <b>iWork - <img class="officeIcons" src="/assets/img/numbers-ico.png" alter="numbers"> Numbers</b> y <b>Microsoft Excel <img class="officeIcons" style="vertical-align: baseline;" src="/assets/img/excel-mac-ico.png" alter="excel-mac"> (<img class="officeIcons" style="vertical-align: baseline;" src="/assets/img/mac-logo.png" alter="mac"> MAC OS X)</b>, inclusive versiones móviles de Ofimaticas tales como <img class="officeIcons" src="/assets/img/officeSuite-movil.png" alter="officeSuit"> <b>OfficeSuite</b> entre otras.  
					<br/>
					<br/>
					<b>7.</b> Por último, puedes adjuntar el archivo de Microsoft Excel simplemente arrastrándolo hacia este botón: <br/><br/><center><input class="botons" type="file" accept=".xls,.xlsx"></center> 
					<br/>
					
					<hr style="margin-bottom: 30px;">
							
					<div class="centrar">
						<a href="https://www.markcoweb.com/" target="_blank"><img class="imglogo" src="./assets/img/logoMarkco2.png" style="width: 150px;" alt="logo"></a>	
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
   
 