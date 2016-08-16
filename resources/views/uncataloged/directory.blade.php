@extends('layouts.app')

@section('content')
<div class="container">

  @if(Session::has('status'))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<p><strong>Parece que tenemos un error!!</strong> </p>
			<ul>
				<li>{{ Session::get('status') }}</li>
			</ul>
		</div>
	@endif
  <div class="col-md-3">
      <input type="text" name="name" value="{{ Session::get('session_disk') }}" id="actual_val" hidden="">
  </div>

  {!! Form::open(['action'=>'PathController@selectDisk' , 'method'=>'POST' ])!!}
    <div class="col-md-6">
      <select class="form-control" name="disk">
        <option selected="" disabled="">-- Seleccionar Unidad --</option>
        <option value="c">Unidad C:\\</option>
        <option value="d">Unidad D:\\</option>
        <option value="e">Unidad E:\\</option>
        <option value="f">Unidad F:\\</option>
        <option value="g">Unidad G:\\</option>
        <option value="h">Unidad H:\\</option>
        <option value="i">Unidad I:\\</option>
        <option value="j">Unidad J:\\</option>
        <option value="k">Unidad K:\\</option>
        <option value="l">Unidad L:\\</option>
        <option value="m">Unidad M:\\</option>
        <option value="n">Unidad N:\\</option>
        <option value="o">Unidad O:\\</option>
        <option value="p">Unidad P:\\</option>
        <option value="q">Unidad Q:\\</option>
        <option value="r">Unidad R:\\</option>
        <option value="s">Unidad S:\\</option>
        <option value="t">Unidad T:\\</option>
        <option value="u">Unidad U:\\</option>
        <option value="v">Unidad V:\\</option>
        <option value="x">Unidad X:\\</option>
        <option value="y">Unidad Y:\\</option>
        <option value="z">Unidad Z:\\</option>
      </select>
    </div>
    <br>
    <input type="submit" class="ui primary button right floated" value="Visualizar Unidad">
  {!! Form::close() !!}
  <br>
  <br>

  <h3>{{ Session::get('session_disk') }}</h3>
<div class="ui divider"></div>

    <button class="ui primary button" id="button-going-back">
      <i class="chevron circle left icon"></i>
      Retroceder
    </button>
    <br>
    <br>
    {!! Form::open(['action'=>'PathController@goingBack', 'id'=>'form-going-back']) !!}
    {!! Form::close() !!}

    @if(isset($directories))
      @foreach($directories as $direct)
          <?php $real_name = substr(strrchr($direct, "\\"), 1);?>

         <div class="col-md-3">
            <label>{{ $real_name }}</label><br>
            <a href="{{ url("/directory/$real_name") }}"><img src="{{ asset('imagenes/dir-icon.png')}}" width="110px" alt="" /></a>
         </div>
      @endforeach

    @endif

</div>

<script type="text/javascript">
    var disk = ['','C:\\', 'D:\\','E:\\','F:\\','G:\\','H:\\','I:\\','J:\\','L:\\'];
    var actualVal = document.getElementById('actual_val').value;

    var v = jQuery.inArray(actualVal, disk);
    if (v != -1) {
      $('#button-going-back').addClass("disabled");
    }
    $('#button-going-back').click(function(){
      $('#form-going-back').submit();
    });
</script>
@endsection
