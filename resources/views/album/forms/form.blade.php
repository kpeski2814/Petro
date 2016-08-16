<div class="col-md-6">

<div class="form-group">
  <div class="ui form">
    <div class="required field">
  	   {{ Form::label('Nombre')}}
    </div>
  </div>
	{{ Form::text('name',null,['class'=>'form-control']) }}
</div>

<div class="form-group">
	{{ Form::label('Descripcion')}}
	@if(isset($album->description))
			<textarea name="description" class="form-control" rows="4" cols="40">{{ $album->description }}</textarea>
		@else
			<textarea name="description" class="form-control" rows="4" cols="40"></textarea>
	@endif

</div>

<div class="form-group">
	{{ Form::label('Estado')}}
	<select name="status" class="form-control">
		<option selected="" disabled="">-- Seleccionar --</option>
		@if(isset($album->status))
			@if($album->status == 1)
			<option value="1" selected="">Activo</option>
			<option value="0">Inactivo</option>
			@else
			<option value="1">Activo</option>
			<option value="0" selected="">Inactivo</option>
			@endif
		@else
		<option value="1" selected="">Activo</option>
		<option value="0">Inactivo</option>
		@endif

	</select>
</div>
		<p class="bg-danger"><b>(*)</b>  Es un campo obligatorio.</p>
</div>
		<style type="text/css"> 
		b{ 
		color: red; 
		}
		p{ 
		padding: 8px;
		}
		</style> 
