@extends('layouts.app')

@section('content')
<div class="container">
    <div class="section" id="xHeader">
        <h5 class="center grey-text text-darken-1">Bienvenido {{ Auth::user()->name }}</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <div class="row">
            <div class="col s12 m6">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <span class="card-title">Herramientas mas populares</span>
                        @if(isset($popularTools))
                        <div>
                            {!! $popularTools->container() !!}
                        </div>
                        <p style="text-align:center">Muestra las herramientas que han tenido mayor uso en el ultimo mes por número de eventos en las que se encuentran.</p>
                        @else
                        <p style="text-align:center">Ups! No hay suficientes datos.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <span class="card-title">Empleados más activos</span>
                        @if(isset($activeEmployees))
                        <div>
                            {!! $activeEmployees->container() !!}
                        </div>
                        <p style="text-align:center">Muestra los empleados que han tenido mayor número de eventos en los últimos 30 días.</p>
                        @else
                        <p style="text-align:center">Ups! No hay suficientes datos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <span class="card-title">Numero de eventos por día</span>
                        @if(isset($ioSem))
                        <div>
                            {!! $ioSem->container() !!}
                        </div>
                        <p style="text-align:center">Muestra el número de eventos diarios de la semana en curso vs la semana pasada.</p>
                        @else
                        <p style="text-align:center">Ups! No hay suficientes datos.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card blue-grey lighten-5">
                    <div class="card-content">
                        <span class="card-title">Porcentaje de eventos por hora</span>
                        @if(isset($busyHours))
                        <div>
                            {!! $busyHours->container() !!}
                        </div>
                        <p style="text-align:center">Muestra las horas más populares donde se realizan eventos.</p>
                        @else
                        <p style="text-align:center">Ups! No hay suficientes datos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="section" style="display: flex; justify-content: space-around;flex-wrap: wrap;">
        <div>
            @if(auth()->user()->get_mail)
            <label style="color: black">
                <input type="checkbox" class="filled-in" checked="checked" onclick="toggle()" />
                <span>Mandar correos de incidencia</span>
            </label>
            @else
            <label style="color: black">
                <input type="checkbox" class="filled-in" onclick="toggle()" />
                <span>Mandar correos de incidencia</span>
            </label>
            @endif
        </div>
        {{--
        @if(!auth()->user()->admin)
        <div>
            <a class="btn-small blue lighten-1" onclick="adminReq()">Solicitar permisos de administrador</a>
        </div>
        @endif 
        --}}
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@if($popularTools)
{!! $popularTools->script() !!}
@endif
@if($ioSem)
{!! $ioSem->script() !!}
@endif
@if($busyHours)
{!! $busyHours->script() !!}
@endif
@if($activeEmployees)
{!! $activeEmployees->script() !!}
@endif
<script>
    function toggle() {
        $.ajax({
            url: "{{ route('mailUpdate') }}",
            method: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                user_id: '{{ Auth::user()->id }}',
            },
            success: function(result) {
                if (result.update)
                    alert("¡Listo! Recibirás un correo con cada incidencia");
                else
                    alert("¡Listo! No recibirás más correos");
            },
            error: function() {
                alert("¡Ocurrió un error!");
            }
        });
    }

    function adminReq() {
        if (confirm("¿Estas seguro?\n Confirmar mandará un correo de aprobación a los usuarios administradores.")) {
            $.ajax({
                url: "{{ route('adminReq') }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: '{{ Auth::user()->id }}',
                },
                success: function(result) {
                    alert("¡Listo! Se ha mandado la solicitud");
                },
                error: function() {
                    alert("¡Ocurrió un error!");
                }
            });
        }

    }
</script>

@endsection