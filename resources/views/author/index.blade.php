@extends('layouts.app')

@section('content')
<div class="container">

	<div class="page-header">
		<h1>
			 Autores
			{{ link_to_route('authors.create', 'Crear nuevo Autor','' , array('class' => 'ui primary button right floated')) }}
				{!!Html::script('js/buscador.js')!!}
		</h1>
	</div>

	<div class="col-sm-3 col-md-3 pull-right">
		<div class="form-group has-feedback">
	    <label class="control-label">Buscador</label>
	    <input type="text" class="form-control" id="buscar" onkeyup="buscador()" placeholder="Buscar..." />
	    <i class="glyphicon glyphicon-search form-control-feedback"></i>
		</div>
	</div>

	<table class="table table-hover">
		<thead>
			<th>Nombre</th>
			<th> Apellidos</th>
			<th> Telefono</th>
			<th> Descripcion </th>
			<th> Estado </th>
			<th> Accion </th>
		</thead>
		@foreach($autor as $autor)
			<tbody>
					<td>{{ $autor->name }}</td>
				  <td>{{ $autor->full_name }}</td>
					<td>{{ $autor->phone_number}}</td>
					<td>{{ $autor->description }}</td>
					<td>
						@if($autor->status == 1)
							Activo
							@else
							Inactivo
						@endif </td>
					<td>
					<a href="{{ route('authors.edit', ['id' => $autor->id]) }}" class="ui green button">Editar</a>
					</td>
					<td>
					{{ Form::open(['route' => ['authors.destroy', $autor->id ], 'method'=>'DELETE']) }}
						<button type="submit" class="ui red button" onclick="return confirm('Deseas eliminar este registro?')">Eliminar</button>
					{{ Form::close() }}
					</td>
			</tbody>
  	@endforeach

	</table>

</div>
@endsection
