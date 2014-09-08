{{-- links  --}}
@section('before-links')
	<!-- Bootstrap core CSS -->
    <!--link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/-->
@endsection
{{-- links  --}}
@section('after-links')
	<!-- Custom styles for this template -->
    <link href="{{ asset('css/tools/dashboard/dashboard.css') }}" rel="stylesheet"/>
@endsection
{{-- APLICATION LOGIN --}}
@section('app')
	<div class="container">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Username</th>
					<th>Email</th>
					<th>Cuenta</th>
					<th>Categoria</th>
					<th>Departamento</th>
					<th>Ver</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr>
					    <td>{{ $user->full_name }}</td>
					    <td>{{ $user->username }}</td>
					    <td>{{ $user->email }}</td>
					    <td>{{ $user->user_type }}</td>
					    <td>{{ $user->category->name }}</td>
					    <td>{{ $user->departament->name }}</td>
					    <td><a class="btn btn-primary">ver</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<!--div class="table-responsive">
		
	</div-->
@endsection