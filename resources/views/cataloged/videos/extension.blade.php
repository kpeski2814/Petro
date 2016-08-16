@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="page-header">
      <h1>Cambiar Extension</h1>
    </div>

    {{ Form::open(['action'=>'VideoController@ExtensionChange','method'=>'POST'])}}
    @foreach($videos as $video)
      <div class="col-md-3">
        <input type="text" name="id" value="{{ $video->id}}" hidden="">
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Nombre del archivo</label>
          <input type="text" class="form-control" name="name" value="{{ $video->name }}">
        </div>

        <div class="form-group">
          <label>Extension del archivo</label>
          <input type="text" class="form-control" name="extension" value="{{ $video->extension }}">
        </div>

        <div class="form-group">
          <label>Nueva Extension</label>
          <select class="form-control" name="new_extension">
            <option selected="" disabled="">-- Seleccionar extension --</option>
            <option value="a">.avi</option>
            <option value="b">.WMV</option>
            <option value="c">.WEBM</option>
          </select>
        </div>
          <input type="submit" class="ui button" value="Cambiar Extension">
      </div>

    @endforeach

    {{ Form::close() }}
  </div>

@endsection
