@extends('layouts.app')

@section('content')
<div class="container">
	<br>
		<div class="page-header">
		  <h1>
        	Crear Album
				<a class="ui button right floated" href="{!!URL::to('/albums')!!}" >Cancelar</a>
				<button id="btn-save-area" class="ui primary button right floated">Guardar</button>
		  </h1>
	 </div>

		  <br>
		  <div class="panel-body">
		    {!! Form::open(['route'=>'albums.store' ,'files' => true, 'method'=>'POST',  'id'=>'create-area-form']) !!}
				@include('album/forms/form')

			{!! Form::close()!!}
		  </div>

	<script type="text/javascript">
		$('#btn-save-area').click(function(){
			$("#create-area-form").submit();
		});
	</script>
</div>
@endsection
