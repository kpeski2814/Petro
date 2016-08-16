@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h2> Busqueda de Archivos Catalogados
      <input type="button" class="ui right floated primary button" id="btn-save-cataloged" value="Buscar">
    </h2>

  </div>
  @include('alerts.success')
  @include('alerts.error')
  @include('cataloged.alerts.errors')

  {!! Form::open(['action'=>'CatalogedController@findby','method'=>'POST' , 'id'=>'form-search-cataloged']) !!}

  <label> Tipo de archivo</label>
  <br>
  <label class="radio-inline"><input type="radio" name="optradio" value="img">Imagenes</label>
  <label class="radio-inline"><input type="radio" name="optradio" value="vid">Videos</label>
  <label class="radio-inline"><input type="radio" name="optradio" value="both" checked>Ambos</label>

  <br>
  <br>

<div class="col-md-6">

<div class="ui form">
  <label>Fecha de Evento</label>
   <div class="two fields">
     <div class="field">
       <div class="ui tiny label">Fecha Inicio</div>
       <input class="form-control" id="event_start" name="event_start" type="text" readonly="">

     </div>
     <div class="field">
      <div class="ui tiny label">Fecha fin</div>
       <input class="form-control" id="event_end" name="event_end" type="text" readonly="">
     </div>
   </div>

</div>

   <div class="form-group">
     <label>Etiquetas</label>
     <input type="text" class="form-control" name="tag" placeholder="Ingresar busqueda por etiquetas">
   </div>

   <div class="form-group">
     <label>Lugar </label>
     <input type="text" class="form-control" name="place" placeholder="Ingresar Lugar">
   </div>

   <div class="form-group">
     <label>Personajes </label>
     <input type="text" class="form-control" name="character" placeholder="Ingresar Personajes">
   </div>
 </div>

 <div class="col-md-6">

   <div class="form-group">
    <label>Titulo de Evento</label>
    <input type="text" class="form-control" name="title" placeholder="Ingresar titulo de evento">
   </div>

   <div class="form-group">
     <label>Area</label>
     <select class="form-control" name="area">
       <option selected="" disabled="">-- Seleccionar area--</option>
       @foreach($area as $area)
         <option value="{{ $area->id }}">{{ $area->name }}</option>
       @endforeach
     </select>
   </div>

   <div class="form-group">
     <label>Autor</label>
     <select class="form-control" name="author">
       <option selected="" disabled="">-- Seleccionar autor--</option>
       @foreach($author as $author)
              <option value="{{ $author->id }}">{{ $author->real_name }}</option>
       @endforeach
     </select>
   </div>

   <div class="form-group">
     <label>Album</label>
     <select class="form-control" name="album">
       <option selected="" disabled="">-- Seleccionar album--</option>
       @foreach($album as $album)
         <option value="{{ $album->id }}"> {{ $album->name }}</option>
       @endforeach
     </select>
   </div>


    </div>
{{ Form::close() }}
</div>

<script type="text/javascript">
$(function() {
      $( "#event_start" ).datepicker({dateFormat: 'yy-mm-dd'});
      $( "#event_end" ).datepicker({dateFormat: 'yy-mm-dd'});
  });

	$('#btn-save-cataloged').click(function(){
		$("#form-search-cataloged").submit();
	});
</script>
@endsection
