@extends('adminlte::page')

@section('title', 'Infantes')

@section('content_header')
    <h1>Infante {{ $infante->nombre }} {{ $infante->apellido }} - Informe detallado</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">

            <div class="card-columns">
                <div class="card">
                        
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title">Datos Personales</h2>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->nombre}} {{$infante->apellido}}</span>
                            </p>
                            
                            <p class="ml-auto d-flex flex-column text-right">
                                @if ($infante->sexo == 'M')
                                <span class="text-secondary">
                                    Masculino <i class="fas fa-male"></i>
                                </span>
                                @else
                                <span class="text-primary">
                                    Femenino <i class="fas fa-female"></i>
                                </span>
                                @endif
                            </p>
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->nacimiento}}</span>
                                <span>Fecha de Nacimiento</span>
                            </p>
                            
                            <p class="ml-auto d-flex flex-column text-right">
                                @php
                                    $fecha_nacimiento = new DateTime($infante->nacimiento);
                                    $hoy = new DateTime();
                                    $edadInfante = $hoy->diff($fecha_nacimiento);
                                @endphp
                                @if ($edadInfante->y < 1)
                                {{$edadInfante->m}} Meses de edad
                                @else
                                {{$edadInfante->y}} Años de edad
                                @endif
                            </p>
                        </div>                            
                        
                    </div>
                </div>

                <div class="card">
                        
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title">Responsable</h2>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->nombres}} {{$infante->ciudadano->apellidos}}</span>
                                <span>{{$infante->ciudadano->nacionalidad}}-{{$infante->ciudadano->cedula}}</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @if ($infante->ciudadano->sexo == 'M')
                                <span class="text-secondary">
                                    Masculino <i class="fas fa-male"></i>
                                </span>
                                @else
                                <span class="text-secondary">
                                    Femenino <i class="fas fa-female"></i>
                                </span>
                                @endif
                            </p>
                            
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->codigo}}-{{$infante->ciudadano->telefono}}</span>
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{date('d-m-Y', strtotime($infante->ciudadano->nacimiento))}}</span>
                            </p>

                            <p class="ml-auto d-flex flex-column text-right">
                                @php
                                    $fecha_nacimiento = new DateTime($infante->ciudadano->nacimiento);
                                    $edadCiudadano = $hoy->diff($fecha_nacimiento);
                                @endphp
                                {{$edadCiudadano->y}} Años de edad
                            </p>
                        </div>

                        <div class="d-flex">
                            @can('personas.index')
                                <a href="{{ route('ciudadanos.show', $infante->ciudadano) }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm btn-block">
                                    Ver Ciudadano
                                </a>
                            @endcan
                        </div>
                        
                    </div>
                </div>

                <div class="card">
                        
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title">Ubicación</h2>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->parroquia->nombre}}</span>
                                <span>Parroquia</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('parroquias.index')
                                    <a href="{{ route('parroquias.show', $infante->ciudadano->parroquia) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Parroquia
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->concejo->comuna->nombre}}</span>
                                <span>Comuna</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('comunas.index')
                                    <a href="{{ route('comunas.show', $infante->ciudadano->concejo->comuna) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Comuna
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->concejo->nombre}}</span>
                                <span>Concejo Comunal</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('concejos.index')
                                    <a href="{{ route('concejos.show', $infante->ciudadano->concejo) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Concejo Comunal
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$infante->ciudadano->direccion}}</span>
                            </p>                                
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop

@section('css')
    <style>
        
    </style>
@stop

@section('js')    
    <script>        

    </script>
@stop