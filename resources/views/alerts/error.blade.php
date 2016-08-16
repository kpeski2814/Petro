@if(Session::has('status'))
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <p><strong> Parace que tenemos un error !! </strong> </p>
    <ul>
      <li>{{ Session::get('status') }}</li>
    </ul>
  </div>
@endif
