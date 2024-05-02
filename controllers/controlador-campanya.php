<?php 
	/* Conforma la comunicación con los Modelos necesarios */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-campanya.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");

	// Gestión de ruta de acceso a archivos
	require_once($_SERVER['DOCUMENT_ROOT']."/config/ruta.php");

	$campanya = new Campanya();
	$crud = new CrudCampanya();

	$sucursales = new Sucursal();
	$crudSuc = new CrudSucursal();
	
	/* Verifica si la variable "verVinPla" está definida */		
	/* se da que está definida cuando se introduce un VIN o Placa y se realiza la petición */
	if (isset($_POST['verVinPla'])) {
		
		$campanya = $crud->obtenerDatos($_POST['vinpla']);
		$campanyasdesc = $crud->obtenerCampanyas($_POST['vinpla']);
		$crud->updateDateVerification($_POST['vinpla'], $_POST['fechaver']);
		
		/* Si el id del objeto retornado no es null, quiere decir que encontro un vehiculo registrado con ese vin o placa */
		if ($campanya->getId()!= NULL) {

			$datos[] = $campanya->getVin(); 
			$datos[] = $campanya->getPlaca();
			$datos[] = $campanya->getMarca();
			$datoMarca = $campanya->getMarca();
			$datos[] = $campanya->getModelo();
			
			/* Procesa las variables antes de enviarlas */
			$datos = serialize($datos);
			$datos = base64_encode($datos);
			$datos = urlencode($datos);

			$campanyasdesc = serialize($campanyasdesc);
			$campanyasdesc = base64_encode($campanyasdesc);
			$campanyasdesc = urlencode($campanyasdesc);

			$datoMarca = serialize($datoMarca);
			$datoMarca = base64_encode($datoMarca);
			$datoMarca = urlencode($datoMarca); 

			 /* envia al formulario para mostrar datos */
			header("Location: ".$url."formulario?data=".$datos."&data1=".$campanyasdesc."&data2=".$datoMarca);
			exit;

		} elseif (strlen($_POST['vinpla'])>17) {
			//cuando los datos son incorrectos muestra el error, se da error porque el vin no es mayor a 17 caracteres, la placa si puede ser menor de 6
			header('Location: '.$url.'?msjcls6=mensaje-error2&mensaje6=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> VIN/Placa incorrectos.#novin');
			exit;
		} else {
			
			$vinpla = $_POST['vinpla']; //asigna la placa o VIN proporcionados por el cliente

			/* Procesa la variable antes de enviarla */
			$vinpla = serialize($vinpla);
			$vinpla = base64_encode($vinpla);
			$vinpla = urlencode($vinpla);

			/* envia al formulario de suscripcion con el vin/placa proporcionados*/
			header("Location: ".$url."suscripcion?data3=".$vinpla);

			/* cuando los datos son incorrectos muestra el error 
			header('Location: ".$url."?msjcls6=mensaje-error2&mensaje6=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> VIN/Placa no encontrado en nuestra base de datos de carros afectados.#novin'); 
			*/
			exit;
		}
	}
	
?>