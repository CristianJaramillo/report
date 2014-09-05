{{-- APLICATION RESTORE --}}
@section('app')
	{{ Form::open(['class' => 'form-contact', 'id' => 'sing-in', 'method' => 'POST', 'role' => 'form', 'route' => 'recover']) }}
		<fieldset>
			<legend>Restaurar Contraseña</legend>
			{{-- USERNAME --}}
			{{ Field::text('username', NULL, ['id' => 'username', 'required']) }}
			{{-- EMAIL --}}
			{{ Field::email('email', NULL, ['id' => 'email', 'required']) }}
			{{-- SUBMIT --}}
			<div class="inline-form">
				<input class="button-ipn" type="submit" value="Ingresar"/>
				<a class="right" href="{{ route('sing-up') }}">Registrate aqui!</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection