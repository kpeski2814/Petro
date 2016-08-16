@extends('layouts.app')

@section('content')

    <div class="container">

      <div class="page-header">
        <h2>  Ver Detalle
        {{ Form::open(['action'=>'VideoController@change', 'method'=>'POST']) }}
          <input type="text" class="form-control" name="id" value="{{ $videos[0]->id }}" hidden="">
            <button type="submit" class="ui tiny primary button" name="button">Cambiar extension</button>
        {{ Form::close() }}
        </h2>
      </div>

          @foreach($videos as $video)

          @endforeach
          {{ Form::open(['action'=>'VideoController@cut', 'method'=>'POST']) }}
          <div class="col-md-6">

            <input type="text" class="form-control" name="id" value="{{ $video->id }}" hidden="">

            <label>Nombre de Archivo</label>
            <input type="text" class="form-control" value="{{ $video->name }}" disabled="">

            <label>Ruta del archivo</label>
            <input type="text" class="form-control" value="{{ $video->real_path }}" disabled="">

            <label>Titulo del evento</label>
            <input type="text" class="form-control" value="{{ $video->event_title }}" disabled="">

            <label>Fecha del evento</label>
            <input type="text" class="form-control" value="{{ $video->event_date }}" disabled="">

            <label>Lugar</label>
            <input type="text" class="form-control" value="{{ $video->place }}" disabled="">
          </div>

          <div class="col-md-6">
            @if($video->type_id == 2)
            <label> File </label><br>
              <video width="400px" controls>
                  <source src="/videos/{{ $video->name }}" type="video/mp4">
              </video>
              <br>
            @endif
            <br>

            <div class="ui form">

            <div class="two fields">
              <div class="field">
                <label> Desde </label>
                {{ Form::text('desde',null,['class'=>'form-control']) }}
              </div>
              <div class="field">
                <label> Hasta </label>
              	{{ Form::text('hasta',null,['class'=>'form-control']) }}
              </div>
            </div>
            </div>

            <button type="submit" class="ui tiny red button" name="button">Recortar</button>
            <br>
          </div>

          {{ Form::close() }}
          <br>
          <br>
          <br>
          {{ Form::open(['action'=>'VideoController@cut', 'method'=>'POST']) }}
          <div class="col-md-6">
            {{ Form::label('Comentario') }}
            <input type="text" class="form-control" name="name" value="{{ $video->id }}" hidden="">

            {{ Form::textarea('comment',null,['class'=>'form-control','size'=>'30x2']) }}

            <input type="submit" class="ui tiny primary button" value="Agregar Comentario">
          </div>

          <div class="col-md-6">
            {{ Form::label('Minuto' )}}
            {{ Form::text('minute', null , ['class'=>'form-control']) }}
          </div>
          {{ Form::close() }}
    </div>

@endsection
