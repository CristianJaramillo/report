<?php
	// Obtenemos las direcciones del sistema.
	include_once '/home/u800110318/public_html/includes/globals.php';
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<title>Table UI</title>
		<link rel="stylesheet" type="text/css" href="css/table-ui.css"/>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="table-ui"></div>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery.js"></script>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery-ui.js"></script>
		<script src="js/table-ui.js"></script>
		<script>
			$(document).on('ready', start);

			function start(){
				$('#table-ui').tableUI({url:"<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/table-ui.php"});
			}

		</script>
	</body>
</html>