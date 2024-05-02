<?php
	/* Conforma la comunicación con el Modelo */
	require_once($_SERVER['DOCUMENT_ROOT']."/models/crud-sucursal.php");
	
	$sucursal = new Sucursal();
	$crud = new CrudSucursal();

	/*
	verifica si la variable "registrarSuc" está definida
	se da que está definida cuando se agrega una nueva sucursal en la vista de administración y entonces se envía la petición
	*/

	if (isset($_POST['registrarSuc'])) {

		if(empty($_POST['nombreSuc']) || empty($_POST['estadoSuc']) || empty($_POST['direccionSuc']) || empty($_POST['paisSuc'])){
			header('Location: ../gestion-suc?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Has dejado algún campo vacio!#alertsuc');
			exit;
		} else {
			$sucursal->setNombre($_POST['nombreSuc']);
			$sucursal->setEstado($_POST['estadoSuc']);
			$sucursal->setDireccion($_POST['direccionSuc']);
			$sucursal->setPais($_POST['paisSuc']);

			$crud->insertarSucursal($sucursal);
			header('Location: ../gestion-suc?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡La sucursal ha sido registrada con exito!#alertsuc');
			exit;

			/*			
			if ($crud->verificarSucursal($_POST['nombreSuc'])) {
				$crud->insertarSucursal($sucursal);
				header('Location: ../gestion-suc?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡La sucursal ha sido registrada con exito!#alertsuc');
				exit;
			}else{
				header('Location: ../gestion-suc?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Esta sucursal ya existe!#alertsuc');
				exit;
			}
			*/	
		}	
	}


	/*
	verifica si la variable "editarSuc" está definida
	se da que está definida cuando se hace una actualización de los datos de una sucursal en la vista de administración y entonces se envía la petición
	*/

	if (isset($_POST['editarSuc'])) {

		$idsucupd = $_POST['idSucUpd'];

		if (!empty($idsucupd)) {
		
			/* Setea el objeto con los parametros obtenidos */
			$sucursal->setId($_POST['idSucUpd']);
			$sucursal->setNombre($_POST['nomSucUpd']);
			$sucursal->setEstado($_POST['estadoSucUpd']);
			$sucursal->setDireccion($_POST['direccionSucUpd']);
			$sucursal->setPais($_POST['paisSucUpd']);
	
			/* Envia el objeto para actualizar los datos de la sucursal */
			$crud->updateSucursal($sucursal);

			header('Location: ../gestion-suc?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡La sucursal ha sido actualizada con exito!#alertsuc');
			exit;

		} else {
			header('Location: ../gestion-suc?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Error! selecciona una sucursal.#alertsuc');
			exit;
		}
	}


	/*
	verifica si la variable "deleteSuc" está definida
	se da que está definida cuando se elimina una sucursal en la vista de administración y entonces se envía la petición
	*/

	if (isset($_POST['deleteSuc'])) {

		/* Recibe el ID de la sucursal a eliminar */
		$idSucursal = $_POST['idSucDel'];

		if (!empty($idSucursal)) {
			$crud->deleteSucursal($idSucursal);	
			header('Location: ../gestion-suc?msjcls2=mensaje-exito&mensaje2=<i class="fa fa-check" aria-hidden="true"></i> ¡La sucursal ha sido eliminada con exito!#alertsuc');
				exit;
		} else {
			header('Location: ../gestion-suc?msjcls2=mensaje-error&mensaje2=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Error! selecciona una sucursal.#alertsuc');
			exit;
		}

	} 

?>