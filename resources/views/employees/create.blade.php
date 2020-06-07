@extends('layouts.app')

@section('content')

<div class="container">
    <div class="section">
        <h5 class="center grey-text text-darken-1">Agregar Empleado</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <section class="container" style="max-width:400px">
            <form action="{{ url('/employee/add') }}" enctype="multipart/form-data" method="post" class="blue lighten-4" style="padding:20px">
                @csrf
                <div class="input-field">
                    <label>Id del empleado</label>
                    <input type="text" name="id" placeholder="EXXXX">
                    @error('id')
                    <script>
                        tabinstance.select('empleado');
                    </script>
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Nombres</label>
                    <input type="text" name="name">
                    @error('name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Apellidos</label>
                    <input type="text" name="last_name">
                    @error('last_name')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" class="datepicker" name="birthdate">
                    @error('birthdate')
                    <span class="helper-text" style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label for="department">Departamento</label>
                    <input id="department" type="text" name="department">
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
                    <button class="btn waves-effect waves-light myOrange" type="submit">Agregar Empleado
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>


@endsection