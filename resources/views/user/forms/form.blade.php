<div class="container">


    <div class="col-md-4">

      <div class="form-group">
      <label>Nombre</label>
      {{ Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Nombre de Usuario']) }}
      </div>

      <div class="form-group">
      <label>Email</label>
      {{ Form::email('email',null,['class'=>'form-control', 'placeholder'=>'usuario@mail.com']) }}
      </div>

      <div class="form-group">
      <label>Contraseña</label>
      @if(isset($user->password))
        <input type="password" class="form-control" name="password" value="{{ $user->password }}">
      @else
        <input type="password"  class="form-control" name="password" placeholder="Ingresar Contraseña">
      @endif
      </div>

      <div class="form-group">
      <label>Repetir Contraseña</label>
      @if(isset($user->password))
        <input type="password" class="form-control" name="password_confirmation" value="{{ $user->password }}">
      @else
        <input type="password"  class="form-control" name="password_confirmation" placeholder="Ingresar Contraseña">
      @endif
      </div>

  </div>
</div>
