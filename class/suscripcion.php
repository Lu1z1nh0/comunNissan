<?php 
	/*
	*
	*
	*/
	class Suscripcion{
		private $id;
		private $nombre;
		private $apellido;
		private $correo;
		private $tel;
		private $vinpla;
		private $polpri;


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

		public function getApellido(){
			return $this->apellido;
		}

		public function setApellido($apellido){
			$this->apellido = $apellido;
		}
		
		public function getCorreo(){
			return $this->correo;
		}

		public function setCorreo($correo){
			$this->correo = $correo;
		}

		public function getTel(){
			return $this->tel;
		}

		public function setTel($tel){
			$this->tel = $tel;
		}

		public function getVinpla(){
			return $this->vinpla;
		}

		public function setVinpla($vinpla){
			$this->vinpla = $vinpla;
		}

		public function getPolpri(){
			return $this->polpri;
		}

		public function setPolpri($polpri){
			$this->polpri = $polpri;
		}
	}
?>