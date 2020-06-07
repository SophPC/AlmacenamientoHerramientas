@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Agregar Incidencia</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('/incidence/add') }}" method="post" class="orange lighten-4" style="padding:20px">
                @csrf
                <div class="input-field">
                    <label for="MENSAJE" class="active">Mensaje </label>
                    <select id="MENSAJE" name="MENSAJE">
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="No existe el lugar">No existe el lugar</option>
                        <option value="Más de dos EPCs (empleado y herramienta) en alta de herramienta">Más de dos EPCs (empleado y herramienta) en alta de herramienta</option>
                        <option value="El ultimo evento del empleado antes del alta de herramienta fue entrada">El ultimo evento del empleado antes del alta de herramienta fue entrada</option>
                        <option value="Más de una EPC en alta de empleado">Más de una EPC en alta de empleado</option>
                        <option value="Se leyo a mas de un empleado durante un evento">Se leyo a mas de un empleado durante un evento</option>
                        <option value="No existe la EPC en la base de datos">No existe la EPC en la base de datos</option>
                        <option value="No existe la EPC de la herramienta en la base de datos">No existe la EPC de la herramienta en la base de datos</option>
                        <option value="No hay empleado en el evento">No hay empleado en el evento</option>
                        <option value="Incongruencia en entradas y salidas de la herramienta">Incongruencia en entradas y salidas de la herramienta</option>
                    </select>
                    @error('MENSAJE')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="LUGAR" class="active">ID del Lugar</label>
                    <select id="LUGAR" name="LUGAR">
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($places as $place)
                        <option value="{{ $place['id'] }}">{{ $place['id'] }} - {{ $place['name'] }}</option>
                        @endforeach
                    </select>
                    @error('LUGAR')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEPCs">
                    <label for="EPCs">EPCs</label>
                    <input type="text" id="EPCs" name="EPCs" placeholder="Separadas por una coma">
                    @error('EPCs')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEPC">
                    <label for="EPC">EPC</label>
                    <input type="text" id="EPC" name="EPC">
                    @error('EPC')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEmployee">
                    <label for="employee_id" class="active">ID del empleado</label>
                    <select id="employee_id" name="ID_DEL_EMPLEADO">
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee['id'] }}">{{ $employee['id'] }} - {{ $employee['last_name'] }} {{ $employee['name'] }}</option>
                        @endforeach
                    </select>
                    @error('ID DEL EMPLEADO')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEmployee2">
                    <label for="employee_id2" class="active">ID del empleado 2</label>
                    <select id="employee_id2" name="ID DEL EMPLEADO 2">
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee['id'] }}">{{ $employee['id'] }} - {{ $employee['last_name'] }} {{ $employee['name'] }}</option>
                        @endforeach
                    </select>
                    @error('ID DEL EMPLEADO 2')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEvent">
                    <label for="event_id" class="active">ID del último evento</label>
                    <select id="event_id" name="ID DEL ULTIMO EVENTO">
                        <option value="" disabled selected>Selecciona una opción</option>
                        {{--
                        @foreach($events_ids as $event_id)
                        <option value="{{ $event_id }}">{{ $event_id }}</option>
                        @endforeach
                        --}}
                    </select>
                    @error('ID DEL ULTIMO EVENTO')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divEmployeeStat">
                    <label for="employee_stat" class="active">Status del empleado</label>
                    <select id="employee_stat" name="STATUS DEL EMPLEADO">
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="1">Entrada</option>
                        <option value="0">Salida</option>
                    </select>
                    @error('STATUS DEL EMPLEADO')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field" style="display: none" id="divTool">
                    <label for="tool_id" class="active">ID de la herramienta/label>
                        <select multiple="multiple" id="tool_id" name="ID DE LA HERRAMIENTA">
                            <option value="" disabled>Selecciona una opción</option>
                            @foreach($tools as $tool)
                            <option value="{{ $tool['id'] }}">{{ $tool['id'] }} - {{ $tool['name'] }}({{ $tool['copy'] }})</option>
                            @endforeach
                        </select>
                        @error('ID DE LA HERRAMIENTA')
                        <span class="helper-text" style="color: red">{{ $message }}</span>
                        @enderror
                </div>
                <div class="input-field" style="display: none" id="divToolStat">
                    <label for="tool_stat" class="active">Status de la herramienta</label>
                    <select id="tool_stat" name="STATUS DE LA HERRAMIENTA">
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="1">Entrada</option>
                        <option value="0">Salida</option>
                    </select>
                    @error('STATUS DE LA HERRAMIENTA')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light myOrange" type="submit">Agregar Incidencia
                        <i class="material-icons right">save</i>
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $("#MENSAJE").change(function() {
        switch (this.value) {
            case 'No existe el lugar':
                $("#divEPC").hide();
                $("#divEPCs").hide();
                $("#divEmployee").hide();
                $("#divEmployee2").hide();
                $("#divEvent").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'Más de dos EPCs (empleado y herramienta) en alta de herramienta':
            case 'Más de una EPC en alta de empleado':
            case 'No hay empleado en el evento':
                $("#divEPCs").show();
                $("#divEmployee").hide();
                $("#divEmployee2").hide();
                $("#divEvent").hide();
                $("#divEPC").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'El ultimo evento del empleado antes del alta de herramienta fue entrada':
                $("#divEmployee").show();
                $("#divEvent").show();
                $("#divEPCs").hide();
                $("#divEmployee2").hide();
                $("#divEPC").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'Se leyo a mas de un empleado durante un evento':
                $("#divEmployee").show();
                $("#divEmployee2").show();
                $("#divEPCs").hide();
                $("#divEvent").hide();
                $("#divEPC").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'No existe la EPC en la base de datos':
                $("#divEPC").show();
                $("#divEPCs").hide();
                $("#divEmployee").hide();
                $("#divEmployee2").hide();
                $("#divEvent").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'No existe la EPC de la herramienta en la base de datos':
                $("#divEmployee").show();
                $("#divEPC").show();
                $("#divEPCs").hide();
                $("#divEmployee2").hide();
                $("#divEvent").hide();
                $("#divEmployeeStat").hide();
                $("#divTool").hide();
                $("#divToolStat").hide();
                break;
            case 'Incongruencia en entradas y salidas de la herramienta':
                $("#divEmployee").show();
                $("#divEmployeeStat").show();
                $("#divTool").show();
                $("#divToolStat").show();
                $("#divEPCs").hide();
                $("#divEmployee2").hide();
                $("#divEvent").hide();
                $("#divEPC").hide();
        }
    });
</script>

@endsection