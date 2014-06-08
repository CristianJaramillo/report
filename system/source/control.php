<?php
	// Agregamos las direcciones del sistema.
	include_once 'globals.php';
	// Agregamos la clase connection.
	include_once 'connection.php';
	// Agregamos la clase validate.
	include_once 'validate.php';

	/*
	 * Evitamos iniciar sessión una y otra vez.
	 */
	if (strlen(session_id()) < 1) {
		session_start();
	}

	/*
	 * Solo se procedera a evaluar la petición si cumple con los parametros solicitados.
	 */
	if (isset($_SESSION['SECURITY']) && isset($_POST['action']) && isset($_POST['security'])) {

		// Mensajes para para el solicitante de la petición.
		$msg = array();

		if ($_SESSION['SECURITY'] == $_POST['security']) {
			switch ($_POST['action']) {
				case 'login':
					$_POST['action'] = 'index';
					$msg = logging($_POST);
				break;
				case 'register':
					$msg = register($_POST);
				break;
				case 'restore':
					$msg = restore($_POST);
				break;
				case 'new-password':
					$msg = newPassword($_POST);	
				break;
				default:
					unset($_POST['action']);
					$msg[] = "Su solicitud es invalida";
				break;
			}
		} else {
			$msg[] = "No se ha podido procesar sus solicitud.";
		}

	} else {
		$url = ERROR404;
	}

	if (!isset($url)) {
		// Definimos la dirección del dominio.
		$url = DOIMAN;
		// agregamos un sub destino y/o mensaje en caso de existir.
		if (isset($_SESSION['URL'])) {
			$url .= $_SESSION['URL'];
			if (isset($_POST['action'])) {
				if ($_POST['action'] == 'new-password' && isset($_SERVER['HTTP_REFERER'])) {
					$url = $_SERVER['HTTP_REFERER'];
				}
			}
		} else if(isset($_POST['action'])) {
			$url .= $_POST['action'].".php";
		}
		if (isset($msg)) {
			if (!empty($msg)) {
				$url .= "?".http_build_query($msg);
			}
		}
	}

	// Realizamos el redireccionamiento.
	// echo $url;
	header("Location:".$url);

	function logging($data) {
		// Mensjaeria de la aplicación.
		$msg = array();
		// Creamos un nuevo objeto encargado de las validaciones de los campos.
		$valid = new Validate();
		// Obtenemos solo los campos a trabajar.
		if (isset($data['session'])) {
			$_SESSION['TIME'] = 1200;
		} else {
			$_SESSION['TIME'] = 300;
		}
		// los cuales los decodificamos para trabajar.
		$data = $valid->extractArray($valid->decodeArray($data), array('username', 'password'));
		// Si emos recibido la informaciòn valida para esta solicitud continuamos...
		if (is_array($data)) {
			// Realizamos las validaciones con expresiones regulares.
			if (!$valid->validateField($data['username'], 'username')) {
				$msg[] = "Campo username es invalido.";
			}
			if (!$valid->validateField($data['password'], 'password')) {
				$msg[] = "Campo password es invalido.";
			}
			// Si no existen mensajes continuamos procesando la solicitud.
			if (empty($msg)) {
				// Creamos una nueva conexión con mysql.
				$cnn = new connection();
				// Encriptamos el password.
				$data['password'] = $cnn->getMD5($data['password']); 
				// creamos la consulta.
				$query = "SELECT users.nombre, users.authorized, type.type, type.url FROM users, type WHERE users.username='".$data['username']."' AND users.password='".$data['password']."' AND type.id=users.type";
				// Ejecutamos la consulta.
				$rs = $cnn->getQuery($query);
				// Verificamos que no se ha producido un error.
				if (is_object($rs)) {
					if ($rs->num_rows == 1) {
						// Obtenemos los datos y los codificamos a UTF-8
						$row = $valid->encodeArray($rs->fetch_assoc());
						if ($row['authorized'] == 'true') {
							// Registramos la hora de ingreso del usuario.
							// Creamos la consulta.
							$query = "UPDATE connection SET date_income='".$cnn->getDate()."', time_income='".$cnn->getTime()."', date_departure=NULL, time_departure=NULL WHERE username='".$data['username']."'";
							// Ejecutamos la consulta.
							$cnn->getQuery($query);
							// verificamos que se aya agregado correctamnente el registro.
							if ($cnn->affected_rows == 1) {
								// Creamos las variables de SESSION
								$_SESSION['NAME'] = $row['nombre'];
								$_SESSION['URL'] = $row['url'];
								$_SESSION['USERNAME'] = $data['username'];
								$_SESSION['TYPE'] = $row['type'];	
							} else {
								$msg[] = "Se ha produciudo un error interno porfavor intentelo mas tarde!";
							}
						} else {
							$msg[] = "Su cuenta aun no ha sido activada!";
						}
					} else {
						$msg[] = "Usuario y/o password invalidos.";
					}
				} else {
					$msg[] = "Se ha producido un error interno intentelo mas tarde.";
				}
				// Limpiamos la conexión.
				unset($rs);
				unset($rs);
				$cnn->close();
				unset($cnn);
			}
		} else {
			$msg[] = "Su solicitud no puede ser procesada"; 
		}
		// regresamos los mensajes.
		return $msg;
	}

	function register($data) {
		
		// Mensjaeria de la aplicación.
		$msg = array();
		// Creamos un nuevo objeto encargado de las validaciones de los campos.
		$valid = new Validate();
		// Obtenemos solo los campos a trabajar.
		$data = $valid->extractArray($data, array("nombre", "apaterno", "amaterno", "username", "password", "confirm_password", "email", "confirm_email", "type", "departament"));
		// Si emos recibido la informaciòn valida para esta solicitud continuamos...
		if (is_array($data)) {
			// Realizamos las validaciones con expresiones regulares.
			if (!$valid->validateField($data['nombre'], 'name')) {
				$msg[] = "Campo nombre es invalido!";
			}
			if (!$valid->validateField($data['apaterno'], 'name')) {
				$msg[] = "Campo apellido paterno es invalido!";
			}
			if (!$valid->validateField($data['amaterno'], 'name')) {
				$msg[] = "Campo apellido materno es invalido!";
			}
			if (!$valid->validateField($data['username'], 'username')) {
				$msg[] = "Campo username es invalido!";
			}
			if (!$valid->validateField($data['password'], 'password')) {
				$msg[] = "Campo password es invalido!";
			} else if ($data['password'] != $data['confirm_password']) {
				$msg[] = "Los campos password no coninciden!";
			} else {
				unset($data['confirm_password']);
			}
			if (!$valid->isEmail($data['email'])) {
				$msg[] = "Campo email es invalido!";
			} else if ($data['email'] != $data['confirm_email']) {
				$msg[] = "Los campos email no coninciden!";
			} else {
				unset($data['confirm_email']);
			}
			if (!$valid->validateField($data['type'], 'numeric')) {
				$msg[] = "Campo tipo de usuario es invalido!";
			}
			if (!$valid->validateField($data['departament'], 'numeric')) {
				$msg[] = "Campo departamento es invalido!";
			}

			if (empty($msg)) {
				// Creamos una conexiuón con mysql.
				$cnn = new Connection();
				// Creamos la consulota.
				$query = "SELECT COUNT(*) FROM users WHERE username='".$data['username']."' OR email='".$data['password']."'";
				// Ejecutamos la consulta.
				$rs = $cnn->getQuery($query);
				// Si no existen mensajes continuamos procesando la solicitud.
				if (is_object($rs)) {
					// Obtenemos el resultado de la busqueda.
					$row = $rs->fetch_assoc();
					if (!$row['COUNT(*)']) {
						// Incluimos la clase Email
						include 'PHPMailer/class.phpmailer.php';
						// Instanciamos la Clas PHPmailer
						$mail = new PHPMailer();	
						// Agregamos el servidor.
						$mail->Host = $_SERVER['HTTP_HOST'];
						// Remitente
						$mail->From = $_SERVER['SERVER_ADMIN']; 
						// Nombre de quien lo envia
						$mail->FromName = "Sistema de Reportes IPN";
						// Asunto de email
						$mail->Subject = "Solicitud de registro!";
						// Correo de destino y nombre.
						$mail->AddAddress($data['email'], "Usuario");
						// Definimod que se trata de html
						$mail->IsHTML(true);
						// Contenido del mensaje.
						$body = file_get_contents(DOIMAN.'system/source/registration.html');
						// validamos que se ha cargado el contenido del mensaje.
						if ($body != false && !empty($body)) {
							$mail->Body = $body;
							// Enviamos el email.
							if ($mail->Send()) {
								// decodificamos el array
								$data = $valid->decodeArray($data);
								// Encriptamos su password.
								$data['password'] = $cnn->getMD5($data['password']);
								// Creamos la consulta.
								$query = $cnn->getInsert($data, "users");
								// Ejecutamos la consulta.
								$cnn->getQuery($query);
								// verificamos que se aya agregado correctamnente el registro.
								if ($cnn->affected_rows == 1) {
									$cnn->getQuery($cnn->getInsert(array("username"=>$data['username']), "connection"));
									$msg[] = "En breve recibira un email con la confirmación de su registro!";
								} else {
									$msg[] = "Se ha produciudo un error interno porfavor intentelo mas tarde!";
								}
							} else {
								$msg[] = "Su email es invalido varifiquelo y vuelva a intentar!";
							}
						} else {
							$msg[] = "Se ha producido un error interno porfavor intentelo mas tarde!";
						}	
						// Eliminamos las variables utilizadas.
						unset($body);
						unset($mail);
					} else {
						$msg[] = "El campo username o email ya estan registrados!";
					}	
				} else {
					$msg[] = "Se ha producido un error interno intentelo mas tarde!";
				}
			}

		} else {
			$msg[] = "Su solicitud no puede ser procesada";
		}

		return $msg;
	}

	function restore($data) {
		
		// Mensjaeria de la aplicación.
		$msg = array();
		// Creamos un nuevo objeto encargado de las validaciones de los campos.
		$valid = new Validate();
	
		// Obtenemos solo los campos a trabajar.
		$data = $valid->extractArray($data, array("username", "email"));		

		if (is_array($data)) {
			// Realizamos las validaciones correspondientes.
			if (!$valid->validateField($data['username'], "username")) {
				$msg[] = "Campo username es invalido!";
			}
			if (!$valid->isEmail($data['email'])) {
				$msg[] = "Campo email es invalido!";
			}

			if (empty($msg)) {
				// Creamos una nueva conexión con mysql.
				$cnn = new Connection();	
				// Creamos la consulta.
				$query = "SELECT COUNT(*) FROM users WHERE username='".$data['username']."' AND email='".$data['email']."' AND authorized='true'";
				// Ejecutamos la consulta.
				$rs = $cnn->getQuery($query);
				// Verificamos que no se ha producido un error.
				if (is_object($rs)) {
					// Obtenemos el resultado de la consulta.
					$row = $rs->fetch_assoc();
					if ($row['COUNT(*)'] == 1) {
						// Simulamos que su respuesta a la solicitud sera procesada en un maximo de 24hrs.
						$msg[] = "Su nuevo password es: ".$valid->generetorField(10, "password"); 
					} else {
						$msg[] = "Usuario y/o email invalidos.";
					}

				} else {
					$msg[] = "Se ha producido un error interno intentelo mas tarde.";
				}
			} 
		} else {
			$msg[] = "Su solicitud no puede ser procesada";
		}

		return $msg;	
	}

	function newPassword ($data){
		// Mensjaeria de la aplicación.
		$msg = array();
		// Creamos un nuevo objeto encargado de las validaciones de los campos.
		$valid = new Validate();
		// Obtenemos solo los campos a trabajar.
		$data = $valid->extractArray($data, array("password", "new_password", "confirm_new_password"));
		if (is_array($data)) {
			// Validamos que los campos sean validos
			if (!$valid->validateField($data['password'], "password")) {
				$msg[] = "Campo password actual es invalido!";
			}
			if (!$valid->validateField($data['new_password'], 'password')) {
				$msg[] = "Campo nuevo password es invalido!";
			} else if ($data['new_password'] != $data['confirm_new_password']) {
				$msg[] = "Los campos de el nuevo password no coninciden!";
			} else {
				unset($data['confirm_new_password']);
			}
			if (empty($msg)) {
				// Creamos un conexión con mysql.
				$cnn = new Connection();
				// Encriptamos las contraseñas.
				$data['password'] = $cnn->getMD5($data['password']);
				$data['new_password'] = $cnn->getMD5($data['new_password']);	
				// Creamos la consulta.,
				$query = "UPDATE users SET password='".$data['new_password']."' WHERE password='".$data['password']."' AND username='".$_SESSION['USERNAME']."'";
				// Ejecutamos la consulta.
				$cnn->getQuery($query);
				// verificamos que se aya agregado correctamnente el registro.
				if ($cnn->affected_rows == 1) {
					$msg[] = "Se ha cambiado su password!";
				} else {
					$msg[] = "password invalida!";
				}
			}
		} else {
			$msg[] = "Se ha producido un error interno"; 
		}
		return $msg;
	}

?>