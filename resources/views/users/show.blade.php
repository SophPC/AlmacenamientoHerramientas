@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles del Usuario</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small waves-effect waves-light right myOrange" href="{{ url('users') }}">
            <i class="material-icons left">arrow_back</i>Todos los usuarios</a>
        <br>
    </div>

    <div class="section">
        <h6>Nombre: {{ $user->name }}</h6>
        <h6>Email: {{ $user->email }}</h6>
        <h6>Fecha de verificación de email: {{ $user->email_verified_at }}</h6>
        <h6>¿Es usuario administrador?: 
        @if($user->admin)
            Si
        @else
            No
        @endif
        </h6>
        <h6>Fecha de creación: {{ $user->created_at }}</h6>
        @if($user->created_at != $user->updated_at)
        <h6>Fecha de modificación: {{ $user->updated_at }}</h6>
        @endif
    </div>

    <br>
    <form action="{{ url('user', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar al usuario?')">
            ELIMINAR USUARIO<i class=" material-icons right">delete_forever</i>
        </button>
    </form>

</div>
@endsection