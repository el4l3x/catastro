@extends('adminlte::page')

@section('title', 'Concejos Comunales')

@section('content_header')
    @can('concejos.create')
        <a class="btn btn-secondary btn-sm float-right" type="button" href="{{ route('concejos.create') }}">Nuevo Concejo Comunal</a>
    @endcan
    <h3>Concejos Comunales</h3>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row justify-content-end mb-3">
                <div class="col-md-12 col-sm-12" id="buttons-exp">
                </div>    
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <table id="concejos-table" class="table table-hover responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Comuna</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($concejos as $concejo)
                                <tr>
                                    <td>{{ $concejo->id }}</td>
                                    <td>{{ $concejo->nombre }}</td>
                                    <td>{{ $concejo->comuna->nombre }}</td>
                                    <td>
                                        @can('concejos.edit')
                                            <a href="{{ route('concejos.edit', $concejo) }}" title="Editar" class="btn btn-sm btn-secondary mx-1 shadow">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('concejos.destroy')
                                            <button title="Eliminar" class="btn btn-sm btn-secondary mx-1 shadow" onclick="event.preventDefault();
                                            document.getElementById({{$concejo->id}}).submit();">
                                                <i class="fa fw fa-trash"></i>
                                            </button>

                                            <form action="{{ route('concejos.destroy', $concejo) }}" method="POST" id="{{$concejo->id}}" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="/src/datatables.min.css"/>

    <style>
        .dt-button.active {
            background: #007BFF !important;
        }
        .dt-button.dropdown-item {
            color: white !important;
        }
        .dt-button-collection {
            background: gray !important;
        }
        .dt-button.active {
            background: #007BFF !important;
        }
        div.dt-button-info {
           background: #007BFF;
        }
        .gray-text {
            color: #007BFF !important;
            text-decoration: none !important;
        }
        .btn-gray {
            background: #007BFF;
            color: white;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="/src/datatables.min.js"></script>
    
    <script>        
        $(function () {

            var table = $("#concejos-table").DataTable({
                "language": {
                    "search": "Buscar:",
                    "emptyTable": "No hay registros",
                    "info":           "Viendo del _START_ al _END_. En total _TOTAL_ registros",
                    "infoEmpty":      "",
                    "infoFiltered":   "(filtrado de _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ".",
                    "lengthMenu":     "Ver _MENU_ filas",
                    "loadingRecords": "Cargando...",
                    "processing":     "",
                    "zeroRecords":    "No se consiguieron coincidencias",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": ordenar de manera ascendente",
                        "sortDescending": ": ordenar de manera descendente"
                    },
                    "buttons": {
                        copy: 'Copy',
                        copySuccess: {
                            1: "Copiado al portapapeles",
                            _: "Copiado al portapapeles"
                        },
                        copyTitle: '',
                        copyKeys: 'Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br><br>To cancel, click this message or press escape.'
                    },
                },
                /* scrollX: true, */
                "responsive": true, 
                "autoWidth": false,
                "buttons": [
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        exportOptions: {
                            columns: [0, 1],
                        },
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: [0, 1],
                        },
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: [0, 1],
                        },
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1],
                        },
                    },
                    {
                        extend: 'colvis',
                        text: 'Ocultar Columnas',
                        className: ''
                    },
                ]
            }).buttons().container().appendTo('#buttons-exp');
          
        });
    </script>
@stop