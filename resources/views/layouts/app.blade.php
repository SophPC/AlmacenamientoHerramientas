<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="#">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.min.css')}}" media="screen,projection" />

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        a.mylink:hover,
        a.mylink:active {
            text-decoration: none;
        }

        main {
            flex: 1 0 auto;
        }

        .mysize {
            font-size: 16px;
            background-color: red;
        }

        @media screen and (min-width: 600px) {
            .mysize {
                font-size: calc(16px + 16 * (100vw - 600px) / 600);
            }
        }

        @media screen and (min-width: 1200px) {
            .mysize {
                font-size: 32px;
            }
        }

        .card {
            min-height: 120px;
        }

        .fixed-action-btn {
            bottom: 4rem;
            right: 1rem;
        }

        .myLtext {
            color: #e0e0e0;
        }

        .myDtext {
            color: #424242;
        }

        .myBlue {
            background-color: #6161E8;
        }

        .myOrange {
            background-color: #FFA000;
        }

        .myLorange {
            background-color: #FFEDD0;
        }

        .myLblue {
            background-color: #E2E2FA;
        }

        .pagination li.active a {
            background: #FFA000;
        }

        .myDetails {
            margin: 2px 0 20px 0;
        }
    </style>

    @yield('styles')

</head>

<body style="background-color: #fafafa ;">
    <header>
        <nav class="nav-wrapper myBlue">
            <div class="container">
                <a class="sidenav-trigger show-on-med-and-down" data-target="mobile-links">
                    <i class="material-icons myLtext">menu</i>
                </a>

                <a href="{{ route('home') }}" style="font-size: calc(10px + 0.9vw);" class="brand-logo myDtext hide-on-small-only">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <ul id='userDropdown' class='dropdown-content'>
                    @auth
                    @if(auth()->user()->admin)
                    <li><a href="{{ route('register') }}" class="myLtext">Registrar usuario</a></li>
                    <li><a href="{{ url('users') }}" class="myLtext">Ver usuarios</a></li>
                    @endif
                    @endauth
                    <li>
                        <a href="{{ route('logout') }}" class="myLtext" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                </ul>

                @guest
                <ul id="nav-desktop" class="right hide-on-med-and-down">
                    <li><a href="{{ url('employees') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Empleados"><i class="material-icons" style="margin-top: 4px;">person</i></a></li>
                    <li><a href="{{ url('tools') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Herramientas"><i class="material-icons" style="margin-top: 4px;">build</i></a></li>
                    <li><a href="{{ url('places') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Lugares"><i class="material-icons" style="margin-top: 4px;">place</i></a></li>
                    <li><a href="{{ url('events') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Eventos"><i class="material-icons" style="margin-top: 4px;">event</i></a></li>
                    <li><a href="{{ route('login') }}">Ingresar</a></li>
                </ul>
                <ul id="mobile-links" class="sidenav">
                    <li><a href="{{ route('login') }}" class="center">Ingresar</a></li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    <li><a href="{{ url('home') }}" class="myDtext"><i class="material-icons">home</i>Inicio</a></li>
                    <li><a class="subheader">Mostrar</a></li>
                    <li><a href="{{ url('employees') }}" class="myDtext"><i class="material-icons">person</i>Empleados</a></li>
                    <li><a href="{{ url('tools') }}" class="myDtext"><i class="material-icons">build</i>Herramientas</a></li>
                    <li><a href="{{ url('places') }}" class="myDtext"><i class="material-icons">place</i>Lugares</a></li>
                    <li><a href="{{ url('events') }}" class="myDtext"><i class="material-icons">event</i>Eventos</a></li>
                </ul>
                @else
                <ul id="nav-desktop" class="right hide-on-med-and-down">
                    <li><a href="{{ url('dashboard') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Dashboard"><i class="material-icons" style="margin-top: 4px;">assessment</i></a></li>
                    <li><a href="{{ url('incidences') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Incidencias" style="padding-right: 0px"><i class="material-icons" style="margin-top: 4px; border-right-style: solid; padding-right: 15px; border-width: 1px">error</i></a></li>
                    <li><a href="{{ url('employees') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Empleados"><i class="material-icons" style="margin-top: 4px;">person</i></a></li>
                    <li><a href="{{ url('tools') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Herramientas"><i class="material-icons" style="margin-top: 4px;">build</i></a></li>
                    <li><a href="{{ url('places') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Lugares"><i class="material-icons" style="margin-top: 4px;">place</i></a></li>
                    <li><a href="{{ url('events') }}" class="myLtext tooltipped" data-position="bottom" data-tooltip="Mostrar Eventos"><i class="material-icons" style="margin-top: 4px;">event</i></a></li>
                    <li><a class='dropdown-trigger myLtext' data-target='userDropdown'>
                            <i class="material-icons right">arrow_drop_down</i>{{ Auth::user()->name }}
                        </a></li>
                </ul>
                <ul id="mobile-links" class="sidenav">
                    <li>
                        <div class="user-view">
                            <div class="background myOrange"></div>
                            <a href="#name"><span class="name myDtext">{{ Auth::user()->name }}</span>
                                <span class="email myDtext">{{ Auth::user()->email }}</span></a>
                        </div>
                    </li>
                    <li><a href="{{ url('home') }}" class="myDtext"><i class="material-icons">home</i>Inicio</a></li>
                    <li><a href="{{ url('dashboard') }}" class="myDtext"><i class="material-icons">assessment</i>Dashboard</a></li>
                    <li><a href="{{ url('incidences') }}" class="myDtext"><i class="material-icons">error</i>Incidencias</a></li>
                    <li><a class="subheader">Mostrar</a></li>
                    <li><a href="{{ url('employees') }}" class="myDtext"><i class="material-icons">person</i>Empleados</a></li>
                    <li><a href="{{ url('tools') }}" class="myDtext"><i class="material-icons">build</i>Herramientas</a></li>
                    <li><a href="{{ url('places') }}" class="myDtext"><i class="material-icons">place</i>Lugares</a></li>
                    <li><a href="{{ url('events') }}" class="myDtext"><i class="material-icons">event</i>Eventos</a></li>
                    <li>
                        <div class="divider"></div>
                    </li>
                    @if(auth()->user()->admin)
                    <li><a href="{{ route('register') }}" class="myLtext">Registrar usuario</a></li>
                    <li><a href="{{ url('users') }}" class="myLtext">Ver usuarios</a></li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" class="myLtext" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                    </li>
                </ul>
                @endguest
            </div>
        </nav>
    </header>

    <main>
        @yield('content')

        <!-- === AGREGAR === -->
        @auth
        <div class="fixed-action-btn">
            <a class="btn-floating tooltipped btn-large waves-effect waves-light myOrange" data-position="left" data-tooltip="Agregar">
                <i class="large material-icons">add</i>
            </a>
            <ul>
                @if(auth()->user()->admin)
                <li><a class="btn-floating tooltipped yellow darken-2" href="{{ url('/event/create') }}" data-position="left" data-tooltip="Evento"><i class="material-icons">event</i></a></li>
                <li><a class="btn-floating tooltipped orange darken-2" href="{{ url('/incidence/create') }}" data-position="left" data-tooltip="Incidencia"><i class="material-icons">error</i></a></li>
                @endif
                <li><a class="btn-floating tooltipped blue" href="{{ url('/employee/create') }}" data-position="left" data-tooltip="Empleado"><i class="material-icons">person</i></a></li>
                <li><a class="btn-floating tooltipped red" href="{{ url('/tool/create') }}" data-position="left" data-tooltip="Herramienta"><i class="material-icons">build</i></a></li>
                <li><a class="btn-floating tooltipped green" href="{{ url('/place/create') }}" data-position="left" data-tooltip="Lugar"><i class="material-icons">place</i></a></li>
            </ul>
        </div>
        @endauth
        </div>

    </main>

    <footer class="grey darken-2 valign-wrapper" style="height:3rem; display: flex; justify-content: center;">
        <h7 class="myLtext">© <?php echo date("Y"); ?> Copyright DESSTEC</h7>
    </footer>

    <!-- JavaScript -->
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/materialize.min.js')}}"></script>

    @yield('scripts')

    <script>
        $(document).ready(function() {

            // Collapsibles
            $('.collapsible').collapsible({
                accordion: false
            });

            // Datepickers
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

            // Dropdown
            $('.dropdown-trigger').dropdown({
                coverTrigger: false,
                constrainWidth: false,
                alignment: 'right',
            });

            // Floating Action Buttons
            $('.fixed-action-btn').floatingActionButton({
                direction: 'up',
                // hoverEnabled: false
            });

            // Material Boxes (images)
            $('.materialboxed').materialbox();

            // Selectors
            $('select').formSelect();

            // Sidenav
            $('.sidenav').sidenav();

            // ToolTips
            $('.tooltipped').tooltip({
                exitDelay: '0',
            });

            // TimePickers
            $('.timepicker').timepicker();
        });
    </script>
</body>

</html>