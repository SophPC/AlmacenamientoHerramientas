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
        <h5 class="center grey-text text-darken-1">Usuarios</h5>
    </div>
    <div class="divider"></div>
    <div class="section">
        <table id="usersTable" cellspacing="0" width="100%" class="myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>EMAIL VERIFICADO</th>
                    <th>ES ADMIN</th>
                    <th>FECHA CREACION</th>
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
        var usersTable = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            bDeferRender: true,
            order: [
                [0, "asc"]
            ],
            ajax: {
                url: "{{ route('users.showAll') }}",
            },
            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'email',
                },
                {
                    data: 'email_verified_at',
                    render: function(data, type, row) {
                        if (row.email_verified_at)
                            return '<p class="green-text lighten-1">Si</p>';
                        return '<p class="red-text lighten-1">No</p>';
                    }
                },
                {
                    data: 'admin',
                    render: function(data, type, row) {
                        if (row.admin)
                            return '<p class="green-text lighten-1">Si</p>';
                        return '<p class="red-text lighten-1">No</p>';
                    }
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

    $('#usersTable').on('click', 'tbody tr', function() {
        location.href = '{{ url("") }}' + this.getAttribute('href');
    });
</script>
@endsection