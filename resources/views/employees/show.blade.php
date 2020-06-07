@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Detalles del Empleado</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <a class="btn-small waves-effect waves-light right myOrange" href="{{ url('employees') }}">
            <i class="material-icons left">arrow_back</i>Todos los empleados</a>
        <br>
    </div>
    <!-- Desktop -->
    <div class="section hide-on-small-and-down" style="display: flex; align-items: center; justify-content: space-between">
        <div>
            <h6>Nombre: {{ $employee->name }} {{ $employee->last_name }}</h6>
            <h6>ID: {{ $employee->id }}</h6>
            <h6>Fecha de nacimiento: {{ $employee->birthdate }}</h6>
            <h6>Incidencias: {{ $employee->incidences }}</h6>
            <h6>Departamento: {{ $employee->department }}</h6>
            <h6>Fecha de creación: {{ $employee->created_at }}</h6>
            @if($employee->created_at != $employee->updated_at)
            <h6>Fecha de modificación: {{ $employee->updated_at }}</h6>
            @endif
        </div>
        <div>
            <img class="materialboxed" src="{{ url('/images/'.$employee->image) }}" alt="{{ $employee->id }}" style="max-width: 300px; max-height:300px">
            <p align="center">EPC: {{ $employee->epc }}</p>
        </div>
    </div>
    <!-- Mobile -->
    <div class="section hide-on-med-and-up" style="display: flex; flex-direction: column; align-items: center; justify-content: space-between">
        <div>
            <img class="materialboxed" src="{{ url('/images/'.$employee->image) }}" alt="{{ $employee->id }}" style="max-width: 300px; max-height:300px">
            <p align="center">EPC: {{ $employee->epc }}</p>
        </div>
        <div>
            <h6>Nombre: {{ $employee->name }} {{ $employee->last_name }}</h6>
            <h6>ID: {{ $employee->id }}</h6>
            <h6>Fecha de nacimiento: {{ $employee->birthdate }}</h6>
            <h6>Incidencias: {{ $employee->incidences }}</h6>
            <h6>Departamento: {{ $employee->department }}</h6>
            <h6>Fecha de creación: {{ $employee->created_at }}</h6>
            @if($employee->created_at != $employee->updated_at)
            <h6>Fecha de modificación: {{ $employee->updated_at }}</h6>
            @endif
        </div>

    </div>
    <!--  -->

    <div class="section" style="display: flex; flex-direction: column; align-items: flex-start;">
        @auth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('employee', $employee->id) }}/edit" style="margin-bottom: 15px">
            EDITAR<i class="material-icons right">edit</i></a>
        @endauth
        <a class="btn-small waves-effect waves-light myOrange" href="{{ url('events') }}?extra={{ $employee->id }}">
            EVENTOS REALIZADOS POR ESTE EMPLEADO</i></a>
    </div>

</div>
@endsection