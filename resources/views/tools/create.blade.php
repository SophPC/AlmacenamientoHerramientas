@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Agregar Herramienta</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('/tool/add') }}" enctype="multipart/form-data" method="post" class="red lighten-4" style="padding:20px">
                @csrf
                <div class="input-field">
                    <label for="id">Id de la herramienta</label>
                    <input type="text" id="id" name="id" placeholder="HXXXX">
                    @error('id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" name="name">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field ">
                    <label for="type">Tipo</label>
                    <input id="type" type="text" name="type">
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
                <div align="center">
                @error('other')
                <span class="helper-text" style="color: red">{{ $message }}</span>
                @enderror
                </div>
                <br>
                <div class="center">
                    <button class="btn waves-effect waves-light myOrange" type="submit">Agregar Herramienta
                        <i class="material-icons right">save</i>
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection