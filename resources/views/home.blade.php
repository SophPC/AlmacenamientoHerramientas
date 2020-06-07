@extends('layouts.app')

@section('styles')
<style>
    .myLink:hover {
        cursor: pointer;
    }

    .collapsible-header {
        background-color: #E2E2FA;
    }

    .myINorOUT {
        padding: 5px 10px 5px 10px;
        margin: 0 0 0 0;
        width: 70px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <ul class="collapsible expandable popout">

        <!-- === HERRAMIENTAS EN USO === -->
        @if($outTools->isNotEmpty())
        <li class="active">
            <div class="collapsible-header"><i class="material-icons">chevron_right</i>Herramientas en Uso</div>
            <div class="collapsible-body">
                <span>
                    <div class="row">
                        @foreach ($outTools as $tool)
                        @if($tool->events->last())
                        <div class="col s12 m6 l4">
                            <div class="card horizontal myLorange myLink" onclick="location.href='{{ url("event", $tool->events->last()->id) }}'">
                                <div class="card-image valign-wrapper">
                                    <img src="{{ url('/images/'.$tool->image) }}">
                                </div>
                                <div class="card-content">
                                    <h6 class="center">{{ $tool->name }} ({{ $tool->copy }})</h6>
                                    <p>{{ $tool->events->last()->employee->last_name }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @if(!(count($outTools) < 5)) <div class="col s12 m6 l4">
                            <div class="card-content center">
                                <ul id="nav-mobile">
                                    <li><a href="{{ url('tools') }}?inORout=0" class="btn-large myLorange myDtext">
                                            <i class="material-icons right">fast_forward</i>MÁS HERRAMIENTAS</a></li>
                                </ul>
                            </div>
                    </div>
                    @endif
            </div>
            </span>
</div>
</li>
@endif

<!-- === HERRAMIENTAS DISPONIBLES === -->
@if($inTools->isNotEmpty())
<li class="active">
    <div class="collapsible-header"><i class="material-icons">chevron_right</i>Herramientas Disponibles</div>
    <div class="collapsible-body">
        <span>
            <div class="row">
                @foreach ($inTools as $tool)
                <div class="col s12 m6 l4">
                    <div class="card horizontal myLorange myLink" onclick="location.href='{{ url("tool", $tool->id) }}'">
                        <div class="card-image valign-wrapper">
                            <img src="{{ url('/images/'.$tool->image) }}">
                        </div>
                        <div class="card-content">
                            <h6 class="center">
                                {{ $tool->name }} ({{ $tool->copy }})
                            </h6>
                        </div>
                    </div>
                </div>
                @endforeach
                @if(!(count($inTools) < 5)) <div class="col s12 m6 l4">
                    <div class="card-content center">
                        <ul id="nav-mobile">
                            <li><a href="{{ url('tools') }}?inORout=1" class="btn-large myLorange myDtext">
                                    <i class="material-icons right">fast_forward</i>MÁS HERRAMIENTAS</a></li>
                        </ul>
                    </div>
            </div>
            @endif
    </div>
    </span>
    </div>
</li>
@endif

<!-- === EVENTOS === -->
@if($events->isNotEmpty())
<li class="active">
    <div class="collapsible-header"><i class="material-icons">chevron_right</i>Eventos</div>
    <div class="collapsible-body">
        <span>
            <div class="row">
                @foreach ($events as $event)
                <div class="col s12 m6 l4">
                    <div class="card myLorange myLink" onclick="location.href='{{ url("event", $event->id) }}'">
                        <div class="card-content" style="display:flex;justify-content: space-between; align-items: center;">
                            <div>
                                <span class="card-title"> {{ $event->employee->last_name }} </span>
                                <h6>
                                    @foreach ($event->tools as $tool)
                                    {{ $tool->id }}
                                    @endforeach
                                </h6>
                            </div>
                            @if (($event->inORout)==1)
                            <p class="center white-text green myINorOUT">Entrada</p>
                            @else
                            <p class="center white-text red myINorOUT">Salida</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @if (!(count($events) < 5)) <div class="col s12 m6 l4">
                    <div class="card-content center">
                        <ul id="nav-mobile">
                            <li><a href="{{ url('events') }}" class="btn-large myLorange myDtext">
                                    <i class="material-icons right">fast_forward</i>MÁS EVENTOS</a></li>
                        </ul>
                    </div>
            </div>
            @endif
    </div>
    </span>
    </div>
</li>
@endif

<!-- === EMPLEADOS === -->
@if($employees->isNotEmpty())
<li class="active">
    <div class="collapsible-header"><i class="material-icons">chevron_right</i>Empleados</div>
    <div class="collapsible-body">
        <span>
            <div class="row">
                @foreach ($employees as $employee)
                <div class="col s12 m6 l4">
                    <div class="card horizontal myLorange myLink" onclick="location.href='{{ url("employee", $employee->id) }}'">
                        <div class="card-image valign-wrapper">
                            <img src="{{ url('/images/'.$employee->image) }}">
                        </div>
                        <div class="card-content">
                            <h6>{{ $employee->last_name }} {{ $employee->name }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
                @if(!(count($employees) < 5)) <div class="col s12 m6 l4">
                    <div class="card-content center">
                        <ul id="nav-mobile">
                            <li><a href="{{ url('employees') }}" class="btn-large myLorange myDtext">
                                    <i class="material-icons right">fast_forward</i>MÁS EMPLEADOS</a></li>
                        </ul>
                    </div>
            </div>
            @endif
    </div>
    </span>
    </div>
</li>
@else
@auth
<h6 align="center">No existen empleados registrados:<br><br>
<a href="{{ url('/employee/create') }}" class="btn-small myOrange myDtext">Registrar empleado</a></h6>
@else
<h6 align="center">No existen empleados registrados.<br>Para registrar un empleado:<br><br>
<a href="{{ route('login') }}" class="btn-small myOrange myDtext">Ingresar</a></h6>
@endauth
@endif

</ul>

@endsection