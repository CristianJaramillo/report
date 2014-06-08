<?php
	
	require_once 'connection.php';	
	require_once 'validate.php';

	if (isset($_POST['action'])) {
		switch ($_POST['action']) {
			case 'tables-system': getJSONTables($_POST); break;
			case 'table': getTable($_POST); break;
			case 'delete': echo json_encode(deleteRow($_POST));break;
			case 'insert': echo json_encode(insertRow($_POST));break;
			case 'update': echo json_encode(updateRow($_POST));break;
			default: echo json_encode(array('Su solicitud es invalida!'));break;
		}
	}

	function getJSONTables($data){
		// Creamos una conexión con mysql
		$cnn = new Connection();
		// Creamos la consulta.
		$query = 'SHOW TABLES';
		// Ejecutamos y recibimos la consulta
		$rs = $cnn->getQuery($query);
		// Creamos un array contenedor del JSON
		$json = array();
		// Obtenemos cada columna.
		while ($row = $rs->fetch_assoc()) {
			foreach ($row as $key => $value) {
				$row[$key] = utf8_encode($value);
			}
			$json[] = $row; 
		}
		// MOstramos el resultado.
		echo json_encode($json);
		// Limpiamos la conexión
		unset($query);
		unset($rs);
		unset($cnn);
	}

	function getTable($data){
		$data = extractArray($data, array('page', 'table', 'offset', 'row_count'));
		if (is_array($data)) {
			if (is_numeric($data['page']) && is_numeric($data['offset']) && is_numeric($data['row_count']) && @preg_match('/(^[A-Za-z0-9_]{1,100}$)/', $data['table'])) {
				// Creamos un aconexión con mysql
				$cnn = new Connection();
				// Creamos la consulta.
				$query = 'SELECT * FROM '.$data['table'].' LIMIT '.$data['row_count'].','.$data['offset'];
				// Ejecutamos y recibimos la consulta
				$rs = $cnn->getQuery($query);
				// Creamos un array contenedor del JSON
				$json = array();
				// Obtenemos el nombre de las columnas.
				while ($column = $rs->fetch_field()) {
					$json['head'][] = $column->name;
				}
				// Obtenemos cada fila.
				while ($row = $rs->fetch_assoc()) {
					foreach ($row as $key => $value) {
						$row[$key] = utf8_encode($value);
					}
					$json[] = $row; 
				}
				// Creamos la consulta para obtener el número de registros..
				$query = 'SELECT COUNT(*) FROM '.$data['table'];
				// ejecutamos la consulta.
				$rs = $cnn->getQuery($query);
				$count = $rs->fetch_assoc();
				$json['foot'][] = $count['COUNT(*)'];
				// Mostramos el resultado.
				echo  json_encode($json);
				// Limpiamos la conexión
				unset($query);
				unset($rs);
				unset($cnn);
			}
		}
	}

	function extractArray($data, $array){		
		$result = array();		
		foreach ($array as $value) {
			if (isset($data[$value])) {
				$result[$value] = $data[$value];
			}
		}
		if (count($array) == count($result)) {
			return $result;	
		} else{
			return false;
		} 
	}

	/*
	 * Elimina un registro a la aplicación.
	 */
	function deleteRow($data){
		// mensaje al usuario.
		$msg = array();
		// Creamos un objeto que valide la información obtenida.
		$valid =  new Validate();
		// Obtenemos la tabla a la cual agregaremos el registro..
		if (isset($data['table'])) {
			// decofificamos los valores recibidos.
			$data = $valid->decodeArray($data);
			// Respaldamos el nombre de la tabla.
			$table = $data['table'];
			// Eliminamos la tabla y la acción del array.
			unset($data['action']);
			unset($data['table']);
			// Hacemos una validación de los registros.
			foreach ($data as $key => $value) {
				if ($valid->validateField($value, 'field')) {
					$msg[] = 'El campo '.$key.' es invalido!';
				}
			}
			if (empty($msg)) {
				// Creamos un objeto conexión para trabajar con mysql.
				$cnn = new Connection();
				// Creamos el query a ejecutar.
				$query = $cnn->getDelete($data, $table);
				// Ejecutamos la consulta.
				$cnn->getQuery($query);
				// Notificamos del exito al usuario.
				$msg[] = 'Se eliminado coreectamente el registro.';
			}
		}

		return count($msg) != 0 ? $msg : array('No se ha podido eliminar el registro!'); 
	}

	/*
	 * Agrega un registro a la aplicación.
	 */
	function insertRow($data){
		// mensaje al usuario.
		$msg = array();
		// Creamos un objeto que valide la información obtenida.
		$valid =  new Validate();
		// Obtenemos la tabla a la cual agregaremos el registro..
		if (isset($data['table'])) {
			// decofificamos los valores recibidos.
			$data = $valid->decodeArray($data);
			// Respaldamos el nombre de la tabla.
			$table = $data['table'];
			// Eliminamos la tabla y la acción del array.
			unset($data['action']);
			unset($data['table']);
			// Hacemos una validación de los registros.
			foreach ($data as $key => $value) {
				if ($valid->validateField($value, 'field')) {
					$msg[] = 'El campo '.$key.' es invalido!';
				}
			}
			if (empty($msg)) {
				// Creamos un objeto conexión para trabajar con mysql.
				$cnn = new Connection();
				// Creamos el query a ejecutar.
				$query = $cnn->getInsert($data, $table);
				// Ejecutamos la consulta.
				$cnn->getQuery($query);
				// Notificamos del exito al usuario.
				$msg[] = 'Se guardado coreectamente el registro.';
			}
		}

		return count($msg) != 0 ? $msg : array('No se ha podido agregar el registro!'); 
	}

	/*
	 * Modifica un registro a la aplicación.
	 */
	function updateRow($data){
		// mensaje al usuario.
		$msg = array();
		// Creamos un objeto que valide la información obtenida.
		$valid =  new Validate();
		// Obtenemos la tabla a la cual agregaremos el registro..
		if (isset($data['table'])) {
			// decofificamos los valores recibidos.
			$data = $valid->decodeArray($data);
			// Respaldamos el nombre de la tabla.
			$table = $data['table'];
			// Eliminamos la tabla y la acción del array.
			unset($data['action']);
			unset($data['table']);
			// Hacemos una validación de los registros.
			foreach ($data as $key => $value) {
				if ($valid->validateField($value, 'field')) {
					$msg[] = 'El campo '.$key.' es invalido!';
				}
			}
			if (empty($msg)) {
				// Creamos un objeto conexión para trabajar con mysql.
				$cnn = new Connection();
				// Creamos el query a ejecutar.
				$query = $cnn->getUpdate($data, $table);
				// Ejecutamos la consulta.
				$cnn->getQuery($query);
				// Notificamos del exito al usuario.
				$msg[] = 'Se modificado corectamente el registro.';
			}
		}

		return count($msg) != 0 ? $msg : array('No se ha podido modificar el registro!'); 
	}

?>