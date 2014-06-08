<?php
	define("HOST", "mysql.hostinger.es");
	define("DATABASE", "u800110318_data");
	define("USER", "u800110318_root");
	define("PASSWORD", "data454_");
	define("PORT", 3306);

	/**
	 * Clase para crear una conexión con mysql. 
	 */
	class Connection extends mysqli{
		/*
		 * constructor
		 */
		public function __construct(){
				parent::__construct(HOST, USER, PASSWORD, DATABASE, PORT);
		} // fin de constructor

		/*
		 * Cerramos la conexión con mysql.
		 */
		public function close(){
			if ($this != NULL) {
				mysqli_close($this);
			}
		} // fin de la función close()

		/*
		 * Desencriptación mediante AES_DECRYPT()
		 */
		public function decrypt($string, $key){
			if(!is_string($string))
				return false;
			else{
				$rs = $this->query("SELECT AES_DECRYPT('".$string."', '".$key."')");
				$fila = $rs->fetch_assoc();
				return $fila["AES_DECRYPT('".$string."', '".$key."')"];
			}
		} // fin de la función decrypt()

		/*
		 * Encriptación mediante AES_ENCRYPT()
		 */
		public function encrypt($string, $key){
			if(!is_string($string) || !is_string($key))
				return false;
			else{
				$rs = $this->query("SELECT AES_ENCRYPT('".$string."', '".$key."')");
				$fila = $rs->fetch_assoc();
				return $fila["AES_ENCRYPT('".$string."', '".$key."')"];
			}
		} // fin de la función encrypt()

		/*
		 *
		 */
		public function getError(){
			return "Error: (" . $this->errno . ") " . $this->error;
		} // fin de la función error.

		/*
		 * Devuelve el error producido por una consultra para 
		 * manejarlo.
		 */
		public function getConnectError(){
			return $this->connect_errno;
		} // fin de la función getError()

		/*
		 * Obtenemos la fecha actual del servidor mysql 
		 */
		public function getDate(){
			$rs = $this->query("SELECT CURDATE()");	
			$fila = $rs->fetch_assoc();
			return $fila['CURDATE()'];
		} // fin de la función getDate()

		/*
		 * Genera un string en formato de consulta 
		 * para eliminar un registro, recibe como parametros 
		 * un "array" donde la clave es la columna y el valor el registro
		 * a eliminar y el nombre de la "tabla". 
		 */
		public function getDelete($data, $table){
			$query = 'DELETE FROM '.$table.' WHERE ';
			foreach ($data as $column => $value) {
				$query .= $column.'=\''.$value.'\' AND ';
			}
			return rtrim($query, ' AND ');
		}

		/*
		 * Genera un string en formato de consulta 
		 * para Insertar un registro, recibe como parametros 
		 * un "array" donde la clave es la columna y el valor
		 * el registro a agregar y el nombre de la "tabla".
		 */
		public function getInsert($data, $table){
			$query = 'INSERT INTO '.$table;		
			$columns = ' (';
			$values = '(';
			foreach ($data as $key => $value) {
				$columns .= $key.', ';
				$values .= '\''.$value.'\', ';
			}
			$columns = rtrim($columns, ', ').')';
			$values = rtrim($values, ', ').')';
			$query .= $columns.' VALUES '.$values;
			return $query;	
		} // fin de la función getInsert()

		/*
		 * Toma una cadena y la retorna con una codificación MD5
		 * en caso de no ser una cadena retorna false
		 */
		public function getMD5($string){
			if(!is_string($string))
				return false;
			else{
				$rs = $this->getQuery("SELECT MD5('".$string."')");
				$fila = $rs->fetch_assoc();
				return $fila["MD5('".$string."')"];
			}
		} // fin de la función getMD5()

		/*
 		 * Simple función que toma como parametros un string 
 		 * y retorna un conjunto resultado de la consulta.
		 */
		public function getQuery($query){
			return $this->query($query);
		} // fin de la función getQuery()		

		/*
		 * Obtenemos la hora del servidor mysql
		 */
		public function getTime(){
			$rs = $this->query("SELECT CURTIME()");	
			$fila = $rs->fetch_assoc();
			return $fila['CURTIME()'];
		} // fin de la función getTime()		

		/*
		 * Gerenera un string en formato de consulta para modificar un registro 
		 * que recibe como parametros un "string" que contiene 
		 * la tabla a modificar  y un "array" con los el registro a modificar
		 * y sus nuevos valores.
		 */
		public function getUpdate($data, $table){
			$query = 'UPDATE '.$table.' SET ';
			$exp = '/^SET_/';
			$set = '';
			$where = '';
			foreach ($data as $key => $value) {
				if (preg_match($exp, $key)) {
					$array = explode('SET_', $key);
					unset($array[0]);
					foreach ($array as $work) {
						$set .= $work;
					}
					$set .= '=\''.$value.'\', ';
				} else{
					$where .= $key.'=\''.$value.'\' AND ';
				}
			}
			$query .= rtrim($set, ', ').' WHERE '.rtrim($where, ' AND ');
			return $query;
		} // Fin de la clase getUpdate()

	} // fin de la clase Connection
	
?>