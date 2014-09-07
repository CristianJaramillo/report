<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="@yield('lang', 'es')"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>@yield('title', 'Sistema de Reportes')</title>
        <meta name="description" content="@yield('description', 'Sistema para el control de la asignación de reportes a los técnicos disponibles.')">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
       	<link type="text/plain" rel="author" href="{{ asset('humans.txt') }}" />
        <link href="http://reportuteycv.esy.es/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
        @yield('before-links')
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
        <link href='http://fonts.googleapis.com/css?family=Black+Ops+One' rel='stylesheet' type='text/css'/>
        <!--link rel="stylesheet" href="{{ asset('css/normalize.min.css') }}"-->
        <link rel="stylesheet" href="{{ asset('css/main.css') }}"/>
        @yield('after-links')
	</head>
	<body id="wrapper">
		<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		<header>
			<div id="header-title">
				<img class="logo-report" src="{{ asset('img/logo-report.png') }}"/>
				<span class="title">
					<a href="http://www.ipn.mx/Paginas/inicio.aspx">
						Instituto Polit&eacute;cnico Nacional
						<span>
							"La T&eacute;cnica al servicio de la patria."
						</span>
					</a>
				</span>
				<img class="logo-ipn" src="{{ asset('img/logo-ipn.png') }}">
			</div>
			<nav id="header-menu" status="show">
				<ul class="left menu" id="social-menu">
					<li><span class="facebook"></span></li>
					<li><span class="google"></span></li>
					<li><span class="twitter"></span></li>
					<li><span class="youtube"></span></li>
				</ul>
				<ul class="menu right" id="movile-menu">
					<li><a id="nav-icon" href="#movile-menu"></a></li>
				</ul>
				@yield('menu')
			</nav>
		</header>
		<section id="container">
			<section class="panel">
				<div id="app">
					@yield('app')
				</div>
			</section>
		</section>
		<footer>
			<h6>
				<span>Sistema de Reportes desarrollado para el <a href="http://www.cecyt8.ipn.mx/Paginas/inicio.aspx">CECyT No.8 "Narciso Bassols"</a></span>
				<span>por la <a href="#">UTEyCV</a>, iniciado el lunes 17 de Septiembre de 2013.</span>
			</h6>
		</footer>
		@yield('before-scripts')
		@section('main-scripts')
			<script src="{{ asset('js/json2.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('js/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('js/jstorage.min.js') }}" type="text/javascript"></script>
			<script src="{{ asset('js/start.js') }}" type="text/javascript"></script>
		@show
		@yield('after-scripts')
		@section('start-scripts')
			<script type="text/javascript">

				$(document).on('ready', start);

				function start(){
					@section('action-script')
						$('#wrapper').startUX();
					@show
				}

			</script>
		@show
	</body>
</html>