(function($){
	
	var defaults = {
		action: undefined,
		offset: 30,
		row_count: 0,
		page: 1,
		table: undefined,
		url: 'includes/table-ui.php'
	};

	$.fn.tableUI = function(options){

		if (this.length==0) {console.log('Elemento inexistente');return 0;};

		// Referencia al objeto this.
		var el = this;

		// Configuraciones de la aplicación.
		var settings = undefined;

		// Número de registros totales.
		var max_rows = 0;

		// Palabra a buscar.
		var wordSearch = '';

		// Hace un respaldo de la fila seleccionada.
		var auxRow = undefined;

		// Contiene el query a ejecutar.
		var query = undefined;

		var struct = {
			childrens: {
				0: {
					id: 'panel-controls',
					childrens: {
						0: {
							id: 'select-table',
							tag: 'select',
							title: 'Seleccionar Tabla'
						},
						1: {
							'class': 'button-update ease',
							id: 'update-table',
							tag: 'button',
							title: 'Actualizar'
						},
						2: {
							id: 'search-table',
							placeholder: 'Buscar',
							tag: 'input',
							title: 'Buscar',
							type: 'search'
						}
					}
				},
				1: {
					id: 'panel-table',
					childrens: {
						0: {
							childrens: {
								0: {
									tag: 'thead'
								},
								1: {
									childrens: {
										0: {
											childrens: {
												0: {
													style: 'text-align:center;',
													tag: 'td',
													text: 'Tabla sin contenido'
												}
											},
											tag: 'tr'
										}
									},
									tag: 'tbody'
								},
								2: {
									tag: 'tfoot'
								},
							},
							tag: 'table'
						}
					}
				},
				2: {
					id: 'panel-pagination',
					childrens: {
						0: {
							childrens: {
								0: {
									'for': 'select-page',
									tag: 'label',
									text: 'Páginas'
								},
								1: {
									id: 'select-page',
									tag: 'select',
									title: 'Seleccionar página'
								}
							},
							'class': 'inline-select'
						},
						1: {
							childrens: {
								0: {
									'for': 'select-rows',
									tag: 'label',
									text: 'Registros'
								},
								1: {
									childrens: {
										0: {
											tag: 'option',
											text: '10',
											value: '10'
										},
										1: {
											tag: 'option',
											text: '20',
											value: '20'
										},
										2: {
											tag: 'option',
											text: '30',
											selected: '',
											value: '30'
										},
										3: {
											tag: 'option',
											text: '40',
											value: '40'
										},
										4: {
											tag: 'option',
											text: '50',
											value: '50'
										}
									},
									id: 'select-rows',
									tag: 'select',
									title: 'Seleccionar filas'
								}
							},
							'class': 'inline-select'
						}
					}
				}, 
				3:{
					id: 'menu-table',
					childrens: {
						0: {
							childrens: {
								0: {
									id: 'insert',
									tag: 'li',
									text: 'Agregar'
								},
								1: {
									id: 'delete',
									tag: 'li',
									text: 'Eliminar'
								},
								2: {
									id: 'update',
									tag: 'li',
									text: 'Modificar'
								},
								3: {
									id: 'cancel',
									tag: 'li',
									text: 'Cancelar'
								}
							},
							tag: 'ul'							
						}	
					}
				},
				4: {
					id: 'dialog-table',
					childrens: {
						0: {
							childrens: {
								0: {
									id: "action",
									name: 'action',
									tag: 'input',
									type: 'hidden',
									value: 'none'
								},
								1: {
									tag: 'fieldset'
								}
							},
							tag: 'form'
						},
						1: {
							id: 'message',
							text: 'Gracias por utilizar este plugin'
						}
					},
					title: 'Bienvenido'
				}
			},
			'class': 'table-ui'
		};

		/*
		 * Activa o desactiva los controles de la aplicación.
		 */
		var activeControls = function(active){
			el.controls.searchTable.prop('disabled', active);
			el.controls.updateTable.prop('disabled', active);
			el.subControls.selectRows.prop('disabled', active);
			el.subControls.selectPage.prop('disabled', active);
		}

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

		var beforeQuery = function(){
			el.dialogTable.formTable.actionForm.attr('value', 'none');
		}

		var beforeSelect = function(){
			el.controls.selectTable.empty();
		}

		/*
		 * Vacia los contenedores de tablas y 
		 * desactiva los controles.
		 */
		var beforeTable = function(){
			// Limpiamos el contenido de la tabla.
			el.panel.table.tbody.empty();
			el.panel.table.thead.empty();
			el.panel.table.tfoot.empty();
			// Limpiamos el control de paginación.
			el.subControls.selectPage.empty();
			// Desactiva los controles.
			activeControls(true);
			// Limpia el contenido del formulario.
			el.dialogTable.formTable.contentForm.empty();
		}

		/*
		 * Envia la peticiòn para eliminar el registro.
		 */
		 var deleteRow = function(){
		 	// Cargamos los campos a eliminar.
		 	loadRow();
		 	// Ocultamos el menucontextual. 
		 	hiddenMenu();
		 	// Establecemos la acción del formulario.
		 	el.dialogTable.formTable.actionForm.attr('value', 'delete');
		 	// Preparamos el query a ejecutar.
		 	query = el.dialogTable.formTable.serialize();
		 	// Inaccivamos los campos del formulario.
		 	el.dialogTable.formTable.contentForm.find('input[type="text"]').each(function(){
		 		$(this).prop('disabled', true);
		 	});
		 	// Asignamos el titulo
		 	el.dialogTable.dialog('option', 'title', 'Eliminar registro.');
		 	// Mostramos el formulario.
		 	el.dialogTable.dialog("open");
		 }

		/*
		 *
		 */
		var errorQuery = function(a, b, c){
			console.log(a);
			console.log(b);
			console.log(c);
		}

		/*
		 * Error al cambiar de tabla.
		 */
		var errorSelect = function(a, b, c){
			console.log(a);
			console.log(b);
			console.log(c);
		}

		var errorTable = function(a, b, c){
			console.log(a);
			console.log(b);
			console.log(c);	
		}

		/*
		 * Oculta el menu de la aplicación.
		 */
		 var hiddenMenu = function(){
		 	// Cierra el menucontextual.
			el.menuTable.hide();	
			// Limpiamos la variable aux.
			auxRow = undefined; 	
			// Establecemos en none la acción del formulario.
			el.dialogTable.formTable.actionForm.attr('value', 'none');
			// Liempiamos el contenido del query.
			query = undefined;
		 }


		/*
		 * Muestra u oculta contenido de la tabla dada un string como parametro.
		 */
		var hiddenRows = function(a, b){
			var td = $(b).find('td');
			var wordfind = false;
			if (td.length) {
				td.each(function(){					
					var exp = new RegExp(wordSearch, "i")
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

		/*
		 * Inicia el plugin.
		 */
		var init = function(){
			// Obtine las configuraciones basicas del usuario.
			settings = $.extend({}, defaults, options);
			// Cargamos la aplicación
			loadStruct();
		}

		/*
		 * Manda una solicitud para agregar un campo.
		 */
		var insertRow = function(){
			// Oculto el menucontextual
			hiddenMenu();
			// Establecemos la ación a ejecutar.
			el.dialogTable.formTable.actionForm.attr('value', 'insert');
			// Falta validar que existan inputs...
			el.dialogTable.formTable.contentForm.find('input[type="text"]').attr('value', '');
			// Inaccivamos los campos del formulario.
		 	el.dialogTable.formTable.contentForm.find('input[type="text"]').each(function(){
		 		$(this).prop('disabled', false);
		 	});			
		 	// Mostramos el formulario.
			el.dialogTable.dialog('option', 'title', 'Agregar registro.');
			el.dialogTable.dialog('open');
		}

		/*
		 * Obtenemos los resultados de una consulta en formato JSON
		 */
		var loadData = function(beforef, errorf, successf, data, url){
			$.ajax({
				async: true,
				beforeSend: beforef,
				contentType: 'application/x-www-form-urlencoded;charset=UTF-8',
				data: data,
				dataType: 'json',
				error: errorf,
				success: successf,
				timeout: 1000,	
				type: 'POST',
				url: url
			});
		}

		/*
		 * Carga su correspondiente función a los elementos.
		 */
		var loadFunctions = function(){
			/*
			 * Funciones de controles principales.
			 */
			el.controls.selectTable.on('change', setTable);
			el.controls.updateTable.on('click', function(){
				loadData(beforeTable, errorTable, successTable, settings, settings.url);
			});
			el.controls.searchTable.on('keyup', searchTable);
			el.subControls.selectRows.on('change', setRows);
			el.subControls.selectPage.on('change', setPage);
			/*
			 * Funciones del menu de la aplicaciòn.
			 */
			el.menuTable.btnCancel.on('click', hiddenMenu);
			el.menuTable.btnDelete.on('click', deleteRow);
			el.menuTable.btnInsert.on('click', insertRow);
			el.menuTable.btnUpdate.on('click', updateRow);
		}

		/*
		 * Carga el contenido de la fila seleccionada
		 * en el formulario.
		 */
		var loadRow = function(){
			if (auxRow!=undefined) {
				var td = auxRow.find('td');
				var x = td.length;
				var input = el.dialogTable.formTable.contentForm.find('input[type="text"]');
				var y = input.length;
				if (x == y) {
					for(var i=0; i< x; i++){
						$(input[i]).attr('value', $(td[i]).text());	
					}
				}
			} else {
				console.log('Error');
			}
		}

		/*
		 * Carga las tablas al select.
		 */
		var loadSelect = function(data){
			$.each(data, function(a, b) {
			    $.each(b, function(c, d){
			    	el.controls.selectTable.append('<option value="' + d + '">' + d + '</option>');
			    });
			});
			return el.controls.selectTable.find('option').length > 0 ? true : false;
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

			/*
			 * Ejecutamos las funciones.
			 */
			nodeStruct();
			loadFunctions();
			loadData(beforeSelect, errorSelect, successSelect, {action:'tables-system'}, settings.url);
		}

		var loadTable = function(data){
			$.each(data, function(a, b){
				var tr = '<tr>'
				$.each(b, function(c, d){
					if (a=='head') {
						el.dialogTable.formTable.contentForm.append('<div class="inline-form"><label for="'+d+'">'+d+'</label><input id="'+d+'" name="'+d+'" type="text"/></div>');
						tr += '<th>' + d + '</th>';
					} else if(a=='foot'){
						max_rows = parseInt(d);
						var page = Math.round((max_rows/settings.offset) + 0.49);
						for (var i = 1; i <= page; i++) {
							var option = '<option value="'+i+'"';
							if (settings.page==i) {
								option += ' selected';
							};
							option += '>'+i+'</option>';
							el.subControls.selectPage.append(option);
						};
						tr += '<td>Desde ' + settings.row_count + ' hasta ' + (settings.row_count + settings.offset) + ' de ' + d + ' registros</td>';
					} else{
						tr += '<td>' + d + '</td>';
					}
				});
				tr += '</tr>';

				if (a=='head') {
					el.panel.table.thead.append(tr);
				} else if(a=='foot'){
					el.panel.table.tfoot.append(tr);
				} else{
					el.panel.table.tbody.append(tr);
				}
			});
			return el.panel.table.thead.find('tr th').length > 0 ? true : false;
		}

		var nodeStruct = function(){
			/*
			 * Controles principales de la aplicación.
			 */
			el.controls = el.find('#panel-controls');
			el.controls.selectTable = el.controls.find('#select-table');
			el.controls.updateTable = el.controls.find('#update-table');
			el.controls.searchTable = el.controls.find('#search-table');
			/*
			 * Contenedor de la tabla.
			 */
			el.panel = el.find('#panel-table');
			el.panel.table = el.panel.find('table');
			el.panel.table.tbody = el.panel.find('tbody');
			el.panel.table.tfoot = el.panel.find('tfoot');
			el.panel.table.thead = el.panel.find('thead');
			/*
			 * Controles secundarios.
			 */
			el.subControls = el.find('#panel-pagination');
			el.subControls.selectRows = el.subControls.find('#select-rows');
			el.subControls.selectPage = el.subControls.find('#select-page');
			/*
			 * Menu de navegación.
			 */
			el.menuTable = el.find('#menu-table');
			el.menuTable.btnDelete = el.menuTable.find('#delete');
			el.menuTable.btnInsert = el.menuTable.find('#insert');
			el.menuTable.btnUpdate = el.menuTable.find('#update');
			el.menuTable.btnCancel = el.menuTable.find('#cancel');
			el.dialogTable = el.find('#dialog-table');
			el.dialogTable.formTable = el.dialogTable.find('form');
			el.dialogTable.formTable.actionForm = el.dialogTable.formTable.find('input[type="hidden"]#action');
			el.dialogTable.formTable.contentForm = el.dialogTable.formTable.find('fieldset');
			el.dialogTable.dialog({
				autoOpen: false,
				buttons: {
					"Aceptar": submitForm,
					"Cancelar": function(){
						$(this).dialog('close');
					}
				},
				modal: true,
				width: 400
			});
			el.dialogTable.message = el.dialogTable.find('#message');
		}

		/*
		 * Ordena la tabla actual dada una columna
		 */
		var orderTable = function () {
			if (el.panel.table.tbody.tr != undefined) {
				if (el.panel.table.tbody.tr.td != undefined) {
					
					var order = $(this).attr('order');
					
					if (order != 'asc') {
						order = true;
						$(this).attr('order', 'asc');
					} else{
						order = false;
						$(this).attr('order', 'desc');
					}			

					var str = $(this).parent('th').text();
					var tr = $(this).parent('th').parent('tr');
					
					$(tr).find('th').each(function (i) {
						if (str == $(this).text()) {
							
							var rows = el.panel.table.tbody.tr.get();
							
							rows.sort(function(a, b){
							
								var keyA = $(a).children('td').eq(i).text().toUpperCase();
								var keyB = $(b).children('td').eq(i).text().toUpperCase();
							
								if (order) {
									if (keyA < keyB) return -1;
									if (keyA > keyB) return 1;
								} else{
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
				} else{
					alert('No existe registros.');
				}
			}
		}

		/*
		 * realiza una busqueda en la tabla.
		 */
		var searchTable = function(){
			if (el.panel.table.thead.tr!=undefined && el.panel.table.tbody.tr!=undefined) {
				if (el.panel.table.thead.tr.th!=undefined && el.panel.table.tbody.tr.td!=undefined) {
					wordSearch = $(this).val();
					el.panel.table.tbody.tr.each(hiddenRows);
				} else{
					alert('La tabla esta vasia!');
				}
			} else{
				alert('Imposible hacer una busqueda');
			}
		}

		/*
		 * Establece la nueva tablas a trabajar e inicializa los valores por defecto,
		 * realiza la carga del nuevo contenido.
		 */
		var setTable = function(){			
			settings.offset = 30;
			settings.row_count = 0;
			settings.table = $(this).val();
			el.subControls.selectRows.val(30);
			loadData(beforeTable, errorTable, successTable, settings, settings.url);
		}

		/*
		 * Establece el número de registros a recibir.
		 * recalcula la pàgina acual y la pocicio.
		 */
		var setRows = function(){
			// restablemos valores.
			settings.offset = parseInt($(this).val());	
			settings.row_count = 0;
			settings.page = 1;

			// settings.page = (max_rows / settings.offset);
			loadData(beforeTable, errorTable, successTable, settings, settings.url);
		}

		/*
		 * Establece los registros a visualizar.
		 */
		var setPage = function () {
			settings.page = $(this).val();
			settings.row_count = (settings.page * settings.offset) - settings.offset;
			loadData(beforeTable, errorTable, successTable, settings, settings.url);
		}

		/*
		 * Crea la estructura de la tabla.
		 */	
		var setStructTable = function(){
			if (el.panel.table.tbody.find('tr').length) {
				el.panel.table.tbody.tr = el.panel.table.tbody.find('tr');
				el.panel.table.tbody.tr.addClass('tbody-tr');
				if (el.panel.table.tbody.tr.find('td').length) {
					el.panel.table.tbody.tr.td = el.panel.table.tbody.tr.find('td');
					el.panel.table.tbody.tr.td.addClass('tbody-tr-td');
					el.panel.table.tbody.tr.on('contextmenu', showMenu);
				}
			}
			if (el.panel.table.tfoot.find('tr').length) {
				el.panel.table.tfoot.tr = el.panel.table.tfoot.find('tr');
				el.panel.table.tfoot.tr.addClass('tfoot-tr');
				if (el.panel.table.tfoot.tr.find('td').length) {
					el.panel.table.tfoot.tr.td = el.panel.table.tfoot.tr.find('td');
					el.panel.table.tfoot.tr.td.addClass('tfoot-tr-td');
				}
			}			
			if (el.panel.table.thead.find('tr').length) {
				el.panel.table.thead.tr = el.panel.table.thead.find('tr');
				el.panel.table.thead.tr.addClass('thead-tr');
				if (el.panel.table.thead.tr.find('th').length) {
					el.panel.table.thead.tr.th = el.panel.table.thead.tr.find('th');
					el.panel.table.thead.tr.th.addClass('thead-tr-th');
					if (el.panel.table.tfoot.find('tr td').length) {
						el.panel.table.tfoot.find('tr td').attr('colspan', el.panel.table.thead.tr.th.length);
					}
					el.panel.table.thead.tr.th.append('<span/>');
					el.panel.table.thead.tr.th.arrow = el.panel.table.thead.tr.th.find('span').addClass('arrow');
					// establecemos el evento para ordenar.
					el.panel.table.thead.tr.th.arrow.on('click', orderTable);
				}
			}

			el.panel.scrollLeft(0);

			if(el.panel.height() > el.panel.table.height()){
				
				var attr = {
					'class': 'not-row',
					colspan: 1,
					height: 0,
					text: ''
				};

				if (el.panel.table.thead.find('tr th').length) {
					attr.colspan = el.panel.table.thead.find('tr th').length;
				}

				attr.height = el.panel.height() - el.panel.table.height();
				
				if (el.panel.table.tbody.find('tr td').length==0) {
					attr.text = 'Tabla sin contenido';
				}

				$('<td>'+attr.text+'</td>').appendTo(el.panel.table.tbody).attr(attr);

			}

		}

		/*
		 * Muetra las opciones de la aplicación.
		 */
		var showMenu = function(event){
			event.preventDefault();
			// Obtenemos la posiciones en la que mostraremos el menu.
			var x = event.pageX;
			var y = event.pageY;
			// mostramos el menu de la tabla.	
			el.menuTable.css({
				display: 'block',
				left: x,
				top: y
			});
			// Hacemos un respaldo de la fila a trabajar.
			auxRow = $(this);
			// Mostramos el formulario.
			el.dialogTable.formTable.show();
			// Ocultamos la barra de mensajes.
			el.dialogTable.message.hide();		}		

		/*
		 * Realizalos preparativos antes de enviar la consulta.
		 */
		var submitForm = function(){
			// Cerramos el formulario.
			$(this).dialog('close');
			// Obtenemos la acción del formulario.
			var action = el.dialogTable.formTable.actionForm.attr('value');
			// Evaluamos la acción y ejecutamos el query.
			if (action != 'none') {
				var enviar = true;
				if (action == 'insert') {
					query = el.dialogTable.formTable.serialize();
				} else if (action == 'update') {
					// Obtenemos los nuevos campos del registro a modificar.
					el.dialogTable.formTable.contentForm.find('input[type="text"]').each(function(){
						query += '&SET_' + $(this).attr('name') + '=' + $(this).val();
					});
				} else if(action != 'delete'){
					enviar = false;
					query = 'error';
				}
				if (enviar) {
					query += '&table=' + settings.table;
	
					loadData(beforeQuery, errorQuery, successQuery, query, settings.url);
				}
			} else {
				el.dialogTable.dialog('close');
			};
		}

		/*
		 * Respuesta del la cosulta a ejecutar.
		 */
		var successQuery = function(data){
			el.dialogTable.dialog('option', 'title', 'Mensaje');
			var msg = '<ul>';
			$.each(data, function(a, b){
				msg += '<li>'+b+'</li>';
			});
			el.dialogTable.message.html(msg+'</ul>');
			// Ocultamos el formulario.
			el.dialogTable.formTable.hide();
			// Mostramos la barra de mensajes.
			el.dialogTable.message.show();
			// Abrimos la ventana de dialogo. 
			el.dialogTable.dialog('open');
			// Recargamos la página.
			loadData(beforeTable, errorTable, successTable, settings, settings.url);
		}

		var successSelect = function(data){
			if(loadSelect(data)){
				settings.action = 'table';
				settings.table = el.controls.selectTable.val();				
				loadData(beforeTable, errorTable, successTable, settings, settings.url);
			} else {
				alert('No se ha podido cargar contenido');
			}
		}

		var successTable = function(data){
			if (loadTable(data)) {
				setStructTable();
				activeControls(false);
			};
		}

		/*
		 * Prepara una consulta para modificar un registro.
		 */
		var updateRow = function(){
			// Cargamos los valores del registro seleccionanda.
			loadRow();
			// Cerramos el menucontextual.
			hiddenMenu();
			// Establecemos la acción de la petición.
			el.dialogTable.formTable.actionForm.attr('value', 'update');
			// Activamos los campos del formulario.
		 	el.dialogTable.formTable.contentForm.find('input[type="text"]').each(function(){
		 		$(this).prop('disabled', false);
		 	});			
			// Obtenemos los valores iniciales del registro a modificar.
			query = el.dialogTable.formTable.serialize();
			// Asignamos el titulo
		 	el.dialogTable.dialog('option', 'title', 'Modificar registro.');
			// Mostramos el formulario.
			el.dialogTable.dialog("open");
		}

		init();

	};

}(jQuery));