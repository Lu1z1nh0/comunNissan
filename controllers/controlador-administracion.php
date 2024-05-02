<?php
	/* Conforma la comunicación con el Modelo */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-administracion.php");

	$adm = new Administracion();
	$crud = new CrudAdministracion(); 
	
	/* verifica si la variable "updatemailad" está definida */
	/* se da que está definida cuando se va a editar un correo */
	if (isset($_POST['updatemailad'])) {

		if (isset($_POST['correoadjid1']) && isset($_POST['correoadj1']) && isset($_POST['correoadjid2']) && isset($_POST['correoadj2'])) {

			$correoDestino = $_POST['correoadj1'];
			$correoDestinoSuscrip = $_POST['correoadj2'];
			$idD = $_POST['correoadjid1'];
			$idDS = $_POST['correoadjid2'];
			$mailsD = explode(";", $correoDestino);
			$mailsDS = explode(";", $correoDestinoSuscrip);

			$mails = $mailsD + $mailsDS;

			foreach ($mails as $validmails) {
				
				/* valida que los correos tengan el formato adecuado */	
				$ban = $crud->is_valid_email($validmails);

				if($ban === false){
					header('Location: ../home?msjcls10=mensaje-error&mensaje10=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Error! en el correo: <b>'.$validmails.'</b>#welcome');
					exit;
				}
			}

			/* Actualiza los correos de destinatarios */
			$crud->updateCorreoDestino($idD, $correoDestino);
			$crud->updateCorreoDestinoSuscrip($idDS, $correoDestinoSuscrip);
			
			header('Location: ../home?msjcls10=mensaje-exito&mensaje10=<i class="fa fa-check" aria-hidden="true"></i> ¡Correo/s actualizado/s con exito!'.'#welcome');
			exit;
			

		} else {
			header('Location: ../home?msjcls10=mensaje-error&mensaje10=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Ha ocurrido un error!'.'#welcome');
			exit;
		}	

	} 
 
?>