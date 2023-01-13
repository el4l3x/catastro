@extends('adminlte::page')

@section('title', 'Comunas')

@section('content_header')
    <h1>Comuna {{ $comuna->nombre }} - Informe detallado</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-6">

                    <div class="card">
                        
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title">Poblacion</h2>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{$poblacion}}</span>
                                    <span>Ciudadanos Totales</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if (($poblacion-$aumentop) == 0)
                                    <span class="text-primary">
                                        <i class="fas fa-arrow-up"></i> {{$aumentop}}<i class="fas fa-users"></i>
                                    </span>
                                    @else
                                    <span class="text-primary">
                                        <i class="fas fa-arrow-up"></i> {{$aumentop}}<i class="fas fa-users"></i> - {{number_format(($aumentop*100)/($poblacion-$aumentop), '2')}}%
                                    </span>
                                    @endif
                                    <span class="text-muted">En la ultima semana</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-male"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-male"></i> {{$genero}}
                                    </span>
                                    <span class="text-muted">Poblacion Masculina</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-female"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-female"></i> {{$poblacion-$genero}}
                                    </span>
                                    <span class="text-muted">Poblacion Femenina</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-child"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-child"></i> {{$edadm}}
                                    </span>
                                    <span class="text-muted">Menores de Edad</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-blind"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-blind"></i> {{$abuelos}}
                                    </span>
                                    <span class="text-muted">Ciudadanos de la 3ra Edad</span>
                                </p>
                            </div>
                            
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