<?php 
	/*
	*
	*
	*/
	class Administracion{
		private $id;
		private $variable;
		private $parametro;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getVariable(){
			return $this->variable;
		}

		public function setVariable($variable){
			$this->variable = $variable;
		}

		public function getParametro(){
			return $this->parametro;
		}

		public function setParametro($parametro){
			$this->parametro = $parametro;
		}

	}
?>