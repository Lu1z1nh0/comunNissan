<?php
	/* Conforma la comunicación con el Modelo */ 
	require_once($_SERVER['DOCUMENT_ROOT']."/models/vaciado-bd.php");
	
	$vaciado = new VaciadoBd();
	
	/* Ocurre si el usuario presiona el botón vaciar, ya que la envía en la petición */
	if (isset($_POST['erasebd'])) {
		$tabla=$_POST['tabla'];
		
		/* Busca la tabla a vaciar y lo hace si esta existe */
		if ($vaciado->buscarTabla($tabla)) {
			$vaciado->vaciarBd($tabla);
			header('Location: ../gestion-bd?msjcls=mensaje-exito&mensaje=<i class="fa fa-check" aria-hidden="true"></i> ¡La Tabla ha sido vaciada exitosamente!');
			exit;
		}else{
			header('Location: ../gestion-bd?msjcls=mensaje-error&mensaje=<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡La Tabla no existe o ha ocurrido algún error!');
			exit;
		}	
	}
?>