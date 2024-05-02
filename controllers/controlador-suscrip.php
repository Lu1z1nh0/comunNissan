<?php
	/* Conforma la comunicación con el Modelo */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-suscripcion.php");
	
	$suscrip = new Suscripcion();
	$crud = new CrudSuscripcion();

	/*
	verifica si la variable "iniSuscrip" está definida
	se da que está definida cuando un cliente no tiene un vehiculo en campaña pero se suscribe y entonces se envía la petición
	*/
	if (isset($_POST['iniSuscrip'])) {

		$captcha = "";

		if(isset($_POST['g-recaptcha-response'])) {

			$captcha=$_POST['g-recaptcha-response'];
        }

        if(!$captcha) {
          
			header('Location: ../suscripcion?data3='.$_POST['data3'].'&msjcls4=mensaje-error&mensaje4=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor haz clic sobre la casilla verificación!#msjf1'); /* cuando hay un error con el recaptcha*/
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

        	header('Location: ../suscripcion?data3='.$_POST['data3'].'&msjcls4=mensaje-error&mensaje4=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor verifica que no eres un robot!#msjf1');
			exit; 

        } else {

			$suscrip->setNombre($_POST['nombre']);
			$suscrip->setApellido($_POST['apellido']);
			$suscrip->setCorreo($_POST['correo']);
			$suscrip->setTel($_POST['telefono']);
			$suscrip->setVinpla($_POST['vincon']);
			$suscrip->setPolpri($_POST['polpri']);

			$datos[] = $suscrip->getNombre(); 
			$datos[] = $suscrip->getApellido();
			$datos[] = $suscrip->getCorreo();
			$datos[] = $suscrip->getTel();
			$datos[] = $suscrip->getVinpla();

			$crud->insertarSuscrip($suscrip);
			
			/* Se envia correo de confirmación al cliente*/
			$estado1 = $crud->sendMailClient($suscrip);

			/* Se envia correo de aviso al Admin */
			$estado2 = $crud->sendMailAdmin($suscrip);

			/* Procesa la variable antes de enviarla */
			$datos = serialize($datos);
			$datos = base64_encode($datos);
			$datos = urlencode($datos); 

			if(!$estado1 && !$estado2) {
				/* echo "Problemas enviando correo electrónico a ".$suscrip->setCorreo($_POST['correo']); */
				/* echo "<br/>".$mail->ErrorInfo; */
				header("Location: ../confirmacion?msjcls4=¡Sus datos fueron enviados correctamente!"."&data1=".$datos);
				exit;	
			} else {
				/* echo "Mensaje enviado correctamente"; */
				header("Location: ../confirmacion?msjcls4=¡Sus datos fueron enviados correctamente!"."&data1=".$datos);
				exit;
			} 
	
		}

	}//fin If clic botón suscribir

?>