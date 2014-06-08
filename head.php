<?php
	include_once 'includes/security.php';
	include_once 'includes/globals.php';
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<title><?php if(isset($title)){echo $title;}?></title>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>css/main.css" rel="stylesheet" type="text/css"/>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<?php
			if (!empty($_GET)) {
				echo '<div id="dialog" title="Mensaje"><ul>';
				foreach ($_GET as $value) {
					echo '<li class="message">';
						echo $value;
					echo '</li>';
				}
				echo '</div></ul>';
			}
		?>
		<div id="wapper">
			<div id="header">
				<div id="header-top">
					<span class="left logo-report"></span>
					<span class="legend">
						<a href="http://www.ipn.mx/Paginas/inicio.aspx">
							Instituto Polit&eacute;cnico Nacional
							<span>
								"La T&eacute;cnica al servicio de la patria."
							</span>
						</a>
					</span>
					<span class="logo-ipn right"></span>
				</div>