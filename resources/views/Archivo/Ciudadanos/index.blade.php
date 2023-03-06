@extends('adminlte::page')

@section('title', 'Ciudadanos')

@section('content_header')
    @can('personas.create')
        <a class="btn btn-secondary btn-sm float-right" type="button" href="{{ route('ciudadanos.create') }}">Nuevo Ciudadano</a>
    @endcan
    <h3>Ciudadanos</h3>
@stop

@section('content')
    
    @livewire('archivo.ciudadanos.index')

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="/src/datatables.min.css"/>

    <style>
        
    </style>
@stop

@section('js')
    
@stop