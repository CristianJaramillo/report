<?php
	// Direcciones del systema.
	include 'globals.php';
	include 'connection.php';

	if (strlen(session_id()) < 1){
		session_start();
	}

	$msg = array();

	if (isset($_SESSION['AUTHENTICATED'])) {
		if (!$_SESSION['AUTHENTICATED']) {
			$msg[] = "Su sessión ha finalizado!";
		} else {
			$msg[] = "Vuelva pronto";
		}
	}

	if (isset($_SESSION['USERNAME'])) {
		// Creamos una conexión con mysql
		$cnn = new Connection();
		// Creamos la consulta.
		$query = "UPDATE connection SET date_departure='".$cnn->getDate()."', time_departure='".$cnn->getTime()."' WHERE username='".$_SESSION['USERNAME']."'";
		// Ejcutamos la consulta
		$cnn->getQuery($query);
	}

	session_destroy();

	$url = DOIMAN;

	if (!empty($msg)) {
		$url .= "?".http_build_query($msg);
	}
	
	header("Location:".$url);

?>