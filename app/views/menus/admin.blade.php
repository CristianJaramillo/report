@section('menu')
	<ul class="menu right" id="primary-menu">
		<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
		<li><a href="{{ route('account') }}">Cuenta</a></li>
		<li><a href="{{ route('table-ui') }}">Sistema</a></li>
		<li><a href="{{ route('logout') }}">Salir</a></li>
	</ul>
@endsection