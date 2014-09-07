{{-- APLICATION LOGIN 2011685792 --}}
@section('app')

	{{-- MESSAGE --}}
	@if (Session::has('message'))
		<span class="message {{ Session::get('message') }}">{{ \Lang::get('utils.message.'.Session::get('message')) }}</span>
	@endif

	{{ Form::open(['class' => 'form-contact', 'id' => 'sing-in', 'method' => 'POST', 'role' => 'form', 'route' => 'login']) }}
		<fieldset>
			<legend>Ingresar</legend>
			{{-- USERNAME --}}
			{{ Field::text('username', NULL, ['id' => 'username', 'required']) }}
			{{-- PASSWORD --}}
			{{ Field::password('password', ['id' => 'password', 'required'], 'password') }}
			{{-- REMEMBER --}}
			{{ Field::checkbox('remember', NULL, ['id' => 'remember'], NULL, 'checkbox') }}
			{{-- SUBMIT --}}
			<div class="inline-form">
				<input class="button-ipn" type="submit" value="Ingresar"/>
				<a class="right" href="{{ route('sing-up') }}">Registrate aqui!</a>
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection