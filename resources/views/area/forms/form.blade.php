<div class="col-md-6">

<div class="form-group">
  <div class="ui form">
    <div class="required field">
	     <label>Nombre</label>
    </div>
  </div>
	{!! Form::text('name', null ,['class'=>'form-control']) !!}
</div>

<div class="form-group">

<label>Descripcion</label>
	{!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Ingresar Descripcion','size'=>'30x5'])!!}
</div>
</div>

<div class="col-md-6">

<div class="form-group">
@if(isset($area->status))
	<label>Estado</label>
	<select class="form-control" name="status" id="status">
		<option selected="" disabled="">-- Elegir Estado --</option>
		@if($area->status == 1)
			<option value="1" selected="">Activo</option>
			<option value="0">Inactivo</option>
		@else
			<option value="1">Activo</option>
			<option value="0" selected="">Inactivo</option>
		@endif
	</select>
@else
	<label>Estado</label>
	<select class="form-control" name="status" id="status">
		<option value="1" selected="">Activo</option>
		<option value="0">Inactivo</option>
	</select>
@endif
</div>

<div class="form-group">
	<label>Abreviacion</label>
	{{ Form::text('abbrev',null,['class'=>'form-control']) }}
</div>
<br>
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