@extends('adminlte::page')

@section('title', 'Infantes')

@section('content_header')
    @can('personas.create')
        <a class="btn btn-secondary btn-sm float-right" type="button" href="{{ route('infantes.create') }}">Nuevo Infante</a>
    @endcan
    <h3>Infantes</h3>
@stop

@section('content')

    @livewire('archivo.infantes.index')

    {{-- <div class="card">
        
        <div class="card-body">
            
            <div class="row justify-content-end mb-3">
                <div class="col-md-12 col-sm-12" id="buttons-exp">
                </div>    
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <table id="infantes-table" class="table table-hover responsive">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>F. de Nacimiento</th>
                                <th>Representante</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infantes as $infante)
                                <tr>
                                    <td>{{ $infante->nombre }}</td>
                                    <td>{{ $infante->apellido }}</td>
                                    <td>{{ $infante->nacimiento }}</td>
                                    <td>{{ $infante->ciudadano->nombres }} {{ $infante->ciudadano->apellidos }}</td>
                                    <td>
                                        @can('personas.edit')
                                            <a href="{{ route('infantes.edit', $infante) }}" title="Editar" class="btn btn-sm btn-secondary mx-1 shadow">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('personas.destroy')
                                            <button title="Eliminar" class="btn btn-sm btn-secondary mx-1 shadow" onclick="event.preventDefault();
                                            document.getElementById({{$infante->id}}).submit();">
                                                <i class="fa fw fa-trash"></i>
                                            </button>

                                            <form action="{{ route('infantes.destroy', $infante) }}" method="POST" id="{{$infante->id}}" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endcan

                                        @can('personas.index')
                                            <a href="{{ route('infantes.show', $infante) }}" target="blank" title="Ver Detalles" class="btn btn-sm btn-secondary mx-1 shadow">
                                                <i class="fa fa-clipboard-list"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>    
            </div>

        </div>
    </div> --}}

@stop

@section('css')

@stop

@section('js')
    
@stop