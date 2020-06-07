@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Editar Empleado</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('employee', $employee->id) }}" method="post" enctype="multipart/form-data" class="blue lighten-4" style="padding:20px">
                @csrf
                @method('PATCH')
                <div class="input-field">
                    <label>Id del empleado</label>
                    <input type="text" name="id" placeholder="EXXXX" value="{{ $employee->id }}">
                    @error('id')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Nombres</label>
                    <input type="text" name="name" value="{{ $employee->name }}">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Apellidos</label>
                    <input type="text" name="last_name" value="{{ $employee->last_name }}">
                    @error('last_name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" class="datepicker" name="birthdate" value="{{ $employee->birthdate }}">
                    @error('birthdate')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="department">Departamento</label>
                    <input id="department" type="text" name="department" value="{{ $employee->department }}">
                    @error('department')
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
                    <button class="btn waves-effect waves-light green lighten-1" type="submit">Editar empleado
                        <i class="material-icons right">edit</i>
                    </button>
                </div>
            </form>

            <br>
            <form action="{{ url('employee', $employee->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn-small waves-effect waves-light red lighten-2" method="post" type="submit" onclick="return confirm('¿Seguro que quieres eliminar el empleado?')">
                    ELIMINAR empleado<i class=" material-icons right">delete_forever</i>
                </button>
            </form>
        </section>
    </div>
</div>

@endsection