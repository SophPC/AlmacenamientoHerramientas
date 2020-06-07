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
        <h5 class="center grey-text text-darken-1">Herramientas</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <table id="toolsTable" cellspacing="0" width="100%" class="myTable">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>COPIA</th>
                    <th>TIPO</th>
                    <th>FECHA CREACIÓN</th>
                    <th>STATUS</th>
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
        var toolsTable = $('#toolsTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            bDeferRender: true,
            order: [
                [5, "desc"]
            ],
            ajax: {
                url: "{{ route('tools.showAll') }}",
            },
            columns: [{
                    data: 'image',
                    name: 'image',
                    render: function(data, type, row) {
                        return "<img src=" + "'" + "{{ url('images') }}/" + row.image + "' style='width: 30px; height:30px'>";
                    },
                    orderable: false,
                },
                {
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'copy',
                },
                {
                    data: 'type',
                },
                {
                    data: 'created_at',
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (row.status)
                            return '<p class="green-text center lighten-1">En almacén</p>';
                        return '<p class="red-text center lighten-1">En Uso</p>';
                    }
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

    $('#toolsTable').on('click', 'tbody tr', function() {
        location.href = '{{ url("") }}' + this.getAttribute('href');
    });
</script>
@endsection