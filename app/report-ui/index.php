<?php
	// Obtenemos las direcciones del sistema.
	include_once '/home/u800110318/public_html/includes/globals.php';
	// Agregamos el archivo de seguridad.
	include_once ROOT.'includes/security.php';
	/*
	 * Tremendo error de seguridad!!!
	 * 
	 * Validamos que exista una sessión autorizada.
	 */
	if (!isset($_SESSION['AUTHENTICATED'])) {
		// header('Location:'.ERROR404);
	}
	// Agregamos el archivo conexión.
	include_once ROOT.'includes/connection.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Report UI</title>
		<link rel="stylesheet" type="text/css" href="css/report-ui.css"/>
	</head>
	<body>
		<div id="wapper">
			<div class="report-ui" id="report-ui">
				<div id="container-buttons">
					<button class="button-option">Nuevo Reporte</button>
					<button class="button-option">Estado de Reportes</button>
				</div>
				<div id="container-form">
					<form>
						<input type="hidden"/>
						<fieldset>
							<div>
								<label></label>
							</div>
						</fieldset>
					</form>
				</div>
				<div>
				</div>
			</div>
		</div>
		<script src="<?php echo DOIMAN;?>js/jquery.js"></script>
		<script>
			$(document).on('ready', start);
			function start(){
				$().reportUI();
			}
			(function($){

				$.fn.reportUI = function(){
					// Evitamos trabajar con elementos null.
					if (this.length==0) {console.log('Elemento inexistente');return 0;};

					// Referencia al objeto this.
					var el = this;

					// Configuraciones de la aplicación.
					var settings = undefined;

					// Estructura de la aplicación.
					var struct = {
						"childrens": {
							"0": {
								"childrens": {
									"0": {
										"class": "button-option",
										"tag": "button",
										"text": "Nuevo Reporte"
									},
									"1": {
										"class": "button-option",
										"tag": "button",
										"text": "Estado de Reportes"
									}
								},
								"id": "container-buttons"
							},
							"1":{
								"childrens": {
									"0": {
										"childrens": {
											"0": {

											}
										},
										"tag": "form"
									}
								},
								"id": "container-forms"
							},
							"2": {
								"childrens": {
									"0": {
										"childrens": {
											"0": {

											}
										},		
										"tag": "table"
									}
								},
								"id": "container-table"
							}
						},
						"class": "report-ui"
					};
					// Inicia la aplicación.

				};

			}(jQuery));
		</script>
	</body>
</html>