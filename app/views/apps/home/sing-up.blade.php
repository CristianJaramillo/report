{{-- APLICATION REGISTER --}}
@section('app')
	{{ Form::open(["class" => "form-contact", "id" => "sing-up", "method" => "POST", "role" => "form", "route" => "register"]) }}
		<fieldset>
			<legend>Registro</legend>
			{{-- FULL NAME --}}
			{{ Field::text('full_name', NULL, ['id' => 'name', 'required']) }}
			{{-- USERNAME --}}
			{{ Field::text('username', NULL, ['id' => 'username', 'required']) }}
			{{-- PASSWORD --}}
			{{ Field::password('password', ['id' => 'password', 'required']) }}
			{{-- CONFIRM PASSWORD --}}
			{{ Field::password('password_confirmation', ['id' => 'password', 'required']) }}
			{{-- EMAIL --}}
			{{ Field::email('email', NULL, ['id' => 'email', 'required']) }}
			{{-- CONFIRM EMAIL --}}
			{{ Field::email('email_confirmation', NULL,['id' => 'email_confirmation', 'required']) }}
			{{-- CATEGORY --}}
			{{ Field::select('category_id', $categories, NULL, ['id' => 'category_id', 'required']) }}
			{{-- DEPARTAMENT --}}
			{{ Field::select('departament_id', $departaments, NULL, ['id' => 'departament_id', 'required']) }}
			{{-- SUBMIT --}}
			<div class="line-form">
				<input class="button-ipn" type="submit" name="resgistro_btn" value="Resgistrarse" />
			</div>
		</fieldset>
	{{ Form::close() }}
@endsection