<div class="col-md-3">
  <input type="button" name="name" value="" hidden="">
</div>
<div class="col-md-6">

  <div class="form-group">
    <div class="ui form">
      <div class="required field">
  	     <label>Nombre</label>
      </div>
    </div>
  	{{ Form::text('name',null,['class'=>'form-control']) }}
  </div>

  <div class="ui form">

  <div class="two fields">
    <div class="field">
      <div class="required field">
        <label> Apellido Paterno</label>
      </div>
    	{{ Form::text('lastnamep',null,['class'=>'form-control']) }}
    </div>
    <div class="field">
      <label> Apellido Materno </label>
    	{{ Form::text('lastnamem',null,['class'=>'form-control']) }}
    </div>
  </div>
  </div>

  <div class="form-group">
    {{ Form::label('Numero Telefonico') }}
    {{ Form::text('phone_number' ,null , ['class'=>'form-control']) }}
  </div>

  <div class="form-group">
  	{{ Form::label('Estado')}}
  	<select name="status" class="form-control">
  		<option selected="" disabled="">-- Seleccionar --</option>
  		@if(isset($autor->status))
  			@if($autor->status == 1)
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

  <div class="form-group">
    {{ Form::label('descripcion') }}
    {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Ingresar Descripcion','size'=>'30x5'])!!}
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