@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Bienvenido</h1>
@stop

@section('content')
    <div class="card">
            
        <div class="card-body">
            
            <div class="row mb-4">
                <div class="col-md-6">

                    <div class="card">
                        
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title">Poblacion del Municipio Zamora</h2>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{$poblacion}}</span>
                                    <span>Ciudadanos Totales</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if (($poblacion-$aumentop) == 0    )
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
                                        <i class="fas fa-house-user"></i> {{$jefesf}}
                                    </span>
                                    <span class="text-muted">Nucleos Familiriares</span>
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

                <div class="col-md-6">

                    <div class="card">
                        
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title">Estructuras del Municipio Zamora</h2>
                            </div>
                        </div>
    
                        <div class="card-body">
                                                        
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-passport"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-passport"></i> {{$parroquias}}
                                    </span>
                                    <span class="text-muted">Parroquias</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-user-tie"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-user-tie"></i> {{$comunas}}
                                    </span>
                                    <span class="text-muted">Comunas</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-users"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-users"></i> {{$concejos}}
                                    </span>
                                    <span class="text-muted">Concejos Comunales</span>
                                </p>
                            </div>
                            
                        </div>
                    </div>

                </div>
                                  
            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crecimiento de la Población</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="chartP"></div>
                        </div>
                    </div>

                </div>                

            </div>

        </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
    <script src="/src/Highcharts/highcharts.js"></script>
    <script>
        var labelm = {{ Js::from($labelm) }};     
        var poblaciong = {{ Js::from($poblaciong) }}; 
        
        Highcharts.chart('chartP', {
            title: {
                text: 'Aumento de Población'
            },

            subtitle: {
                text: 'Basados en los nuevos registros del SEPP'
            },

            yAxis: {
                title: {
                    text: 'Número de Personas'
                }
            },

            xAxis: {
                categories: labelm
            },

            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },

            series: [{
                name: 'Nueva Poblacion por Mes',
                data: poblaciong
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 100
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>
@stop