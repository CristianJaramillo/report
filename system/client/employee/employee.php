<?php
	/*
	 * Proteje las páginas del administrador.
	 */

	// Agregamos las direcciones del sistema.
	require_once '/home/u800110318/public_html/includes/globals.php';

	// require_once '/home/a5307922/public_html/includes/globals.php';

	// Definimos el tipo de usuario autorizado para esta aplicación.
	define('TYPE', 'Cliente');

	// Agregamos el archivo que se encargara de validar el acceso al este archivo.
	require_once ROOT.'includes/authenticated.php';

	// Cabecera de la página.
	include_once ROOT.'head.php';
?>
	<div id="nav-container">
					<ul class="right" id="movile-menu">
						<li><a class="item-nav nav-icon" href="#nav-movile"></a></li>
					</ul>
					<ul class="right" id="pc-menu">
						<li class="left"><a class="item-nav" href="<?php if(defined('DOIMAN')){echo DOIMAN;if(isset($_SESSION['URL'])){echo $_SESSION['URL'];}}?>">Inicio</a></li>
						<li class="left"><a class="item-nav" href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/exit.php">Salir</a></li>
					</ul>
				</div>
			</div>
			<div id="container">
				<div class="panel">
					<div id="nav-movile">
						<ul>
							<li class="item-movile" ><a href="<?php if(defined('DOIMAN')){echo DOIMAN;if(isset($_SESSION['URL'])){echo $_SESSION['URL'];}}?>">Inicio</a></li>
							<li class="item-movile" ><a href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/exit.php">Salir</a></li>
						</ul>
					</div>
				</div>
			<div class="panel">
					<div id="app">
						<iframe  src="<?php if(defined('DOIMAN')){echo DOIMAN;}if (isset($app)){echo $app;}?>">
							<p>Lo siento tu navegador no soporta frames</p>
						</iframe>
					</div>	
				</div>
			</div>
			<div id="footer">
				<h6>
					<span>Sistema de Reportes desarrollado para el <a href="http://www.cecyt8.ipn.mx/Paginas/inicio.aspx">CECyT No.8 "Narciso Bassols"</a></span>
					<span>por la <a href="#">UTEyCV</a>, iniciado el lunes 17 de Septiembre de 2013.</span>
				</h6>
			</div>
		</div>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery.js"></script>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/start.js"></script>
		<script>
			
			$(document).on('ready', start);
			
			function start(){
				$('#wapper').startUX();
				$('a, span, input').addClass('ease');
			};

		</script>
	</body>
</html>