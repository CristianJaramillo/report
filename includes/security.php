<?php
	/*
	 * Evitamos iniciar sessión una y otra vez.
	 */
	if (strlen(session_id()) < 1) {
		session_start();
	}
	/*
	 * Generamos un nuevo id_sessiòn.
	 */
	session_regenerate_id(TRUE);
	/*
	 * Almacenamos el id de sessión
	 */
	$_SESSION['SECURITY'] = session_id();
?>