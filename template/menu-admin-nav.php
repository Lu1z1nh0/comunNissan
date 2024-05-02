<div style="background-color: #c7c7c778; text-align:center; margin:0; border-bottom: 1px solid #ff1723; border-radius: 15px;">

	<a title="Ir Atrás" class="adm" href="javascript:history.back(-1);">
		<i class="fa fa-sign-in" aria-hidden="true" style="transform: rotateY(180deg);color: #fff;font-size: 20px;"></i>
	</a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp; 
	
	<a title="Ir a Inicio" class="adm" href="./home"><i class="fa fa-home" aria-hidden="true" style="color: #fff; font-size: 20px;"></i></a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;    

	<a class="inline cboxElement" href="#gestmail" title="Ingresa para gestionar correos">
		<button class="gestcorreo">
			<i style="color: #fff;font-size: 18px;" class="fa fa-envelope" aria-hidden="true"></i>
		</button>
	</a>

	&nbsp;&nbsp;|&nbsp;&nbsp;    

	<a href="./gestion-suc" title="Ingresa para gestionar sucursales">

		<i style="color: #fff; font-size: 18px;" class="fa fa-map-marker" aria-hidden="true"></i>

	</a>
	
	&nbsp;&nbsp;|&nbsp;&nbsp;
	
	<form style="display: unset;" action="./controllers/controlador-login" method="POST">
		<input type="hidden" name="salir" value="salir">
		<a title="Cerrar Sesión" style="cursor: pointer;">
			<button class="cerrarSesion">
				<i style="color: #fff; background-color: #d2081b; padding: 2px 4px; border-radius: 15px;" class="fa fa-power-off" aria-hidden="true"></i>
			</button>
		</a>
	</form> 

</div>

<!-- Contiene la ventana emergente para gestionar correo -->
<div style='display:none'>
	<div id='gestmail' style='padding:10px; background:#fff;'>
		<h2 class="centertxt";>Gestionar Receptores de Correos</h2>
		<br/>	
		<span class="line"></span>
		
		<div class="centrar">

			<?php 
				
				$db=Db::conectar();	
				//$select=$db->prepare("SELECT id, correoDestino FROM administracion");
				$select=$db->prepare("SELECT id, parametro, variable FROM administracion WHERE variable = 'correoDestino' OR variable = 'correoDestinoSuscrip'");
				$select->execute();
				$listaCorreos = $select->fetchAll();

				foreach ($listaCorreos as $correo) {

					if ($correo['variable'] == "correoDestino") {
						$correosadjuntos1 = $correo['parametro'];
						$correosadjuntosid1 = $correo['id'];
					} else { 
						$correosadjuntos2 = $correo['parametro'];
						$correosadjuntosid2 = $correo['id']; 
					}
				}

			?>

			<div style="max-width: 100%; width: 100%;">
				<form class="users" action="controllers/controlador-administracion" method="POST">
					
					<p>
					<label for="correoad"><i class="fa fa-envelope" aria-hidden="true"></i> Correo/s electrónico/s - Citas:</label><br/>
					<input type="hidden" name="correoadjid1" value="<?php echo $correosadjuntosid1; ?>">
					<input class="correosadjuntos" id="correoadj1" type="text" name="correoadj1" value="<?php echo $correosadjuntos1; ?>" placeholder="ejemplo1@email.com;ejemplo2@email.com" autocomplete="off" required>
					</p>

					<p>
					<label for="correoad"><i class="fa fa-envelope" aria-hidden="true"></i> Correo/s electrónico/s - Suscripciones:</label><br/>
					<input type="hidden" name="correoadjid2" value="<?php echo $correosadjuntosid2; ?>">
					<input class="correosadjuntos" id="correoadj2" type="text" name="correoadj2" value="<?php echo $correosadjuntos2; ?>" placeholder="ejemplo1@email.com;ejemplo2@email.com" autocomplete="off" required>
					</p>

					<p class="text-center"><button class="botons" type="submit" name="updatemailad">Actualizar</button></p>
				</form>

				<p><b>NOTA:</b> Agrega los correos que gustes separados por ";" sin espacios y respetando el formato correcto de una dirección de correo electrónico.</p>
			</div>

		</div>

	</div>
</div>
<!-- fin ventana emergente para para gestionar correo -->




				
					  

						