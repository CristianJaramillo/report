@section('menu')
	<ul class="left menu" id="social-menu">
		<li><span class="facebook"></span></li>
		<li><span class="google"></span></li>
		<li><span class="twitter"></span></li>
		<li><span class="youtube"></span></li>
	</ul>
	<ul class="menu right" id="primary-menu">
		<li><a href="{{ asset('') }}">Entrar</a></li>
		<li><a href="{{ asset('sing-up') }}">Registro</a></li>
		<li><a href="{{ asset('restore') }}">Restaurar</a></li>
		<li><a href="{{ asset('help') }}">Ayuda</a></li>
	</ul>
@endsection