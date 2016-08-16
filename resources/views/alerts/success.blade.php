@if(Session::has('success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <p><strong> Accion Realizada con Exito!! </strong> </p>
    <ul>
      <li>{{ Session::get('success') }}</li>
    </ul>
  </div>
@endif
