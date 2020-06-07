@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Reseteo de contraseña</h5>
    </div>
    <div class="divider"></div>
    <br />
    <section class="container" style="max-width:400px">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="indigo lighten-5" style="padding:20px">
            @csrf
            <div class="input-field">
                <label for="email">Dirección de correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn myBlue">
                Envía el link de reseteo de contraseña
            </button>
        </form>
    </section>
</div>
</div>

@endsection