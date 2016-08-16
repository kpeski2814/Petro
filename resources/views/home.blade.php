@extends('layouts.app')
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
<div class="container">
  @if(Session::has('status'))
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<p><strong>Acción realizada con Exito</strong> </p>
			<ul>
				<li>{{ Session::get('status') }}</li>
			</ul>
		</div>
	@endif
  <center>
    <h2 class="ui icon header">
      <i class="settings icon"></i>
      <div class="content">
         Disk Usage
        <div class="sub header">Disk usage bar</div>
      </div>
    </h2>
  </center>
<div class="ui inverted segment">
  <div class="ui orange inverted progress">
    <div class="ui large progress">
      <div class="bar"></div>
        <div class="label">Uploading Files</div>
    </div>
  </div>
</div>

@endsection
<script type="text/javascript">
$(document).ready(function () {
    $('.ui.search').search({
        apiSettings: {
            url: '/autocomplete/{query}',
            minCharacters : 3,
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
    });
});
</script>
