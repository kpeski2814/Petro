@extends('layouts.app')

@section('content')
<div class="container">

<div class="page-header">
  <h2>Archivos No Catalogados

  </h2>
</div>

  <a class="ui primary button" href="{!!URL::to('/navigate')!!}" >Leer Archivos</a>
  <br>
	<br>

  {!! Form::open(['action'=>'CatalogedController@create']) !!}

	<div class="row">
    @php($cont = 0)

	 	@foreach($file as $file)
      @php($cont++)
	 		<div class="col-md-3">
         <div class="panel panel-default">
                <div class="panel-body" >
                  @if($file->type_id == 1)
                    <img src="{{ $file->path }}" width="220px" height="220px" ><br>
      						  <a href="{{ url("/details/$file->id/view") }}">Ver Detalle</a>
                    @else
                      <video width="210px" height="220px" controls>
                        <source src="{{ $file->path }}" type="video/mp4">
                      </video>
                      <a href="{{ url("/details/$file->id/view") }}">Ver Detalle</a>
                  @endif

                </div>
         </div>
	 		</div>

	 	@endforeach

 	</div>
  {!! Form::close() !!}
</div>
@endsection
