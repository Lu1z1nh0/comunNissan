<?php 
	/*
	*
	*
	*/
	class Sucursal{
		private $id;
		private $nombre;
		private $estado; //activo 1, inactivo 2
		private $direccion;
		private $pais;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
		}

		public function getDireccion(){
			return $this->direccion;
		}

		public function setDireccion($direccion){
			$this->direccion = $direccion;
		}

		public function getPais(){
			return $this->pais;
		}

		public function setPais($pais){
			$this->pais = $pais;
		}

	}
?>

