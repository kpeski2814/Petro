@extends('layouts.app')

@section('content')

<div class="container">
	<br>
		<div class="page-header">
		  <h1>
        	Crear Area

				<a class="ui button right floated" href="{!!URL::to('/areas')!!}" >Cancelar</a>
				<button id="btn-save-area" class="ui primary button right floated">Guardar</button>
		  </h1>
	 </div>
	 	@include('area.alerts.errors')
		  <br>
		  <div class="panel-body">
		    {!! Form::open(['route'=>'areas.store' , 'method'=>'POST',  'id'=>'create-area-form']) !!}
				@include('area/forms/form')

			{!! Form::close()!!}
		  </div>



	<script type="text/javascript">
		$('#btn-save-area').click(function(){
			$("#create-area-form").submit();
		});
	</script>
</div>
@endsection
