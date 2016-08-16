@extends('layouts.app')

@section('content')
	<div class="container">
	<div class="page-header">
		<h1>
			 Usuarios
			{{ link_to_route('users.create', 'Crear Nuevo Usuario','' ,
													array('class' => 'ui primary button right floated')) }}
		</h1>

		<br>

		{!!Html::script('js/buscador.js')!!}

	</div>

	<div class="col-sm-3 col-md-3 pull-right">
		<div class="form-group has-feedback">
	    <label class="control-label">Buscador</label>
	    <input type="text" class="form-control" id="buscar" onkeyup="buscador()" placeholder="Buscar..." />
	    <i class="glyphicon glyphicon-search form-control-feedback"></i>
	</div>
	</div>
	<br>
	<br>
	<br>
	<br>

	<table class="table table-hover" id="datos">
		<thead>
			<th>Nombre</th>
			<th>Email</th>
			<th>Fecha Reg.</th>
			<th>Accion</th>
		</thead>
		@foreach($user as $user)
			<tbody>
				<td> {{ $user->name }}</td>
				<td> {{ $user->email }}</td>
				<td> {{ $user->created_at }}</td>
				<td>
				<a href="{{ route('users.edit', ['id' => $user->id]) }}" class="ui green button">Editar</a>
				</td>
				<td>
				{{ Form::open(['route' => ['users.destroy', $user->id ], 'method'=>'DELETE']) }}
					<button type="submit" class="ui red button">Eliminar</button>
				{{ Form::close() }}
				</td>
			</tbody>
		@endforeach
	</table>

	</div>
@endsection
