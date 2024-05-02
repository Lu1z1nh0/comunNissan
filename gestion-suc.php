<?php
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

	/* Comunicación con modelo sucursales*/
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");

	$crudSuc = new CrudSucursal();

?>
  
<!-- Inicio Contenido -->
<section>
	<div class="container-excelautomotriz" style="background-color: #ffffffd6; border: solid 3px #1e1e1e;">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			
				<br/>
				<h1 class="centertxt";>Gestión de Sucursales</h1>
				<br/>

				<!-- Botón Ayuda -->
				<a title="¡Ver Ayuda!" class="inline ayuda cboxElement animated bounce infinite" href="#help4" style="animation-duration: 2.5s; animation-delay: 2s;"><i class="fa fa-question" aria-hidden="true"></i></a>
				<span class="line"></span>
				
				<br/>

				<div class="centertxt"><i class="fa fa-wrench" aria-hidden="true" style="font-size: 80px;"></i></div>

				<br/>
				
				<div class="centertxt">
					<a style="color: red;" class='inline' href="#addsuc"><i class="fa fa-plus" aria-hidden="true" style="font-size: 20px;"></i> <b>Agregar Sucursal</b></a>
				</div>
		  
				<br/>

				<div class="centrar">
					<div id="alertsuc" class="<?php if(isset($_GET['msjcls2'])){ echo $_GET['msjcls2']; } ?>"><?php if(isset($_GET['mensaje2'])){ echo $_GET['mensaje2']; } ?></div>
				</div>
				
				<br/>
				
				<div class="container">
					<div class="row centrar" style="display: block; overflow-x: auto;">	  
						<table style="width: max-content; max-width: 1800px;">
					
							<thead class="centertxt">
								<tr>
									<th><i class="fa fa-hashtag" aria-hidden="true"></i></th>
									<th><b><i class="fa fa-tag" aria-hidden="true"></i></i> NOMBRE</b></th>
									<th><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> ESTADO</b></th>
									<th><b><i class="fa fa-map-marker" aria-hidden="true"></i> DIRECCIÓN</b></th>
									<th><b><i class="fa fa-flag" aria-hidden="true"></i> PAÍS</b></th>
									<th><b><i class="fa fa-cogs" aria-hidden="true"></i> ACCIÓN</b></th>
								</tr>
							</thead>

							<tbody>
								<?php  
									
									$db=Db::conectar();	
									$select=$db->prepare("SELECT * FROM sucursales ORDER BY id ASC");
									$select->execute();
									$listaSucursales = $select->fetchAll();
									
									foreach($listaSucursales as $sucursal) { 
								
								?> 
							    <tr>
									<td id="<?php echo "id-suc-".$sucursal['id']; ?>" class="centertxt"><?php echo $sucursal['id']; ?></td>
									<td id="<?php echo "nom-suc-".$sucursal['id']; ?>" ><?php echo $sucursal['nombre']; ?></td>
									<td id="<?php echo "st-suc-".$sucursal['id']; ?>" class="centertxt"><?php if($sucursal['estado']==1){echo "Activa";}else{echo "Inactiva";} ?></td>
									<td id="<?php echo "dir-suc-".$sucursal['id']; ?>" ><?php echo $sucursal['direccion']; ?></td>
									<td id="<?php echo "pais-suc-".$sucursal['id']; ?>" class="centertxt"><?php echo $sucursal['pais']; ?></td>
									<td class="centertxt">
										<a title="Editar" id="<?php echo "editSucBoton".$sucursal['id']; ?>" class="inline cboxElement" href="#updsuc" style="color: #000;" onclick="editSuc(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										&nbsp;&nbsp;
										<a title="Eliminar" id="<?php echo "delSucBoton".$sucursal['id']; ?>" class="inline cboxElement" href="#delsuc" style="color: #000;" onclick="delSuc(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									</td>
								</tr>
								<?php } ?>
							</tbody>

						</table>
					</div>
				</div>

				<br/>
				<br/>	
				
			</div>
		</div> 
	</div>
</section>
<!-- Fin Contenido -->


<!-- Contiene la ventana emergente para agregar sucursales -->
<div style="display:none">
	<div id="addsuc" style="padding:10px; background:#fff;">
		<h2 class="centertxt";>Agrega una Sucursal</h2>
		<br/>	
		<span class="line"></span>
		
		<div class="centrar">

			<div>
				<form class="users" action="controllers/controlador-sucursal" method="POST">
					<p>
					<label for="nombreSuc">Nombre:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="nombreSuc" type="text" name="nombreSuc" placeholder="-" required>
					</p>
					<p>
					<label for="estadoSuc">Estado:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="estadoSuc" name="estadoSuc" required>
						<option value="1">Activa</option>
						<option value="2">Inactiva</option>
					</select>
					</p>
					<p>
					<label for="direccionSuc">Dirección:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="direccionSuc" type="text" name="direccionSuc" placeholder="-" required>
					</p>
					<p>
					<label for="paisSuc">País:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="paisSuc" name="paisSuc" required>
						<option value="El Salvador" selected>El Salvador</option>
						<option value="Nicaragua">Nicaragua</option>
						<option value="Honduras">Honduras</option>
						<option value="Panama">Panamá</option>
						<option value="Guatemala">Guatemala</option>
					</select>
					</p>
					<p>
					<button type="submit" name="registrarSuc" class="botons">Agregar</button>
					</p>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- fin ventana emergente para agregar sucursales -->


<!-- Contiene la ventana emergente para editar sucursal -->
<div style='display:none'>
	<div id="updsuc" style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>Editar Sucursal</h2>
		<br/>	
		<span class="line"></span>
		
		<div class="centrar">

			<div>
				<form class="users" action="controllers/controlador-sucursal" method="POST">
					<input type="hidden" id="idSucUpd" name="idSucUpd" value="">
					<p>
					<label for="nomSucUpd">Nombre:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="nomSucUpd" type="text" name="nomSucUpd" placeholder="-" required>
					</p>
					<p>
					<label for="estadoSucUpd">Estado:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="estadoSucUpd" name="estadoSucUpd" required>
						<option value="1">Activa</option>
						<option value="2">Inactiva</option>
					</select>
					</p>
					<p>
					<label for="direccionSucUpd">Dirección:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="direccionSucUpd" type="text" name="direccionSucUpd" placeholder="-" required>
					</p>
					<p>
					<label for="paisSucUpd">País:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="paisSucUpd" name="paisSucUpd" required>
						<option value="El Salvador" selected>El Salvador</option>
						<option value="Nicaragua">Nicaragua</option>
						<option value="Honduras">Honduras</option>
						<option value="Panama">Panamá</option>
						<option value="Guatemala">Guatemala</option>
					</select>

					</p>
					<p>
					<button type="submit" name="editarSuc" class="botons">Actualizar</button>
					</p>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- fin ventana emergente para editar sucursal -->


<!-- Contiene la ventana emergente para eliminar sucursales - INACTIVA -->
<div style='display:none'>
	<div id='delsuc' style='padding:10px; background:#fff;'>
		
		<br/>
		<h2 class="centertxt";>Eliminar Sucursal</h2>
		<br/>	
		<span class="line"></span>

		<!--<p class="centertxt">La Sucursal: </p>-->
		
		<div class="centrar" style="display: block; overflow-x: auto;">
			<table style="width: 100%; max-width: 1000px;">		
				<thead class="centertxt">
					<tr>
						<th><i class="fa fa-hashtag" aria-hidden="true"></i></th>
						<th><b><i class="fa fa-tag" aria-hidden="true"></i> NOMBRE</b></th>
						<th><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> ESTADO</b></th>
						<th><b><i class="fa fa-map-marker" aria-hidden="true"></i> DIRECCIÓN</b></th>
						<th><b><i class="fa fa-flag" aria-hidden="true"></i> PAÍS</b></th>
					</tr>
				</thead>
				<tbody>
				    <tr>
						<td id="id-suc-del" class="centertxt"></td>
						<td id="nom-suc-del" ></td>
						<td id="st-suc-del" class="centertxt"></td>
						<td id="dir-suc-del" class="centertxt"></td>
						<td id="pais-suc-del" class="centertxt"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<br/>
		<p class="centertxt"><b>Será eliminada de forma definitiva, esta acción es irreversible ¿Estás seguro?</b></p>
		
		<form style="display: contents;" action="controllers/controlador-sucursal" method="POST">

			<div class="centrar">
				<input type="hidden" id="idSucDel" name="idSucDel" value="">
				<div><button class="botons" type="submit" name="deleteSuc" title="¿Seguro?">Eliminar</button></div>
			</div>

		</form>
	
	</div>
</div>
<!-- fin ventana emergente para eliminar sucursales -->


<!-- Contiene la ventana emergente para ayuda -->
<div style='display:none'>
	<div id='help4' style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>AYUDA</h2>
		<br/>	
		<span class="line"></span>
		<div class="centrar">
			<div>
				<p style="text-align: justify;">
					<b>1.</b> Puedes realizar el mantenimiento completo de las sucursales disponibles para atender al cliente que haga una cita en el sistema: Agregar una nueva, editarla o eliminarla (inhabilitarla).
					<br/>
					<br/>
					<b>2.</b> Al agregar una sucursal se establece por defecto que su país es El Salvador y puedes agregar una dirección en caso sea necesario mostrarla en el sistema aunque, solo se muestra el nombre de la sucursal tanto en el formulario para agendar una cita como en el panel de administración.  
					<br/>
					<br/>
					<b>3.</b> Al editar una sucursal puedes definir su estado (activo o inactivo) para que sea mostrada o no en el formulario para agendar citas (lado del cliente).  . 
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
 