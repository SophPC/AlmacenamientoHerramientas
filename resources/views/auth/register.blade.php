@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Registro</h5>
    </div>
    <!-- {{ __('Register') }} -->
    <div class="divider"></div>
    <br />
    <section class="container" style="max-width:400px">

        <form method="POST" action="{{ route('register') }}" class="indigo lighten-5" style="padding:20px"">
      @csrf
            <div class=" input-field">
            <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name">
            <label for="name">Nombre</label>
            @error('name')
            <span class="helper-text" style="color: red">{{ $message }}</span>
            @enderror
</div>

<div class="input-field">
    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
    <label for="email">Dirección de correo electrónico</label>
    @error('email')
    <span class="helper-text" style="color: red">{{ $message }}</span>
    @enderror
</div>

<div class="input-field">
    <input id="password" type="password" name="password" value="{{ old('password') }}" autocomplete="new-password">
    <label for="email">Contraseña</label>
    @error('password')
    <span class="helper-text" style="color: red">{{ $message }}</span>
    @enderror
</div>

<div class="input-field">
    <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password">
    <label for="password-confirm">Confirmar contraseña</label>
</div>

<div class="center">
    <button type="submit" class="btn myOrange">
        Registrarse
    </button>
</div>

</form>
</section>
</div>
@endsection