@extends('layouts.app')

@section('content')
<div class="container">
	<br>
		<div class="page-header">
		  <h1>
        	Crear Etiquetas/Personajes
				<a class="ui button right floated" href="{!!URL::to('/tags')!!}" >Cancelar</a>
				<button id="btn-save-tag" class="ui right floated primary button">Guardar</button>
		  </h1>
	 </div>

	 @if(Session::has('status'))
	 	<div class="alert alert-danger alert-dismissible" role="alert">
	 		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	 			<span aria-hidden="true">&times;</span>
	 		</button>
	 		<p><strong>Hemos encontrado un error!!</strong> </p>
	 		<ul>
	 			<li>{{ Session::get('status') }}</li>
	 		</ul>
	 	</div>
	 @endif

		  <br>
		  <div class="panel-body">
		    {!! Form::open(['route'=>'tags.store' , 'method'=>'POST',  'id'=>'create-tag-form']) !!}
				@include('tag/forms/form')

			{!! Form::close()!!}
		  </div>



	<script type="text/javascript">
		$('#btn-save-tag').click(function(){
			$("#create-tag-form").submit();
		});
	</script>
</div>
@endsection
