@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles de la Incidencia</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small right waves-effect waves-light myOrange" href="{{ url('incidences') }}">
            <i class="material-icons left">arrow_back</i>Todas las incidencias</a>
        <br>
    </div>
    <div class="section">
        <h6>Mensaje: </h6>
        <h5 class="myDetails"><span style="background-color: lightcoral; padding: 5px 5px 5px 5px;">{{ $incidence->message }}</span></h5>
        <h6>Lugar:</h6>
        <h5 class="myDetails">{{ $incidence->place_id }}</h5>
        @if($incidence->epcs)
        <h6>EPC(s) involucrada(s):</h6>
        <h5 class="myDetails">{{ $incidence->epcs }}</h5>
        @endif
        @if($incidence->employee_id)
        <h6>Empleado involucrado: </h6>
        <h5 class="myDetails"><a href="{{ url('employee', $incidence->employee_id) }}">{{ $incidence->employee_id }}</a></h5>
        @endif
        @if($incidence->employee_id_2)
        <h6>Empleado involucrado: </h6>
        <h5 class="myDetails"><a href="{{ url('employee', $incidence->employee_id_2) }}">{{ $incidence->employee_id_2 }}</a></h5>
        @endif
        @if($incidence->employee_status !== NULL)
        <h6>Status del empleado:</h6>
        @if ($incidence->employee_status==1)
        <h5 class="green-text myDetails">Dentro del almacén</h5>
        @else
        <h5 class="red-text myDetails">Fuera del almacén</h5>
        @endif
        @endif
        @if($incidence->last_event_id)
        <h6>ID del último evento: </h6>
        <h5 class="myDetails"><a href="{{ url('event', $incidence->last_event_id) }}">{{ $incidence->last_event_id }}</a></h5>
        @endif
        @if($incidence->tool_id)
        <h6>ID de la herramienta involucrada:</h6>
        <h5 class="myDetails"><a href="{{ url('tool', $incidence->tool_id) }}">{{ $incidence->tool_id }}</a></h5>
        @endif
        @if($incidence->tool_status !== NULL)
        <h6>Status de la herramienta:</h6>
        @if ($incidence->tool_status==1)
        <h5 class="green-text myDetails">Dentro del almacén</h5>
        @else
        <h5 class="red-text myDetails">Fuera del almacén</h5>
        @endif
        @endif
        <h6>Fecha de la incidencia: </h6>
        <h5 class="myDetails">{{ $incidence->created_at }}</h5>
        @if($incidence->created_at != $incidence->updated_at)
        <h6>Fecha de modificación: {{ $incidence->updated_at }}</h6>
        @endif
    </div>
    <div class="section" style="display: flex; flex-direction: column; align-items: flex-start;">
        @if(auth()->user() && auth()->user()->admin)
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('incidence', $incidence->id) }}/edit" style="margin-bottom: 15px">
            EDITAR<i class="material-icons right">edit</i></a>
        @endif
    </div>
</div>

@endsection