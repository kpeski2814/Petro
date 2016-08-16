@extends('layouts.app')

@section('content')

<div class="container" >
{!! Form::open(['action'=>'UncatalogedController@resize', 'enctype' => 'multipart/form-data','method'=>'POST']) !!}

	{{ Form::label('Descripcion') }}
	{{ Form::text('description', null , ['class'=>'form-control']) }}

	{!!Form::label('Archivos')!!}
	<input type="file" name="path[]" multiple="">

  {{ Form::label('Tipo') }}
  <select class="form-control" name="type_id">
    <option selected="" disabled="">option</option>
    @foreach($type as $type)
      <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
  </select>
  <br>
  {{ Form::submit('Subir Archivos' , ['class' => 'btn btn-warning'])}}
</div>



{!! Form::close()!!}
</div>

@endsection
