@extends('layouts.app')
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')

  <div class="container">
      <div class="page-header">
        <h1  class="ui header">Catalogar Archivos
          <button type="button" class="ui primary button right floated" id="button-form-catalogar">Catalogar Archivos</button>
        </h1>
      </div>

      <div class="ui blue small message">
         Para poder catalogar un archivo debes de completar por lo menos un campo.
      </div>

      {{ Form::open(['route'=>'files.store', 'method'=>'POST', 'id'=>'form-create-catalog']) }}

    <div class="col-md-6">

      <br>
        @foreach($check as $check)
          <input type="text"  name="name[]" value="{{ $check }}" hidden>
        @endforeach

        <input type="text" name="path" value="{{ $path }}" hidden>

        <label>Autor</label>
        <select  id="author" name="author" class="form-control">
          <option selected="" disabled="">-- Seleccionar --</option>
          @foreach($author as $author)
            <option value="{{ $author->id }}">{{ $author->name }} {{$author->lastnamep}}</option>
          @endforeach
        </select>

        <label>Album</label>
        <select  id="album" name="album" class="form-control">
          <option selected="" disabled="">-- Seleccionar --</option>
          @foreach($album as $album)
            <option value="{{ $album->id }}">{{ $album->name }}</option>
          @endforeach
        </select>

        <label>Área</label>
        <select id="area" class="form-control" name="area">
          <option selected="" disabled="">-- Seleccionar --</option>
          @foreach($area as $area)
            <option value="{{ $area->id }}">{{ $area->name }}</option>
          @endforeach
        </select>
        <br>
        <label>Titulo de Evento</label>
        <input type="text" class="form-control" id="title" name="event_title">
        <br>
        <label>Descripcion</label>
        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Ingresar descripcion maximo de 100 caracteres"></textarea>
        </div>

        <div class="col-md-6">
        <br>
        <label>Lugar</label>
        {{ Form::text('place' , null , ['class'=>'form-control'])}}
        <br>
        <label>Fecha del Evento</label>
        <input type="text" class="form-control" id="datepicker" name='event_date' value="">
        <br>
        <label>Etiquetas</label>
        <div id="fuckingshit">
          <div class="ui search" id="tag">
            <div class="ui icon input">
              <input style="width:400px;" class="prompt" type="text"  name="tag[]" placeholder="Busqueda autocompletado para etiquetas">
              <i class="search icon"></i>
            </div>
            <div class="results"></div>
        </div>

        </div>

      <button type="button" id="create-tags" class="ui primary tiny button">Anadir Etiqueta</button>
      <button type="button" id="delete-tags" class="ui red tiny button">Eliminar Etiqueta</button>
      <div id="dynamic-tag">

      </div>
      <br>

      <label>Personajes</label>
      <div class="ui search" id="character">
        <div class="ui icon input">
          <input style="width:400px;" class="prompt" type="text"  name="tag[]" placeholder="Busqueda autocompletado para personajes">
          <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>
    <br>
    <button type="button" id="create-character" class="ui primary tiny button">Anadir Personajes</button>
    <div id="dynamic-character">

    </div>
    <br>

  </div>
    {{ Form::close() }}

  </div>
  </div>

@endsection
<script type="text/javascript">


$(function() {
      $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
  });

$(document).ready(function () {
    $('#tag').search({
        apiSettings: {
            url: '/autocomplete/{query}',
            onResponse: function(results) {
                var response = {
                    results : []
                };
                $.each(results, function(index, item) {
                    response.results.push({
                        title       : item.name,
                        description : item.description
                        //url       : item.html_url
                    });
                });
                return response;
            },
        },
          minCharacters : 3,
    });
});

$(document).ready(function () {
    $('#character').search({
        apiSettings: {
            url: '/autocompleteCharacter/{query}',
            onResponse: function(results) {
                var response = {
                    results : []
                };
                $.each(results, function(index, item) {
                    response.results.push({
                        title       : item.name,
                        description : item.description
                        //url       : item.html_url
                    });
                });
                return response;
            },
        },
          minCharacters : 3,
    });
});

$(document).ready(function(){
   var ctr_ = 0;
   var ids  = [];
   $("#create-tags").click(function(e){
     ctr_++;
     var unique_id = 'tag'+ ctr_;
     ids.push(unique_id);
     console.log(ids);
     $("#dynamic-tag").append($('#tag').clone().addClass(unique_id));
     $('.'+ unique_id).search({
        apiSettings: {
            url: '/autocomplete/{query}',
            onResponse: function(results) {
                var response = {
                    results : []
                };
                $.each(results, function(index, item) {
                    response.results.push({
                        title       : item.name,
                        description : item.description
                        //url       : item.html_url
                    });
                });
                return response;
            },
        },
          minCharacters : 3,
    }).search('set value', '');
   });

   $("#delete-tags").click(function(){
     var size = ids.length;
     var last = ids[size-1];
     var ultimo = ".ui.search."+last;

     $(ultimo).remove();
     ids.splice(size-1,1);

   });
});

$(document).ready(function(){
   var ctr_ = 0;
   $("#create-character").click(function(e){
     ctr_++;
     var unique_id = 'character'+ ctr_;
     $("#dynamic-character").append($('#character').clone().addClass(unique_id));
     $('.'+ unique_id).search({
        apiSettings: {
            url: '/autocompleteCharacter/{query}',
            onResponse: function(results) {
                var response = {
                    results : []
                };
                $.each(results, function(index, item) {
                    response.results.push({
                        title       : item.name,
                        description : item.description
                        //url       : item.html_url
                    });
                });
                return response;
            },
        },
          minCharacters : 3,
    }).search('set value', '');
   });


});


  $(document).ready(function(){
    $("#button-form-catalogar").click(function(){
      $("#form-create-catalog").submit();
    });

       $("#button-form-catalogar").addClass("disabled");

       $( "#title" ).keyup(function() {
          $("#button-form-catalogar").removeClass("disabled");
          $("#button-form-catalogar").toggleClass("disabled", $( "#title" ).val() == "" && $( "#datepicker" ).val() == "");
        });

      $("#tag").keyup(function(){
        $("#button-form-catalogar").removeClass("disabled");
      });

      $("#datepicker").click(function(){
        $("#button-form-catalogar").removeClass("disabled");
      });
      $("#datepicker").keyup(function(){
          $("#button-form-catalogar").toggleClass("disabled", $( "#datepicker" ).val() == "" && $( "#title" ).val() == ""  );
      });

      $("#author").change(function(){
        $("#button-form-catalogar").removeClass("disabled");
      });

      $("#area").change(function(){
        $("#button-form-catalogar").removeClass("disabled");
      });

      $("#album").change(function(){
        $("#button-form-catalogar").removeClass("disabled");
      });






  });
</script>
