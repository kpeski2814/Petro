@extends('layouts.app')

@section('content')
	<div class="container">
	<div class="page-header">
		<h1>
			 Albumes
			{{ link_to_route('albums.create', 'Crear Nuevo Album','' ,
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
			<th>Descripcion</th>
			<th>Estado</th>
			<th>Accion</th>
		</thead>
		@foreach($album as $album)
			<tbody>
				<td> {{ $album->name }}</td>
				<td> {{ $album->description }}</td>
				<td>
					@if($album->status == 1)
						 Activo
					@else
						Inactivo
					@endif
			  </td>
				<td>
				<a href="{{ route('albums.edit', ['id' => $album->id]) }}" class="ui button green">Editar</a>
				</td>
				<td>
				{{ Form::open(['route' => ['albums.destroy', $album->id ], 'method'=>'DELETE' , 'id'=>'delete-form']) }}
        <button type="submit" class="ui red button" onclick="return confirm('Deseas eliminar este registro?')">Eliminar</button>
        {{ Form::close() }}
				</td>
			</tbody>
		@endforeach
	</table>

	</div>

@endsection
