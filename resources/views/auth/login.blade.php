@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Ingresar</h5>
    </div>
    <div class="divider"></div>
    <br />
    <section class="container" style="max-width:400px">
        <form method="POST" action="{{ route('login') }}" class="indigo lighten-5" style="padding:20px">
            @csrf

            <div class="input-field">
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
                <label for="email">Correo electrónico</label>
                @error('email')
                <span class="helper-text" style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <input id="password" type="password" name="password" autocomplete="current-password">
                <label for="password">Contraseña</label>
                @error('password')
                <span class="helper-text" style="color: red">{{ $message }}</span>
                @enderror
            </div>

            <label>
                <input type="checkbox" checked="checked" name="remember" {{ old('remember') ? 'checked' : '' }} />
                <span> Recuérdame</span>
            </label>
            <br /><br />

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </div>
            <div class="center">
                <button class="btn waves-effect waves-light myOrange" type="submit">Ingresar</button>
                <br><br>
                @if (Route::has('password.request'))
                <a class="btn-small blue lighten-1" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>


        </form>

    </section>
</div>

@endsection