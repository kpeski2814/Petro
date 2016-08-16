@extends('layouts.app')

@section('content')
<div class="container">
	<br>
		<div class="page-header">
		  <h1>
        	Crear Usuario

				<a class="ui button right floated" href="{!!URL::to('/users')!!}" >Cancelar</a>
				<button id="btn-save-user" class="ui primary button right floated">Guardar</button>
		  </h1>
	 </div>
      @include('user.alerts.errors')
		  <br>
		  <div class="panel-body">
		    {!! Form::open(['route'=>'users.store' , 'method'=>'POST',  'id'=>'create-user-form']) !!}
				{{ csrf_field() }}
				@include('user/forms/form')

			{!! Form::close()!!}
		  </div>



	<script type="text/javascript">
		$('#btn-save-user').click(function(){
			$("#create-user-form").submit();
		});
	</script>
</div>
@endsection
