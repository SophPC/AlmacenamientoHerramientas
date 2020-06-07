@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Agregar Evento</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('/event/add') }}" method="post" class="amber accent-1" style="padding:20px">
                @csrf
                <div class="input-field">
                    <label for="employee_id" class="active">Id del empleado</label>
                    <!-- <input type="text" name="employee_id" placeholder="EXXXX" value="EXXXX"> -->
                    <select id="employee_id" name="employee_id">
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee['id'] }}">{{ $employee['id'] }} - {{ $employee['last_name'] }} {{ $employee['name'] }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="tool_id" class="active">Id de la herramienta</label>
                    <!-- <input type="text" name="tool_id" placeholder="HXXXX" value="HXXXX"> -->
                    <select multiple="multiple" id="tool_id" name="tool_id">
                        <option value="" disabled>Selecciona una opción</option>
                        @foreach($tools as $tool)
                        <option value="{{ $tool['id'] }}">{{ $tool['id'] }} - {{ $tool['name'] }}({{ $tool['copy'] }})</option>
                        @endforeach
                    </select>
                    @error('tool_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="place_id" class="active">Id del Lugar</label>
                    <!-- <input type="text" name="place_id" placeholder="LXXXX" value="LXXXX"> -->
                    <select id="place_id" name="place_id">
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($places as $place)
                        <option value="{{ $place['id'] }}">{{ $place['id'] }} - {{ $place['name'] }}</option>
                        @endforeach
                    </select>
                    @error('idLugar')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none">
                    <label for="inORout" class="active">Entrada o Salida</label>
                    <select id="inORout" name="inORout">
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="1">Entrada</option>
                        <option value="0">Salida</option>
                    </select>
                    <p></p>
                    @error('inORout')

                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light myOrange" type="submit">Agregar Evento
                        <i class="material-icons right">save</i>
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection