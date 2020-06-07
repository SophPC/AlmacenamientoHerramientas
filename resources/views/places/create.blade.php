@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Agregar Lugar</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('/place/add') }}" method="post" class="green lighten-4" style="padding:20px">
                @csrf
                <div class="input-field">
                    <label>ID del lugar</label>
                    <input type="text" name="id" placeholder="LXXXX">
                    @error('id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Nombre</label>
                    <input type="text" name="name">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="center">
                    <button class="btn waves-effect waves-light myOrange" type="submit">Agregar Lugar
                        <i class="material-icons right">save</i>
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection