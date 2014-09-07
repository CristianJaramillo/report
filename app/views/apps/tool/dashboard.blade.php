{{-- APLICATION LOGIN --}}
@section('app')
	<table class="table table-striped">
		<head>
			<tr>
	            <th>Nombre</th>
	            <th>Username</th>
	            <th>Email</th>
	            <th>Departamento</th>
	            <th>Categoria</th>
	            <th>Cuenta</th>
	        </tr>
		</head>
		<tbody>
			@foreach ($users as $user)
		        <tr>
		            <td>{{ $user->full_name }}</td>
		            <td>{{ $user->username }}</td>
		            <td>{{ $user->email }}</td>
		            <td>{{ $user->departament_id }}</td>
		            <td>{{ $user->category_id }}</td>
		            <td>{{ $user->user_type }}</td>
		        </tr>
	        @endforeach
		</tbody>
    </table>
@endsection