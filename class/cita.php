<?php 
	/*
	*
	*
	*/
	class Cita{
		private $id;
		private $vinc;
		private $placac;
		private $nombre;
		private $apellido;
		private $correo;
		private $tel;
		private $fecha;
		private $hora;
		private $userAE;
		private $fechaAE;
		private $polpri;
		private $sucursal;
		private $estado;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getVinc(){
			return $this->vinc;
		}

		public function setVinc($vinc){
			$this->vinc = $vinc;
		}

		public function getPlacac(){
			return $this->placac;
		}

		public function setPlacac($placac){
			$this->placac = $placac;
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

		public function getFecha(){
			return $this->fecha;
		}

		public function setFecha($fecha){
			$this->fecha = $fecha;
		}

		public function getHora(){
			return $this->hora;
		}

		public function setHora($hora){
			$this->hora = $hora;
		}

		public function getUserae(){
			return $this->userAE;
		}

		public function setUserae($userAE){
			$this->userAE = $userAE;
		}

		public function getFechaae(){
			return $this->fechaAE;
		}

		public function setFechaae($fechaAE){
			$this->fechaAE = $fechaAE;
		}

		public function getPolpri(){
			return $this->polpri;
		}

		public function setPolpri($polpri){
			$this->polpri = $polpri;
		}

		public function getSucursal(){
			return $this->sucursal;
		}

		public function setSucursal($sucursal){
			$this->sucursal = $sucursal;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function setEstado($estado){
			$this->estado = $estado;
		}

	}
?>