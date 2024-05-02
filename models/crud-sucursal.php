<?php
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Sucursal */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/sucursal.php");
	
	class CrudSucursal{

		public function __construct(){}
		
		/* Actualiza los datos de la sucursal */
		public function updateSucursal($sucursal){
			
			$db=DB::conectar();
			
			$update=$db->prepare('UPDATE sucursales SET nombre=:nombre, estado=:estado, direccion=:direccion, pais=:pais WHERE id=:id');
			$update->bindValue(':id',$sucursal->getId());
			$update->bindValue(':nombre',$sucursal->getNombre());
			$update->bindValue(':estado',$sucursal->getEstado());
			$update->bindValue(':direccion',$sucursal->getDireccion());
			$update->bindValue(':pais',$sucursal->getPais());
			$update->execute();
			
		}
		
		/* Activa/Desactiva un sucursal - SIN USO */
		public function cambiarEstadoSucursal($idSucursal,$estado){
			
			$db=DB::conectar();
			
			$actdeact=$db->prepare('UPDATE sucursales SET estado=:estado WHERE id=:id');
			$actdeact->bindValue(':id',$idSucursal);
			$actdeact->bindValue(':estado',$estado); /* 1:activo ó 2:inactivo */
			$actdeact->execute();
			
		}
	
	
		/* Elimina un sucursal */
		public function deleteSucursal($idSucursal){
			
			$db=DB::conectar();
			
			$delete=$db->prepare('DELETE FROM sucursales WHERE id=:id');
			$delete->bindValue(':id',$idSucursal);
			$delete->execute();
			
		}
		
		
		/* inserta los datos del sucursal */
		public function insertarSucursal($sucursal){
			
			$db=DB::conectar();
			
			$insert=$db->prepare('INSERT INTO sucursales VALUES(NULL, :nombre, :estado, :direccion, :pais)');
			$insert->bindValue(':nombre',$sucursal->getNombre());
			$insert->bindValue(':estado',$sucursal->getEstado());
			$insert->bindValue(':direccion',$sucursal->getDireccion());
			$insert->bindValue(':pais',$sucursal->getPais());
			$insert->execute();
			
		}

		
		/*busca y devuelve la coleccion de sucursales, solo nombres*/ 
		public function obtenerSucursalesLista($estado){
			
			$db=Db::conectar();

			if ($estado == 1 || $estado == 2) {
				$sucursales = $db->prepare('SELECT nombre FROM sucursales WHERE estado = :estado');
				$sucursales->bindValue(':estado',$estado);
			} elseif ($estado == 3) {
				$sucursales = $db->prepare('SELECT nombre FROM sucursales');			
			} else {
				return null;
			}


	        $sucursales->execute();
	        $allsucursalesN = $sucursales->rowCount(); /* Total de sucursales */
	        $allsucursales = $sucursales->fetchAll();
			
			return $allsucursales;
		}

		/*busca y devuelve una direccion de suc. según su nombre*/ 
		public function obtenerSucursalDir($nombre){
			
			$db=Db::conectar();

			$dirSuc = $db->prepare('SELECT direccion FROM sucursales WHERE nombre = :nombre');
			$dirSuc->bindValue(':nombre',$nombre);
	        $dirSuc->execute();
	        $direccion = $dirSuc->fetch(PDO::FETCH_ASSOC);

			return $direccion['direccion'];
		}


		/*busca y devuelve la coleccion de sucursales - SIN TERMINAR*/ 
		public function obtenerSucursales(){
			
			$db=Db::conectar();

			$sucursales = $db->prepare('SELECT * FROM sucursales');
			//$sucursales->bindValue(':id',$idSucursal);
	        $sucursales->execute();
	        $allcampanyas = $sucursales->fetch();

	        $allsucursalesN = $sucursales->rowCount(); /* Total de sucursales */
	        
				
			$sucursal = new Sucursal();

			$sucursal->setId($allcampanyas['id']);
			$sucursal->setNombre($allcampanyas['nombre']);
			$sucursal->setEstado($allcampanyas['estado']);
			$sucursal->setDireccion($allcampanyas['direccion']);
			$sucursal->setPais($allcampanyas['pais']);

			return $sucursales;
		}

	}
?>