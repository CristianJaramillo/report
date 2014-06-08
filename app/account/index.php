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
		header('Location:'.ERROR404);
	}
	// Agregamos el archivo conexión.
	include_once ROOT.'includes/connection.php';
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<title>Account of user</title>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="css/account.css"/>
		<link href="<?php if(defined('DOIMAN')){echo DOIMAN;}?>css/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="account"></div>
		<?php 
			if (isset($_SESSION['TYPE'])) {
				echo "<div id=\"dialog\" title=\"Mensaje\"><ul>";
				if (!empty($_GET)) {
					foreach ($_GET as $key => $value) {
						echo "<li>".$value."</li>";
					}
				} else {
					echo "<li>Bienvenido ".$_SESSION['TYPE']."</li>";
				}
				echo "</ul></div>";
			}
		?>
		<script src="<?php echo DOIMAN;?>js/jquery.js"></script>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery-ui.js"></script>
		<script>
			$(document).on('ready', start);
			// inicia el plugin
			function start(){
				if ($("#dialog").length==1) {
					// Mostramos la ventana modal
					$("#dialog").dialog({
						autoOpen: true,
						buttons: {
					    	"Aceptar": function() {
					        	$( this ).dialog( "close" );
					        }
					    },
						modal: true,
						width: 400
					});
				}
				$("#account").account({
					data: <?php
						// Creamos una conexión con mysql.
						$cnn = new Connection();	
						// Creamos la consulta a ejecutar.
						$query = "SELECT departament.departament AS 'Departamento', type.type AS 'Tipo de usuario', users.email AS 'Email', concat_ws(' ', users.nombre, users.apaterno, users.amaterno) AS 'Nombre de Usuario', users.username AS 'No. de Usuario', users.authorized AS 'Autorizado' FROM departament, type, users WHERE users.username=".$_SESSION['USERNAME']." AND type.id=users.type AND departament.id=users.departament";
						// Ejecutamos la consulta.
						$rs = $cnn->getQuery($query);
						// Data del la consulta.
						$data = array();
						// Mostramos el contenido de la misma.
						if (is_object($rs)) {
							if ($rs->num_rows) {
								$data = $rs->fetch_assoc();									
							} else {
								$data[] = "Sin contenido";
							}
						} else{
							$data[] = "Error";
						}
						echo json_encode($data);
					?>,
					security: "<?php echo $_SESSION['SECURITY'];?>",
					url: "<?php echo DOIMAN;?>includes/control.php"
				});
			}
			(function($){
				var defaults = {
					action: undefined,
					data: undefined,
					security: undefined,
					url: undefined
				};
				/*
				 *
				 */
				$.fn.account = function(options){

					// Verificamos que el objeto exista.
					if (this.length==0) {console.log('Elemento inexistente');return 0;};

					// Referencia al objeto this.
					var el = this;

					// Configuraciones de la aplicación.
					var settings = undefined;

					// Structura de la aplicación.
					var struct = {
						"childrens": {
							"0": {
								"childrens": {
									"0": {
										"childrens":{
											"0": {
												"childrens": {
													"0": {
														"childrens": {
															"0": {
																"colspan": "2",
																"tag": "th",
																"text": "Información de Usuario"
															}
														},
														"tag": "tr"
													}
												},
												"tag": "thead"
											},
											"1": {
												"tag": "tbody"
											},
											"2": {
												"childrens": {
													"0": {
														"childrens": {
															"0": {
																"colspan": "2",
																"tag": "td",
																"text": "Esta información es de caracter informativa"
															}
														},
														"tag": "tr"
													}
												},
												"tag": "tfoot"
											}
										},
										"tag": "table"
									}
								},
								"id": "info-users"
							},
							"1": {
								"childrens": {
									"0": {
										"action": "",
										"childrens": {
											"0": {
												"id": "action",
												"name": "action",
												"tag": "input",
												"type": "hidden",
												"value": "new-password"
											},
											"1": {
												"id": "security",
												"name": "security",
												"tag": "input",
												"type": "hidden",
												"value": ""
											},
											"2": {
												"childrens": {
													"0": {
														"tag": "legend",
														"text": "Cambiar password"
													},
													"1": {
														"childrens": {
															"0": {
																"for": "password",
																"tag": "label",
																"text": "Password Actual"
															}, 
															"1": {
																"id": "password",
																"name": "password",
																"required": "", 
																"tag": "input",
																"type": "password"
															}
														},
														"class": "line-form"
													},
													"2": {
														"childrens": {
															"0": {
																"for": "new_password",
																"tag": "label",
																"text": "Nuevo Password"
															}, 
															"1": {
																"id": "new_password",
																"name": "new_password",
																"required": "", 
																"tag": "input",
																"type": "password"
															}
														},
														"class": "line-form"
													},
													"3": {
														"childrens": {
															"0": {
																"for": "confirm_new_password",
																"tag": "label",
																"text": "Confirmar Nuevo Password"
															}, 
															"1": {
																"id": "confirm_new_password",
																"name": "confirm_new_password",
																"required": "", 
																"tag": "input",
																"type": "password"
															}
														},
														"class": "line-form"
													},
													"4": {
														"childrens" : {
															"0": {
																"class": "button-ipn",
																"tag": "input",
																"type": "submit",
																"value": "Enviar"
															}
														},
														"class": "line-form"
													}
												},
												"tag": "fieldset"
											}
										},
										"enctype":"application/x-www-form-urlencoded",
										"method": "POST",
										"tag": "form"
									}
								},
								"id": "pass-users"
							}
						},
						"class": "account-ui"
					};

					/*
					 * Añade elementos a un objeto mediante
					 * una structura json dada.
					 */
					var addElement = function(obj, json){
						$.each(json, function(a, b){
							var childrens = undefined;
							var tag = 'div';
							if (b.childrens!=undefined) {childrens=b.childrens;delete b.childrens;}
							if (b.tag!=undefined) {tag = b.tag; delete b.tag;}
							var x = $('<'+tag+'/>', b).appendTo(obj);
							if (childrens!=undefined) {addElement(x, childrens);};
						});
					}
					// Inicia la aplicación.
					var init = function(){
						// Obtine las configuraciones basicas del usuario.
						settings = $.extend({}, defaults, options);
						loadStruct();
					};

					/*
					 * Carga la información del usuario.
					 */
					var loadData = function(){
						$.each(settings.data, function(a, b){
							el.boxUsers.tbody.append("<tr><td>"+a+"</td><td>"+b+"</td></tr>");
						});
					}

					/*
					 * Crea la estructra de la aplicación.
					 */
					var loadStruct = function(){

						// Si existe una estructura hijo es agregada.
						if (struct.childrens!=undefined) {
							addElement(el, struct.childrens);
							// Eliminamos la estructura hijo para no se agregada como un atributo.
							delete struct.childrens;
						}
						el.attr(struct);
						// Cargamos la estructura de nodos
						nodeStruct();
						// Cargamos el contenido.
						loadData();
					}

					/*
					 * Crea una estructura de nodos para facil acceso a los elementos.
					 */
					var nodeStruct = function(){
						if (el.find("#info-users").length) {
							el.boxUsers = el.find("#info-users");
							if (el.boxUsers.find("table tbody")) {
								el.boxUsers.tbody = el.boxUsers.find("table tbody");
							}
						}
						if (el.find("#pass-users").length) {
							el.boxPass = el.find("#pass-users");	
							el.boxPass.find('form').attr("action", settings.url);
							console.log(settings.url);
							el.boxPass.find('input[type="hidden"]#security').val(settings.security);
						}
					}

					// Iniciamos la aplicación
					init();
				};
			}(jQuery));			
		</script>
	</body>
</html>