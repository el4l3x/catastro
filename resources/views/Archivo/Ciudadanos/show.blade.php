@extends('adminlte::page')

@section('title', 'Ciudadanos')

@section('content_header')
    <h1>Ciudadano {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }} - Informe detallado</h1>
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
                                <span class="text-bold text-lg">{{$ciudadano->nombres}} {{$ciudadano->apellidos}}</span>
                                <span>{{$ciudadano->nacionalidad}}-{{$ciudadano->cedula}}</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @if ($ciudadano->sexo == 'M')
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
                                <span class="text-bold text-lg">{{$ciudadano->codigo}}-{{$ciudadano->telefono}}</span>
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{date('d-m-Y', strtotime($ciudadano->nacimiento))}}</span>
                            </p>

                            <p class="ml-auto d-flex flex-column text-right">
                                @php
                                    $fecha_nacimiento = new DateTime($ciudadano->nacimiento);
                                    $hoy = new DateTime();
                                    $edadCiudadano = $hoy->diff($fecha_nacimiento);
                                @endphp
                                {{$edadCiudadano->y}} Años de edad
                            </p>
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
                                <span class="text-bold text-lg">{{$ciudadano->parroquia->nombre}}</span>
                                <span>Parroquia</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('parroquias.index')
                                    <a href="{{ route('parroquias.show', $ciudadano->parroquia) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Parroquia
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$ciudadano->concejo->comuna->nombre}}</span>
                                <span>Comuna</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('comunas.index')
                                    <a href="{{ route('comunas.show', $ciudadano->concejo->comuna) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Comuna
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$ciudadano->concejo->nombre}}</span>
                                <span>Concejo Comunal</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @can('concejos.index')
                                    <a href="{{ route('concejos.show', $ciudadano->concejo) }}" target="blank" class="btn btn-sm btn-secondary mx-1 shadow">
                                        Ver Concejo Comunal
                                    </a>
                                @endcan
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{$ciudadano->direccion}}</span>
                            </p>                                
                        </div>
                        
                    </div>
                </div>

                @foreach ($ciudadano->infantes as $infante)
                <div class="card">
                        
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h2 class="card-title">{{$infante->nombre}} {{$infante->apellido}}</h2>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">{{date('d-m-Y', strtotime($infante->nacimiento))}}</span>
                                <span>Fecha de Nacimiento</span>                                    
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                @php
                                    $fecha_nacimiento = new DateTime($infante->nacimiento);
                                    $edadInfante = $hoy->diff($fecha_nacimiento);
                                @endphp
                                @if ($edadInfante->y < 1)
                                {{$edadInfante->m}} Meses de edad
                                @else
                                {{$edadInfante->y}} Años de edad
                                @endif
                            </p>                                
                        </div>

                        <div class="d-flex">
                            <p class="ml-auto d-flex flex-column text-right">
                                @if ($infante->sexo == 'M')
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
                        
                    </div>
                </div>
                @endforeach
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