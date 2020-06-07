<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="#">
    <title>Almacenamiento de Herramientas</title>

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.min.css')}}" media="screen,projection" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-image: linear-gradient(to left bottom, #ffa000, #ff8353, #f3767e, #ca7797, #9c7a97, #907198, #806a99, #6c649b, #6256b6, #5445d0, #4130e8, #2200ff);
            color: #e0e0e0;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size:7vw;
        }

        .links>a {
            color: #424242;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .myOrange {
            background-color: #FFA000;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
            <a href="{{ route('login') }}">Ingresar</a>
            @endauth
        </div>
        @endif

        {{-- Instituto Politécnico Nacional

        Escuela Superior de Ingeniería
        Mecánica y Eléctrica
        Unidad Profesional “Adolfo López Mateos”

        Proyecto Terminal

        “DISEÑO E IMPLEMENTACIÓN
        DE UN SISTEMA DE
        AUTOGESTIÓN DE HERRAMIENTAS”

        Que para obtener el grado de
        INGENIERO EN COMUNICACIONES
        Y ELECTRÓNICA
        Presentan

        PÉREZ CONTRERAS ANA SOFÍA
        SÁNCHEZ VALENCIA JOSÉ DAVID

        Asesor metodológico: Karla Sandra Arellano García
        Asesor técnico: Juan Manuel Cobilt Catana

        México, CDMX
        Abril, 2020 --}}

        <div class="content">
            <div class="title m-b-md">
                Sistema de Autogestión<br>de Herramientas
            </div>

            <div class="container">
                <ul id="nav-mobile">
                    <li><a href="{{ url('/home') }}" class="btn-large myOrange" style="color: #424242">
                            <i class="material-icons right">arrow_forward</i>Acceder</a></li>
                </ul>
            </div>
        </div>

    </div>

</body>

</html>