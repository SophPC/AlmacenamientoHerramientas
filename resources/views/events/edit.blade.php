@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Editar Evento</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('event', $event->id) }}" method="post" class="amber accent-1" style="padding:20px">
                @csrf
                @method('PATCH')
                <div class="input-field">
                    <label>Id del empleado</label>
                    <input type="text" name="employee_id" value="{{ $event->employee_id }}">
                    @error('employee_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Id de la herramienta</label>
                    <input type="text" name="tool_id" value="{{ $event->tool_id }}">
                    @error('tool_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Id del Lugar</label>
                    <input type="text" name="place_id" value="{{ $event->place_id }}">
                    @error('place_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="inORout" class="active">Entrada o Salida</label>
                    <select id="inORout" name="inORout">
                        <option value="1">Entrada</option>
                        <option value="0">Salida</option>
                    </select>
                    <p></p>
                    @error('inORout')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light green lighten-1" type="submit">Editar Evento
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </form>

            <br>
            <form action="{{ url('event',$event->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar el evento?')">
                    ELIMINAR EVENTO<i class=" material-icons right">delete_forever</i>
                </button>
            </form>

            <script>
                document.getElementById('inORout').value = '{{ $event->inORout }}';
            </script>
        </section>
    </div>
</div>


@endsection