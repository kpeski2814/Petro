@extends('layouts.app')

@section('content')
<div class="container">
  <div class="page-header">
    <h1>Carga masiva de etiquetas</h1>
  </div>
  @if(Session::has('status'))
   <div class="alert alert-danger alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
     <p><strong>Hemos encontrado un error!!</strong> </p>
     <ul>
       <li>{{ Session::get('status') }}</li>
     </ul>
   </div>
  @endif

  {{ Form::open(['action'=>'TagController@populate', 'method'=>'POST', 'enctype' => 'multipart/form-data']) }}

    <div class="col-md-6">
      <label>Archivo CSV</label>
      <input type="file" class="form-control" name="csv" accept=".txt">
  	  <input class="ui button" type="submit" >
    </div>

  {{ Form::close() }}

</div>

@endsection
