@extends('layouts.app')

@section('content')

    <div class="container">

      <div class="page-header">
        <h3>  Ver Detalle  </h3>
      </div>

          @foreach($detail as $file)

          @endforeach
          <div class="col-md-8">

            <label>File id</label>
            <input type="text" class="form-control" name="name" value="{{ $file->id }}" disabled="">

            <label></label>
            <input type="text" class="form-control" value="{{ $file->name }}" disabled="">

            <br>
            @if($file->type_id == 1)
              <label> File </label><br>
              <img src="/images/{{ $file->name }}" width="250px" height="250px" ><br>
              <br>
              @else
                  <label> File </label><br>
              <video width="500px" controls>
                  <source src="/videos/{{ $file->name }}" type="video/mp4">
              </video>
              <br>
            @endif

            <label>description</label>
            <input type="text" class="form-control" value="{{ $file->description }}" disabled="">
            <br>
          </div>

    </div>

@endsection
