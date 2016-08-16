@extends('layouts.app')

@section('content')
<div class="container">
	<div class="page-header">
		<h1>
			Editar Etiqueta
			<a class="ui button right floated" href="{!!URL::to('/tags')!!}" >Cancelar</a>
			<button id="btn-save-tag" class="ui primary button right floated">Guardar</button>
		</h1>
	</div>
	<br>
	{!! Form::model($tag,['route'=>['tags.update',$tag->id] , 'method'=>'PUT', 'id'=>'edit-tag-form']) !!}
		@include('tag/forms/form')
	{!! Form::close()!!}

<script type="text/javascript">
	$('#btn-save-tag').click(function(){
		$("#edit-tag-form").submit();
	});
</script>
</div>
@endsection
