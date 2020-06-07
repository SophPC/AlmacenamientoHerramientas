@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Editar Incidencia</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('incidence', $incidence->id) }}" method="post" class="amber accent-1" style="padding:20px">
                @csrf
                @method('PATCH')
                <div class="input-field">
                    <label for="message" class="active">Mensaje </label>
                    <select id="message" name="message">
                        <option value="" disabled selected>Selecciona una opción</option>
                        <option value="a">Ma</option>
                        <option value="b">Mb</option>
                        <option value="c">Mc</option>
                        <option value="d">Md</option>
                        <option value="e">Me</option>
                        <option value="f">Mf</option>
                    </select>
                    @error('message')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Id del Lugar</label>
                    <input type="text" name="place_id" value="{{ $incidence->place_id }}">
                    @error('place_id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light green lighten-1" type="submit">Editar Incidencia
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </form>

            <br>
            <form action="{{ url('incidence',$incidence->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar la incidencia?')">
                    ELIMINAR INCIDENCIA<i class=" material-icons right">delete_forever</i>
                </button>
            </form>
        </section>
    </div>
</div>


@endsection