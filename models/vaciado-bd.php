<?php 
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	class VaciadoBd{

		public function __construct(){}

		/* metodo que vacia la tabla importada mediante un excel */
		public function vaciarBd($tabla){
			$db=DB::conectar();
			$delete=$db->prepare('TRUNCATE TABLE '.$tabla.'');
			/* $delete->bindValue('tabla',$tabla); */
			$delete->execute();
		}

		/* metodo para buscar la tabla que se quiere borrar */
		public function buscarTabla($tabla){

			$env = $_SERVER['SERVER_NAME']; // remote || local (excelrecall.test)
			$dbName = ""; 

			if ($env == "excelrecall.com.sv") {
				//excelrecall.com.sv - DB Name
				$dbName =  "excel-slv-bd";
			} else {
				//excelrecall.test - DB Name
				$dbName =  "excel";
			}
			
			$db=DB::conectar();
			$buscar=$db->prepare('SHOW FULL TABLES FROM `'.$dbName.'` LIKE :tabla'); //produccion: excel-slv-bd | desarrollo: excel
			$buscar->bindValue(':tabla',$tabla);
			$buscar->execute();			
			$registro=$buscar->fetch();
			
			if($registro != NULL){
				$existe=TRUE;
			}else{
				$existe=FALSE;
			}
			
			return $existe;			
			/* echo "Tabla existe: "."$existe"." - "."Tabla Nombre: "."$registro[0]"; */
		}

	}
?>
