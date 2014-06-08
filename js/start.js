(function($){
	/*
	 * Inicializa la estructura de la aplicación y maneja los menus
	 * del documento.
	 */
	$.fn.startUX = function(){

		if (this.length==0) {return 0;};

		el = this;

		var hiddenMenu = function(){
			if ($(this).outerWidth() > 767) {
				el.section.nav.css('right', - el.section.nav.outerWidth());
			} else{
				if (el.section.nav.css('right')!='0px') {
					el.section.nav.css('right', - el.section.nav.outerWidth());
				}
			} 
		};

		var init = function(){
			// Cargamos la estructura de nodos.
			setStruct();
			// Establecemos las dimenciones iniciales de la aplicación.
			setHeight();
			// Agregamos sus funciones alos elementos.
			setFunctions();
		};

		var setFunctions = function(){
			if (el.section.panel != undefined) {
				$(window).on('resize', setHeight);
				if (el.section.panel.find('input[type="submit"]').length) {
					el.section.panel.btnSubmit = el.section.panel.find('input[type="submit"]');
				}
			}
			if (el.section.nav != undefined) {
				el.header.menuMovile.on('click', showMenu);
				$(window).on('resize', hiddenMenu);
			}
		};

		var setHeight = function(){
			var h = parseInt(el.section.panel.css('margin-top')) * 2;
			h += el.section.panel.outerHeight();
			el.section.height(h + 10);
			if (el.outerHeight() < $(window).outerHeight()) {
				h = $(window).outerHeight() - el.outerHeight() + h;
				if (h < 196) {
					console.log(h);
					h = 196;
				};
				console.log(h);
				el.section.height(h);				
			}
		};

		var setStruct = function(){
			if (el.find('#header').length) {
				el.header = el.find('#header');
				if (el.header.find('a.nav-icon').length) {
					el.header.menuMovile = el.header.find('a.nav-icon');
				}
			}
			if (el.find('#container').length) {
				el.section = el.find('#container');
				if (el.section.find('form.form-contact').length) {
					el.section.panel = el.section.find('form.form-contact');
					// validaciones para login.
				} else if(el.section.find('#app')){
					el.section.panel = el.section.find('#app');
				}
				// Menu de navegación movil.
				if (el.section.find('#nav-movile').length) {
					el.section.nav = el.section.find('#nav-movile');
				}
			}
			if (el.find('#footer').length) {
				el.footer = el.find('#footer');
			}
		};


		var showMenu = function(event){

			event.preventDefault();
			
			var right = 0;

			if (el.section.nav.css('right') == '0px') {
				right -= el.section.nav.outerWidth();
			}

			el.section.nav.animate({'right': right}, 500);
		
		};

		init();

	};

})(jQuery);