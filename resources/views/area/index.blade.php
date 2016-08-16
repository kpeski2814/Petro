@extends('layouts.app')

@section('content')
	<div class="container">
	<div class="page-header">
		<h1>
			 Areas
			{{ link_to_route('areas.create', 'Crear Nueva Area','' ,
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
			<th>Abreviacion</th>
			<th>Accion</th>
		</thead>
		@foreach($area as $area)
			<tbody>
				<td> {{ $area->name }}</td>
				<td> {{ $area->description }}</td>
				<td>
				@if($area->status == 1)
					Activo
				@else
					Inactivo
				@endif
				 </td>
				<td> {{ $area->abbrev }}</td>
				<td>
				<a href="{{ route('areas.edit', ['id' => $area->id]) }}" class="ui green button">Editar</a>
				</td>
				<td>
				{{ Form::open(['route' => ['areas.destroy', $area->id ], 'method'=>'DELETE']) }}
					<button type="submit" class="ui red button" onclick="return confirm('Deseas eliminar este registro?')">Eliminar</button>
				{{ Form::close() }}
				</td>
			</tbody>
		@endforeach
	</table>

	</div>
@endsection
