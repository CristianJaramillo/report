<?php
	// Direcciones del systema.
	require_once 'globals.php';

	if (strlen(session_id()) < 1){
		session_start();
	}
	
	/* 
	 * Validamos que la sessión del usuario sea valida  y este activa.
	 */

	if (isset($_SESSION['TIME']) && isset($_SESSION['USERNAME'])) {
		
		require_once 'connection.php';

		$cnn = new Connection();

		$query = "SELECT date_income, time_income FROM connection WHERE username='".$_SESSION['USERNAME']."'";

		$rs = $cnn->getQuery($query);

		if (is_object($rs)) {
			if ($rs->num_rows == 1) {

				$row = $rs->fetch_assoc();

				$date = $cnn->getDate();

				if ($row['date_income'] != $date) {
					$current_time = (int) 60 * 60 * 24;
				} else{
					$current_time = 0;
				}

				$previous_time = getSeconds($row['time_income']) + $_SESSION['TIME']; 
				$current_time += getSeconds($cnn->getTime());
				
				$_SESSION['AUTHENTICATED'] = ((bool) ($previous_time > $current_time) ? 1 : 0);

			}			
		} else{
			echo "Error";
		}
		// Limpiamos la conexión.
		unset($query);
		unset($rs);
		unset($cnn);
	}

	function getSeconds($time){
		list($h, $m, $s) = explode(":", $time);
		return (int) $h*3600 + $m*60 + $s;
	}	

	/*
	 * Errores al intentar ingresar al systema sin estar autorizado.
	 */
	if (!isset($_SESSION['SECURITY'])) {
		$url = DOIMAN;
	} elseif (!isset($_SESSION['TYPE'])  || !defined('TYPE') || !isset($_SESSION['AUTHENTICATED'])) {
		$url = ERROR404;
	} elseif ($_SESSION['TYPE'] != TYPE) {
		$url = ERROR403;
	} elseif ($_SESSION['AUTHENTICATED'] != true) {
		$url = DOIMAN.'includes/exit.php';
	}
	
	if (isset($url)) {
		header("Location:".$url);
	}

?>