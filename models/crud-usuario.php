<?php 
	/* Conforma la conexion con la BD */
	require_once($_SERVER['DOCUMENT_ROOT']."/config/conexion-config.php");
	
	/* Permite acceder a la clase Usuario */
	require_once($_SERVER['DOCUMENT_ROOT']."/class/usuario.php");
	
	class CrudUsuario{

		public function __construct(){}
		
		/* Actualiza los datos del usuario */
		public function updateUsuario($usuario){
			
			$db=DB::conectar();
			
			$update=$db->prepare('UPDATE usuarios SET correo=:correo, clave=:clave, nombre=:nombre, rol=:rol, estado=:estado WHERE id=:id');
			$update->bindValue(':id',$usuario->getId());
			$update->bindValue(':correo',$usuario->getCorreo());

			$user = new Usuario();
			$crud = new CrudUsuario();

			$user = $crud->buscarUsuario($usuario->getId());
			
			/* Verifica si la clave es la misma o es diferente y actualiza */
			if (($usuario->getClave()) == ($user->getClave())) {
				$update->bindValue(':clave',$usuario->getClave());
			} else {
				/* encripta la clave */
				$pass = password_hash($usuario->getClave(),PASSWORD_DEFAULT);
				$update->bindValue(':clave',$pass);
			}

			$update->bindValue(':nombre',$usuario->getNombre());
			$update->bindValue(':rol',$usuario->getRol());
			$update->bindValue(':estado',$usuario->getEstado());
			$update->execute();
			
		}
		
		
		/* Activa/Desactiva un usuario */
		public function cambiarEstadoUsuario($idUsuario,$estado){
			
			$db=DB::conectar();
			
			$actdeact=$db->prepare('UPDATE usuarios SET estado=:estado WHERE id=:id');
			$actdeact->bindValue(':id',$idUsuario);
			$actdeact->bindValue(':estado',$estado); /* 1:activo ó 2:inactivo */
			$actdeact->execute();
			
		}
	
	
		/* Elimina un usuario */
		public function deleteUsuario($idUsuario){
			
			$db=DB::conectar();
			
			$delete=$db->prepare('DELETE FROM usuarios WHERE id=:id');
			$delete->bindValue(':id',$idUsuario);
			$delete->execute();
			
		}
		
		
		/* inserta los datos del usuario */
		public function insertarUsuario($usuario){
			
			$db=DB::conectar();
			
			$insert=$db->prepare('INSERT INTO usuarios VALUES(NULL, :correo, :clave, :nombre, :rol, :estado)');
			$insert->bindValue(':correo',$usuario->getCorreo());
			/* encripta la clave */
			$pass = password_hash($usuario->getClave(),PASSWORD_DEFAULT);
			$insert->bindValue(':clave',$pass);
			$insert->bindValue(':nombre',$usuario->getNombre());
			$insert->bindValue(':rol',$usuario->getRol());
			$insert->bindValue(':estado',$usuario->getEstado());
			$insert->execute();
			
		}

		
		/* busca un usuario según el ID recibido SIN USO */ 
		public function buscarUsuario($idUsuario){
			
			$db=Db::conectar();
			
			$select=$db->prepare('SELECT * FROM usuarios WHERE id=:id');
			$select->bindValue(':id',$idUsuario);
			$select->execute();
			$registro=$select->fetch();
			
			$usuario = new Usuario();

			$usuario->setId($registro['id']);
			$usuario->setCorreo($registro['correo']);
			$usuario->setClave($registro['clave']);
			$usuario->setNombre($registro['nombre']);
			$usuario->setRol($registro['rol']);
			$usuario->setEstado($registro['estado']);

			return $usuario;
		}

		
		/* obtiene el usuario para el login */
		public function obtenerUsuario($correo, $clave){
			
			$db=Db::conectar();
			
			$select=$db->prepare('SELECT * FROM usuarios WHERE correo=:correo'); /* AND clave=:clave */
			$select->bindValue(':correo',$correo);
			$select->execute();
			$registro=$select->fetch();
			
			$usuario = new Usuario();
			
			/* Verifica si el usuario se ecuentra activo */
			if ($registro['estado'] == 1) {
				/* verifica si la clave es correcta */
				if (password_verify($clave, $registro['clave'])) {
					/* $coincide='si'; */
					/* si es correcta, asigna los valores que trae desde la base de datos */
					$usuario->setId($registro['id']);
					$usuario->setCorreo($registro['correo']);
					$usuario->setClave($registro['clave']);
					$usuario->setNombre($registro['nombre']);
					$usuario->setRol($registro['rol']);
					$usuario->setEstado($registro['estado']);
				} /* else {$coincide='no';} */			
				/* return $coincide; */
			}
			
			
			return $usuario;
		}

		
		/* busca el correo del usuario si existe */
		public function verificarUsuario($correo){
			
			$db=Db::conectar();
			
			$select=$db->prepare('SELECT * FROM usuarios WHERE correo=:correo');
			$select->bindValue(':correo',$correo);
			$select->execute();
			$registro=$select->fetchAll();

			if( empty($registro) != 1 ){
				$usado=1;
				//echo '<script> console.log("correo ya está en uso: '.$usado.' "); </script>';
			}else{
				$usado=0;
				//echo '<script> console.log("correo no está en uso: '.$usado.' "); </script>';
			}

			return $usado;	
		}
			
	}
?>