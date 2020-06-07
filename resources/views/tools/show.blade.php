@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles de la Herramienta</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small waves-effect waves-light myOrange right" href="{{ url('tools') }}">
            <i class="material-icons left">arrow_back</i>Todas las herramientas</a>
        <br>
    </div>
    <!-- Desktop -->
    <div class="section hide-on-small-and-down" style="display: flex; align-items: center; justify-content: space-between">
        <div>
            <h6>Tipo: {{ $tool->type }}</h6>
            <h6>Nombre: {{ $tool->name }}</h6>
            <h6>Copia: {{ $tool->copy }}</h6>
            <h6>ID: {{ $tool->id }}</h6>
            <h6>Fecha de creación: {{ $tool->created_at }}</h6>
            @if($tool->created_at != $tool->updated_at)
            <h6>Fecha de modificación: {{ $tool->updated_at }}</h6>
            @endif
            <h6>Status:
                @if($tool->events->last())
                @if($tool->status)
                <a href="{{ url('/event/'.$tool->events->last()->id) }}" class="green-text center lighten-1">Entrada por {{ $tool->events->last()->employee->last_name }} {{ $tool->events->last()->employee->name }}</a>
                @else
                <a href="{{ url('/event/'.$tool->events->last()->id) }}" class="red-text center lighten-1">Salida por {{ $tool->events->last()->employee->last_name }} {{ $tool->events->last()->employee->name }}</a>
                @endif
                @else
                Esperando eventos
                @endif
            </h6>
        </div>
        <div>
            <img class="materialboxed" src="{{ url('/images/'.$tool->image) }}" alt="{{ $tool->id }}" style="max-width: 300px; max-height:300px">
            <p align="center">EPC: {{ $tool->epc }}</p>
        </div>
    </div>
    <!-- Mobile -->
    <div class="section hide-on-med-and-up" style="display: flex; flex-direction: column; align-items: center; justify-content: space-between">
        <div>
            <img class="materialboxed" src="{{ url('/images/'.$tool->image) }}" alt="{{ $tool->id }}" style="max-width: 300px; max-height:300px">
            <p align="center">EPC: {{ $tool->epc }}</p>
        </div>
        <div>
            <h6>Tipo: {{ $tool->type }}</h6>
            <h6>Nombre: {{ $tool->name }}</h6>
            <h6>Copia: {{ $tool->copy }}</h6>
            <h6>ID: {{ $tool->id }}</h6>
            <h6>Fecha de creación: {{ $tool->created_at }}</h6>
            @if($tool->created_at != $tool->updated_at)
            <h6>Fecha de modificación: {{ $tool->updated_at }}</h6>
            @endif
        </div>
    </div>
    <!--  -->

    <div class="section" style="display: flex; flex-direction: column; align-items: flex-start;">
        @auth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('tool', $tool->id) }}/edit" style="margin-bottom: 15px">
            EDITAR<i class="material-icons right">edit</i></a>
        @endauth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('events') }}?extra={{ $tool->id }}">
            EVENTOS CON ESTA HERRAMIENTA</i></a>
    </div>

</div>
@endsection