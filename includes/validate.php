<?php
	/**
	 * Permite validar campos con expresiones regulares.
	 */
	class Validate {
		
		private $expresion = array(
			'email' => "/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",
			'field' => "/(^[()'\"]$)/", 
			'name' => "/(^[A-Za-zÁÉÍÓÚáéíóúñ ]{2,50}$)/",
			'numeric' => "/(^[0-9]{1,4}$)/",
			'password' => "/(^[A-Za-z0-9_\-]{6,20}$)/", 
			'phone' => "/(^[0-9]{8,16}$)/",
			'username' => "/(^[0-9]{6,10}$)/"
		);

		public function addExpresion($name, $value){
			$this->expresion[$name] = $value;
		}

		/*
		 * Devuelve un array decodificado.
		 */
		public function decodeArray($array){
			if (is_array($array)) {
				foreach ($array as $key => $value) {
					$array[$key] = utf8_decode($value);
				}		
			}
			return $array;			
		}

		public function deleteExpresion($name) {
			if (isset($this->expresion[$name])) {
				unset($this->expresion[$name]);
			}
		}

		/*
		 * Devuelve un array decodificado.
		 */
		public function encodeArray($array){
			if (is_array($array)) {
				foreach ($array as $key => $value) {
					$array[$key] = utf8_encode($value);
				}		
			}
			return $array;			
		}

		/*
		 * Extrae solo los campos que hemos delimitado.
		 * retorna false en caso de no encontrar todos los
		 * registros solicitados.
		 */
		public function extractArray($array, $data){
			$result = array();			
			foreach ($data as $value) {
				if (isset($array[$value])) {
					$result[$value] = $array[$value];
				}
			}
			if (count($data) == count($result)) {
				return $result;	
			} else{
				return false;
			} 
		}

		public function generetorField($lenght, $type){
			if (isset($this->expresion[$type])) {
				return substr(preg_replace($this->expresion[$type], "", md5(rand())) . 
			       preg_replace($this->expresion[$type], "", md5(rand())) . 
			       preg_replace($this->expresion[$type], "", md5(rand())), 
			       0, $lenght);
			} else {
				return FALSE;
			}
		}

		public function getExpresion() {
			return $this->expresion;
		}

		public function isEmail($email){
			if($this->validateField($email, 'email')){
				if(@checkdnsrr(array_pop(explode("@", $email)),"MX")){
			    	return true;
			    } else{
			    	return false;
				}
			} else{
			    	return false;
			} 
		}

		public function setExpresion($expresion) {
			if (is_array($expresion)) {
				$this->expresion = $expresion;
			}
		}

		public function validateField($value, $type) {
			if (isset($this->expresion[$type])) {
				return @preg_match($this->expresion[$type], $value) ? TRUE : FALSE;	
			}
		}

	};	
?>