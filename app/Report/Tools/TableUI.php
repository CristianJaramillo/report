<?php

namespace Report\Tools;

/**
 * 
 */
class TableUI
{

	public static function getQuery($action, $data = [], $table = NULL)
	{

		switch ($action) {

			case 'delete':
				$query = self::getDelete($data, $table);
			break;

			case 'insert':
				$query = self::getInsert($data, $table);
			break;

			case 'select':
				return self::getSelect($table);
			break; 

			case 'show':
				$query = "SHOW TABLES";
			break;

			case 'update':
				$query = self::getUpdate($data, $table);
			break;
			
			default:
				$query = "SELECT NULL";
			break;

		}

		return \DB::select($query);
	}

	/*
	 * Genera un string en formato de consulta 
	 * para eliminar un registro, recibe como parametros 
	 * un "array" donde la clave es la columna y el valor el registro
	 * a eliminar y el nombre de la "tabla". 
	 */
	public static function getDelete($data, $table)
	{
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
	public static function getInsert($data, $table)
	{
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

	/**
	 *
	 */
	public static function getSelect($table)
	{
		return [
			"body" => \DB::table($table)->get(),
			"head" => \DB::select("DESCRIBE ".$table)
		];
	}

	/*
	 * Gerenera un string en formato de consulta para modificar un registro 
	 * que recibe como parametros un "string" que contiene 
	 * la tabla a modificar  y un "array" con los el registro a modificar
	 * y sus nuevos valores.
	 */
	public static function getUpdate($data, $table)
	{
		$query = 'UPDATE '.$table.' SET ';
		$exp = '/^SET_/';
		$set = '';
		$where = '';
		foreach ($data as $key => $value) 
		{
			if (preg_match($exp, $key)) 
			{
				$array = explode('SET_', $key);
				unset($array[0]);
				foreach ($array as $work) 
				{
					$set .= $work;
				}
				$set .= '=\''.$value.'\', ';
			} 
			else
			{
				$where .= $key.'=\''.$value.'\' AND ';
			}
		}
		$query .= rtrim($set, ', ').' WHERE '.rtrim($where, ' AND ');
		return $query;
	} // Fin de la clase getUpdate()

}