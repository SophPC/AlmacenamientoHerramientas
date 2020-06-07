@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Editar Lugar</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('place', $place->id) }}" method="post" class="green lighten-4" style="padding:20px">
                @csrf
                @method('PATCH')
                <div class="input-field">
                    <label>ID del lugar</label>
                    <input type="text" name="id" value="{{ $place->id }}">
                    @error('id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Nombre</label>
                    <input type="text" name="name" value="{{ $place->name }}">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light green lighten-1" type="submit">Editar lugar
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </form>
            <br>
            <form action="{{ url('place', $place->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar el lugar?')">
                    ELIMINAR LUGAR<i class=" material-icons right">delete_forever</i>
                </button>
            </form>
        </section>
    </div>
</div>

@endsection
