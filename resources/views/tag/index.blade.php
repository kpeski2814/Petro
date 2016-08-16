@extends('layouts.app')

@section('content')
	<div class="container">
	<div class="page-header">
		<h1>
			 Etiquetas/Personajes
			{{ link_to_route('tags.create', 'Crear Nueva etiqueta/personaje','' ,
													array('class' => 'ui right floated primary button')) }}
													<br>
			<a href="{{ url('/tag/csv') }}" class="ui tiny primary button">Carga masiva</a>
		</h1>
		{!!Html::script('js/buscador.js')!!}
	</div>

	<div class="col-sm-3 col-md-3 pull-right">
		<div class="form-group has-feedback">
	    <label class="control-label">Buscador</label>
	    <input type="text" class="form-control" id="buscar" onkeyup="buscador()" placeholder="Buscar..." />
	    <i class="glyphicon glyphicon-search form-control-feedback"></i>
	</div>
	</div>

	<table class="table table-hover" id="datos">
		<thead>
			<th>Nombre</th>
			<th>Descripción</th>
      <th>Tipo</th>
			<th>Estado</th>
			<th>Acción</th>
		</thead>
		@foreach($tags as $tag)
			<tbody>
				<td>{{  $tag->name }}</td>
				<td>{{ $tag->description }}</td>
        <td>{{ $tag->type }}</td>
				<td>{{ $tag->status }}</td>
				<td>
				<a href="{{ route('tags.edit', ['id' => $tag->id]) }}" class="ui green button">Editar</a>
				</td>
				<td>
				{{ Form::open(['route' => ['tags.destroy', $tag->id ], 'method'=>'DELETE']) }}
					<button type="submit" class="ui red button" onclick="return confirm('Deseas eliminar este registro?')">Eliminar</button>
				{{ Form::close() }}
				</td>


			</tbody>
		@endforeach
	</table>
  	<center>{{ $tags->links() }}</center>
	</div>
@endsection
