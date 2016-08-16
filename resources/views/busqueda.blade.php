@extends('layouts.app')

@section('content')

    <div class="container">

      <h2>Buscador de imagenes/Videos</h2>

      <div class="col-md-4">

      <div class="form-group">
        <label>Buscar</label>
        <input type="text" name="name" class="form-control" placeholder="Ingresar Busqueda">
      </div>

      <div class="form-group">
        <label>Tipo</label>
        <select class="form-control" id="type" name="type">
          <option disabled="" selected="">Seleccionar Tipo</option>
          @foreach($type as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label>Formato</label>
          <select class="form-control" name="format" id="format">
          </select>
      </div>

      <div class="form-group">
        <label>Fecha de Creacion</label>
        <input type="text" name="fecha" class="form-control" placeholder="Ingresar Busqueda por Fecha">
      </div>

      <div class="form-group">
        <label class="checkbox-inline"><input type="checkbox" value="">Option 1</label>
        <label class="checkbox-inline"><input type="checkbox" value="">Option 2</label>
      </div>

      <div class="form-group">
        <label for="">Autor</label>
        <input type="text" class="form-control" name="autor" placeholder="Ingresar Busqueda por autor">
      </div>

    </div>

</div>

<script>
    $('#type').on('change',function(e){
        console.log(e);
        var type_id = e.target.value;

        //ajax
        $.get('/ajax-format?type_id=' +type_id, function(data){
            $('#format').empty();
          $.each(data , function (index, format) {
            $('#format').append('<option value="'+format.id+'">'+format.name+'</option>');
          });
        });
    });
</script>
@endsection
