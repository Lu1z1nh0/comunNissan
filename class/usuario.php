<?php 
	/*
	*
	*
	*/
	class Usuario{
		private $id;
		private $correo;
		private $clave;
		private $nombre;
		private $rol;
		private $estado;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getCorreo(){
			return $this->correo;
		}

		public function setCorreo($correo){
			$this->correo = $correo;
		}

		public function getClave(){
			return $this->clave;
		}

		public function setClave($clave){
			$this->clave = $clave;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getRol(){
			return $this->rol;
		}

		public function setRol($rol){
			$this->rol = $rol;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
		}

	}
?>


