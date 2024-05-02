<?php 
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Suscripcion */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/suscripcion.php");

	/* Permite acceder a la clase PHPMAILER */
	use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require ($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

	class CrudSuscripcion {

		public function __construct(){}


		/* Registra una suscripcion de un cliente */
		public function insertarSuscrip($suscrip){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO suscripciones VALUES(NULL, :nombre, :apellido, :correo, :telefono, :vinpla, :politicaPrivacida)');
			$insert->bindValue(':nombre',$suscrip->getNombre());
			$insert->bindValue(':apellido',$suscrip->getApellido());
			$insert->bindValue(':correo',$suscrip->getCorreo());
			$insert->bindValue(':telefono',$suscrip->getTel());
			$insert->bindValue(':vinpla',$suscrip->getVinpla());
			$insert->bindValue(':politicaPrivacida',$suscrip->getPolpri());
			$insert->execute();
		}


		/* Obtener el ID de una Suscripcion 
		public function obtenerSuscripId($suscrip){
			$db=DB::conectar();
			$select=$db->prepare('SELECT id FROM suscripciones WHERE placa=:placa');
			$select->bindValue(':placa',$cita->getPlacac());
			$select->execute();

			$result = $select->fetch();


			return $result['id']; 
		}
		*/


		/* Método que envia el correo de confirmación */ 
		public function sendMailClient($suscrip){		

			$mail = new PHPMailer(true);
			$mail->CharSet = "UTF-8";

			try {
				/*Propiedades del Servidor*/
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      		//Enable verbose debug output
	    		$mail->isSMTP();                                            		//Send using SMTP
			    $mail->Host       = 'p3plmcpnl492698.prod.phx3.secureserver.net';   //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   		//Enable SMTP authentication
			    $mail->Username   = 'info@excelrecall.com.sv';                     	//SMTP username
			    $mail->Password   = 'g_Dfw2uYr*kSNMat7e';                           //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           			//Enable implicit TLS encryption
			    $mail->Port       = 465;                                    		//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			    //Destinatarios

			    /* Indicamos cual es nuestra dirección de correo y el nombre que verá el usuario que lee el correo */
			    $mail->setFrom('info@excelrecall.com.sv', 'Excel Talleres El Salvador');
			    
			    /* Indicamos cual es la/s dirección/es de destino del correo */
			    $mail->addAddress($suscrip->getCorreo());     //Add a recipient, Name is optional
			    $mail->addReplyTo('info@excelrecall.com.sv', 'Excel Recall Información');
			    //$mail->addCC('cc@example.com');
			    //$mail->addBCC('bcc@example.com');			

			    //Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

				/* Asignamos asunto y cuerpo del mensaje */
				$mail->isHTML(true);                                  //Set email format to HTML
			
				/* Asignamos asunto y cuerpo del mensaje */
				$mail->Subject = "Suscripción enviada";
				$mail->Body = " 
								<div style='display: flex; justify-content: center;' >
									<img alt='Excel-Talleres-Logo' src='https://excelrecall.com.sv/assets/img/excel-logo-wbg.png'>
								</div>

								<br/>
								<br/>

								<p><b>TUS DATOS FUERON ENVIADOS CORRECTAMENTE</b></p>
								
								<br/>

								<p><b>RESUMEN</b>:</p>
								<p><b>Nombre</b>: ".$suscrip->getNombre()." ".$suscrip->getApellido()." <br/>
								   <b>VIN/Placa</b>: ".$suscrip->getVinpla()." <br/>
								   <b>Correo electrónico</b>: ".$suscrip->getCorreo()." <br/>
								   <b>Teléfono</b>: ".$suscrip->getTel()."
								</p>
							  ";

				/* Definimos AltBody por si el destinatario del correo no admite email con formato html */ 
				$mail->AltBody = "TUS DATOS FUERON ENVIADOS CORRECTAMENTE -> 
								  Nombre: ".$suscrip->getNombre()." ".$suscrip->getApellido().",
								  VIN/Placa: ".$suscrip->getVinpla().", 
								  Correo: ".$suscrip->getCorreo().", 
								  Teléfono: ".$suscrip->getTel();

				/* Se envia el mensaje, si no ha habido problemas la variable $exito tendra el valor true */
				$exito = $mail->Send();
				/* 
				Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar 
				enviar el mensaje, cada intento se hara 5 segundos despues del anterior, para ello se usa la 
				funcion sleep
				*/	
				$intentos=1; 
				
				while ((!$exito) && ($intentos < 5)) {
					sleep(5);
				 	/*echo $mail->ErrorInfo;*/
				 	$exito = $mail->Send();
				 	$intentos=$intentos+1;	
				}

				return $exito;
				//echo 'Mensaje enviado';
			} catch (Exception $e) {
    			//echo "Mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
			}
		
		} /* Fin Método que envia el correo de confirmación */


		/* Método que envia el correo al Administrador */ 
		public function sendMailAdmin($suscrip){

			$db=Db::conectar();	
			$select=$db->prepare("SELECT parametro FROM administracion WHERE variable = 'correoDestinoSuscrip'");
			$select->execute();
			$listaCorreos = $select->fetchAll();

			foreach ($listaCorreos as $correo) {
				$correosadjuntos = $correo['parametro']; 
			}

			$correosDestino = explode(";", $correosadjuntos);
			
			$crud = new CrudSuscripcion();
			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';
			
			$lastid=$db->prepare("SELECT * FROM suscripciones ORDER BY id DESC LIMIT 1");
			$lastid->execute();
			$lastID = $lastid->fetch();

			$idSuscripcion = $lastID['id'];
	
			try {
				/*Propiedades del Servidor*/
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      		//Enable verbose debug output
	    		$mail->isSMTP();                                            		//Send using SMTP
			    $mail->Host       = 'p3plmcpnl492698.prod.phx3.secureserver.net';   //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   		//Enable SMTP authentication
			    $mail->Username   = 'info@excelrecall.com.sv';                     	//SMTP username
			    $mail->Password   = 'g_Dfw2uYr*kSNMat7e';                           //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           			//Enable implicit TLS encryption
			    $mail->Port       = 465;                                    		//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			    //Destinatarios

				/* Indicamos cual es la/s dirección/es de destino del correo */
			    $mail->setFrom('info@excelrecall.com.sv', 'Excel Talleres El Salvador');

				foreach($correosDestino as $correos) {
					/* Indicamos cual es la/s dirección/es de destino del correo */
					$mail->addAddress($correos);
			      //$mail->addCC('cc@example.com');
	   			  //$mail->addBCC('bcc@example.com');
				}

			    $mail->addReplyTo('info@excelrecall.com.sv', 'Excel Recall Información');
			    			
			    //Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				
				/* Asignamos asunto y cuerpo del mensaje */
				$mail->isHTML(true);

				/* Asignamos asunto y cuerpo del mensaje */
				$mail->Subject = "Excel Talleres Recall - Nueva Suscripción # ".$idSuscripcion;
				 
				$BodyEdit = ' 
							<div style="display: flex; justify-content: center;">
								<img alt="Excel-Talleres-Logo" src="https://excelrecall.com.sv/assets/img/excel-logo-wbg.png">
							</div>

							<br/>
							<br/>

							<p><b>Hay un nuevo suscriptor:</b></p>
							
							<br/>

							<p><b>Resumen de datos</b>:</p>
							<p><b>Nombre</b>: '.$suscrip->getNombre().' '.$suscrip->getApellido().' <br/>
							   <b>VIN/Placa</b>: '.$suscrip->getVinpla().' <br/>
							   <b>Correo electrónico</b>: '.$suscrip->getCorreo().' <br/>
							   <b>Teléfono</b>: '.$suscrip->getTel().'
							</p>

							<br/>

							<p>*El vehículo del cliente no posee campañas activas.</p>
							<p> 
						 ';

				$mail->Body = $BodyEdit;

				/* Definimos AltBody por si el destinatario del correo no admite email con formato html */ 
				$mail->AltBody = "NUEVO SUSCRIPTOR -> 
								  Nombre: ".$suscrip->getNombre()." ".$suscrip->getApellido().",
								  VIN/Placa: ".$suscrip->getVinpla().", 
								  Correo: ".$suscrip->getCorreo().", 
								  Teléfono: ".$suscrip->getTel();

				/* Se envia el mensaje, si no ha habido problemas la variable $exito tendra el valor true */
				$exito = $mail->Send();

				/* 
				Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho para intentar 
				enviar el mensaje, cada intento se hara 5 segundos despues del anterior, para ello se usa la 
				funcion sleep
				*/	
				$intentos=1; 
				
				while ((!$exito) && ($intentos < 5)) {
					sleep(5);
				 	/*echo $mail->ErrorInfo;*/
				 	$exito = $mail->Send();
				 	$intentos=$intentos+1;	
				}

				return $exito;
				//echo 'Mensaje enviado';
			} catch (Exception $e) {
    			//echo "Mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
			}
		
		} // Fin Método que envia el correo de nueva cita al administrador
	} 
?>