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

?>
  
<!-- Inicio Contenido -->
<section>
	<div class="container-excelautomotriz" style="background-color: #ffffffd6; border: solid 3px #1e1e1e;">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			
				<br/>
				<h1 class="centertxt";>Gestión de Usuarios</h1>
				<br/>

				<!-- Botón Ayuda -->
				<a title="¡Ver Ayuda!" class="inline ayuda cboxElement animated bounce infinite" href="#help2" style="animation-duration: 2.5s; animation-delay: 2s;"><i class="fa fa-question" aria-hidden="true"></i></a>
				<span class="line"></span>
				
				<br/>

				<div class="centertxt"><i class="fa fa-users" aria-hidden="true" style="font-size: 80px;"></i></div>
				
				<br/>
				
				<p class="centertxt"><b style="color: red;">*</b>Todos los usuarios poseen privilegios de administrador.</p>
				
				<div class="centertxt">
					<a style="color: red;" class='inline' href="#adduser"><i class="fa fa-user-plus" aria-hidden="true" style="font-size: 20px;"></i> <b>Agregar Usuario</b></a>
				</div>
		  
				<br/>

				<div class="centrar">
					<div id="alertusr" class="<?php if(isset($_GET['msjcls2'])){ echo $_GET['msjcls2']; } ?>"><?php if(isset($_GET['mensaje2'])){ echo $_GET['mensaje2']; } ?></div>
				</div>
				
				<br/>
				
				<div class="container">
					<div class="row centrar" style="display: block; overflow-x: auto;">	  
						<table style="width: 1100px; max-width: 100%;">
					
							<thead class="centertxt">
								<tr>
									<th><i class="fa fa-hashtag" aria-hidden="true"></i></th>
									<th><b><i class="fa fa-user" aria-hidden="true"></i></i> NOMBRE</b></th>
									<th><b><i class="fa fa-envelope-o" aria-hidden="true"></i> CORREO ELECTRÓNICO</b></th>
									<th><b><i class="fa fa-shield" aria-hidden="true"></i> ROL</b></th>
									<th><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> ESTADO</b></th>
									<th style="display: none;"><b><i class="fa fa-key" aria-hidden="true"></i> CLAVE</b></th>
									<th><b><i class="fa fa-cogs" aria-hidden="true"></i> ACCIÓN</b></th>
								</tr>
							</thead>
							
							<tbody>
								<?php  
									
									$db=Db::conectar();	
									$select=$db->prepare("SELECT * FROM usuarios ORDER BY id ASC");
									$select->execute();
									$listaUsuarios = $select->fetchAll();
									
									foreach($listaUsuarios as $usuario) { 
								
								?> 
							    <tr>
									<td id="<?php echo "id-usr-".$usuario['id']; ?>" class="centertxt"><?php echo $usuario['id']; ?></td>
									<td id="<?php echo "nom-usr-".$usuario['id']; ?>" ><?php echo $usuario['nombre']; ?></td>
									<td id="<?php echo "cor-usr-".$usuario['id']; ?>" ><?php echo $usuario['correo']; ?></td>
									<td id="<?php echo "rol-usr-".$usuario['id']; ?>" class="centertxt"><?php echo $usuario['rol']; ?></td>
									<td id="<?php echo "st-usr-".$usuario['id']; ?>" class="centertxt"><?php if($usuario['estado']==1){echo "Activo";}else{echo "Inactivo";} ?></td>
									<td id="<?php echo "cla-usr-".$usuario['id']; ?>" style="display: none;"><?php echo $usuario['clave']; ?></td>
									<td class="centertxt">
										<a title="Editar" id="<?php echo "editUsrBoton".$usuario['id']; ?>" class="inline cboxElement" href="#upduser" style="color: #000;" onclick="editUsr(this.id)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										&nbsp;&nbsp;
										<a title="Eliminar" id="<?php echo "delUsrBoton".$usuario['id']; ?>" class="inline cboxElement" href="#deluser" style="color: #000;" onclick="delUsr(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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


<!-- Contiene la ventana emergente para agregar usuarios -->
<div style="display:none">
	<div id="adduser" style="padding:10px; background:#fff;">
		<h2 class="centertxt";>Registra un Usuario</h2>
		<br/>	
		<span class="line"></span>
		
		<div class="centrar">

			<div>
				<form class="users" action="controllers/controlador-login" method="POST">
					<p>
					<label for="correo">Correo electrónico:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="correo" type="email" name="correo" placeholder="ejemplo@email.com" required>
					</p>
					<p>
					<label for="nombre">Nombre de usuario:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="nombre" type="text" name="nombre" placeholder="-" onkeypress="return validarLetras(event)" required>
					</p>
					<p>
					<label for="rol">Rol:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="rol" name="rol" required>
						<option value="Administrador">Administrador</option>
					</select>
					</p>
					<p>
					<label for="estado">Estado:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="estado" name="estado" required>
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
					</p>
					<p>
					<label for="clave">Password:</label><br/>
					<input  style="width: 250px;" class="usersinputinput" id="clave" type="password" name="clave" placeholder="" required>
					</p>
					<p>
					<button type="submit" name="registrarse" class="botons">Agregar</button>
					</p>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- fin ventana emergente para agregar usuarios -->


<!-- Contiene la ventana emergente para editar usuarios -->
<div style='display:none'>
	<div id="upduser" style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>Editar Usuario</h2>
		<br/>	
		<span class="line"></span>
		
		<div class="centrar">

			<div>
				<form class="users" action="controllers/controlador-login" method="POST">
					<input type="hidden" id="idupd" name="idupd" value="">
					<p>
					<label for="correoupd">Correo electrónico:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="correoupd" type="email" name="correoupd" placeholder="ejemplo@email.com" required>
					</p>
					<p>
					<label for="nombreupd">Nombre de usuario:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="nombreupd" type="text" name="nombreupd" placeholder="-" onkeypress="return validarLetras(event)" required>
					</p>
					<p>
					<label for="rolupd">Rol:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="rolupd" name="rolupd" required>
						<option value="Administrador">Administrador</option>
						<!--<option value="Super">Super Usuario</option>-->
					</select>
					</p>
					<p>
					<label for="estadoupd">Estado:</label><br/>
					<select style="width: 250px;" class="usersinputinput" id="estadoupd" name="estadoupd" required>
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select>
					</p>
					<p>
					<label for="claveupd">Password:</label><br/>
					<input style="width: 250px;" class="usersinputinput" id="claveupd" type="password" name="claveupd" placeholder="" required>
					</p>
					<p>
					<button type="submit" name="editar" class="botons">Actualizar</button>
					</p>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- fin ventana emergente para editar usuarios -->


<!-- Contiene la ventana emergente para eliminar usuarios -->
<div style='display:none'>
	<div id='deluser' style='padding:10px; background:#fff;'>
		
		<br/>
		<h2 class="centertxt";>Eliminar un Usuario</h2>
		<br/>	
		<span class="line"></span>

		<p class="centertxt">El usuario: </p> 
		
		<div class="centrar" style="display: block; overflow-x: auto;">
			<table style="width: 100%; max-width: 1000px;">		
				<thead class="centertxt">
					<tr>
						<th><i class="fa fa-hashtag" aria-hidden="true"></i></th>
						<th><b><i class="fa fa-user" aria-hidden="true"></i> NOMBRE</b></th>
						<th><b><i class="fa fa-envelope-o" aria-hidden="true"></i> CORREO ELECTRÓNICO</b></th>
						<th><b><i class="fa fa-shield" aria-hidden="true"></i> ROL</b></th>
						<th><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> ESTADO</b></th>
					</tr>
				</thead>
				<tbody>
				    <tr>
						<td id="id-usr-del" class="centertxt"></td>
						<td id="nom-usr-del" ></td>
						<td id="cor-usr-del" class="centertxt"></td>
						<td id="rol-usr-del" class="centertxt"></td>
						<td id="st-usr-del" class="centertxt"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<br/>
		<p class="centertxt"><b>Será eliminado de forma definitiva, esta acción es irreversible ¿Estás seguro?</b></p>
		
		<form style="display: contents;" action="controllers/controlador-login" method="POST">

			<div class="centrar">
				<input type="hidden" id="iddel" name="iddel" value="">
				<input type="hidden" id="idusrses" name="idusrses" value="<?php echo $usrid; ?>">
				<div><button class="botons" type="submit" name="deleteusr" title="¿Seguro?">Eliminar</button></div>
			</div>

		</form>
	
	</div>
</div>
<!-- fin ventana emergente para eliminar usuarios -->


<!-- Contiene la ventana emergente para ayuda -->
<div style='display:none'>
	<div id='help2' style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>AYUDA</h2>
		<br/>	
		<span class="line"></span>
		<div class="centrar">
			<div>
				<p style="text-align: justify;">
					<b>1.</b> Puedes realizar el mantenimiento completo de los Usuarios del sistema: Agregar uno nuevo, editarlo o eliminarlo.
					<br/>
					<br/>
					<b>2.</b> Al agregar un usuario considera una clave complicada (al menos 8 caracteres), que incluya numeros, letras mayúsculas, minúsculas y caracteres especiales diversos para mayor seguridad.  
					<br/>
					<br/>
					<b>3.</b> Al editar un usuario puedes definir su estado (activo o inactivo) para permitirle o no su acceso al sistema, no edites la clave si no vas a cambiarla en realidad, pues el campo muestra un valor cifrado y un cambio erróneo no permitira su posterior acceso al sistema.  
					<br/>
					<br/>
					<b>4.</b> Si eliminas al usuario actual (es decir con quien estás logueado) el sistema cerrara la sesión inmediatamente, para cualquier caso es irreversible, tendrás que crear de nuevo un usuario. 
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
 