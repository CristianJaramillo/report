			</div>
			<div id="footer">
				<h6>
					<span>Sistema de Reportes desarrollado para el <a href="http://www.cecyt8.ipn.mx/Paginas/inicio.aspx">CECyT No.8 "Narciso Bassols"</a></span>
					<span>por la <a href="#">UTEyCV</a>, iniciado el lunes 17 de Septiembre de 2013.</span>
				</h6>
			</div>
		</div>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery.js"></script>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/jquery-ui.js"></script>
		<script src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>js/start.js"></script>
		<script>
			
			$(document).on('ready', start);
			
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
				$('#wapper').startUX();
				$('a, span, input').addClass('ease');
			};

		</script>
	</body>
</html>