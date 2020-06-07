@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles del Evento</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small waves-effect waves-light right myOrange" href="{{ url('events') }}">
            <i class="material-icons left">arrow_back</i>Todos los eventos</a>
        <br>
    </div>
    <div class="section">
        <h6>Tipo de evento: </h6>
        @if ($event->inORout==1)
        <h5 class="myDetails green-text">Entrada</h5>
        @else
        <h5 class="myDetails red-text">Salida</h5>
        @endif
        <h6>Realizado por el empleado: </h6>
        <h5 class="myDetails"><a href="{{ url('employee', $event->employee) }}">{{ $event->employee->name }} {{ $event->employee->last_name }} ({{ $event->employee_id }})</a></h5>
        @if($event->tools->last())
        <h6>Herramientas escaneadas: </h6>
        @foreach($event->tools as $tool)
        <h5 class="myDetails"><a href="{{ url('tool', $tool) }}">{{ $tool->name }} {{ $tool->copy }} ({{ $tool->id }})</a></h5>
        @endforeach
        @endif
        <h6>Lugar de escaneo: </h6>
        <h5 class="myDetails"><a href="{{ url('place', $event->place) }}">{{ $event->place->name }} ({{ $event->place_id }})</a></h5>
        <h6>Fecha de realización: </h6>
        <h5 class="myDetails">{{ $event->created_at }}</h5>
        @if($event->created_at != $event->updated_at)
        <h6>Fecha de modificación: {{ $event->updated_at }}</h6>
        @endif
    </div>
    <div class="section">
        @if(auth()->user() && auth()->user()->admin)
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('event',$event->id) }}/edit">
            EDITAR<i class="material-icons right">edit</i></a>
        @endif
    </div>

</div>
@endsection