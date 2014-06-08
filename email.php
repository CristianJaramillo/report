<?php
	// Incluimos la clase Email
	include 'includes/PHPMailer/class.phpmailer.php';
	// Instanciamos la Clas PHPmailer
	$mail = new PHPMailer();	
	// Agregamos el servidor.
	$mail->Host = $_SERVER['HTTP_HOST'];
	// Remitente
	$mail->From = $_SERVER['SERVER_ADMIN']; 
	// Nombre de quien lo envia
	$mail->FromName = "IPN";
	// Asunto de email
	$mail->Subject = "Prueva 1";
	//Correo de destino y nombre.
	$mail->AddAddress("cristian_gerar@hotmail.com", "Loko");
	// Definimod que se trata de html
	$mail->IsHTML(true);
	// Contenido del mensaje.
	$body = file_get_contents('http://reportuteycv.site50.net/system/source/registration.html');
	// validamos que se ha cargado el contenido del mensaje.
	if ($body != false && !empty($body)) {
		$mail->Body = $body;
		// Enviamos el email....
		if ($mail->Send()) {
			echo "<h1>Envio Exitoso!</h1>";
		} else{
			echo "<h1>Envio Fallido!</h1>";
			echo $mail->ErrorInfo;
		}
	} else{
		echo "<h1>No se ha cargado el contenido del mensaje!</h1>";
	}
?>