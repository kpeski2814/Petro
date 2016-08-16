@extends('layouts.app')

@section('content')

<div class="container" >
{!! Form::open(['route'=>'uncataloged.store', 'enctype' => 'multipart/form-data','method'=>'POST']) !!}

	{{ Form::label('Descripcion') }}
	{{ Form::text('description', null , ['class'=>'form-control']) }}

	{!!Form::label('Image')!!}
	<input type="file" name="path[]" multiple="">

	{!!Form::label('Video')!!}
	<input type="file" name="video">
	<div id="image-container">

	</div>
	{{ Form::submit('go' , ['class' => 'btn btn-warning'])}}

{!! Form::close()!!}


</div>

@endsection
