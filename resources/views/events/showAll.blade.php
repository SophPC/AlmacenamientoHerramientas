@extends('layouts.app')

@section('styles')
<link type="text/css" rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('css/nouislider.min.css')}}" />

<style>
    tbody tr[role='row']:hover {
        cursor: pointer;
        background-color: #E2E2FA;
    }

    .noUi-connect {
        background: #FFA000;
    }

    .myTable th,
    td {
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="section" id="xHeader">
        <h5 class="center grey-text text-darken-1">Eventos</h5>
    </div>
    <div class="divider"></div>

    @if(isset($tools))
    <div class="section" id="filterButtons">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <button class="btn-small waves-effect waves-light myOrange" id="filterOpen" onclick="displayFilters();">Filtrar
                    <i class="material-icons right">filter_list</i>
                </button>
                <button class="btn-small waves-effect waves-light grey" style="display:none;" id="filterClose" onclick="hideFilters();">Filtrar
                    <i class="material-icons right">close</i>
                </button>
            </div>
            <div>
                <button class="btn-small waves-effect waves-light red lighten-1" onclick="location.href='{{ url("events") }}'">
                    Borrar filtros<i class="material-icons right">close</i>
                </button>
            </div>
        </div>
    </div>

    <div id="filterForm" style="display:none; padding: 10px 20px 0 20px" class="grey lighten-2">
        <div class="row" style="margin-bottom: 0">
            <div class="input-field col l4 m6 s12">
                <select class="filterSelect" data-column="6" id="employeeFilter">
                    <option selected></option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee['id'] }}">{{ $employee['last_name'] }} {{ $employee['name'] }} ({{ $employee['id'] }})</option>
                    @endforeach
                </select>
                <label>Empleado</label>
            </div>
            <div class="input-field col l4 m6 s12">
                <select class="filterSelect" data-column="8" id="toolFilter">
                    <option selected></option>
                    @foreach($tools as $tool)
                    <option value="{{ $tool['id'] }}">{{ $tool['name'] }}-{{ $tool['copy'] }} ({{ $tool['id'] }})</option>
                    @endforeach
                </select>
                <label>Herramienta</label>
            </div>
            <div class="input-field col l4 m6 s12">
                <select class="filterSelect" data-column="9" id="placeFilter">
                    <option selected></option>
                    @foreach($places as $place)
                    <option value="{{ $place['id'] }}">{{ $place['name'] }} ({{ $place['id'] }})</option>
                    @endforeach
                </select>
                <label>Lugar</label>
            </div>
        </div>
        <div class="row" style="margin-bottom: 0">
            <div class="col l1 hide-on-med-and-down"></div>
            <div class="input-field col l3 m6 s12">
                <select class="filterSelect" data-column="4">
                    <option selected></option>
                    <option value="1">Entrada</option>
                    <option value="0">Salida</option>
                </select>
                <label>Entrada o Salida</label>
            </div>
            <div class="col l1 hide-on-med-and-down"></div>
            <div class="input-field col l6 m6 s12" style="margin-top: 0">
                <div style="display: flex; justify-content: space-between; flex-direction: column;">
                    <div style="display: flex; justify-content: space-around; padding-bottom: 8px" class="valign-wrapper">
                        <div>
                            <label>Desde: </label><label id="eventStart"></label>
                        </div>
                        <div>
                            <label>Hasta: </label><label id="eventEnd"></label>
                        </div>
                    </div>
                    <div id="dateSlider"></div>
                </div>
            </div>   
        </div>
    </div>

    <div class="section">
        <table id="eventsTable" cellspacing="0" width="100%" class="myTable">
            <thead>
                <tr>
                    <th>EMPLEADO</th>
                    <th>HERRAMIENTAS</th>
                    <th>LUGAR</th>
                    <th>FECHA DEL EVENTO</th>
                    <th>I/O</th>
                </tr>
            </thead>
        </table>
    </div>
    @else
    <h6 align="center">No existen eventos</h6>
    @endif

</div>
@endsection

@section('scripts')
@if(isset($tools))
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/nouislider.min.js')}}"></script>
<script src="{{asset('js/wNumb.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var dateSlider = document.getElementById('dateSlider');
        noUiSlider.create(dateSlider, {
            range: {
                'min': timestamp('{{ $dateFrom["created_at"] }}'),
                'max': timestamp('now')
            },
            start: [timestamp('{{ $dateFrom["created_at"] }}'), timestamp('now')],
            step: 1000,
            orientation: 'horizontal',
            connect: true,
            format: wNumb({
                decimals: 0
            }),
        });

        function timestamp(str) {
            if (str == 'now')
                return new Date().getTime();
            return new Date(str).getTime();
        }

        dateSlider.noUiSlider.on('update', function(values, handle) {
            dateValues[handle].innerHTML = formatDate(new Date(+values[handle]));
        });

        var eventsTable = $('#eventsTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            bDeferRender: true,
            order: [
                [3, "desc"]
            ],
            ajax: {
                url: "{{ route('events.showAll') }}",
                data: {
                    min: function() {
                        return document.getElementById('eventStart').textContent;
                    },
                    max: function() {
                        return document.getElementById('eventEnd').textContent;
                    }
                }
            },
            columns: [{
                    data: 'e_lname',
                    name: 'employees.last_name',
                    render: function(data, type, row) {
                        return row.e_lname + ' ' + row.e_name + ' (' + row.e_id + ')';
                    },
                },
                {
                    data: 'tools_ids',
                    searchable: false,
                },
                {
                    data: 'p_name',
                    name: 'places.name',
                    render: function(data, type, row) {
                        return row.p_name + ' (' + row.p_id + ')';
                    }
                },
                {
                    data: 'created_at',
                    name: 'events.created_at'
                },
                {
                    data: 'inORout',
                    name: 'events.inORout',
                    render: function(data, type, row) {
                        if (row.inORout == 1)
                            return '<p class="green-text center lighten-1">Entrada</p>';
                        return '<p class="red-text center lighten-1">Salida</p>';
                    }
                },

                // Invisible, just for searching
                {
                    data: 'e_name',
                    name: 'employees.name',
                    visible: false
                },
                {
                    data: 'e_id',
                    name: 'employees.id',
                    visible: false
                },
                {
                    data: 'p_id',
                    name: 'places.id',
                    visible: false
                },
            ],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Registros a mostrar: _MENU_",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
            }

        });

        dateSlider.noUiSlider.on('set', function() {
            eventsTable.draw();
        });

        var url = new URL(window.location.href);
        var selector;
        if (selector = url.searchParams.get("extra")) {
            var mySelect = $('option[value="' + selector + '"').prop('selected', true).parent();
            myFilter(mySelect);
        }

        $('.filterSelect').change(function() {
            myFilter($(this))
        });

        function myFilter(object) {
            eventsTable.columns(object.data('column'))
                .search(object.val())
                .draw();
        }

    });

    var dateValues = [
        document.getElementById('eventStart'),
        document.getElementById('eventEnd')
    ];

    function formatDate(date) { // YYYY-MM-DD HH:mm:SS
        return date.getFullYear() + "-" +
            ("0" + (date.getMonth() + 1)).slice(-2) + "-" +
            ("0" + date.getDate()).slice(-2) + " " +
            ("0" + date.getHours()).slice(-2) + ":" +
            ("0" + date.getMinutes()).slice(-2) + ":" +
            ("0" + date.getSeconds()).slice(-2);
    }

    function displayFilters() {
        $("#filterForm").show();
        $("#filterClose").show();
        $("#filterOpen").hide();
    }

    function hideFilters() {
        $("#filterForm").hide();
        $("#filterClose").hide();
        $("#filterOpen").show();
    }

    $('#eventsTable').on('click', 'tbody tr', function() {
        location.href = '{{ url("") }}' + this.getAttribute('href');
    });
@endif
</script>
@endsection