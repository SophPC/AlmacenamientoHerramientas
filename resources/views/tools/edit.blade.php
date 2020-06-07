@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Editar Herramienta</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('tool', $tool->id) }}" method="post" enctype="multipart/form-data" class="red lighten-4" style="padding:20px">
                @csrf
                @method('PATCH')
                <div class="input-field">
                    <label for="id">ID de la herramienta</label>
                    <input type="text" id="id" name="id" placeholder="HXXXX" value="{{ $tool->id }}">
                    @error('id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ $tool->name }}">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="copy">Copia</label>
                    <input id="copy" type="text" name="copy" placeholder="A" value="{{ $tool->copy }}">
                    @error('copy')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field ">
                    <label for="type">Tipo</label>
                    <input id="type" type="text" name="type" value="{{ $tool->type }}" validate>
                    @error('type')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="file-field input-field">
                    <div class="btn myOrange">
                        <span>Imagen</span>
                        <input type="file" name="image" id="foto">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                    @error('image')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light green lighten-1" type="submit">Editar herramienta
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </form>

            <br>
            <form action="{{ url('tool', $tool->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar la herramienta?')">
                    ELIMINAR HERRAMIENTA<i class=" material-icons right">delete_forever</i>
                </button>
            </form>
        </section>
    </div>
</div>

@endsection