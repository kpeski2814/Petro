@extends('layouts.app')

@section('content')
	<div class="container">

	<div class="page-header">
		<h1>
			Editar Autor
			<a class="btn btn-default pull-right" href="{!!URL::to('/authors')!!}" >Cancelar</a>
			<button id="btn-save-rentals" class="btn btn-default pull-right">Guardar</button>
		</h1>
	</div>
	<br>
	{!! Form::model($autor,['route'=>['authors.update',$autor->id] , 'method'=>'PUT', 'id'=>'edit-rentals-form']) !!}
		@include('author/forms/form')
	{!! Form::close()!!}

<script type="text/javascript">
	$('#btn-save-rentals').click(function(){
		$("#edit-rentals-form").submit();
	});
</script>

</div>
@endsection
