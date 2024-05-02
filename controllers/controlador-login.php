<?php
	/* Conforma la comunicación con el Modelo */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-usuario.php");

	/* inicio de sesion */
	session_start();

	$usuario = new Usuario();
	$crud = new CrudUsuario();

	/* 
	verifica si la variable "registrarse" está definida
	se da que está definida cuando se va a registrar un nuevo usuario y se envía la petición
	*/
	if (isset($_POST['registrarse'])) {
		
		if(empty($_POST['correo']) || empty($_POST['nombre']) || empty($_POST['rol']) || empty($_POST['estado']) || empty($_POST['clave'])){
			header('Location: ../gestion-usr?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Has dejado algún campo vacio!#alertusr');
			exit;
		} else {
			$usuario->setCorreo($_POST['correo']);
			$usuario->setNombre($_POST['nombre']);
			$usuario->setRol($_POST['rol']);
			$usuario->setEstado($_POST['estado']);
			$usuario->setClave($_POST['clave']);
							
			if ($crud->verificarUsuario($_POST['correo']) != 1) {
				$crud->insertarUsuario($usuario);
				header('Location: ../gestion-usr?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡El usuario ha sido registrado con exito!#alertusr');
				exit;
			}else{
				header('Location: ../gestion-usr?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡El nombre de usuario ya existe!#alertusr');
				exit;
			}
		
		}
		
	/*
	verifica si la variable "entrar" está definida		
	se da que está definida cuando se loguea y envía la petición
	*/
	} elseif (isset($_POST['entrar'])) {

		$email = "";
		$clave = "";
		$captcha = "";
        
        if(isset($_POST['correo'])) {

			$email = $_POST['correo'];
        } else {
			header('Location: ../admin?msjcls3=mensaje-error&mensaje3=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Tu correo o contraseña son incorrectos!#msj3'); /* cuando los datos son incorrectos muestra el error */
			exit;
		}

        if(isset($_POST['clave'])) {

        	$clave = $_POST['clave'];
        } else {
			header('Location: ../admin?msjcls3=mensaje-error&mensaje3=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Tu correo o contraseña son incorrectos!#msj3'); /* cuando los datos son incorrectos muestra el error */
			exit;
		}

		if(isset($_POST['g-recaptcha-response'])) {

			$captcha=$_POST['g-recaptcha-response'];
        }

        if(!$captcha) {
          
			header('Location: ../admin?msjcls3=mensaje-error&mensaje3=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor haz clic sobre la casilla verificación!#msj3'); /* cuando hay un error con el recaptcha*/
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

        	header('Location: ../admin?msjcls3=mensaje-error&mensaje3=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Por favor verifica que no eres un robot!#msj3'); /* cuando hay un error con el recaptcha*/
			exit; 
        } else {
		
			$usuario = $crud->obtenerUsuario($email,$clave);
			
			/* si el id del objeto retornado no es null, quiere decir que encontro un usuario registrado */
			if ($usuario->getId()!=NULL) {
				
				$username = $usuario->getNombre();	
				$userArr = (array)$usuario; //covierte el objeto $usuario en un array
				//$userArr = get_object_vars( $usuario );
				//$userArr = json_decode( json_encode( $usuario ), true );
				
				$_SESSION['usuario'] = $userArr; /* si el usuario se encuentra, crea la sesión de usuario */
				
				header('Location: ../home?msjcls10=welcome-p&mensaje10=<i class="fa fa-ravelry" aria-hidden="true"></i> ¡Bienvenido: ' .$username. '!'.'#welcome'); /* envia a la página que simula la cuenta */
				exit;
			}else{
				header('Location: ../admin?msjcls3=mensaje-error&mensaje3=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Tu correo o contraseña son incorrectos!#msj3'); /* cuando los datos son incorrectos muestra el error */
				exit;
			}
		}
		
	} elseif(isset($_POST['salir'])) { /* cuando presiona el botón salir */
			header('Location: ../admin');
			exit;
			unset($_SESSION['usuario']); /* destruye la sesión */
			session_destroy();

	} elseif (isset($_POST['editar'])) {

		$idusr = $_POST['idupd'];

		if (!empty($idusr)) {
		
			/* Setea el objeto con los parametros obtenidos */
			$usuario->setId($idusr);
			$usuario->setCorreo($_POST['correoupd']);
			$usuario->setClave($_POST['claveupd']);
			$usuario->setNombre($_POST['nombreupd']);
			$usuario->setRol($_POST['rolupd']);
			$usuario->setEstado($_POST['estadoupd']);
		
			/* Envia el objeto para actualizar los datos del Usuario */
			$crud->updateUsuario($usuario);
			
			header('Location: ../gestion-usr?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡El usuario ha sido actualizado con exito!#alertusr');
			exit;
		} else {
			header('Location: ../gestion-usr?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Selecciona un usuario!#alertusr');
			exit;
		}

	} elseif (isset($_POST['deleteusr'])) {
		
		/* Recibe el ID del usuario a eliminar */
		$idUsuario = $_POST['iddel'];
		$idSesion = $_POST['idusrses'];
		
		if (!empty($idUsuario)) {

			if ($idUsuario === $idSesion) {
			  	/* Elimina el usuario actual */
				$crud->deleteUsuario($idUsuario);
				/* Y lo saca de sesión */
				header('Location: ../admin');
				exit;
				unset($_SESSION['usuario']); /* destruye la sesión */
				session_destroy();
			  } else {
			  	/* Elimina el usuario seleccionado */
				$crud->deleteUsuario($idUsuario);

				header('Location: ../gestion-usr?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡El usuario ha sido eliminado!#alertusr');
				exit;

			  }  
	
		} else {
			header('Location: ../gestion-usr?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Selecciona un usuario!#alertusr');
			exit;
		}		
	}

?>