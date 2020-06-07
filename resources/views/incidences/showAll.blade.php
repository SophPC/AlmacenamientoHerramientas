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
    <div class="section">
        <h5 class="center grey-text text-darken-1">Incidencias</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <table id="incidencesTable" cellspacing="0" width="100%" class="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>MENSAJE</th>
                    <th>LUGAR</th>
                    <th>FECHA CREACIÓN</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/nouislider.min.js')}}"></script>
<script src="{{asset('js/wNumb.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var incidencesTable = $('#incidencesTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            bDeferRender: true,
            order: [
                [3, "desc"]
            ],
            ajax: {
                url: "{{ route('incidences.showAll') }}",
            },
            columns: [{
                    data: 'id',
                },
                {
                    data: 'message',
                },
                {
                    data: 'place_id',
                },
                {
                    data: 'created_at',
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

    });

    $('#incidencesTable').on('click', 'tbody tr', function() {
        location.href = '{{ url("") }}' + this.getAttribute('href');
    });
</script>
@endsection