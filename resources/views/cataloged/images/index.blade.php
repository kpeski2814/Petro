@extends('layouts.app')

@section('content')

    <div class="container">

      <div class="page-header">
        <h2>Ver detalle de Archivo</h2>
        
        <a href="/images/{{ $detail[0]->name }} " class="tiny ui primary button" target="_blank"><i class="unhide icon"> </i> Ver Ampliacion </a>
        <a href="/download/{{ $detail[0]->name }}" class="tiny ui primary button"><i class="download icon"> </i>Descargar</a><br>
      </div>

          @foreach($detail as $file)

          @endforeach
          <div class="col-md-6">

            <input type="text" class="form-control" name="name" value="{{ $file->id }}" hidden="">
            @if($file->type_id == 1)
              <label> Archivo </label><br>
              <img src="/images/{{ $file->name }}" width="250px" height="250px" title="Tamaño: {{ $data[0] }}KB , Dimensiones: {{ $data[1]}}"><br>
              <br>
            @endif

            <label>Etiquetas asociadas</label><br>
            @foreach($tags as $tag)

              @if($tag->tags->type == 'Personaje')
                 <p class="ui green tag label">{{ $tag->tags->name }}</p>
                @else
                  <p class="ui teal tag label">{{ $tag->tags->name }}</p>
              @endif

            @endforeach
            <br>
            <br>
            <label>Nombre de Archivo</label>
            <input type="text" class="form-control" value="{{ $file->name }}" disabled="">

            <br>

            <div class="form-group">
              <label>Ruta del archivo</label>
              <input type="text" class="form-control" value="{{ $file->real_path }}" disabled="">
            </div>
            <br>
          </div>

          <div class="col-md-6">
            <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" rows="2" disabled=""> {{ $file->description }} </textarea>
            </div>

             <div class="form-group">
               <label>Titulo de Evento</label>
               <input type="text" class="form-control" value="{{ $file->event_title }}" disabled="">
             </div>

             <div class="form-group">
               <label>Fecha de Evento</label>
               <input type="text" class="form-control" value="{{ $file->event_date }}" disabled="">
             </div>

             <div class="form-group">
               <label>Lugar</label>
               <input type="text" class="form-control" value="{{ $file->place }}" disabled="">
             </div>

             <div class="form-group">
               <label>Autor</label>
               @if(isset($file->author_id))
                 <input type="text" class="form-control" value="{{ $file->authors->name }}" disabled="">
               @else
                 <input type="text" class="form-control" value="" disabled="">
               @endif

             </div>

             <div class="form-group">
               <label>Area</label>
               @if(isset($file->area_id))
                  <input type="text" class="form-control" value="{{ $file->areas->name }}" disabled="">
               @else
                   <input type="text" class="form-control" value="" disabled="">
               @endif

             </div>

             <div class="form-group">
              {{ Form::label('Album')}}
              @if(isset($file->album_id))
                 <input type="text" class="form-control" value="{{ $file->album_name}}" disabled="">
              @else
                  <input type="text" class="form-control" value="" disabled="">
              @endif

             </div>

          </div>

    </div>

@endsection
