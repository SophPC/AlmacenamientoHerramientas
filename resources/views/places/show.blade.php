@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles del Lugar</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small right waves-effect waves-light myOrange" href="{{ url('places') }}">
            <i class="material-icons left">arrow_back</i>Todos los lugares</a>
        <br>
    </div>
    <div class="section">
        <h6>Nombre: {{ $place->name }}</h6>
        <h6>ID: {{ $place->id }}</h6>
        <h6>Fecha de creación: {{ $place->created_at }}</h6>
        @if($place->created_at != $place->updated_at)
        <h6>Fecha de modificación: {{ $place->updated_at }}</h6>
        @endif
    </div>
    <div class="section" style="display: flex; flex-direction: column; align-items: flex-start;">
        @auth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('place', $place->id) }}/edit" style="margin-bottom: 15px">
            EDITAR<i class="material-icons right">edit</i></a>
        @endauth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('events') }}?extra={{ $place->id }}">
            EVENTOS EN ESTE LUGAR</i></a>
    </div>
</div>

@endsection