<div class="col-md-3">
  <input type="button" name="name" value="" hidden="">
</div>

<div class="col-md-6">

  <div class="form-group">
    <div class="ui form">
      <div class="required field">
        {{ Form::label('Tipo')}}
      </div>
    </div>
    <select class="form-control" name="type">
      <option selected="" disabled="">--Seleccionar--</option>
      @if(isset($tag->type))
        @if($tag->type == 1)
          <option value="1" selected="">Etiqueta</option>
          <option value="0">Personaje</option>
        @else
          <option value="0" selected="">Personaje</option>
          <option value="1">Etiqueta</option>
        @endif
      @else
        <option value="0">Personaje</option>
        <option value="1">Etiqueta</option>
      @endif
    </select>
  </div>

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
  @if(isset($tag->description))
    <textarea name="description" class="form-control" rows="5" cols="40">{{ $tag->description }}</textarea>
  @else
    <textarea name="description" class="form-control" rows="5" cols="40"></textarea>
  @endif
</div>

<div class="form-group">
	{{ Form::label('Estado')}}
	<select name="status" class="form-control">
		<option selected="" disabled="">-- Seleccionar --</option>
		@if(isset($tag->status))
			@if($tag->status == 1)
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