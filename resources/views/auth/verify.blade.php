@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Verifica tu correo electrónico</h5>
    </div>
    <div class="divider"></div>
    <br />
    <section class="container center" style="max-width:400px">
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Un link de verificación ha sido enviado a tu correo electrónico.
        </div>
        @endif

        Antes de proceder, por favor revisa tu correo electrónico por un link de verificación.
        <br>Si no recibiste el correo:<br><br>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn myBlue">Presiona aquí para solicitar otro</button>
        </form>
</div>
</section>
</div>
@endsection