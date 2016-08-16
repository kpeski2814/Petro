@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Ver Archivos Catalogados
          <a class="ui primary button right floated" href="{!!URL::to('/cataloged')!!}" >Regresar</a>
          <button class="ui red button right floated" id="delete-files">Eliminar Archivos</button>
          <button class="ui yellow button right floated" id="download-files">Descargar Archivos</button>
        </h1>
    </div>

    @if(count($result) == 0)
      <div class="ui negative message">
          <i class="close icon"></i>
          <div class="header">
            Resultado de Busquedas : {{ count($result) }}
          </div>
          <p>No se han encontrado archivo con esas especificaciones, intentalo de nuevo.
      </p></div>
      @else
        <div class="ui info message">
            <i class="close icon"></i>
            <div class="header">
              Exito en la busqueda!!
            </div>
            <p>Resultado de Busquedas : {{ count($result) }}.
        </p></div>
    @endif

    {!! Form::open(['action'=>'CatalogedController@selectAction', 'method'=>'POST', 'id'=>'form-files']) !!}

    <h3>Seleccionar Todo :  <input type="checkbox" class="ui checkbox" id="select_all"/></h3>
    <input type="text" id="action-value" name="action-value" value=""><br><br>
  @foreach($result as $result)

      @if(isset($result[0]))

        @foreach($result as $res)

          <div class="col-md-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <label>Nombre de Archivos</label>
                <input type="text" class="form-control" value="{{ $res->files->name }}" disabled>

                <label>Ruta del archivo</label>
                <input type="text" class="form-control" value="{{ $res->files->real_path }}" disabled="">

                <label>Archivo</label><br>
                @if($res->files->type_id == 1)
                  <img src="/thumb/{{ $res->files->name }} " width="110px" height="110px"><br>
                  <a href="/details/{{$res->files->id }}/view" class="mini ui primary button">Ver Detalle</a>
                  <a href="/download/{{ $res->files->name }}" class="mini ui primary button">Descargar</a><br>
                  @else
                  <img src="/thumb/{{ $res->files->name }} " width="110px" height="110px"><br>
                  <a href="/videos/{{$res->files->id}}/options" class="ui tiny primary button" >Personalizar</a>
                @endif
                <input type="checkbox" name="catalog[]" value="{{ $res->files->name }}">
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-md-4">
          <div class="panel panel-default">
      <div class="panel-body" >
        <label>Nombre Archivos</label>
        <input type="text" class="form-control" value="{{ $result->name }}" disabled="">

        <label>Ruta real del archivo</label>
        <input type="text" class="form-control" value="{{ $result->real_path }}" disabled="">

        <label>Archivo</label><br>
        @if($result->type_id == 1)
          <img src="/thumb/{{ $result->name }} " width="110px" height="110px"><br><br>
          <a href="{{ url("/details/$result->id/view") }}" class="mini ui primary button">Ver Detalle</a>
          @else
            <?php $explode = explode('.', $result->name); ?>
          <img src="/thumb/{{$explode[0]}}.jpg" width="110px" height="110px"><br><br>
          <a href="/videos/{{$result->id}}/options" class="ui tiny primary button" >Personalizar</a>
        @endif

      <input type="checkbox" name="catalog[]" value="{{ $result->name }}">
      </div>
      </div>
        </div>
        @endif

      @endforeach
{!! Form::close() !!}
</div>

<script type="text/javascript">
$('#select_all').change(function() {
  var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
  if($(this).is(':checked')) {
      checkboxes.prop('checked', true);
  } else {
      checkboxes.prop('checked', false);
  }
});


  $('#download-files').click(function(){
    var text = 'download';
    $("#action-value").val(text);
    $('#form-files').submit();
  });

  $('#delete-files').click(function(){
    var text = 'delete';
    $("#action-value").val(text);
    $('#form-files').submit();
  });
</script>
@endsection
