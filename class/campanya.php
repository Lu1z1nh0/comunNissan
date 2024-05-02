<?php 
	/*
	*
	*
	*/
	class Campanya{
		private $id;
		private $pais;
		private $vin;
		private $placa;
		private $marca;
		private $modelo;
		private $idExcel;
		private $idFabrica;
		private $nombreCampanya;
		private $descripcionCampanya;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getPais(){
			return $this->pais;
		}

		public function setPais($pais){
			$this->pais = $pais;
		}

		public function getVin(){
			return $this->vin;
		}

		public function setVin($vin){
			$this->vin = $vin;
		}

		public function getPlaca(){
			return $this->placa;
		}

		public function setPlaca($placa){
			$this->placa = $placa;
		}

		public function getMarca(){
			return $this->marca;
		}

		public function setMarca($marca){
			$this->marca = $marca;
		}

		public function getModelo(){
			return $this->modelo;
		}

		public function setModelo($modelo){
			$this->modelo = $modelo;
		}

		public function getIdExcel(){
			return $this->idExcel;
		}

		public function setIdExcel($idExcel){
			$this->idExcel = $idExcel;
		}

		public function getIdFabrica(){
			return $this->idFabrica;
		}

		public function setIdFabrica($idFabrica){
			$this->idFabrica = $idFabrica;
		}
		
		public function getNombreCampanya(){
			return $this->nombreCampanya;
		}

		public function setNombreCampanya($nombreCampanya){
			$this->nombreCampanya = $nombreCampanya;
		}
		
		public function getDescripcionCampanya(){
			return $this->descripcionCampanya;
		}

		public function setDescripcionCampanya($descripcionCampanya){
			$this->descripcionCampanya = $descripcionCampanya;
		}		
	}
?>

