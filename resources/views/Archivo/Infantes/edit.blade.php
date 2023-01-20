@extends('adminlte::page')

@section('title', 'Infantes')

@section('content_header')
    <h1>Editar Infante {{ $infante->nombre }} {{ $infante->apellido }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("infantes.update", $infante) }}" method="post">
                        @method('PUT')
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <x-adminlte-input name="nombre" label="Nombre" value="{{$infante->nombre}}" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12"/>
                            
                            <x-adminlte-input name="apellido" label="Apellido" value="{{$infante->apellido}}" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12"/>
                        </div>

                        <div class="row">

                            @php
                            $config = ['format' => 'DD-MM-YYYY'];
                            @endphp
                            <x-adminlte-input-date name="nacimiento" label="Fecha de Nacimiento" value="{{date('d-m-Y', strtotime($infante->nacimiento))}}" enable-old-support fgroup-class="col-lg-4 col-md-4 col-sm-6" :config="$config"/>
                            
                            @if ($infante->sexo == 'M')
                                <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink" checked/>
                            @else
                                <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink"/>
                            @endif

                            {{-- @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona al responsable...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="responsable" name="responsable" label="Responsable" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                @foreach ($ciudadanos as $ciudadano)
                                    @if ($ciudadano->id == $infante->ciudadano_id)
                                    <option selected value="{{ $ciudadano->id }}">{{ $ciudadano->nacionalidad }}-{{ $ciudadano->cedula }} {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}</option>
                                    @else
                                    <option value="{{ $ciudadano->id }}">{{ $ciudadano->nacionalidad }}-{{ $ciudadano->cedula }} {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}</option>
                                    @endif                                    
                                @endforeach
                            </x-adminlte-select2> --}}

                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona al responsable...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="responsable" name="responsable" label="Responsable" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                @foreach ($ciudadanos as $ciudadano)
                                    @if ($ciudadano->id == $infante->ciudadano_id)
                                    <option selected value="{{ $ciudadano->id }}">{{ $ciudadano->nacionalidad }}-{{ $ciudadano->cedula }} {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}</option>
                                    @else
                                    <option value="{{ $ciudadano->id }}">{{ $ciudadano->nacionalidad }}-{{ $ciudadano->cedula }} {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}</option>
                                    @endif                                    
                                @endforeach
                            </x-adminlte-select2>
                    
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("infantes.index") }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.BootstrapSwitch', true)
@section('plugins.TempusDominusBs4', true)

@section('css')
    <style>
        .btn-gray {
            background: #6c757d;
            color: white;
        }
    </style>
@stop

@section('js')    
    <script>        

    </script>
@stop