<?php 
	/* Conforma la conexion con la BD */ 
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Administracion */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/administracion.php");
	
	class CrudAdministracion{

		public function __construct(){}
	
		/* Actualiza el correo/s de destino para la cita */   
		//$correoDestino en este caso es el parametro para cambiar el correo/s
		public function updateCorreoDestino($id, $correoDestino){
			$db=Db::conectar();
			$update=$db->prepare('UPDATE administracion SET parametro=:correoDestino WHERE id=:id');
			$update->bindValue(':id',$id);
			$update->bindValue(':correoDestino',$correoDestino);
			$update->execute();	
		}

		/* Actualiza el correo/s de destino para la suscripcion */   
		//$correoDestinoSuscrip en este caso es el parametro para cambiar el correo/s
		public function updateCorreoDestinoSuscrip($id, $correoDestinoSuscrip){
			$db=Db::conectar();
			$update=$db->prepare('UPDATE administracion SET parametro=:correoDestinoSuscrip WHERE id=:id');
			$update->bindValue(':id',$id);
			$update->bindValue(':correoDestinoSuscrip',$correoDestinoSuscrip);
			$update->execute();	
		}

		/**
		 *
		 * Valida un email usando filter_var. 
		 *  Devuelve true si es correcto o false en caso contrario
		 *
		 * @param    string  $str la dirección a validar
		 * @return   boolean
		 *
		 */
		public function is_valid_email($validmails){
		  return (false !== filter_var($validmails, FILTER_VALIDATE_EMAIL));
		}

	} 

?>