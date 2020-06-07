@extends('layouts.app')

@section('content')
<div class="container">
    <section class="container" style="max-width:400px">
        <form method="POST" action="{{ route('password.update') }}" class="indigo lighten-5" style="padding:20px">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-field">
                <label for="email">Dirección de correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="helper-text" style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                <span class="helper-text" style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <label for="password-confirm">Confirma tu contraseña</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

            <button type="submit" class="btn myBlue">Resetear contraseña</button>

        </form>
    </section>
</div>

@endsection