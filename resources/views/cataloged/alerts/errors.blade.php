<br>
@if(count($errors) > 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<p><strong>Parece que tenemos algunos errores...</strong></p>
		<ul>
			@foreach($errors->all() as $error)
				<li>{!!$error!!}</li>
			@endforeach
		</ul>
	</div>
@endif
