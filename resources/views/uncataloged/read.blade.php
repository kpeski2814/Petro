@extends('layouts.app')

@section('content')

<div class="container">

  <div class="page-header">
    <h3>Leer Archivos</h3>
  </div>

  @if(Session::has('status'))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<p><strong>Al parecer tenemos un problema...</strong> </p>
			<ul>
				<li>{{ Session::get('status') }}</li>
			</ul>
		</div>
	@endif

  {{ Form::open(['action'=>'ReadController@catalog']) }}


    <div class="form-group">
       <input type="submit" class="btn btn-info" value="Catalogar Archivos">
    </div>
    @foreach ($info as $file)

      @php $hasBook = false; @endphp

      @foreach ($archivos as $book)

          @if ($book->name == $file['basename'])
            @if($file['extension'] == 'jpg' || $file['extension'] == 'png' || $file['extension'] == 'jpeg' )
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                      <img src="{{$file['dirname']}}\{{ $file['basename'] }}" width="220px" height="220px" ><br>
                      <input type="checkbox"  disabled="">
                      <input type="text" class="form-control" name="filename" value="{{ $file['basename'] }}">
                  </div>
                </div>
              </div>
          @else
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-body">
                  <video width="190px" height="200px" controls>
                    <source src="{{$file['dirname']}}\{{ $file['basename'] }}" type="video/mp4">
                  </video>
                    <input type="checkbox"  disabled="">
                  <input type="text" class="form-control" name="filename" value="{{ $file['basename'] }}">
                </div>
              </div>
            </div>
          @endif

              @php $hasBook = true; @endphp
          @endif


      @endforeach

      @if (!$hasBook)
        @if($file['extension'] == 'jpg' || $file['extension'] == 'png' || $file['extension'] == 'jpeg' )
              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-body">
                      <img src="{{$file['dirname']}}\{{ $file['basename'] }}" width="220px" height="220px" ><br>

                      {!! Form::checkbox('check[]', $file['basename']) !!}
                      <input type="text" class="form-control" name="filename" value="{{ $file['basename'] }}">
                  </div>
                </div>
              </div>
          @else
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-body">
                  <video width="200px" height="220px" controls>
                    <source src="{{$file['dirname']}}\{{ $file['basename'] }}" type="video/mp4">
                  </video>
                  {!! Form::checkbox('check[]', $file['basename']) !!}
                  <input type="text" class="form-control" name="filename" value="{{ $file['basename'] }}">
                </div>
              </div>
            </div>
          @endif
      @endif

   @endforeach

  <input type="text" name="path" value="{{ $file['dirname'] }}" hidden="">
  {{ Form::close() }}
</div>
@endsection
