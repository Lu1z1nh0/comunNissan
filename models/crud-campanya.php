<?php	
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Campanya */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/campanya.php");
	
	class CrudCampanya{

		public function __construct(){}
	
		/* Obtiene los datos asociados al vin o placa */    
		public function obtenerDatos($vinpla){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM campanyas WHERE vin=:vinpla OR placa=:vinpla');
			$select->bindValue(':vinpla',$vinpla);
			$select->execute();
			$registro=$select->fetch(PDO::FETCH_ASSOC);

			$campanya = new Campanya();
			
			/* Asigna los valores que trae desde la base de datos al objeto */
			if($registro)
			{
    			$campanya->setId($registro['id']);
    			$campanya->setPais($registro['pais']);
    			$campanya->setVin($registro['vin']);
    			$campanya->setPlaca($registro['placa']);
    			$campanya->setMarca($registro['marca']);
    			$campanya->setModelo($registro['modelo']);
    			$campanya->setIdExcel($registro['idExcel']);
    			$campanya->setIdFabrica($registro['idFabrica']);
    			$campanya->setNombreCampanya($registro['nombreCampanya']);
    			$campanya->setDescripcionCampanya($registro['descripcionCampanya']);
			} 
	
			return $campanya;
		}
		
		/* Obtiene las campañas asociadas al vin o placa */    
		public function obtenerCampanyas($vinpla){
			$db=Db::conectar();
			$select=$db->prepare('SELECT nombreCampanya, descripcionCampanya FROM campanyas WHERE vin=:vinpla OR placa=:vinpla');
			$select->bindValue(':vinpla',$vinpla);
			$select->execute();
			
			$listaCampanyas = $select->fetchAll();
			
			return $listaCampanyas;
		}

		/* Registra la fecha/hora en la que se hace la verificación mediante VIN ó Placa */   
		public function updateDateVerification($vinpla, $fechaver){
			$db=Db::conectar();
			$update=$db->prepare('UPDATE auditoria SET fechaVerificacion=:fechaver WHERE vin=:vinpla OR placa=:vinpla');
			$update->bindValue(':fechaver',$fechaver);
			$update->bindValue(':vinpla',$vinpla);
			$update->execute();	
		}

	}
?>