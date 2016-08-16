@extends('layouts.app')

@section('content')
<div class="container">
	<div class="page-header">
		<h1>
			Editar Usuario
			<a class="ui button right floated" href="{!!URL::to('/users')!!}" >Cancelar</a>
			<button id="btn-save-equipment" class="ui primary button right floated">Guardar</button>
		</h1>
	</div>
	<br>
	{!! Form::model($user,['route'=>['users.update',$user->id] , 'method'=>'PUT', 'id'=>'edit-equipment-form']) !!}
		@include('user/forms/form')
	{!! Form::close()!!}

<script type="text/javascript">
	$('#btn-save-equipment').click(function(){
		$("#edit-equipment-form").submit();
	});
</script>
</div>
@endsection
