(function($){

	var defaults = {
		"contentType": 'application/x-www-form-urlencoded;charset=UTF-8',
		"data": {
			"_token": undefined,
			"action": undefined
		},
		"dialog-table":     true,
		"menu-table":       true,
		"method":           "POST",
		"panel-controls":   true,
		"panel-pagination": true,
		"panel-table":      true,
		"url":              undefined
	};

	$.fn.tableUI = function(options){
		
		if (this.length==0) {alert("Error");return this;};

		// Referencia al objeto contenedor.
		var el = this;

		// Canfiguraciones del usuario.
		var settings = undefined;

		// Estructura por defecto del plugin.
		var struct = {
			"childrens": {
				"0": {
					"id": "panel-controls",
					"childrens": {
						"0": {
							"childrens": {
								"0": {
									"tag": "option",
									"text": "-- No hay tablas --",
									"value": ""
								}
							},
							"id": "select-table",
							"tag": "select",
							"title": "Seleccionar Tabla"
						},
						"1": {
							"class": "ease",
							"id": "update-table",
							"tag": "button",
							"title": "Actualizar"
						},
						"2": {
							"id": "search-table",
							"placeholder": "Buscar",
							"tag": "input",
							"title": "Buscar",
							"type": "search"
						}
					}
				},
				"1": {
					"id": "panel-table",
					"childrens": {
						"0": {
							"childrens": {
								"0": {
									"tag": "thead"
								},
								"1": {
									"childrens": {
										"0": {
											"childrens": {
												"0": {
													"style": "text-align:center;",
													"tag": "td",
													"text": "Tabla sin contenido"
												}
											},
											"tag": "tr"
										}
									},
									"tag": "tbody"
								},
								"2": {
									"tag": "tfoot"
								},
							},
							"tag": "table"
						}
					}
				},
				"2": {
					"id": "panel-pagination",
					"childrens": {
						"0": {
							"childrens": {
								"0": {
									"tag": "option",
									"text": "-- No hay páginas --",
									"value": ""
								}
							},
							"id": "select-page",
							"tag": "select",
							"title": "Seleccionar página"
						},
						"1": {
							"childrens": {
								"0": {
									"tag": "option",
									"text": "10",
									"value": "10"
								},
								"1": {
									"tag": "option",
									"text": "20",
									"value": "20"
								},
								"2": {
									"tag": "option",
									"text": "30",
									"selected": "",
									"value": "30"
								},
								"3": {
									"tag": "option",
									"text": "40",
									"value": "40"
								},
								"4": {
									"tag": "option",
									"text": "50",
									"value": "50"
								}
							},
							"id": "select-rows",
							"tag": "select",
							"title": "Seleccionar filas"
						}
					}
				}, 
				"3":{
					"id": "menu-table",
					"childrens": {
						"0": {
							"childrens": {
								"0": {
									"id": "insert",
									"tag": "li",
									"text": "Agregar"
								},
								"1": {
									"id": "delete",
									"tag": "li",
									"text": "Eliminar"
								},
								"2": {
									"id": "update",
									"tag": "li",
									"text": "Modificar"
								},
								"3": {
									"id": "cancel",
									"tag": "li",
									"text": "Cancelar"
								}
							},
							"tag": "ul"							
						}	
					}
				},
				"4": {
					"id": "dialog-table",
					"childrens": {
						"0": {
							"childrens": {
								"0": {
									"id": "action",
									"name": "action",
									"tag": "input",
									"type": "hidden",
									"value": "none"
								},
								"1": {
									"tag": "fieldset"
								}
							},
							"tag": "form"
						},
						"1": {
							"id": "message",
							"text": "Gracias por utilizar este plugin"
						}
					},
					"title": "Bienvenido"
				}
			},
			"class": "table-ui"
		};

		/**
		 * Añade elementos a un objeto mediante
		 * una structura json dada.
		 */
		var addElement = function(obj, json){
			$.each(json, function(a, b){

				var childrens = undefined;
				var tag       = "div";
				var sentinel  = true;

				// Validamos su creación.
                if (b.id!=undefined) {
                	$.each(settings, function(key, value){
						if (b.id==key) {
							sentinel = value;
						}
					});
                }
                // Se crea el objeto.
                if (sentinel == true) {
                	if (b.childrens!=undefined) {childrens=b.childrens;delete b.childrens;}
					if (b.tag!=undefined) {tag = b.tag; delete b.tag;}
					var x = $("<"+tag+"/>", b).appendTo(obj);
					if (childrens!=undefined) {addElement(x, childrens);};
	            }

			});
		};

		/**
		 * Añade funciones a cada objeto.
		 */
		var addFunctions = function(){
			// Fija las dimenciones de los componentes.
			$(window).on("resize", setSize);
			// Control para cambiar de tabla actual.
			if (el.controls.selectTable!=undefined) {	
				el.controls.selectTable.on('change', setTable);
			}
			// Control para refrescar el contenido de la tabla.
			if (el.controls.updateTable!=undefined) {	
				el.controls.updateTable.on('click', function(){
					loadData(beforeTable, errorTable, successTable);
				});
			}
			// Realiza una busque da en la tabla actual.
			if (el.controls.searchTable!=undefined) {
				el.controls.searchTable.on("keyup", function(){
					el.panel.table.tbody.find("tr").each(hiddenRows);
				});
			};
		};

		/**
		 * Carga las tablas del sistema.
		 */
		var beforeSelect = function(){
			// Limpiamos el control.
			el.controls.selectTable.empty();
		};

		/**
		 * Vacia los contenedores de tablas y 
		 * mostramos ventana modal.
		 */
		var beforeTable = function(){
			// Limpiamos el contenido de la tabla.
			el.panel.table.tbody.empty();
			el.panel.table.thead.empty();
			el.panel.table.tfoot.empty();
			// Limpiamos el control de paginación.
			el.pagination.selectPage.empty();
		}

		/**
		 * Error al cargar las tablas de la base de datos.
		 */
		var errorSelect = function(a, b, c){
			console.log(a);
			console.log(b);
			console.log(c);
		};

		/**
		 *
		 */
		var errorTable = function(a, b, c){
			console.log(a);
			console.log(b);
			console.log(c);	
		};

		/*
		 * Muestra u oculta contenido de la tabla dada un string como parametro.
		 */
		var hiddenRows = function(a, b){
			var td = $(b).find('td');
			var wordfind = false;
			if (td.length) {
				td.each(function(){					
					var exp = new RegExp(el.controls.searchTable.val(), "i")
					var word = $(this).text();
					if( exp.test(word) ){
						wordfind = true;
						return;
					}
				});
			}
			if(wordfind){
				$(b).show();
			} else{
				$(b).hide();
			}
		}

		/**
		 * Inicia el plugin.  n
		 */
		var init = function(){
			// Obtine las configuraciones basicas del usuario.
			settings = $.extend({}, defaults, options);
			// Cargamos la estructura del plugin.
			loadStruct();
			// Creamos una estructura de nodos para facil acceso.
			nodeStruct();
			// Establecemos las dimenciones.
			setSize();
			// Agregamos los eventos.
			addFunctions();
			// Obtenemos el _token.
			if (settings._token!=undefined) {
				settings.data._token = settings._token;
				delete settings._token;
			};

			// Obtenemos la acción.
			if (settings.action!=undefined) {
				settings.data.action = settings.action;
				delete settings.action;
			};
			// Cargamos contenido de las tablas.
			loadData(beforeSelect, errorSelect, successSelect);
		};

		/**
		 * Obtenemos los resultados de una consulta en formato JSON
		 */
		var loadData = function(beforef, errorf, successf){
			$.ajax({
				async: true,
				beforeSend: beforef,
				contentType: settings.contentType,
				data: settings.data,
				dataType: "json",
				error: errorf,
				success: successf,
				timeout: 10000,	
				type: settings.method,
				url: settings.url
			});
		};

		/**
		 * Carga las tablas al selectTable.
		 */
		var loadSelect = function(data){
			$.each(data, function(a, b) {
			    $.each(b, function(c, d){

			    	if ($.jStorage.get("table")==d) {
			    		el.controls.selectTable.append('<option value="' + d + '" selected>' + d + '</option>');
			    	} else {
			    		el.controls.selectTable.append('<option value="' + d + '">' + d + '</option>');
			    	}
			    });
			});
			return el.controls.selectTable.find('option').length > 0 ? true : false;
		}

		/**
		 * Crea la estructra de la aplicación.
		 */
		var loadStruct = function(){

			// Si existe una estructura hijo es agregada.
			if (struct.childrens!=undefined) {
				addElement(el, struct.childrens);
				// Eliminamos la estructura hijo para no se agregada como un atributo.
				delete struct.childrens;
			}
			// Agregamos los atributos del contenedor.
			el.attr(struct);
		};

		/**
		 * Carga el contenido a la tabla.
		 */
		var loadTable = function(data){

			// filas de la tabla.
			var tr = undefined;

			if (data.head != undefined) {
				tr = $("<tr/>");
				$.each(data.head, function(index, column){
					$.each(column, function(field, value){
						if (field=="Field") {
							tr.append($("<th/>", {"text":value}).append($("<span/>", {"class":"arrow","order":"asc"})));
						};
					});
				});
				el.panel.table.thead.append(tr);
				// establecemos el evento para ordenar.
				el.panel.table.thead.find("span.arrow").on('click', orderTable);
			};

			if (data.body != undefined) {
				$.each(data.body, function(index, column){
					tr = $("<tr/>");
					$.each(column, function(field, value){
						tr.append("<td>"+value+"</td>");
					});
					el.panel.table.tbody.append(tr);
				});

				if (el.panel.table.tbody.find("tr").length>0) {
					el.panel.table.tbody.tr = el.panel.table.tbody.find("tr");
					el.panel.table.tbody.tr.on("click", function(){

						if ($(this).hasClass("select-tr")) {
							$(this).removeClass("select-tr");
						} else {
							el.panel.table.tbody.tr.removeClass("select-tr");
							$(this).addClass("select-tr");
						}


					});
				} else {

					var x = 1;

					if (el.panel.table.thead.find("tr th").length>0) {x=el.panel.table.thead.find("tr th").length};

					el.panel.table.tbody.append($("<tr/>").append($("<td/>",{"text":"Tabla sin contenido!","colspan":x,"style":"text-align:center"})));
				}

			};

			console.log(data);

			return el.panel.table.thead.find('tr th').length > 0 ? true : false;
		
		};

		/**
		 * Estructura de nodos.
		 */
		var nodeStruct = function(){

			/**
			 * Controles principales de la aplicación.
			 */
			if (el.find("#panel-controls").length!=0) {
				el.controls = el.find("#panel-controls");
				if(el.controls.find("#select-table").length!=0) el.controls.selectTable = el.controls.find("#select-table");
				if(el.controls.find("#update-table").length!=0) el.controls.updateTable = el.controls.find("#update-table");
				if(el.controls.find("#search-table").length!=0) el.controls.searchTable = el.controls.find("#search-table");
			}
			/**
			 * Controles secundarios.
			 */
			if (el.find("#panel-pagination").length!=0) {
				el.pagination = el.find("#panel-pagination");
				el.pagination.selectRows = el.pagination.find("#select-rows");
				el.pagination.selectPage = el.pagination.find("#select-page");
			}
			/**
			 * Contenedor de la tabla.
			 */
			if (el.find("#panel-table").length!=0) {
				el.panel = el.find("#panel-table");
				if(el.panel.find("table").length!=0) {
					el.panel.table = el.panel.find("table");
					if(el.panel.find("tbody").length!=0) el.panel.table.tbody = el.panel.find("tbody");
					if(el.panel.find("tfoot").length!=0) el.panel.table.tfoot = el.panel.find("tfoot");
					if(el.panel.find("thead").length!=0) el.panel.table.thead = el.panel.find("thead");
				}
			}
			/**
			 * Menu de navegación.
			 */
			if (el.find("#menu-table").length!=0) {
				el.menuTable = el.find("#menu-table");
				if(el.menuTable.find("#delete").length!=0) el.menuTable.btnDelete = el.menuTable.find("#delete");
				if(el.menuTable.find("#insert").length!=0) el.menuTable.btnInsert = el.menuTable.find("#insert");
				if(el.menuTable.find("#update").length!=0) el.menuTable.btnUpdate = el.menuTable.find("#update");
				if(el.menuTable.find("#cancel").length!=0) el.menuTable.btnCancel = el.menuTable.find("#cancel");
			}
			
		};

		/*
		 * Ordena la tabla actual dada una columna
		 */
		var orderTable = function () {


			if (el.panel.table.tbody.find("tr").length>0 && el.panel.table.tbody.find("tr td").length>0) {

				var order = $(this).attr("order");
			
				if (order != 'asc') {
					order = true;
					$(this).attr('order', 'asc');
				} else{
					order = false;
					$(this).attr('order', 'desc');
				}

				// string
				var str = $(this).parent('th').text();
				// fila
				var tr = $(this).parent('th').parent('tr');

				$(tr).find('th').each(function (i) {
					if (str == $(this).text()) {
							
						var rows = el.panel.table.tbody.find("tr").get();
							
						rows.sort(function(a, b){
							
							var keyA = $(a).children('td').eq(i).text().toUpperCase();
							var keyB = $(b).children('td').eq(i).text().toUpperCase();
							
							if (order) {
								if (keyA < keyB) return -1;
								if (keyA > keyB) return 1;
							} else {
								if (keyA > keyB) return -1;
								if (keyA < keyB) return 1;
							}
							return 0;	
						});
						$.each(rows, function(index, row) {
							el.panel.table.tbody.append(row);
						});
					}	
				});			

			};
		};

		/**
		 * Establece las dimenciones de los componentes.
		 */
		var setSize = function(){
			
			var h = el.outerHeight();
			var w = el.outerWidth();

			if (el.controls!=undefined) {
				el.controls.css("bottom", (h-50) + "px");
			};

			if (el.pagination!=undefined) {
				el.pagination.css("top", (h-50) + "px");
			};

			if (el.panel!=undefined) {
				if (el.controls==undefined) el.panel.css("top", "10px");
				if (el.pagination==undefined) el.panel.css("bottom", "10px");
			};

		};

		/*
		 * Establece la nueva tablas a trabajar e inicializa los valores por defecto,
		 * realiza la carga del nuevo contenido.
		 */
		var setTable = function(){		
			// Almacenamos la tabla en uso actual.
			$.jStorage.set("table", $(this).val(), {TTL: 60000});

			settings.data.table = $(this).val();
			loadData(beforeTable, errorTable, successTable);
		};

		/**
		 * Acción al cargar recibir una respuesta.
		 */
		var successSelect = function(data){

			if (data.success!=undefined) {
				if (loadSelect(data.success)) {
					// Obtenemos el nombre de la tabla inicial.
					settings.data.table = el.controls.selectTable.val().toString();
					// Definimos la ación a realizar.
					settings.data.action = "select";
					// Cargamos contenido a la tabla.
					loadData(beforeTable, errorTable, successTable);
				}
			}

		};

		/**
		 * Cargamos el contenido de la tabla.
		 */
		var successTable = function(data)
		{

			if (data.success!=undefined) 
			{
				// Datos de la tabla.
				if (loadTable(data.success)) console.log("Exito");
			}
		};

		init();

	};

})(jQuery);