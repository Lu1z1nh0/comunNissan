<?php
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Cita */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/cita.php");

	/* Permite acceder a la clase PHPMAILER */
	use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require ($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

	class CrudCita {

		public function __construct(){}


		/* Registra una cita */
		public function insertarCita($cita){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO cita VALUES(NULL, :vin, :placa, :nombre, :apellido, :correo, :telefono, :sucursal, :fechaManto, :hora, :estado, :userAE, :fechaAE, :politicaPrivacida)');
			$insert->bindValue(':vin',$cita->getVinc());
			$insert->bindValue(':placa',$cita->getPlacac());
			$insert->bindValue(':nombre',$cita->getNombre());
			$insert->bindValue(':apellido',$cita->getApellido());
			$insert->bindValue(':correo',$cita->getCorreo());
			$insert->bindValue(':telefono',$cita->getTel());
			$insert->bindValue(':sucursal',$cita->getSucursal());
			$insert->bindValue(':fechaManto',$cita->getFecha());
			$insert->bindValue(':hora',$cita->getHora());
			$insert->bindValue(':estado',$cita->getEstado());
			$insert->bindValue(':userAE',$cita->getUserae());
			$insert->bindValue(':fechaAE',$cita->getFechaae());
			$insert->bindValue(':politicaPrivacida',$cita->getPolpri());
			$insert->execute();
		}


		/* Actualiza un cita */
		public function updateCita($cita){
			
			$db=DB::conectar();
			
			$update=$db->prepare('UPDATE cita SET vin=:vin, placa=:placa, nombre=:nombre, apellido=:apellido, correo=:correo, telefono=:telefono, sucursal=:sucursal, fechaManto=:fechaManto, hora=:hora, estado=:estado, addEdit=:userAE, fechaAddEdit=:fechaAE WHERE id=:id');
			$update->bindValue(':id',$cita->getId());
			$update->bindValue(':vin',$cita->getVinc());
			$update->bindValue(':placa',$cita->getPlacac());
			$update->bindValue(':nombre',$cita->getNombre());
			$update->bindValue(':apellido',$cita->getApellido());
			$update->bindValue(':correo',$cita->getCorreo());
			$update->bindValue(':telefono',$cita->getTel());
			$update->bindValue(':sucursal',$cita->getSucursal());
			$update->bindValue(':fechaManto',$cita->getFecha());
			$update->bindValue(':hora',$cita->getHora());
			$update->bindValue(':estado',$cita->getEstado());
			$update->bindValue(':userAE',$cita->getUserae());
			$update->bindValue(':fechaAE',$cita->getFechaae());
			$update->execute();
			
		}


		/* Elimina una reservación de cita */
		public function deleteCita($idCita){
			
			$db=DB::conectar();
			
			$delete=$db->prepare('DELETE FROM cita WHERE id=:id');
			$delete->bindValue(':id',$idCita);
			$delete->execute();
			
		}


		/* Obtener el ID de una cita */
		public function obtenerCitaId($cita){
			$db=DB::conectar();
			$select=$db->prepare('SELECT id FROM cita WHERE placa=:placa');
			$select->bindValue(':placa',$cita->getPlacac());
			$select->execute();
			$result = $select->fetch();

			return $result['id']; 
		}


		/* Registra la fecha/hora en la que el cliente reserva la cita y actualiza su estado */   
		public function updateDateCita($placacon, $fechacon, $estadoCita){
			$db=Db::conectar();
			$update=$db->prepare('UPDATE auditoria SET fechaCita=:fechacon, estadoCita=:estadoCita WHERE placa=:placacon');
			$update->bindValue(':fechacon',$fechacon);
			$update->bindValue(':placacon',$placacon);
			$update->bindValue(':estadoCita',$estadoCita);
			$update->execute();	
		}


		/* Actualiza el estado de la cita en auditoria */   
		public function updateDateCitaAuth($placa, $estadoCita){
			$db=Db::conectar();
			$update=$db->prepare('UPDATE auditoria SET estadoCita=:estadoCita WHERE placa=:placa');
			$update->bindValue(':placa',$placa);
			$update->bindValue(':estadoCita',$estadoCita);
			$update->execute();	
		}


		/* Método que envia el correo de confirmación */ 
		public function sendMailClient($cita, $direccionSuc, $msj) {		

			$mail = new PHPMailer(true);
			$mail->CharSet = "UTF-8";
			
			try {
				/*Propiedades del Servidor*/
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      		//Enable verbose debug output
	    		$mail->isSMTP();                                            		//Send using SMTP
			    $mail->Host       = 'p3plzcpnl452766.prod.phx3.secureserver.net';   //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   		//Enable SMTP authentication
			    $mail->Username   = 'info@comunidadnissan.com.pa';                     	//SMTP username
			    $mail->Password   = 'eUl-fP~7A?@$';                           //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           			//Enable implicit TLS encryption
			    $mail->Port       = 465;                                    		//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			    //Destinatarios

			    /* Indicamos cual es nuestra dirección de correo y el nombre que verá el usuario que lee el correo */
			    $mail->setFrom('info@comunidadnissan.com.pa', 'Excel Talleres Panamà');
			    
			    /* Indicamos cual es la/s dirección/es de destino del correo */
			    $mail->addAddress($cita->getCorreo());     //Add a recipient, Name is optional
			    $mail->addReplyTo('info@excelrecall.com.sv', 'Excel Recall Información');
			    //$mail->addCC('cc@example.com');
			    //$mail->addBCC('bcc@example.com');			

			    //Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				
				/* Asignamos asunto y cuerpo del mensaje */
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = "Solicitud de Cita Excel Recall";
				$mail->Body = " 
								<div style='display: flex; justify-content: center;' >
									<img alt='Excel-Talleres-Logo' src='https://excelrecall.com.sv/assets/img/excel-logo-wbg.png'>
								</div>

								<br/>
								<br/>

								<p><b>¡SUS DATOS HAN SIDO PROCESADOS CORRECTAMENTE!</b></p>
								
								<br/>

								<p><b>RESUMEN</b>:</p>
								<p><b>Nombre</b>: ".$cita->getNombre()." ".$cita->getApellido()." <br/>
								   <b>Correo electrónico</b>: ".$cita->getCorreo()." <br/>
								   <b>Teléfono</b>: ".$cita->getTel()." <br/>
								   <b>Sucursal</b>: ".$cita->getSucursal().", ".$direccionSuc." <br/>
								   <b>Fecha/hora de cita</b>: ".$cita->getFecha()." ".$cita->getHora()." <br/>
								   <b>Estado de su cita</b>: ".$cita->getEstado()."
								</p>

								<br/>
								
								<p><b>NOTA</b>:".$msj.".</p>
							  ";

				/* Definimos AltBody por si el destinatario del correo no admite email con formato html */ 
				$mail->AltBody = "SUS DATOS HAN SIDO PROCESADOS CORRECTAMENTE -> 
								  Nombre: ".$cita->getNombre()." ".$cita->getApellido().", 
								  Correo: ".$cita->getCorreo().", 
								  Teléfono: ".$cita->getTel().",
								  Sucursal: ".$cita->getSucursal().", ".$direccionSuc.",  
								  Fecha/hora de cita: ".$cita->getFecha()." ".$cita->getHora().",
								  Estado de su cita: ".$cita->getEstado()." -> 
								  NOTA: ".$msj.".";

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


		/* Método que envia el correo de confirmación de finalizacion de cita */ 
		public function sendMailClientFinal($cita) {		

			$mail = new PHPMailer(true);
			$mail->CharSet = "UTF-8";
			
			try {
				/*Propiedades del Servidor*/
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      		//Enable verbose debug output
	    		$mail->isSMTP();                                            		//Send using SMTP
			    $mail->Host       = 'p3plzcpnl452766.prod.phx3.secureserver.net';   //Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   		//Enable SMTP authentication
			    $mail->Username   = 'info@comunidadnissan.com.pa';                     	//SMTP username
			    $mail->Password   = 'eUl-fP~7A?@$';                           //SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           			//Enable implicit TLS encryption
			    $mail->Port       = 465;                                    		//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			    //Destinatarios

			    /* Indicamos cual es nuestra dirección de correo y el nombre que verá el usuario que lee el correo */
			    $mail->setFrom('info@comunidadnissan.com.pa', 'Excel Talleres Panamá');
			    
			    /* Indicamos cual es la/s dirección/es de destino del correo */
			    $mail->addAddress($cita->getCorreo());     //Add a recipient, Name is optional
			    $mail->addReplyTo('info@comunidadnissan.com.pa', 'Excel Recall Información');
			    //$mail->addCC('cc@example.com');
			    //$mail->addBCC('bcc@example.com');			

			    //Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				
				/* Asignamos asunto y cuerpo del mensaje */
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = "Cita Excel Recall";
				$mail->Body = " 
								<div style='display: flex; justify-content: center;' >
									<img alt='Excel-Talleres-Logo' src='https://excelrecall.com.sv/assets/img/excel-logo-wbg.png'>
								</div>

								<br/>
								<br/>

								<p><b>¡FELICIDADES, HAS COMPLETADO LAS CAMPAÑAS DE SERVICIO DE TU VEHÍCULO!</b></p>
								
								<br/>

								<p><b>Sr/Sra</b>: ".$cita->getNombre()." ".$cita->getApellido()." ha sido un placer atenderte.</p>
							  ";

				/* Definimos AltBody por si el destinatario del correo no admite email con formato html */ 
				$mail->AltBody = "¡FELICIDADES, HAS COMPLETADO LAS CAMPAÑAS DE SERVICIO DE TU VEHÍCULO! -> 
								  Sr/Sra: ".$cita->getNombre()." ".$cita->getApellido()." ha sido un placer atenderte.";

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
		
		} /* Fin Método que envia el correo confirmacion de finalizacion de cita */ 


		/* Método que envia el correo al Administrador */ 
		public function sendMailAdmin($cita, $campydesc, $msj) {

			$db=Db::conectar();	
			$select=$db->prepare("SELECT parametro FROM administracion WHERE variable = 'correoDestino'");
			$select->execute();
			$listaCorreos = $select->fetchAll();

			foreach ($listaCorreos as $correo) {
				$correosadjuntos = $correo['parametro']; 
			}

			$correosDestino = explode(";", $correosadjuntos);
			
			$crud = new CrudCita();
			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';
			
			$lastid=$db->prepare("SELECT * FROM cita ORDER BY id DESC LIMIT 1");
			$lastid->execute();
			$lastID = $lastid->fetch();

			$idCliente = $lastID['id'];

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
				$mail->Subject = "Excel Talleres - Nueva cita reservada # ".$idCliente;
				 
				$BodyEdit = ' 
							<div style="display: flex; justify-content: center;">
								<img alt="Excel-Talleres-Logo" src="https://excelrecall.com.sv/assets/img/excel-logo-wbg.png">
							</div>

							<br/>
							<br/>

							<p><b>'.$msj.'.</b></p>
							
							<br/>

							<p><b>Resumen de datos</b>:</p>
							<p><b>Nombre</b>: '.$cita->getNombre().' '.$cita->getApellido().' <br/>
							   <b>VIN</b>: '.$cita->getVinc().' <br/>
							   <b>Placa</b>: '.$cita->getPlacac().' <br/>
							   <b>Correo electrónico</b>: '.$cita->getCorreo().' <br/>
							   <b>Teléfono</b>: '.$cita->getTel().' <br/>
							   <b>Sucursal</b>: '.$cita->getSucursal().' <br/>
							   <b>Fecha/hora de cita</b>: '.$cita->getFecha().' '.$cita->getHora().' <br/>
							   <b>Estado de cita</b>: '.$cita->getEstado().'
							</p>

							<br/>

							<p><b>Campañas a las que aplica el cliente:</b></p>
							<p> 
						 ';
				
				$i=1;

				foreach($campydesc as $campanyas) {

					$BodyEdit .= '<b><span style="color: #d13239;">'.$i.'.</span> '.$campanyas['nombreCampanya'].'</b>: '.$campanyas['descripcionCampanya'].'<br/>';
				
					$i++;						
				}

				$BodyEdit .= ' 
							</p>
							<br/>
							<p><b>Agregada/Editada por</b>: '.$cita->getUserae().' | <b>Fecha/Hora</b>: '.$cita->getFechaae().'</p>
						  ';

				$mail->Body = $BodyEdit;

				/* Definimos AltBody por si el destinatario del correo no admite email con formato html */ 
				$mail->AltBody = "NUEVA SOLICITUD DE CITA -> 
							      VIN: ".$cita->getVinc().",
								  Placa: ".$cita->getPlacac().",
								  Nombre: ".$cita->getNombre()." ".$cita->getApellido().", 
								  Correo: ".$cita->getCorreo().", 
								  Teléfono: ".$cita->getTel().",
								  Sucursal: ".$cita->getSucursal().",  
								  Fecha/hora de cita: ".$cita->getFecha()." ".$cita->getHora().",
								  Agregada/Edita por: ".$cita->getUserae().",  
								  Fecha/Hora: ".$cita->getFechaae().",
								  Estado de la cita: ".$cita->getEstado(); 

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
		
		} /* Fin Método que envia el correo de nueva cita al administrador */

 	}
?>