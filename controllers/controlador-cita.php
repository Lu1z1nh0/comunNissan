<?php
	/* Conforma la comunicación con el Modelo */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-cita.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-campanya.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");
	
	$cita = new Cita();
	$crud = new CrudCita();
	$crudCmp = new CrudCampanya();
	$crudSuc = new CrudSucursal();
	
	/*
	verifica si la variable "hacerCita" está definida
	se da que está definida cuando un cliente hace una cita y entonces se envía la petición
	*/

	if (isset($_POST['hacerCita'])) {

		$captcha = "";

		if(isset($_POST['g-recaptcha-response'])) {

			$captcha=$_POST['g-recaptcha-response'];
        }

        if(!$captcha) {
          
			header('Location: ../formulario?data='.$_POST['data'].'&data1='.$_POST['data1'].'&data2='.$_POST['data2'].'&msjcls4=mensaje-error&mensaje4=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor haz clic sobre la casilla verificación!#msjf1'); /* cuando hay un error con el recaptcha*/
			exit; 
		}

		$env2 = $_SERVER['SERVER_NAME']; // remote || local (excelrecall.test)
		$secretKey = ""; 

		if ($env2 == "excelrecall.com.sv") {
			//excelrecall.com.sv - g-secret-recaptcha key
			$secretKey =  "6LflCVEgAAAAAHZgcVwlnjfq_RiXiTpPmuzO-kQ7";
		} else {
			//excelrecall.test - g-secret-recaptcha key
			$secretKey =  "6Lct2mEgAAAAAPkNk4qqeQGtXmDWd9bX46TKYyxp";
		}

        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        
        // should return JSON with success as true
        if(!$responseKeys["success"]) {

        	header('Location: ../formulario?data='.$_POST['data'].'&data1='.$_POST['data1'].'&data2='.$_POST['data2'].'&msjcls4=mensaje-error&mensaje4=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor verifica que no eres un robot!#msjf1');
			exit; 

        } else {


			$cita->setVinc($_POST['vincon']);
			$cita->setPlacac($_POST['placacon']);

			//Estado por defecto al registrarse una cita 
			$estadoCita = "Activa";

			$cita->setNombre($_POST['nombre']);
			$cita->setApellido($_POST['apellido']);
			$cita->setCorreo($_POST['correo']);
			$cita->setTel($_POST['telefono']);
			$direccionSuc = $crudSuc->obtenerSucursalDir($_POST['citasuc']);
			$cita->setSucursal($_POST['citasuc']);
			$cita->setFecha($_POST['fechaM']);
			$cita->setHora($_POST['horacita']);
			$cita->setEstado($estadoCita);
			$cita->setUserae($_POST['reservacion']);
			$cita->setFechaae($_POST['fechacon']);  
			$cita->setPolpri($_POST['polpri']);

			$datos[] = $cita->getNombre(); 
			$datos[] = $cita->getApellido();
			$datos[] = $cita->getCorreo();
			$datos[] = $cita->getTel();
			$datos[] = $cita->getFecha();
			$datos[] = $cita->getHora();
			$datos[] = $cita->getSucursal();
			$datos[] = $direccionSuc;

			/* verifica las campañas a las que aplica el cliente */
			$campydesc = $crudCmp->obtenerCampanyas($_POST['vincon']); 

			/*
			if ($crud->buscarCita($_POST['correo'])) {
			*/
				$crud->insertarCita($cita);
				$crud->updateDateCita($_POST['placacon'], $_POST['fechacon'], $estadoCita);

				$msj = "EN BREVE UN AGENTE SE CONTACTARÁ CON USTED PARA CONFIRMAR LA CITA";
				$msj21 = "Has recibido una nueva solicitud de cita";

				/* Se envia correo de confirmación al cliente*/
				$estado1 = $crud->sendMailClient($cita, $direccionSuc, $msj);

				/* Se envia correo de aviso al Admin */
				$estado2 = $crud->sendMailAdmin($cita, $campydesc, $msj21);


				/* Procesa la variable antes de enviarla */
				$datos = serialize($datos);
				$datos = base64_encode($datos);
				$datos = urlencode($datos); 

				if(!$estado1 && !$estado2) {
					header("Location: ../confirmacion?msjcls4=¡Sus datos fueron enviados correctamente!"."&data=".$datos);
					/* echo "Problemas enviando correo electrónico a ".$cita->setCorreo($_POST['correo']); */
					/* echo "<br/>".$mail->ErrorInfo; */
					exit;	
				} else {
					header("Location: ../confirmacion?msjcls4=¡Sus datos fueron enviados correctamente!"."&data=".$datos);
					/* echo "Mensaje enviado correctamente"; */
					exit;
				} 
		
			/*
			}else{
				header('Location: ../formulario?msjcls4=mensaje-error&mensaje4=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Ya has reservado una cita!');
				exit;
			}
			*/
		}
	  /*
	  verifica si la variable "reservarCita" está definida
	  se da que está definida cuando se hace una cita en la vista de administración y entonces se envía la petición
	  */
	} elseif (isset($_POST['reservarCita'])) {

		//Estado por defecto al registrarse una cita 
		$estadoCita = "Activa";

		$cita->setVinc($_POST['citavinadd']);
		$cita->setPlacac($_POST['citaplaadd']);
		$cita->setNombre($_POST['citanameadd']);
		$cita->setApellido($_POST['citaapeladd']);
		$cita->setCorreo($_POST['citacorreoadd']);
		$cita->setTel($_POST['citateladd']);
		$cita->setSucursal($_POST['citasucadd']);
		$direccionSuc = $crudSuc->obtenerSucursalDir($_POST['citasucadd']);
		$cita->setFecha($_POST['citafechaadd']);
		$cita->setHora($_POST['citahoraadd']);
		$cita->setEstado($estadoCita);
		$cita->setUserae($_POST['whoReser']);
		$cita->setFechaae($_POST['dateReser']);
		$cita->setPolpri("Acepto");
	
		$crud->insertarCita($cita);
		$crud->updateDateCita($_POST['citaplaadd'], $_POST['dateReser'], $estadoCita);

		/* verifica las campañas a las que aplica el cliente */
		$campydesc2 = $crudCmp->obtenerCampanyas($_POST['citavinadd']);

		$msj3 = "EN BREVE UN AGENTE SE CONTACTARÁ CON USTED PARA CONFIRMAR LA CITA";
		$msj33 = "Has recibido una nueva solicitud de cita";

		/* Se envia correo de confirmación al cliente*/
		$estado3 = $crud->sendMailClient($cita, $direccionSuc, $msj3);

		/* Se envia correo de aviso al Admin */
		$estado4 = $crud->sendMailAdmin($cita, $campydesc2, $msj33);

		if(!$estado3 && !$estado4) {
			header('Location: ../reportes?r=citas&msjcls8=mensaje-exito&mensaje8=<i class="fa fa-check" aria-hidden="true"></i> ¡Datos guardados con exito!#citastab');
			exit;	
		} else {
			header('Location: ../reportes?r=citas&msjcls8=mensaje-exito&mensaje8=<i class="fa fa-check" aria-hidden="true"></i> ¡Datos guardados con exito!#citastab'); 
			exit;
		} 
	  /*
	  verifica si la variable "reservarCitaupd" está definida
	  se da que está definida cuando se hace una actualización de los datos de una cita en la vista de administración y entonces se envía la petición
	  */
	} elseif (isset($_POST['reservarCitaupd'])) {

		$idcitaupd = $_POST['idupdcita'];

		if (!empty($idcitaupd)) {
		
			/* Setea el objeto con los parametros obtenidos */
			$cita->setId($_POST['idupdcita']);
			$cita->setVinc($_POST['citavinupd']);
			$cita->setPlacac($_POST['citaplaupd']);
			$cita->setNombre($_POST['citanameupd']);
			$cita->setApellido($_POST['citaapelupd']);
			$cita->setCorreo($_POST['citacorreoupd']);
			$cita->setTel($_POST['citatelupd']);
			$cita->setSucursal($_POST['citasucupd']);
			$direccionSuc = $crudSuc->obtenerSucursalDir($_POST['citasucupd']);
			$cita->setFecha($_POST['citafechaupd']);
			$cita->setHora($_POST['citahoraupd']);
			$cita->setEstado($_POST['citastateupd']);
			$cita->setUserae($_POST['whoReserupd']);
			$cita->setFechaae($_POST['dateReserupd']);


			$msj1 = "LOS DATOS DE LA CITA HAN SIDO ACTUALIZADOS EXITOSAMENTE";
			$msj4 = "Has actualizado la solicitud de cita";

			
			/* Envia el objeto para actualizar los datos de la cita en su tabla y en Auditoría */
			$crud->updateCita($cita);
			$crud->updateDateCitaAuth($_POST['citaplaupd'], $_POST['citastateupd']);

			/* verifica las campañas a las que aplica el cliente */
			$campydesc3 = $crudCmp->obtenerCampanyas($_POST['citavinupd']);


			if ($_POST['citastateupd'] == "Finalizada") {
				/* Se envia correo de confirmación de finalizacion de cita al cliente*/
				$estado5 = $crud->sendMailClientFinal($cita);
			} else { 
				/* Se envia correo de confirmación de reserva al cliente
				   Activa || En Proceso
				*/
				$estado5 = $crud->sendMailClient($cita, $direccionSuc, $msj1);
			}

			/* Se envia correo de aviso al Admin */
			$estado6 = $crud->sendMailAdmin($cita, $campydesc3, $msj4);

			if(!$estado5 && !$estado6) {
				header('Location: ../reportes?r=citas&msjcls8=mensaje-exito&mensaje8=<i class="fa fa-check" aria-hidden="true"></i> ¡Registro actualizado con exito!#citastab');
				exit;
			} else {
				header('Location: ../reportes?r=citas&msjcls8=mensaje-exito&mensaje8=<i class="fa fa-check" aria-hidden="true"></i> ¡Registro actualizado con exito!#citastab');
				exit;
			}

		} else {
			header('Location: ../reportes?r=citas&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Error! selecciona una cita.#citastab'); 
			exit;
		}
	  /*
	  verifica si la variable "deletecita" está definida
	  se da que está definida cuando se elimina una reservación de cita en la vista de administración y entonces se envía la petición
	  */
	} elseif (isset($_POST['deletecita'])) {

		/* Recibe el ID de la cita a eliminar */
		$idCita = $_POST['iddelcita'];

		if (!empty($idCita)) {
			$crud->deleteCita($idCita);	
			header('Location: ../reportes?r=citas&msjcls8=mensaje-exito&mensaje8=<i class="fa fa-check" aria-hidden="true"></i> ¡Registro eliminado con exito!#citastab');
				exit;
		} else {
			header('Location: ../reportes?r=citas&msjcls8=mensaje-error&mensaje8=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Error! selecciona una cita.#citastab'); 
			exit;
		}

	} else {		
		header('Location: ../'); 
		exit;
	} 

?>